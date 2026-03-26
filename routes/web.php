<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AIController;
use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiaryController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PrivateChatController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StudySessionController;
use App\Http\Controllers\TargetController;
use App\Http\Controllers\TargetLogController;
use App\Http\Controllers\TaskController;
use App\Models\Review;
use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Route;

$pageViewData = static function (): array {
    $howItWorksRaw = WebsiteSetting::getValue('homepage_how_it_works', '');

    $howItWorks = collect(preg_split('/\r\n|\r|\n/', $howItWorksRaw ?: ''))
        ->map(function (string $line): ?array {
            $parts = explode('|', $line, 2);
            if (count($parts) < 2) {
                return null;
            }

            $title = trim($parts[0]);
            $description = trim($parts[1]);

            if ($title === '' || $description === '') {
                return null;
            }

            return ['title' => $title, 'description' => $description];
        })
        ->filter()
        ->values()
        ->all();

    $totalUsers = 0;
    $activeUsers = 0;
    $averageRating = null;
    $recentReviews = collect();
    $totalReviews = 0;

    try {
        $totalUsers = User::query()->count();

        $activeUsers = User::query()
            ->where(function ($query) {
                $query->whereHas('studySessions', fn ($sessions) => $sessions->where('created_at', '>=', now()->subDays(30)))
                    ->orWhereHas('tasks', fn ($tasks) => $tasks->where('updated_at', '>=', now()->subDays(30)))
                    ->orWhereHas('diaries', fn ($diaries) => $diaries->where('updated_at', '>=', now()->subDays(30)));
            })
            ->count();

        $avgRatingRaw = (float) Review::query()->avg('rating');
        $averageRating = $avgRatingRaw > 0 ? round($avgRatingRaw, 1) : null;

        $recentReviews = Review::query()
            ->with('user:id,name')
            ->latest('id')
            ->limit(6)
            ->get();

        $totalReviews = Review::query()->count();
    } catch (QueryException) {
        // Keep homepage available when review table is not migrated yet.
    }

    return [
        'premiumPriceMonthly' => (int) WebsiteSetting::getValue('premium_price_monthly', '49000'),
        'premiumFeatureLines' => collect(preg_split('/\r\n|\r|\n/', WebsiteSetting::getValue('premium_feature_lines', '') ?: ''))
            ->map(fn (string $line): string => trim($line))
            ->filter()
            ->values()
            ->all(),
        'howItWorksSteps' => $howItWorks,
        'heroTotalUsers' => $totalUsers,
        'heroActiveUsers' => $activeUsers,
        'heroAverageRating' => $averageRating,
        'recentReviews' => $recentReviews,
        'totalReviews' => $totalReviews,
    ];
};

Route::get('/', function () use ($pageViewData) {
    return view('page', $pageViewData());
})->name('welcome');

Route::get('/page', function () use ($pageViewData) {
    return view('page', $pageViewData());
})->name('page');

Route::get('/tentang-kami', function () use ($pageViewData) {
    return view('about', $pageViewData());
})->name('about');

Route::get('/ulasan', [ReviewController::class, 'publicIndex'])->name('reviews.public');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('daftar');
    Route::post('/daftar', [AuthController::class, 'register'])->name('daftar.process');
});

Route::middleware(['auth', 'not.banned'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/targets', [TargetController::class, 'index'])->name('targets.index');
    Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai.index');
    Route::get('/challenge', [ChallengeController::class, 'index'])->name('challenge.index');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::get('/chat', [PrivateChatController::class, 'index'])->name('chat.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/premium', [PremiumController::class, 'index'])->name('premium');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::post('/targets', [TargetController::class, 'store'])->name('targets.store');
    Route::patch('/targets/{target}', [TargetController::class, 'update'])->name('targets.update');
    Route::post('/targets/{target}/logs', [TargetLogController::class, 'store'])->name('targets.logs.store');
    Route::patch('/targets/{target}/progress', [TargetLogController::class, 'store'])->name('targets.progress');
    Route::delete('/targets/{target}', [TargetController::class, 'destroy'])->name('targets.destroy');

    Route::post('/study-sessions', [StudySessionController::class, 'store'])->name('study-session.store');
    Route::post('/challenge/sessions', [ChallengeController::class, 'storeSession'])->name('challenge.sessions.store');

    Route::post('/friends/request', [FriendController::class, 'sendRequest'])->name('friends.request');
    Route::patch('/friends/{friend}/accept', [FriendController::class, 'accept'])->name('friends.accept');
    Route::patch('/friends/{friend}/reject', [FriendController::class, 'reject'])->name('friends.reject');

    Route::get('/chat/{friend}/messages', [PrivateChatController::class, 'fetch'])->name('chat.fetch');
    Route::post('/chat/{friend}/messages', [PrivateChatController::class, 'store'])->name('chat.store');

    Route::post('/ai-assistant/chat', [AiAssistantController::class, 'chat'])->name('ai.chat');
    Route::post('/ai-chat', [AIController::class, 'chat'])->name('ai.chat.json');
    Route::post('/ai-assistant/generate-today', [AiAssistantController::class, 'generateTodaySchedule'])->name('ai.generate.today');
    Route::delete('/ai-assistant/clear', [AiAssistantController::class, 'clear'])->name('ai.clear');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/premium/activate', [PremiumController::class, 'activate'])->name('premium.activate');

    Route::resource('diary', DiaryController::class);
});

Route::middleware(['auth', 'not.banned', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // ===== DASHBOARD =====
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');

    // ===== USER MANAGEMENT =====
    Route::get('/users', [AdminController::class, 'listUsers'])->name('users.list');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::patch('/users/{user}/role', [AdminController::class, 'toggleUserRole'])->name('users.role.toggle');
    Route::patch('/users/{user}/status', [AdminController::class, 'toggleUserStatus'])->name('users.status.toggle');

    // ===== TASK MANAGEMENT =====
    Route::get('/users/{user}/tasks', [AdminController::class, 'listUserTasks'])->name('users.tasks');
    Route::delete('/tasks/{task}', [AdminController::class, 'deleteTask'])->name('tasks.delete');

    // ===== SESSIONS/CHALLENGE MANAGEMENT =====
    Route::get('/users/{user}/sessions', [AdminController::class, 'listUserSessions'])->name('users.sessions');

    // ===== STREAK MANAGEMENT =====
    Route::patch('/users/{user}/streak/reset', [AdminController::class, 'resetUserStreak'])->name('users.streak.reset');

    // ===== PREMIUM MANAGEMENT =====
    Route::patch('/users/{user}/ban', [AdminController::class, 'toggleBan'])->name('users.ban.toggle');
    Route::patch('/users/{user}/premium', [AdminController::class, 'updatePremiumStatus'])->name('users.premium.update');
    Route::patch('/users/{user}/premium-toggle', [AdminController::class, 'togglePremium'])->name('users.premium.toggle');
});