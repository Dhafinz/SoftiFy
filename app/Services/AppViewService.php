<?php

namespace App\Services;

use App\Models\User;
use App\Models\StudyTarget;
use Illuminate\Support\Carbon;

class AppViewService
{
    public function notifications(User $user): array
    {
        $today = now()->toDateString();
        $tomorrow = now()->addDay()->toDateString();

        $pendingToday = $user->tasks()
            ->whereDate('due_date', $today)
            ->where('is_done', false)
            ->count();

        $overdue = $user->tasks()
            ->whereDate('due_date', '<', $today)
            ->where('is_done', false)
            ->count();

        $dueTomorrow = $user->tasks()
            ->whereDate('due_date', $tomorrow)
            ->where('is_done', false)
            ->count();

        $items = [];

        if ($pendingToday > 0) {
            $items[] = [
                'type' => 'warning',
                'text' => "Ada {$pendingToday} task hari ini yang belum selesai.",
            ];
        }

        if ($overdue > 0) {
            $items[] = [
                'type' => 'danger',
                'text' => "Ada {$overdue} task yang sudah melewati deadline.",
            ];
        }

        if ($dueTomorrow > 0) {
            $items[] = [
                'type' => 'info',
                'text' => "Reminder: {$dueTomorrow} task deadline besok.",
            ];
        }

        $weeklyUnfinished = $user->studyTargets()
            ->where('period_type', 'weekly')
            ->where('status', StudyTarget::STATUS_ACTIVE)
            ->count();

        if ($weeklyUnfinished > 0) {
            $items[] = [
                'type' => 'warning',
                'text' => "Target mingguan belum tercapai ({$weeklyUnfinished} target).",
            ];
        }

        if ($user->current_streak > 0 && $pendingToday > 0) {
            $items[] = [
                'type' => 'danger',
                'text' => 'Streak hampir hilang. Selesaikan task hari ini untuk menjaga streak.',
            ];
        }

        if ($items === []) {
            $items[] = [
                'type' => 'success',
                'text' => 'Semua aman. Tidak ada deadline mendesak saat ini.',
            ];
        }

        return $items;
    }

    public function leaderboardScore(User $user): int
    {
        $doneTasks = (int) $user->tasks()->where('is_done', true)->count();
        $streak = (int) $user->current_streak;

        $totalTarget = (int) $user->studyTargets()->sum('target_hours');
        $currentTarget = (int) $user->studyTargets()->sum('current_hours');
        $progress = $totalTarget > 0 ? (int) round(($currentTarget / $totalTarget) * 100) : 0;

        return ($doneTasks * 5) + ($streak * 8) + $progress;
    }

    public function targetProgressPercent(User $user): int
    {
        $totalTarget = (int) $user->studyTargets()->sum('target_hours');
        $currentTarget = (int) $user->studyTargets()->sum('current_hours');

        if ($totalTarget <= 0) {
            return 0;
        }

        return min(100, (int) round(($currentTarget / $totalTarget) * 100));
    }

    public function greeting(): string
    {
        $hour = (int) Carbon::now()->format('H');

        if ($hour < 12) {
            return 'Selamat pagi';
        }

        if ($hour < 18) {
            return 'Selamat siang';
        }

        return 'Selamat malam';
    }
}
