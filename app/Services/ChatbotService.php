<?php

namespace App\Services;

use App\Contracts\TripComApiContract;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotService
{
    protected string $apiKey;
    protected string $model;
    protected int $maxTokens;
    protected float $temperature;
    protected string $systemPrompt;
    protected TripComApiContract $tripComApi;

    public function __construct(TripComApiContract $tripComApi)
    {
        $this->tripComApi = $tripComApi;
        $this->apiKey = config('chatbot.api_key', '');
        $this->model = config('chatbot.model', 'gemini-2.0-flash');
        $this->maxTokens = config('chatbot.max_tokens', 512);
        $this->temperature = config('chatbot.temperature', 0.7);
        $this->systemPrompt = config('chatbot.system_prompt', '');
    }

    /**
     * Generate a chatbot response.
     */
    public function reply(string $userMessage, array $history = []): string
    {
        // If no API key, use smart fallback
        if (empty($this->apiKey)) {
            return $this->fallbackReply($userMessage);
        }

        return $this->geminiReply($userMessage, $history);
    }

    /**
     * Call Gemini API for a response.
     */
    protected function geminiReply(string $userMessage, array $history = []): string
    {
        $maxRetries = 3;

        // Build conversation contents
        $contents = [];

        // Add conversation history (keep last 10 messages to reduce token usage)
        $recentHistory = array_slice($history, -10);
        foreach ($recentHistory as $msg) {
            $contents[] = [
                'role' => $msg['role'] === 'user' ? 'user' : 'model',
                'parts' => [['text' => $msg['content']]],
            ];
        }

        // Add current user message
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]],
        ];

        // Define tools (Function Calling)
        $tools = [
            [
                'functionDeclarations' => [
                    [
                        'name' => 'search_hotels',
                        'description' => 'Search for live hotel prices, ratings, and availability in a specific city. Use this when the user asks for hotel recommendations or pricing.',
                        'parameters' => [
                            'type' => 'OBJECT',
                            'properties' => [
                                'city' => [
                                    'type' => 'STRING',
                                    'description' => 'The city to search for hotels in, e.g. Tokyo, Singapore.',
                                ],
                            ],
                            'required' => ['city'],
                        ],
                    ],
                    [
                        'name' => 'search_flights',
                        'description' => 'Search for live flight schedules, airlines, and prices between two cities. Use this when the user asks for flight deals or routes.',
                        'parameters' => [
                            'type' => 'OBJECT',
                            'properties' => [
                                'origin' => [
                                    'type' => 'STRING',
                                    'description' => 'The origin city or airport code, e.g. NRT, Tokyo.',
                                ],
                                'destination' => [
                                    'type' => 'STRING',
                                    'description' => 'The destination city or airport code, e.g. SIN, Singapore.',
                                ],
                            ],
                            'required' => ['origin', 'destination'],
                        ],
                    ]
                ]
            ]
        ];

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";

        // Allow up to 3 function calls in a single conversational turn
        $maxFunctionCalls = 3;
        $functionCallCount = 0;

        while ($functionCallCount <= $maxFunctionCalls) {
            $attempt = 0;
            $success = false;
            $data = [];

            while ($attempt < $maxRetries) {
                try {
                    $response = Http::timeout(20)->post($url, [
                        'system_instruction' => [
                            'parts' => [['text' => $this->systemPrompt . " You are a helpful travel assistant. When you use tools to get data, present the data beautifully using markdown formatting (e.g. bolding names, using bullet points)."]],
                        ],
                        'contents' => $contents,
                        'tools' => $tools,
                        'generationConfig' => [
                            'maxOutputTokens' => $this->maxTokens,
                            'temperature' => $this->temperature,
                        ],
                    ]);

                    if ($response->successful()) {
                        $data = $response->json();
                        $success = true;
                        break; // Break retry loop
                    }

                    $status = $response->status();

                    Log::warning("Gemini API error (Attempt {$attempt})", [
                        'status' => $status,
                        'body' => $response->body(),
                    ]);

                    if ($status === 429) {
                        $attempt++;
                        if ($attempt >= $maxRetries) {
                            throw new \Exception("⏳ The AI is currently experiencing high demand. Please try again in a few minutes.");
                        }
                        sleep(pow(2, $attempt));
                        continue;
                    }

                    if ($status === 403 || $status === 400) {
                        throw new \Exception("🔑 API configuration issue. The requested operation could not be completed.");
                    }

                    throw new \Exception("An unexpected error occurred while communicating with the AI.");
                } catch (\Exception $e) {
                    if ($attempt >= $maxRetries || (!str_contains($e->getMessage(), '429') && !str_contains($e->getMessage(), 'timeout'))) {
                        throw $e;
                    }
                    $attempt++;
                    sleep(pow(2, $attempt));
                }
            }

            if (!$success) {
                throw new \Exception("An unexpected error occurred. Please try again later.");
            }

            $candidate = $data['candidates'][0] ?? null;
            if (!$candidate) {
                return 'I apologize, I couldn\'t generate a response. Please try again!';
            }

            $parts = $candidate['content']['parts'] ?? [];
            $hasFunctionCall = false;

            foreach ($parts as $part) {
                if (isset($part['functionCall'])) {
                    $hasFunctionCall = true;
                    $functionCall = $part['functionCall'];
                    $name = $functionCall['name'];
                    $args = $functionCall['args'];

                    Log::info("Gemini invoking tool: {$name}", $args);

                    // Append the model's functionCall to contents history
                    $contents[] = [
                        'role' => 'model',
                        'parts' => [['functionCall' => $functionCall]]
                    ];

                    // Execute the requested function
                    $functionResult = [];
                    try {
                        if ($name === 'search_hotels') {
                            $functionResult = $this->tripComApi->searchHotels(['city' => $args['city'] ?? '']);
                        } elseif ($name === 'search_flights') {
                            $functionResult = $this->tripComApi->searchFlights([
                                'origin' => $args['origin'] ?? '',
                                'destination' => $args['destination'] ?? ''
                            ]);
                        } else {
                            $functionResult = ['error' => 'Unknown function'];
                        }
                    } catch (\Exception $e) {
                        Log::error("Function call {$name} failed: " . $e->getMessage());
                        $functionResult = ['error' => 'Failed to retrieve data.'];
                    }

                    // Append the functionResponse to contents history
                    $contents[] = [
                        'role' => 'function',
                        'parts' => [
                            [
                                'functionResponse' => [
                                    'name' => $name,
                                    'response' => ['result' => $functionResult]
                                ]
                            ]
                        ]
                    ];

                    $functionCallCount++;
                }
            }

            // If there was no function call, the model has finished its thought process and returned text
            if (!$hasFunctionCall) {
                return $parts[0]['text'] ?? '';
            }
        }

        return "I'm sorry, I couldn't process your request as it required too many tool calls.";
    }

    /**
     * Keyword-based fallback when no LLM API key is configured.
     */
    protected function fallbackReply(string $message): string
    {
        $msg = strtolower($message);

        // Greetings
        if (preg_match('/\b(hi|hello|hey|greetings|good morning|good afternoon)\b/', $msg)) {
            return "Hello! 👋 I'm TripExplorer AI, your travel assistant. I can help you find hotels and flights across Asia. Where would you like to go?";
        }

        // Hotel queries
        if (preg_match('/\b(hotel|stay|accommodation|room|resort|villa)\b/', $msg)) {
            if (str_contains($msg, 'tokyo') || str_contains($msg, 'japan')) {
                return "🏨 For Tokyo, I recommend **The Grand Sakura Hotel** — a 5★ luxury hotel at \$285/night (was \$350). Rating: 4.8/5 with 2,847 reviews. Use code **FIRST20** for 20% off your first booking!";
            }
            if (str_contains($msg, 'singapore')) {
                return "🏨 In Singapore, check out **Marina Bay Sands** — 5★ iconic hotel at \$420/night (was \$520). Rating: 4.9/5. Features infinity pool, casino, and SkyPark! Use code **FIRST20** for 20% off!";
            }
            if (str_contains($msg, 'bangkok') || str_contains($msg, 'thailand')) {
                return "🏨 In Bangkok, try the **Riverside Boutique Resort** — 4★ at just \$145/night (was \$180). Rating: 4.6/5 with stunning river views. Great value! Code **FIRST20** saves you 20%.";
            }
            if (str_contains($msg, 'seoul') || str_contains($msg, 'korea')) {
                return "🏨 For Seoul, I suggest **Seoul Sky Tower Hotel** — 5★ at \$310/night (was \$380). Rating: 4.7/5 with city skyline views and a rooftop bar. Use **FIRST20** for 20% off!";
            }
            if (str_contains($msg, 'bali') || str_contains($msg, 'indonesia')) {
                return "🏨 In Bali, the **Bali Serenity Villas** are stunning — 5★ private villas at \$195/night (was \$250). Rating: 4.8/5 with pool, spa, and ocean views. Code **FIRST20** for 20% off!";
            }
            if (str_contains($msg, 'hanoi') || str_contains($msg, 'vietnam')) {
                return "🏨 In Hanoi, try the **Hanoi Heritage Hotel** — 4★ at just \$98/night (was \$125). Rating: 4.5/5 in the Old Quarter. Best budget-friendly option! Code **FIRST20** for 20% off!";
            }
            if (str_contains($msg, 'cheap') || str_contains($msg, 'budget') || str_contains($msg, 'affordable')) {
                return "💰 Best budget options:\n• **Hanoi Heritage Hotel** — \$98/night (4★)\n• **Riverside Boutique Resort**, Bangkok — \$145/night (4★)\n• **Bali Serenity Villas** — \$195/night (5★)\nUse code **FIRST20** for an extra 20% off!";
            }
            if (str_contains($msg, 'luxury') || str_contains($msg, 'best') || str_contains($msg, 'premium')) {
                return "✨ Top luxury picks:\n• **Marina Bay Sands**, Singapore — \$420/night (4.9★)\n• **Seoul Sky Tower Hotel** — \$310/night (4.7★)\n• **The Grand Sakura Hotel**, Tokyo — \$285/night (4.8★)\nAll 5-star rated!";
            }
            return "🏨 We have amazing hotels across Asia! Which city interests you? Tokyo, Singapore, Bangkok, Hanoi, Seoul, or Bali? I'll find the perfect match for you.";
        }

        // Flight queries
        if (preg_match('/\b(flight|fly|plane|airline|airport|ticket)\b/', $msg)) {
            if (str_contains($msg, 'cheap') || str_contains($msg, 'budget') || str_contains($msg, 'affordable')) {
                return "✈️ Best-value flights:\n• **Thai Airways** BKK→SIN — \$178 (2h 25m)\n• **Korean Air** ICN→NRT — \$215 (2h 15m)\n• **Vietnam Airlines** SGN→ICN — \$265 (5h 25m)\nUse code **FLY50NOW** for \$50 off flights over \$300!";
            }
            if (str_contains($msg, 'tokyo') || str_contains($msg, 'japan') || str_contains($msg, 'nrt')) {
                return "✈️ Flights to/from Tokyo:\n• **Singapore Airlines** NRT→SIN — \$489 (7h 35m, Direct)\n• **ANA** NRT→BKK — \$385 (6h 50m, Direct)\n• **Emirates** NRT→DXB — \$725 (11h 45m)\nCode **FLY50NOW** saves \$50 on flights over \$300!";
            }
            if (str_contains($msg, 'singapore') || str_contains($msg, 'sin')) {
                return "✈️ Flights to Singapore:\n• **Thai Airways** BKK→SIN — \$178 (2h 25m, Direct)\n• **Singapore Airlines** NRT→SIN — \$489 (7h 35m, Direct)\nBoth excellent airlines! Code **FLY50NOW** saves \$50 on flights over \$300.";
            }
            return "✈️ We have flights across Asia with airlines like Singapore Airlines, ANA, Korean Air, and more. Where are you flying from and to? I'll find the best deals!";
        }

        // Coupon / discount queries
        if (preg_match('/\b(coupon|discount|promo|code|deal|save|offer)\b/', $msg)) {
            return "🎟️ Active coupon codes:\n• **FIRST20** — 20% off your first hotel booking\n• **FLY50NOW** — \$50 off any flight over \$300\n• **BUNDLE15** — 15% off when you book hotel + flight together\nWant me to help you find the best deal?";
        }

        // Package / trip queries
        if (preg_match('/\b(package|trip|plan|itinerary|tour|bundle)\b/', $msg)) {
            return "📦 Our curated packages:\n• **Japan Explorer** — 7 days, Tokyo→Kyoto→Osaka, \$1,999 (save \$900)\n• **SE Asia Circuit** — 10 days, Singapore→Bangkok→Bali, \$2,499 (save \$1,000)\n• **Korea Highlights** — 5 days, Seoul→Busan, \$1,199 (save \$400)\nUse code **BUNDLE15** for an extra 15% off!";
        }

        // Weather queries
        if (preg_match('/\b(weather|climate|season|when to visit|best time)\b/', $msg)) {
            return "🌤️ Best times to visit:\n• **Tokyo** — Mar-May (cherry blossoms) or Oct-Nov (autumn)\n• **Bangkok** — Nov-Feb (cool & dry)\n• **Bali** — Apr-Oct (dry season)\n• **Seoul** — Sep-Nov (fall foliage)\nWant hotel recommendations for your dates?";
        }

        // Thank you
        if (preg_match('/\b(thanks|thank you|thx|appreciate)\b/', $msg)) {
            return "You're welcome! 😊 Happy to help. Let me know if you need anything else — whether it's hotels, flights, or travel tips!";
        }

        // Goodbye
        if (preg_match('/\b(bye|goodbye|see you|later)\b/', $msg)) {
            return "Safe travels! ✈️ Come back anytime you need help planning your next adventure. Bon voyage! 🌍";
        }

        // Help
        if (preg_match('/\b(help|what can you|what do you|how do)\b/', $msg)) {
            return "I can help you with:\n• 🏨 Finding hotels (e.g., \"hotels in Tokyo\")\n• ✈️ Searching flights (e.g., \"flights to Singapore\")\n• 🎟️ Coupon codes & deals\n• 📦 Trip packages\n• 🌤️ Travel tips & weather\nJust ask away!";
        }

        // Default
        return "I'm your TripExplorer travel assistant! 🌍 I can help you find hotels, flights, and deals across Asia. Try asking about:\n• Hotels in a specific city\n• Flights between destinations\n• Current coupon codes\n• Trip package deals";
    }
}
