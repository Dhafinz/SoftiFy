<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class AiAssistantService
{
    public function answer(User $user, string $question): string
    {
        $apiKey = env('OPENAI_API_KEY');

        if (! $apiKey) {
            return $this->fallbackAnswer($question);
        }

        try {
            $response = Http::withToken($apiKey)
                ->timeout(20)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
                    'messages' => [
                        ['role' => 'system', 'content' => 'Kamu adalah asisten belajar untuk pelajar Indonesia. Jawaban singkat, jelas, dan ramah pemula.'],
                        ['role' => 'user', 'content' => $question],
                    ],
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                return (string) data_get($response->json(), 'choices.0.message.content', $this->fallbackAnswer($question));
            }
        } catch (\Throwable $e) {
            // Fall through to fallback response for better UX.
        }

        return $this->fallbackAnswer($question);
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

    private function fallbackAnswer(string $question): string
    {
        return "Berikut jawaban singkat untuk pertanyaanmu: {$question}\n\n1. Pecah materi jadi bagian kecil.\n2. Gunakan teknik Pomodoro 25 menit fokus + 5 menit istirahat.\n3. Akhiri dengan review 10 menit supaya ingatan lebih kuat.";
    }
}
