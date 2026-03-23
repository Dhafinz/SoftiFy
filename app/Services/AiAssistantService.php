<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class AiAssistantService
{
    public const CHAT_MESSAGE_LIMIT = 20;

    public const CHAT_WINDOW_HOURS = 24;

    public function answer(User $user, string $question, Collection $recentMessages): string
    {
        $apiKey = env('OPENAI_API_KEY');

        $messages = [
            [
                'role' => 'system',
                'content' => 'Kamu adalah asisten personal untuk pelajar Indonesia. Boleh jawab pertanyaan umum apa pun, termasuk rekomendasi aktivitas hari ini, rencana belajar, produktivitas, dan manajemen waktu. Gaya bahasa santai, jelas, dan langsung actionable. Berikan langkah konkret. Jika user minta jadwal, buatkan rencana jam-per-jam yang realistis.',
            ],
            [
                'role' => 'system',
                'content' => $this->buildUserContext($user),
            ],
        ];

        foreach ($recentMessages as $message) {
            $messages[] = [
                'role' => $message->role === 'assistant' ? 'assistant' : 'user',
                'content' => (string) $message->message,
            ];
        }

        $messages[] = ['role' => 'user', 'content' => $question];

        if (! $apiKey) {
            return $this->fallbackAnswer($user, $question);
        }

        try {
            $response = Http::withToken($apiKey)
                ->timeout(20)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
                    'messages' => $messages,
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                return (string) data_get($response->json(), 'choices.0.message.content', $this->fallbackAnswer($user, $question));
            }
        } catch (\Throwable $e) {
            // Fall through to fallback response for better UX.
        }

        return $this->fallbackAnswer($user, $question);
    }

    public function chatMessageLimit(): int
    {
        return self::CHAT_MESSAGE_LIMIT;
    }

    public function chatWindowHours(): int
    {
        return self::CHAT_WINDOW_HOURS;
    }

    public function chatUsageInWindow(User $user): int
    {
        return (int) $user->aiMessages()
            ->where('mode', 'chat')
            ->where('role', 'user')
            ->where('created_at', '>=', now()->subHours(self::CHAT_WINDOW_HOURS))
            ->count();
    }

    public function remainingChatMessages(User $user): int
    {
        return max(0, self::CHAT_MESSAGE_LIMIT - $this->chatUsageInWindow($user));
    }

    public function recentChatMessages(User $user, int $limit = 12): Collection
    {
        return $user->aiMessages()
            ->where('mode', 'chat')
            ->whereIn('role', ['user', 'assistant'])
            ->latest('id')
            ->limit($limit)
            ->get()
            ->reverse()
            ->values();
    }

    public function scheduleTaskLimit(User $user): int
    {
        return $user->is_premium ? 5 : 2;
    }

    public function generateTodaySchedule(User $user): array
    {
        $today = now()->toDateString();
        $taskLimit = $this->scheduleTaskLimit($user);

        $todayTasks = $user->tasks()
            ->where('is_done', false)
            ->whereDate('due_date', $today)
            ->orderByRaw("CASE priority WHEN 'high' THEN 1 WHEN 'medium' THEN 2 ELSE 3 END")
            ->orderBy('id')
            ->get();

        $availableCount = $todayTasks->count();
        $tasks = $todayTasks->take($taskLimit)->values();

        if ($tasks->isEmpty()) {
            $tasks = $this->createFallbackTodayTasks($user, $taskLimit, $today);
        }

        $schedule = [];
        $cursor = Carbon::today()->setTime(8, 0);

        foreach ($tasks as $task) {
            $duration = max(60, min(120, (int) ($task->estimated_minutes ?? 60)));

            $task->update([
                'due_date' => $today,
                'time' => $cursor->format('H:i:s'),
                'status' => $task->is_done ? 'done' : 'pending',
            ]);

            $schedule[] = sprintf('%s - %s', $cursor->format('H:i'), $task->title);
            $cursor->addMinutes($duration);
        }

        return [
            'lines' => $schedule,
            'saved_count' => count($schedule),
            'task_limit' => $taskLimit,
            'available_count' => $availableCount,
            'was_limited' => $availableCount > $taskLimit,
            'plan' => $user->is_premium ? 'premium' : 'free',
        ];
    }

    private function createFallbackTodayTasks(User $user, int $taskLimit, string $today): Collection
    {
        $fallbacks = [
            ['title' => 'Belajar Matematika Bab 1', 'subject' => 'Matematika'],
            ['title' => 'Latihan Coding Dasar', 'subject' => 'Informatika'],
            ['title' => 'Review Catatan Pelajaran', 'subject' => 'Review'],
            ['title' => 'Latihan Soal Campuran', 'subject' => 'Mandiri'],
            ['title' => 'Rangkuman Belajar Hari Ini', 'subject' => 'Refleksi'],
        ];

        $created = collect();

        foreach (collect($fallbacks)->take($taskLimit) as $fallback) {
            $created->push($user->tasks()->create([
                'title' => $fallback['title'],
                'subject' => $fallback['subject'],
                'description' => 'Task otomatis dari AI Mode 2.',
                'priority' => 'medium',
                'estimated_minutes' => 60,
                'due_date' => $today,
                'status' => 'pending',
                'is_done' => false,
            ]));
        }

        return $created;
    }

    private function buildUserContext(User $user): string
    {
        $today = now()->toDateString();

        $todayTasks = $user->tasks()
            ->whereDate('due_date', $today)
            ->orderByRaw("CASE priority WHEN 'high' THEN 1 WHEN 'medium' THEN 2 ELSE 3 END")
            ->orderBy('time')
            ->orderBy('id')
            ->limit(5)
            ->get(['title', 'priority', 'time', 'is_done']);

        if ($todayTasks->isEmpty()) {
            return 'Konteks user: belum ada task untuk hari ini.';
        }

        $lines = $todayTasks->map(function ($task): string {
            $time = $task->time ? Carbon::parse($task->time)->format('H:i') : '--:--';
            $status = $task->is_done ? 'done' : 'pending';

            return "- {$time} | {$task->title} | {$task->priority} | {$status}";
        })->implode("\n");

        return "Konteks task user hari ini:\n{$lines}";
    }

    private function fallbackAnswer(User $user, string $question): string
    {
        $lowerQuestion = mb_strtolower($question);

        if (str_contains($lowerQuestion, 'jadwal') || str_contains($lowerQuestion, 'hari ini') || str_contains($lowerQuestion, 'ngapain')) {
            $tasks = $user->tasks()
                ->whereDate('due_date', now()->toDateString())
                ->where('is_done', false)
                ->orderByRaw("CASE priority WHEN 'high' THEN 1 WHEN 'medium' THEN 2 ELSE 3 END")
                ->orderBy('id')
                ->limit(3)
                ->get();

            if ($tasks->isNotEmpty()) {
                $start = Carbon::today()->setTime(8, 0);
                $lines = [];

                foreach ($tasks as $task) {
                    $lines[] = $start->format('H:i').' - '.$task->title;
                    $start->addMinutes(max(60, (int) ($task->estimated_minutes ?? 60)));
                }

                return "Rekomendasi aktivitas hari ini:\n".implode("\n", $lines)."\n\nTips: mulai dari prioritas tinggi dulu, lalu review 10 menit di akhir sesi.";
            }

            return "Boleh, ini saran aktivitas hari ini:\n1. 08:00-09:00 fokus 1 materi paling sulit.\n2. 10:00-11:00 latihan soal.\n3. 13:30-14:00 review catatan.\n4. 16:00-16:30 evaluasi progres + siapkan rencana besok.";
        }

        return "Jawaban singkat untuk pertanyaanmu: {$question}\n\n1. Tentukan target yang spesifik dulu.\n2. Kerjakan langkah kecil paling penting dalam 25-45 menit fokus.\n3. Cek hasilnya, lalu lanjut langkah berikutnya.";
    }
}
