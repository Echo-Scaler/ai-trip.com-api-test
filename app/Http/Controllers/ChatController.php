<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

        // Get AI response
        $reply = $this->chatbot->reply($userMessage, $history);

        // Store in session history (keep last 20 messages)
        $history[] = ['role' => 'user', 'content' => $userMessage];
        $history[] = ['role' => 'assistant', 'content' => $reply];
        $history = array_slice($history, -20);
        $request->session()->put('chat_history', $history);

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
