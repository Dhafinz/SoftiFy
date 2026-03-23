<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AppViewService;
use Illuminate\Support\Facades\Auth;

class LeaderboardController extends Controller
{
    public function __construct(private readonly AppViewService $appView)
    {
    }

    public function index()
    {
        /** @var User $viewer */
        $viewer = Auth::user();

        $rows = User::query()->get()->map(function (User $user) {
            $doneTasks = (int) $user->tasks()->where('is_done', true)->count();
            $targetProgress = $this->appView->targetProgressPercent($user);
            $score = $this->appView->leaderboardScore($user);

            return [
                'id' => $user->id,
                'name' => $user->name,
                'class_level' => $user->class_level,
                'done_tasks' => $doneTasks,
                'streak' => (int) $user->current_streak,
                'target_progress' => $targetProgress,
                'score' => $score,
            ];
        })->sortByDesc('score')->values();

        $notifications = $this->appView->notifications($viewer);
        $title = 'Leaderboard';

        return view('app.leaderboard', [
            'rows' => $rows,
            'notifications' => $notifications,
            'viewerId' => $viewer->id,
            'title' => $title,
        ]);
    }
}
