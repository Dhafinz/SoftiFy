<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WebsiteSetting;
use App\Services\AppViewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PremiumController extends Controller
{
    public function __construct(private readonly AppViewService $appView)
    {
    }

    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $notifications = $this->appView->notifications($user);
        $title = 'Premium';
        $premiumPriceMonthly = (int) WebsiteSetting::getValue('premium_price_monthly', '49000');
        $premiumFeatureLines = collect(preg_split('/\r\n|\r|\n/', WebsiteSetting::getValue('premium_feature_lines', '') ?: ''))
            ->map(fn (string $line): string => trim($line))
            ->filter()
            ->values()
            ->all();

        return view('app.premium', compact('user', 'notifications', 'title', 'premiumPriceMonthly', 'premiumFeatureLines'));
    }

    public function activate(Request $request)
    {
        $validated = $request->validate([
            'verification_email' => ['required', 'email', 'max:255'],
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ]);

        /** @var User $user */
        $user = Auth::user();

        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        if ($user->premium_payment_proof_path && Storage::disk('public')->exists($user->premium_payment_proof_path)) {
            Storage::disk('public')->delete($user->premium_payment_proof_path);
        }

        $user->update([
            'premium_verification_email' => $validated['verification_email'],
            'premium_payment_proof_path' => $proofPath,
            'premium_verification_status' => 'pending',
            'premium_payment_submitted_at' => now(),
        ]);

        return redirect()->route('premium.index')->with('success', 'Bukti pembayaran berhasil dikirim. Tim kami akan verifikasi pembayaran kamu melalui email.');
    }
}
