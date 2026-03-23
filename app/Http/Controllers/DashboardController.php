<?php

namespace App\Http\Controllers;

use App\Models\StudySession;
use App\Models\StudyTarget;
use App\Models\User;
use App\Services\AppViewService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(private readonly AppViewService $appView)
    {
    }

    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $this->syncStreak($user);
        $user->refresh();

        $today = now()->toDateString();
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $todayTasksQuery = $user->tasks()->whereDate('due_date', $today);
        $todayTaskCount = (clone $todayTasksQuery)->count();
        $todayCompletedCount = (clone $todayTasksQuery)->where('is_done', true)->count();

        $targetProgress = $this->appView->targetProgressPercent($user);

        StudyTarget::syncStatusesForUser($user);

        $weekMinutes = (int) $user->studySessions()
            ->whereBetween('study_date', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
            ->sum('minutes');

        $weeklyHours = round($weekMinutes / 60, 1);

        $chartStart = now()->subDays(6);
        $rawDailyMinutes = StudySession::query()
            ->where('user_id', $user->id)
            ->whereBetween('study_date', [$chartStart->toDateString(), now()->toDateString()])
            ->selectRaw('study_date, SUM(minutes) as total_minutes')
            ->groupBy('study_date')
            ->pluck('total_minutes', 'study_date');

        $activityLabels = [];
        $activityHours = [];

        for ($date = $chartStart->copy(); $date->lte(now()); $date->addDay()) {
            $key = $date->toDateString();
            $activityLabels[] = $date->translatedFormat('D');
            $activityHours[] = round(((int) ($rawDailyMinutes[$key] ?? 0)) / 60, 1);
        }

        $tasks = $user->tasks()
            ->orderByDesc('due_date')
            ->orderBy('time')
            ->latest('id')
            ->limit(6)
            ->get();
        $targets = $user->studyTargets()
            ->with(['logs' => fn ($query) => $query->latest('date')->latest('id')])
            ->orderByRaw("CASE status WHEN 'active' THEN 0 WHEN 'expired' THEN 1 ELSE 2 END")
            ->orderBy('end_date')
            ->latest('id')
            ->limit(4)
            ->get();
        $latestSessions = $user->studySessions()->latest('study_date')->latest('id')->limit(4)->get();

        $todayAllDone = $todayTaskCount > 0 && $todayTaskCount === $todayCompletedCount;

        $graceUsed = $user->grace_month === now()->format('Y-m') ? $user->grace_used_month : 0;
        $graceRemaining = max(0, 3 - $graceUsed);

        $notifications = $this->appView->notifications($user);
        $leaderboardScore = $this->appView->leaderboardScore($user);
        $greeting = $this->appView->greeting();
        $title = 'Dashboard';

        return view('app.dashboard', compact(
            'todayTaskCount',
            'todayCompletedCount',
            'targetProgress',
            'weeklyHours',
            'activityLabels',
            'activityHours',
            'tasks',
            'targets',
            'latestSessions',
            'todayAllDone',
            'graceRemaining',
            'graceUsed',
            'notifications',
            'leaderboardScore',
            'greeting',
            'title'
        ));
    }

    private function syncStreak(User $user): void
    {
        $today = Carbon::today();
        $yesterday = $today->copy()->subDay();

        if ($yesterday->isBefore($today->copy()->subYears(3))) {
            return;
        }

        $startDate = $user->streak_calculated_at
            ? Carbon::parse($user->streak_calculated_at)->addDay()
            : collect([
                $user->tasks()->min('due_date'),
                $user->studySessions()->min('study_date'),
            ])->filter()->sort()->first();

        if (! $startDate) {
            return;
        }

        $startDate = Carbon::parse($startDate);

        if ($startDate->gt($yesterday)) {
            return;
        }

        for ($cursor = $startDate->copy(); $cursor->lte($yesterday); $cursor->addDay()) {
            $monthKey = $cursor->format('Y-m');
            if ($user->grace_month !== $monthKey) {
                $user->grace_month = $monthKey;
                $user->grace_used_month = 0;
            }

            $dailyTasks = $user->tasks()->whereDate('due_date', $cursor->toDateString());
            $total = (clone $dailyTasks)->count();

            $hasChallengeSession = $user->studySessions()
                ->where('source', 'challenge')
                ->whereDate('study_date', $cursor->toDateString())
                ->exists();

            if ($total === 0) {
                if ($hasChallengeSession) {
                    $user->current_streak += 1;
                }

                continue;
            }

            $done = (clone $dailyTasks)
                ->where('is_done', true)
                ->whereNotNull('completed_at')
                ->whereDate('completed_at', '<=', $cursor->toDateString())
                ->count();

            if ($done === $total || $hasChallengeSession) {
                $user->current_streak += 1;
                continue;
            }

            if ($user->grace_used_month < 3) {
                $user->grace_used_month += 1;
                continue;
            }

            $user->current_streak = 0;
        }

        $user->setAttribute('streak_calculated_at', $yesterday->toDateString());
        $user->save();
    }
}
