<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AiAssistantController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PremiumController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudySessionController;
use App\Http\Controllers\StudyTargetController;
use App\Http\Controllers\TaskController;
use App\Models\WebsiteSetting;
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

    return [
        'premiumPriceMonthly' => (int) WebsiteSetting::getValue('premium_price_monthly', '49000'),
        'premiumFeatureLines' => collect(preg_split('/\r\n|\r|\n/', WebsiteSetting::getValue('premium_feature_lines', '') ?: ''))
            ->map(fn (string $line): string => trim($line))
            ->filter()
            ->values()
            ->all(),
        'howItWorksSteps' => $howItWorks,
    ];
};

Route::get('/', function () use ($pageViewData) {
    return view('page', $pageViewData());
})->name('welcome');

Route::get('/page', function () use ($pageViewData) {
    return view('page', $pageViewData());
})->name('page');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('daftar');
    Route::post('/daftar', [AuthController::class, 'register'])->name('daftar.process');
});

Route::middleware(['auth', 'not.banned'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/targets', [StudyTargetController::class, 'index'])->name('targets.index');
    Route::get('/ai-assistant', [AiAssistantController::class, 'index'])->name('ai.index');
    Route::get('/challenge', [ChallengeController::class, 'index'])->name('challenge.index');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard.index');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/premium', [PremiumController::class, 'index'])->name('premium.index');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    Route::post('/targets', [StudyTargetController::class, 'store'])->name('targets.store');
    Route::patch('/targets/{target}', [StudyTargetController::class, 'update'])->name('targets.update');
    Route::patch('/targets/{target}/progress', [StudyTargetController::class, 'updateProgress'])->name('targets.progress');
    Route::delete('/targets/{target}', [StudyTargetController::class, 'destroy'])->name('targets.destroy');

    Route::post('/study-sessions', [StudySessionController::class, 'store'])->name('study-session.store');
    Route::post('/challenge/sessions', [ChallengeController::class, 'storeSession'])->name('challenge.sessions.store');

    Route::post('/ai-assistant/chat', [AiAssistantController::class, 'chat'])->name('ai.chat');
    Route::post('/ai-assistant/generate-today', [AiAssistantController::class, 'generateTodaySchedule'])->name('ai.generate.today');
    Route::delete('/ai-assistant/clear', [AiAssistantController::class, 'clear'])->name('ai.clear');

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/premium/activate', [PremiumController::class, 'activate'])->name('premium.activate');
});

Route::middleware(['auth', 'not.banned', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::patch('/users/{user}/ban', [AdminController::class, 'toggleBan'])->name('users.ban.toggle');
    Route::patch('/users/{user}/premium', [AdminController::class, 'updatePremiumStatus'])->name('users.premium.update');
    Route::patch('/users/{user}/premium-toggle', [AdminController::class, 'togglePremium'])->name('users.premium.toggle');
});