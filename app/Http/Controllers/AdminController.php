<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use App\Models\StudySession;
use App\Models\WebsiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ===== DASHBOARD =====
    public function index()
    {
        $totalUsers = User::where('is_admin', false)->count();
        $totalTasks = Task::count();
        $totalSessions = StudySession::count();
        $totalPremiumUsers = User::where('is_premium', true)->where('is_admin', false)->count();

        $users = User::query()
            ->where('is_admin', false)
            ->latest('id')
            ->limit(10)
            ->get();

        $pendingPremiumUsers = User::query()
            ->where('premium_verification_status', 'pending')
            ->latest('premium_payment_submitted_at')
            ->get();

        $settings = [
            'premium_price_monthly' => WebsiteSetting::getValue('premium_price_monthly', '49000'),
            'premium_feature_lines' => WebsiteSetting::getValue('premium_feature_lines', ''),
            'homepage_how_it_works' => WebsiteSetting::getValue('homepage_how_it_works', ''),
        ];

        $title = 'Admin Dashboard';

        return view('admin.dashboard', compact('totalUsers', 'totalTasks', 'totalSessions', 'totalPremiumUsers', 'users', 'pendingPremiumUsers', 'settings', 'title'));
    }

    // ===== USER MANAGEMENT =====
    public function listUsers(Request $request)
    {
        $search = $request->get('search');

        $query = User::where('is_admin', false);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest('created_at')->paginate(15);

        $title = 'Manajemen User';

        return view('admin.users.index', compact('users', 'title', 'search'));
    }

    public function editUser(User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users.list')->withErrors(['admin' => 'Tidak bisa edit akun admin.']);
        }

        $title = 'Edit User: ' . $user->name;

        return view('admin.users.edit', compact('user', 'title'));
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        if ($user->is_admin) {
            return back()->withErrors(['admin' => 'Tidak bisa edit akun admin.']);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'class_level' => ['nullable', 'string', 'max:255'],
            'learning_goal' => ['nullable', 'string', 'max:500'],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.list')->with('success', 'User berhasil diperbarui.');
    }

    public function deleteUser(User $user): RedirectResponse
    {
        if ($user->is_admin) {
            return back()->withErrors(['admin' => 'Tidak bisa hapus akun admin.']);
        }

        $user->delete();

        return redirect()->route('admin.users.list')->with('success', 'User berhasil dihapus.');
    }

    public function toggleUserRole(User $user): RedirectResponse
    {
        if ($user->is_admin && Auth::id() !== $user->id) {
            // Jangan biarkan admin lain disable akun admin
            return back();
        }

        $user->update(['is_admin' => !$user->is_admin]);

        $action = $user->is_admin ? 'dipromosikan menjadi admin' : 'diturunkan menjadi user biasa';

        return back()->with('success', "User {$user->name} berhasil {$action}.");
    }

    public function toggleUserStatus(User $user): RedirectResponse
    {
        if ($user->is_admin) {
            return back()->withErrors(['admin' => 'Akun admin tidak bisa dinonaktifkan.']);
        }

        $user->update(['is_banned' => !$user->is_banned, 'banned_at' => $user->is_banned ? null : now()]);

        $status = $user->is_banned ? 'dinonaktifkan' : 'diaktifkan';

        return back()->with('success', "User {$user->name} berhasil {$status}.");
    }

    // ===== TASK MANAGEMENT =====
    public function listUserTasks(User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users.list')->withErrors(['admin' => 'Admin tidak memiliki task.']);
        }

        $tasks = Task::where('user_id', $user->id)->latest('created_at')->paginate(20);

        $title = "Task User: {$user->name}";

        return view('admin.tasks.index', compact('user', 'tasks', 'title'));
    }

    public function deleteTask(Task $task): RedirectResponse
    {
        $user = $task->user;
        $task->delete();

        return back()->with('success', "Task berhasil dihapus.");
    }

    // ===== CHALLENGE/STUDY SESSION MANAGEMENT =====
    public function listUserSessions(User $user)
    {
        if ($user->is_admin) {
            return redirect()->route('admin.users.list')->withErrors(['admin' => 'Admin tidak memiliki study session.']);
        }

        $sessions = StudySession::where('user_id', $user->id)->latest('created_at')->paginate(20);

        $title = "Challenge/Timer User: {$user->name}";

        return view('admin.sessions.index', compact('user', 'sessions', 'title'));
    }

    // ===== STREAK MANAGEMENT =====
    public function resetUserStreak(User $user): RedirectResponse
    {
        if ($user->is_admin) {
            return back()->withErrors(['admin' => 'Akun admin tidak bisa direset streak-nya.']);
        }

        $user->update(['current_streak' => 0]);

        return back()->with('success', "Streak user {$user->name} berhasil direset.");
    }

    // ===== PREMIUM MANAGEMENT =====
    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'premium_price_monthly' => ['required', 'integer', 'min:0'],
            'premium_feature_lines' => ['required', 'string'],
            'homepage_how_it_works' => ['required', 'string'],
        ]);

        foreach ($validated as $key => $value) {
            WebsiteSetting::setValue($key, (string) $value);
        }

        return back()->with('success', 'Pengaturan website berhasil diperbarui.');
    }

    public function toggleBan(User $user): RedirectResponse
    {
        if ($user->is_admin) {
            return back()->withErrors(['admin' => 'Akun admin tidak bisa diblokir.']);
        }

        $nextBan = ! $user->is_banned;

        $user->update([
            'is_banned' => $nextBan,
            'banned_at' => $nextBan ? now() : null,
        ]);

        return back()->with('success', $nextBan ? 'User berhasil diblokir.' : 'User berhasil dibuka blokirnya.');
    }

    public function updatePremiumStatus(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'action' => ['required', 'in:approve,reject'],
        ]);

        if ($validated['action'] === 'approve') {
            $user->update([
                'is_premium' => true,
                'premium_verification_status' => 'approved',
                'premium_activated_at' => now(),
            ]);

            return back()->with('success', 'Premium user berhasil di-ACC.');
        }

        $user->update([
            'is_premium' => false,
            'premium_verification_status' => 'rejected',
            'premium_activated_at' => null,
        ]);

        return back()->with('success', 'Pengajuan premium ditolak.');
    }

    public function togglePremium(User $user): RedirectResponse
    {
        if ($user->is_admin) {
            return back()->withErrors(['admin' => 'Akun admin tidak bisa diubah plan-nya.']);
        }

        $nextPremium = ! $user->is_premium;

        $user->update([
            'is_premium' => $nextPremium,
            'premium_verification_status' => $nextPremium ? 'approved' : null,
            'premium_activated_at' => $nextPremium ? now() : null,
        ]);

        return back()->with('success', $nextPremium ? 'Plan user diubah ke Premium.' : 'Plan user diubah ke Free.');
    }
}
