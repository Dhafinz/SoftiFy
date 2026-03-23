<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WebsiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::query()
            ->where('is_admin', false)
            ->latest('id')
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

        return view('admin.dashboard', compact('users', 'pendingPremiumUsers', 'settings', 'title'));
    }

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
