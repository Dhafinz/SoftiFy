<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return view('page');
});

Route::get('/page', function () {
    return view('page');
});

use App\Http\Controllers\AuthController;

Route::get('/auth', function () {
    return view('auth');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/admin', function () {
    $totalUsers = User::count();
    $newRegistrations = User::where('created_at', '>=', now()->subDays(7))->count();
    // For demo, reports and activity are static. Replace with real queries if needed.
    $reports = 5;
    $recentUsers = User::orderByDesc('created_at')->take(4)->get();
    return view('admin_dashboard', [
        'totalUsers' => $totalUsers,
        'newRegistrations' => $newRegistrations,
        'reports' => $reports,
        'recentUsers' => $recentUsers,
    ]);

    
});