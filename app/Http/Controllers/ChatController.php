<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AIContextService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    protected $contextService;

    public function __construct(AIContextService $contextService)
    {
        $this->contextService = $contextService;
    }

    /**
     * Handle the chatbot request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');

        if (!$apiKey) {
            return response()->json([
                'message' => "I'm sorry, my AI brain isn't connected right now. Please check back later!",
                'error' => 'Missing API Key'
            ], 503);
        }

        $systemPrompt = $this->contextService->getSystemPrompt();
        $storeContext = $this->contextService->getStoreContext();
        $userMessage = $request->input('message');

        try {
            // switching to gemini-flash-lite-latest as 2.0-flash has 0 quota limit
            $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-lite-latest:generateContent?key={$apiKey}";
            
            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => "{$systemPrompt}\n\n{$storeContext}\n\nUser Question: {$userMessage}"]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 800,
                ]
            ];

            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post($apiUrl, $payload);

            if ($response->failed()) {
                Log::error('Gemini API Failure', [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]);

                return response()->json([
                    'message' => "I'm having a bit of trouble thinking right now. Could you ask again?",
                    'error_details' => $response->json()
                ], 500);
            }

            $data = $response->json();
            
            // Check for candidates and content
            if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                Log::warning('Unexpected Gemini API Structure', ['response' => $data]);
                return response()->json([
                    'message' => "I didn't quite catch that. Could you rephrase?",
                    'error_details' => $data
                ], 500);
            }

            $aiText = $data['candidates'][0]['content']['parts'][0]['text'];

            return response()->json([
                'message' => $aiText,
            ]);

        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json([
                'message' => "Oops! Something went wrong on my end. I'll be back shortly.",
            ], 500);
        }
    }
}
