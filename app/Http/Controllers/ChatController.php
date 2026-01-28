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

        $apiKey = config('services.gemini.key');
        $model = config('services.gemini.model', 'gemini-1.5-flash');

        if (!$apiKey) {
            Log::error('Chatbot Error: GEMINI_API_KEY is not set in environment variables.');
            return response()->json([
                'message' => "I'm sorry, my AI brain isn't connected right now. Please tell the administrator to set the GEMINI_API_KEY.",
                'error' => 'Missing API Key'
            ], 503);
        }

        $systemPrompt = $this->contextService->getSystemPrompt();
        $storeContext = $this->contextService->getStoreContext();
        $userMessage = $request->input('message');

        try {
            $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
            
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
                ->timeout(30)
                ->post($apiUrl, $payload);

            if ($response->failed()) {
                $errorData = $response->json();
                $errorMessage = $errorData['error']['message'] ?? 'Unknown Gemini API Error';
                
                Log::error('Gemini API Failure', [
                    'status' => $response->status(),
                    'error' => $errorMessage,
                    'details' => $errorData,
                ]);

                // User friendly message with technical hint for admin
                $displayMessage = "I'm having a bit of trouble thinking right now. Could you ask again?";
                if (str_contains($errorMessage, 'API_KEY_INVALID')) {
                    $displayMessage = "My API Key seems to be invalid. Please check the server configuration.";
                } elseif ($response->status() === 429) {
                    $displayMessage = "I'm a bit overwhelmed with requests right now. Please try again in a minute!";
                }

                return response()->json([
                    'message' => $displayMessage,
                    'error_details' => $errorData // Temporarily expose for debugging
                ], 500);
            }

            $data = $response->json();
            
            // Check for candidates and content
            if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                Log::warning('Unexpected Gemini API Structure', ['response' => $data]);
                return response()->json([
                    'message' => "I didn't quite catch that. Could you rephrase?",
                    'error_details' => $data // Temporarily expose for debugging
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
