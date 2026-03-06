# AI Chatbot with Gemini API — Complete Guide

> A step-by-step guide to building an AI-powered chatbot using Google's Gemini API with Laravel.

---

## Table of Contents

- [1. Architecture Overview](#1-architecture-overview)
- [2. Setup & Configuration](#2-setup--configuration)
- [3. Gemini API Functions Reference](#3-gemini-api-functions-reference)
- [4. Step-by-Step Implementation](#4-step-by-step-implementation)
- [5. Code Walkthrough](#5-code-walkthrough)
- [6. Advanced Features](#6-advanced-features)
- [7. Troubleshooting](#7-troubleshooting)

---

## 1. Architecture Overview

```
┌──────────────────────────────────────────────────────────────┐
│                      FRONTEND (Browser)                      │
│  ┌─────────────┐    ┌──────────────┐    ┌────────────────┐  │
│  │ Chat Widget │───▶│  AJAX POST   │───▶│ Display Reply  │  │
│  │ (Blade+JS)  │    │  /chat       │    │ (Formatted)    │  │
│  └─────────────┘    └──────────────┘    └────────────────┘  │
└───────────────────────────┬──────────────────────────────────┘
                            │ HTTP POST JSON
                            ▼
┌──────────────────────────────────────────────────────────────┐
│                      BACKEND (Laravel)                       │
│  ┌────────────────┐    ┌────────────────┐                   │
│  │ ChatController │───▶│ ChatbotService │                   │
│  │ - validate     │    │ - geminiReply  │                   │
│  │ - session mgmt │    │ - fallbackReply│                   │
│  └────────────────┘    └───────┬────────┘                   │
└────────────────────────────────┬─────────────────────────────┘
                                 │ HTTPS POST
                                 ▼
┌──────────────────────────────────────────────────────────────┐
│                 GEMINI API (Google Cloud)                     │
│  ┌──────────────────────────────────────────────────────┐   │
│  │ generativelanguage.googleapis.com/v1beta/models/     │   │
│  │   gemini-2.0-flash:generateContent                   │   │
│  └──────────────────────────────────────────────────────┘   │
└──────────────────────────────────────────────────────────────┘
```

---

## 2. Setup & Configuration

### Get a Gemini API Key (Free)

1. Visit [Google AI Studio](https://aistudio.google.com/apikey)
2. Sign in with your Google account
3. Click **"Create API Key"**
4. Copy the API key

### Add API Key to `.env`

```env
# AI Chatbot Configuration
GEMINI_API_KEY=AIzaSy...your-key-here
GEMINI_MODEL=gemini-2.0-flash
CHATBOT_MAX_TOKENS=512
CHATBOT_TEMPERATURE=0.7
```

### Available Gemini Models

| Model                          | Speed        | Quality | Best For                      |
| ------------------------------ | ------------ | ------- | ----------------------------- |
| `gemini-2.0-flash`             | ⚡ Fast      | ★★★★    | General chatbot (recommended) |
| `gemini-2.0-flash-lite`        | ⚡⚡ Fastest | ★★★     | High-traffic, simple tasks    |
| `gemini-2.5-pro-preview-06-05` | 🐢 Slow      | ★★★★★   | Complex reasoning             |
| `gemini-1.5-flash`             | ⚡ Fast      | ★★★★    | Balanced performance          |

### Free Tier Limits

| Quota               | Limit     |
| ------------------- | --------- |
| Requests per minute | 15        |
| Requests per day    | 1,500     |
| Tokens per minute   | 1,000,000 |

---

## 3. Gemini API Functions Reference

### 3.1 `generateContent` — Text Generation (Used in Chatbot)

The core function for generating text responses.

```php
// API Endpoint
POST https://generativelanguage.googleapis.com/v1beta/models/{model}:generateContent?key={apiKey}

// Request Body
{
    "system_instruction": {
        "parts": [{"text": "You are a helpful travel assistant."}]
    },
    "contents": [
        {"role": "user", "parts": [{"text": "Tell me about Tokyo"}]},
        {"role": "model", "parts": [{"text": "Tokyo is Japan's capital..."}]},
        {"role": "user", "parts": [{"text": "What hotels do you recommend?"}]}
    ],
    "generationConfig": {
        "maxOutputTokens": 512,
        "temperature": 0.7,
        "topP": 0.9,
        "topK": 40,
        "stopSequences": ["END"]
    }
}
```

**Laravel Implementation:**

```php
$response = Http::timeout(15)->post($url, [
    'system_instruction' => [
        'parts' => [['text' => $systemPrompt]],
    ],
    'contents' => $contents,
    'generationConfig' => [
        'maxOutputTokens' => 512,
        'temperature' => 0.7,
    ],
]);

$reply = $response->json()['candidates'][0]['content']['parts'][0]['text'];
```

### 3.2 `generateContent` — Multi-Modal (Image + Text)

Send images along with text for visual understanding.

```php
// Send an image URL with a question
$contents = [
    [
        'role' => 'user',
        'parts' => [
            [
                'inline_data' => [
                    'mime_type' => 'image/jpeg',
                    'data' => base64_encode(file_get_contents($imagePath)),
                ]
            ],
            ['text' => 'What landmark is this? Should I visit it?']
        ]
    ]
];

$response = Http::post($url, [
    'contents' => $contents,
]);
```

### 3.3 `streamGenerateContent` — Streaming Responses

Get responses token-by-token for real-time chat feel.

```php
// API Endpoint (add ?alt=sse)
POST https://generativelanguage.googleapis.com/v1beta/models/{model}:streamGenerateContent?key={apiKey}&alt=sse

// Laravel Streaming Implementation
$response = Http::withOptions(['stream' => true])->post($url, $payload);
$body = $response->getBody();

while (!$body->eof()) {
    $chunk = $body->read(1024);
    // Parse SSE data and send to frontend
    echo "data: " . json_encode(['chunk' => $chunk]) . "\n\n";
    ob_flush();
    flush();
}
```

### 3.4 `countTokens` — Token Counting

Check how many tokens your prompt uses before sending.

```php
// API Endpoint
POST https://generativelanguage.googleapis.com/v1beta/models/{model}:countTokens?key={apiKey}

$response = Http::post($countUrl, [
    'contents' => [
        ['role' => 'user', 'parts' => [['text' => $message]]]
    ]
]);

$tokenCount = $response->json()['totalTokens'];
// Use this to check if within limits before sending
```

### 3.5 `embedContent` — Text Embeddings

Generate vector embeddings for semantic search.

```php
// API Endpoint
POST https://generativelanguage.googleapis.com/v1beta/models/text-embedding-004:embedContent?key={apiKey}

$response = Http::post($embedUrl, [
    'model' => 'models/text-embedding-004',
    'content' => [
        'parts' => [['text' => 'Hotels near Tokyo Station']]
    ]
]);

$embedding = $response->json()['embedding']['values'];
// Returns a 768-dimensional vector array
// Use for: semantic search, recommendations, similarity matching
```

### 3.6 Generation Config Parameters

| Parameter          | Type   | Default      | Description                                           |
| ------------------ | ------ | ------------ | ----------------------------------------------------- |
| `temperature`      | float  | 1.0          | Creativity (0.0 = deterministic, 2.0 = very creative) |
| `topP`             | float  | 0.95         | Nucleus sampling threshold                            |
| `topK`             | int    | 40           | Top-K sampling                                        |
| `maxOutputTokens`  | int    | 8192         | Maximum response length                               |
| `stopSequences`    | array  | []           | Stop generation at these strings                      |
| `responseMimeType` | string | `text/plain` | Force JSON output with `application/json`             |
| `responseSchema`   | object | null         | JSON schema for structured output                     |

### 3.7 Structured JSON Output

Force Gemini to return structured JSON:

```php
$response = Http::post($url, [
    'contents' => $contents,
    'generationConfig' => [
        'responseMimeType' => 'application/json',
        'responseSchema' => [
            'type' => 'object',
            'properties' => [
                'hotel_name' => ['type' => 'string'],
                'city' => ['type' => 'string'],
                'rating' => ['type' => 'number'],
                'recommendation' => ['type' => 'string'],
            ],
            'required' => ['hotel_name', 'city', 'rating', 'recommendation'],
        ],
    ],
]);

// Returns: {"hotel_name": "Grand Sakura", "city": "Tokyo", "rating": 4.8, ...}
```

### 3.8 Safety Settings

Control content safety filters:

```php
$response = Http::post($url, [
    'contents' => $contents,
    'safetySettings' => [
        ['category' => 'HARM_CATEGORY_HARASSMENT', 'threshold' => 'BLOCK_ONLY_HIGH'],
        ['category' => 'HARM_CATEGORY_HATE_SPEECH', 'threshold' => 'BLOCK_ONLY_HIGH'],
        ['category' => 'HARM_CATEGORY_SEXUALLY_EXPLICIT', 'threshold' => 'BLOCK_ONLY_HIGH'],
        ['category' => 'HARM_CATEGORY_DANGEROUS_CONTENT', 'threshold' => 'BLOCK_ONLY_HIGH'],
    ],
]);
```

---

## 4. Step-by-Step Implementation

### Step 1: Create Config File

```php
// config/chatbot.php
return [
    'api_key' => env('GEMINI_API_KEY', ''),
    'model' => env('GEMINI_MODEL', 'gemini-2.0-flash'),
    'max_tokens' => env('CHATBOT_MAX_TOKENS', 512),
    'temperature' => env('CHATBOT_TEMPERATURE', 0.7),
    'system_prompt' => 'You are a helpful travel assistant...',
];
```

### Step 2: Create ChatbotService

```php
// app/Services/ChatbotService.php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotService
{
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('chatbot.api_key', '');
        $this->model = config('chatbot.model', 'gemini-2.0-flash');
    }

    public function reply(string $message, array $history = []): string
    {
        if (empty($this->apiKey)) {
            return $this->fallbackReply($message);
        }

        try {
            // Build conversation for multi-turn chat
            $contents = [];
            foreach ($history as $msg) {
                $contents[] = [
                    'role' => $msg['role'] === 'user' ? 'user' : 'model',
                    'parts' => [['text' => $msg['content']]],
                ];
            }
            $contents[] = [
                'role' => 'user',
                'parts' => [['text' => $message]],
            ];

            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";

            $response = Http::timeout(15)->post($url, [
                'system_instruction' => [
                    'parts' => [['text' => config('chatbot.system_prompt')]],
                ],
                'contents' => $contents,
                'generationConfig' => [
                    'maxOutputTokens' => config('chatbot.max_tokens'),
                    'temperature' => config('chatbot.temperature'),
                ],
            ]);

            if ($response->successful()) {
                return $response->json()['candidates'][0]['content']['parts'][0]['text']
                    ?? 'Sorry, I could not generate a response.';
            }

            if ($response->status() === 429) {
                return '⏳ Rate limited. Please wait and try again.';
            }

            return $this->fallbackReply($message);
        } catch (\Exception $e) {
            Log::error('Chatbot error', ['message' => $e->getMessage()]);
            return $this->fallbackReply($message);
        }
    }

    protected function fallbackReply(string $message): string
    {
        return "I'm currently in offline mode. Please try again later.";
    }
}
```

### Step 3: Create Controller

```php
// app/Http/Controllers/ChatController.php
namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat(Request $request, ChatbotService $chatbot): JsonResponse
    {
        $request->validate(['message' => 'required|string|max:1000']);

        $history = $request->session()->get('chat_history', []);
        $reply = $chatbot->reply($request->input('message'), $history);

        // Store conversation (keep last 20 messages)
        $history[] = ['role' => 'user', 'content' => $request->input('message')];
        $history[] = ['role' => 'assistant', 'content' => $reply];
        $request->session()->put('chat_history', array_slice($history, -20));

        return response()->json(['reply' => $reply]);
    }
}
```

### Step 4: Add Route

```php
// routes/web.php
Route::post('/chat', [ChatController::class, 'chat'])->name('chat.send');
```

### Step 5: Create Chat Widget (Frontend)

```html
<!-- Floating Chat Button -->
<button
    onclick="toggleChat()"
    class="fixed bottom-6 right-6 w-14 h-14 rounded-full bg-blue-600"
>
    💬
</button>

<!-- Chat Panel -->
<div
    id="chat-panel"
    class="hidden fixed bottom-24 right-6 w-96 bg-white rounded-2xl shadow-xl"
>
    <div id="messages" class="h-80 overflow-y-auto p-4"></div>
    <form onsubmit="sendMessage(event)" class="flex p-3 border-t">
        <input
            id="chat-input"
            type="text"
            class="flex-1 border rounded-lg px-3 py-2"
        />
        <button
            type="submit"
            class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg"
        >
            Send
        </button>
    </form>
</div>

<script>
    async function sendMessage(e) {
        e.preventDefault();
        const input = document.getElementById("chat-input");
        const msg = input.value.trim();
        if (!msg) return;
        input.value = "";

        // Add user message to UI
        addMessage(msg, "user");

        // Send to backend
        const res = await fetch("/chat", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
            body: JSON.stringify({ message: msg }),
        });

        const data = await res.json();
        addMessage(data.reply, "bot");
    }

    function addMessage(text, sender) {
        const div = document.createElement("div");
        div.className =
            sender === "user" ? "text-right mb-2" : "text-left mb-2";
        div.innerHTML = `<span class="inline-block px-3 py-2 rounded-lg ${
            sender === "user" ? "bg-blue-100" : "bg-gray-100"
        }">${text}</span>`;
        document.getElementById("messages").appendChild(div);
    }

    function toggleChat() {
        document.getElementById("chat-panel").classList.toggle("hidden");
    }
</script>
```

---

## 5. Code Walkthrough

### Project Files

```
app/
├── Http/Controllers/
│   └── ChatController.php      ← Handles chat API requests
├── Services/
│   └── ChatbotService.php      ← Gemini API integration + fallback
config/
└── chatbot.php                 ← API key, model, system prompt
resources/views/layouts/
└── app.blade.php               ← Chat widget UI (bottom of file)
routes/
└── web.php                     ← POST /chat route
```

### Request Flow

```
1. User types message → JavaScript AJAX POST to /chat
2. ChatController validates input, loads session history
3. ChatbotService builds Gemini API request with:
   - System instruction (travel assistant persona)
   - Conversation history (multi-turn context)
   - User's current message
4. Gemini returns AI-generated response
5. Controller stores in session, returns JSON {reply}
6. JavaScript renders response in chat widget
```

---

## 6. Advanced Features

### 6.1 Function Calling (Tool Use)

Let Gemini call your app's functions:

```php
$response = Http::post($url, [
    'contents' => $contents,
    'tools' => [
        [
            'function_declarations' => [
                [
                    'name' => 'search_hotels',
                    'description' => 'Search for hotels in a specific city',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'city' => [
                                'type' => 'string',
                                'description' => 'City name (e.g., Tokyo, Singapore)',
                            ],
                            'max_price' => [
                                'type' => 'number',
                                'description' => 'Maximum price per night in USD',
                            ],
                        ],
                        'required' => ['city'],
                    ],
                ],
                [
                    'name' => 'search_flights',
                    'description' => 'Search for flights between cities',
                    'parameters' => [
                        'type' => 'object',
                        'properties' => [
                            'origin' => ['type' => 'string'],
                            'destination' => ['type' => 'string'],
                            'date' => ['type' => 'string'],
                        ],
                        'required' => ['origin', 'destination'],
                    ],
                ],
            ],
        ],
    ],
]);

// Check if Gemini wants to call a function
$candidate = $response->json()['candidates'][0];
$part = $candidate['content']['parts'][0];

if (isset($part['functionCall'])) {
    $functionName = $part['functionCall']['name'];
    $args = $part['functionCall']['args'];

    // Execute the function
    if ($functionName === 'search_hotels') {
        $results = $tripComApi->searchHotels($args['city'], $args['max_price'] ?? null);
    }

    // Send results back to Gemini for natural language response
    $contents[] = $candidate['content'];
    $contents[] = [
        'role' => 'user',
        'parts' => [[
            'functionResponse' => [
                'name' => $functionName,
                'response' => ['results' => $results],
            ]
        ]],
    ];

    // Get final response
    $finalResponse = Http::post($url, ['contents' => $contents]);
}
```

### 6.2 Chat with Context (Grounding)

Provide real-time data to Gemini:

```php
// Pull live data from your database/API
$hotels = $tripComApi->searchHotels($city);
$context = "Available hotels:\n";
foreach ($hotels as $hotel) {
    $context .= "- {$hotel['name']}, {$hotel['city']}, \${$hotel['price_per_night']}/night\n";
}

// Include as system instruction context
$systemPrompt = "You are a travel assistant. Here is current data:\n" . $context;
```

### 6.3 Conversation Memory with Database

For persistent chat history across sessions:

```php
// Migration
Schema::create('chat_messages', function (Blueprint $table) {
    $table->id();
    $table->string('session_id');
    $table->enum('role', ['user', 'assistant']);
    $table->text('content');
    $table->timestamps();
});

// Store in DB instead of session
ChatMessage::create([
    'session_id' => session()->getId(),
    'role' => 'user',
    'content' => $userMessage,
]);
```

---

## 7. Troubleshooting

| Error                     | Cause                    | Solution                                     |
| ------------------------- | ------------------------ | -------------------------------------------- |
| `429 Rate Limited`        | Free tier quota exceeded | Wait 1 min (per-min) or 24h (per-day)        |
| `403 Forbidden`           | Invalid API key          | Check `GEMINI_API_KEY` in `.env`             |
| `400 Bad Request`         | Malformed request body   | Check JSON structure matches API spec        |
| Generic fallback response | Empty `GEMINI_API_KEY`   | Add your API key to `.env`                   |
| Browser timeout           | Response too slow        | Reduce `maxOutputTokens` or use `flash-lite` |
| Blank response            | Content safety blocked   | Adjust `safetySettings` thresholds           |

### Debug Commands

```bash
# Check if API key is loaded
php artisan tinker --execute="echo config('chatbot.api_key');"

# Clear config cache after .env changes
php artisan config:clear

# Check Laravel logs for API errors
tail -50 storage/logs/laravel.log

# Test API directly with curl
curl -X POST "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=YOUR_KEY" \
  -H "Content-Type: application/json" \
  -d '{"contents":[{"parts":[{"text":"Hello!"}]}]}'
```

---

## Quick Reference Card

```php
// 1. Text Chat (basic)
Http::post($url . ':generateContent', [
    'contents' => [['role' => 'user', 'parts' => [['text' => $msg]]]]
]);

// 2. Multi-turn Chat (with history)
Http::post($url . ':generateContent', [
    'system_instruction' => ['parts' => [['text' => $prompt]]],
    'contents' => $conversationHistory,
]);

// 3. Streaming
Http::post($url . ':streamGenerateContent?alt=sse', $payload);

// 4. Image Analysis
'parts' => [['inline_data' => ['mime_type' => 'image/jpeg', 'data' => $base64]], ['text' => 'Describe']]

// 5. JSON Output
'generationConfig' => ['responseMimeType' => 'application/json', 'responseSchema' => $schema]

// 6. Token Count
Http::post($url . ':countTokens', ['contents' => $contents]);

// 7. Embeddings
Http::post('models/text-embedding-004:embedContent', ['content' => $content]);

// 8. Function Calling
'tools' => [['function_declarations' => [...]]];
```
