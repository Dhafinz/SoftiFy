<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIController extends Controller
{
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $userMessage = trim($validated['message']);
        $apiKey = (string) config('services.openai.key', '');
        $model = (string) config('services.openai.model', 'gpt-4o-mini');

        if ($apiKey === '') {
            return response()->json([
                'ok' => true,
                'message' => $userMessage,
                'response' => $this->fallbackResponse($userMessage),
                'source' => 'fallback',
            ]);
        }

        try {
            $response = Http::withToken($apiKey)
                ->timeout(20)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $model,
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Kamu adalah AI Assistant untuk SoftiFY (platform manajemen belajar). Kamu membantu membuat jadwal belajar, memberi saran tugas, dan menjawab pertanyaan user. Jika ditanya siapa pembuatmu, jawab: Saya dibuat oleh Vega Fadan Putra untuk SoftiFY.',
                        ],
                        [
                            'role' => 'user',
                            'content' => $userMessage,
                        ],
                    ],
                    'temperature' => 0.7,
                ]);

            if (! $response->successful()) {
                return response()->json([
                    'ok' => false,
                    'message' => $userMessage,
                    'error' => 'OpenAI API request failed.',
                    'status_code' => $response->status(),
                ], 502);
            }

            $aiText = (string) data_get($response->json(), 'choices.0.message.content', '');

            if ($aiText === '') {
                return response()->json([
                    'ok' => false,
                    'message' => $userMessage,
                    'error' => 'OpenAI returned empty content.',
                ], 502);
            }

            return response()->json([
                'ok' => true,
                'message' => $userMessage,
                'response' => $aiText,
                'source' => 'openai',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'ok' => false,
                'message' => $userMessage,
                'error' => 'Failed to contact OpenAI API.',
                'detail' => $e->getMessage(),
            ], 500);
        }
    }

    private function fallbackResponse(string $userMessage): string
    {
        $text = mb_strtolower($userMessage);

        if (str_contains($text, 'siapa') && (str_contains($text, 'buat') || str_contains($text, 'pembuat'))) {
            return 'Saya dibuat oleh Vega Fadan Putra untuk SoftiFY.';
        }

        if (str_contains($text, 'jadwal') || str_contains($text, 'belajar')) {
            return "Contoh jadwal belajar hari ini:\n- 08:00-09:00: Fokus materi utama\n- 10:00-11:00: Latihan soal\n- 13:30-14:00: Review catatan\n- 19:00-19:30: Evaluasi hasil belajar";
        }

        if (str_contains($text, 'tugas') || str_contains($text, 'saran')) {
            return "Saran tugas sekarang:\n1. Kerjakan 1 tugas paling prioritas\n2. Pecah jadi 3 langkah kecil\n3. Kerjakan 30 menit fokus tanpa distraksi";
        }

        return 'Siap, saya bantu jawab: '.$userMessage;
    }
}
