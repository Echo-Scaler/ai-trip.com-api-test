<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TripPlanReady;

class ChatController extends Controller
{
    protected ChatbotService $chatbot;

    public function __construct(ChatbotService $chatbot)
    {
        $this->chatbot = $chatbot;
    }

    /**
     * Handle a chat message and return AI response.
     */
    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');

        // Get conversation history from session
        $history = $request->session()->get('chat_history', []);

        try {
            // Get AI response
            $reply = $this->chatbot->reply($userMessage, $history);

            // Store in session history (keep last 20 messages)
            $history[] = ['role' => 'user', 'content' => $userMessage];
            $history[] = ['role' => 'assistant', 'content' => $reply];
            $history = array_slice($history, -20);
            $request->session()->put('chat_history', $history);

            // Simple logic for "automated" email: if user mentions "email" and there's a likely content
            if (preg_match('/(email|send).* (plan|itinerary|summary)/i', $userMessage) && strlen($reply) > 200) {
                // In a real app, we'd get the user's email from their profile. 
                // For this demo, we'll use a placeholder or check if they mentioned an email.
                preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', $userMessage, $matches);
                $targetEmail = $matches[0] ?? 'demo@example.com';

                Mail::to($targetEmail)->send(new TripPlanReady($reply));
                $reply .= "\n\n(Note: I've also sent this trip plan to {$targetEmail} for your convenience!)";
            }
        } catch (\Exception $e) {
            // If API fails (e.g. rate limit), return fallback error but DO NOT save to history
            $reply = $e->getMessage();
        }

        return response()->json([
            'reply' => $reply,
        ]);
    }

    /**
     * Clear chat history.
     */
    public function clear(Request $request): JsonResponse
    {
        $request->session()->forget('chat_history');

        return response()->json(['status' => 'cleared']);
    }
}
