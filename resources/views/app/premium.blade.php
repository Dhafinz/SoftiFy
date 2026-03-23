@extends('app.layout')

@section('content')
@php
    $displayPremiumFeatures = !empty($premiumFeatureLines ?? [])
        ? $premiumFeatureLines
        : [
            'AI Mode 2 generate 2-5 task per hari',
            'Prioritas schedule lebih fleksibel',
            'Cocok untuk planning belajar intensif',
        ];
@endphp
<div class="grid gap-4 lg:grid-cols-3">
    <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200 p-5">
        <div class="flex items-start justify-between gap-3 mb-4">
            <div>
                <h2 class="text-xl font-semibold">Upgrade Premium</h2>
                <p class="text-sm text-slate-600">Buka limit generate jadwal lebih besar dan optimalkan planning harianmu.</p>
            </div>
            <span class="text-xs px-3 py-1 rounded-full {{ $user->is_premium ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                {{ $user->is_premium ? 'PREMIUM ACTIVE' : 'FREE PLAN' }}
            </span>
        </div>

        <div class="rounded-2xl border border-softi-200 bg-gradient-to-r from-softi-50 to-blue-50 p-4 mb-4">
            <p class="text-xs uppercase tracking-wide text-softi-700 font-semibold">Harga</p>
            <p class="text-3xl font-black text-softi-700 mt-1">Rp{{ number_format((int) ($premiumPriceMonthly ?? 49000), 0, ',', '.') }}<span class="text-sm font-medium text-slate-600"> / bulan</span></p>
            <ul class="mt-3 text-sm text-slate-700 space-y-1">
                @foreach ($displayPremiumFeatures as $feature)
                    <li>{{ $feature }}</li>
                @endforeach
            </ul>
        </div>

        <div class="rounded-2xl border border-slate-200 p-4 bg-slate-50">
            <p class="font-semibold">Langkah Pembayaran (QRIS Manual)</p>
            <ol class="mt-2 text-sm text-slate-700 space-y-1 list-decimal list-inside">
                <li>Klik tombol upgrade, lalu scan QRIS di samping.</li>
                <li>Lakukan pembayaran manual sesuai nominal.</li>
                <li>Klik tombol "Saya sudah bayar", lalu kirim email dan bukti pembayaran untuk verifikasi.</li>
            </ol>
        </div>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 p-5 space-y-3">
        <h3 class="font-semibold">QRIS Pembayaran</h3>
        <img src="{{ asset('img/qris-placeholder.svg') }}" alt="QRIS SoftiFY" class="w-full rounded-xl border border-slate-200 bg-white p-2">
        <p class="text-xs text-slate-500">Gambar QRIS saat ini placeholder statis dan bisa diganti manual oleh admin.</p>

        <button id="openVerificationModal" type="button" class="w-full rounded-xl bg-softi-600 text-white py-2 font-medium">
            {{ $user->is_premium ? 'Kirim Ulang Bukti Pembayaran' : 'Saya sudah bayar' }}
        </button>

        @if ($user->premium_verification_status === 'pending')
            <div class="text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-xl px-3 py-2 space-y-1">
                <p class="font-semibold">Status verifikasi: MENUNGGU</p>
                <p>Email verifikasi: {{ $user->premium_verification_email }}</p>
                @if ($user->premium_payment_submitted_at)
                    <p>Dikirim pada: {{ $user->premium_payment_submitted_at->format('d M Y H:i') }}</p>
                @endif
            </div>
        @endif

        @if ($user->premium_verification_status === 'approved' && $user->is_premium)
            <div class="text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl px-3 py-2 space-y-1">
                <p class="font-semibold">Status verifikasi: DISETUJUI</p>
                <p>Title akun kamu sekarang: <strong>PREMIUM USER</strong>.</p>
            </div>
        @endif

        @if ($user->premium_verification_status === 'rejected')
            <div class="text-xs text-red-700 bg-red-50 border border-red-200 rounded-xl px-3 py-2 space-y-1">
                <p class="font-semibold">Status verifikasi: DITOLAK</p>
                <p>Silakan kirim ulang bukti pembayaran yang valid.</p>
            </div>
        @endif

        @if ($user->premium_activated_at)
            <p class="text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-xl px-3 py-2">
                Premium aktif sejak {{ $user->premium_activated_at->format('d M Y H:i') }}.
            </p>
        @endif
    </div>
</div>

<div id="verificationModal" class="fixed inset-0 bg-slate-900/50 hidden items-center justify-center p-4 z-50">
    <div class="w-full max-w-lg rounded-2xl bg-white border border-slate-200 p-5">
        <div class="flex items-start justify-between gap-3 mb-4">
            <div>
                <h3 class="font-semibold text-lg">Kirim Bukti Pembayaran</h3>
                <p class="text-sm text-slate-600">Isi email verifikasi dan upload bukti pembayaran untuk diproses tim kami.</p>
            </div>
            <button id="closeVerificationModal" type="button" class="text-slate-500 hover:text-slate-700 text-xl leading-none">&times;</button>
        </div>

        <form action="{{ route('premium.activate') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <div>
                <label for="verification_email" class="block text-sm font-medium text-slate-700 mb-1">Email Verifikasi</label>
                <input id="verification_email" name="verification_email" type="email" value="{{ old('verification_email', $user->email) }}" class="w-full rounded-xl border-slate-300" placeholder="nama@email.com" required>
            </div>
            <div>
                <label for="payment_proof" class="block text-sm font-medium text-slate-700 mb-1">Bukti Pembayaran</label>
                <input id="payment_proof" name="payment_proof" type="file" accept=".jpg,.jpeg,.png,.pdf" class="w-full rounded-xl border-slate-300" required>
                <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, PDF. Maksimal 4MB.</p>
            </div>
            <div class="grid grid-cols-2 gap-2 pt-1">
                <button type="button" id="cancelVerificationModal" class="rounded-xl border border-slate-300 text-slate-700 py-2">Batal</button>
                <button type="submit" class="rounded-xl bg-softi-600 text-white py-2">Kirim Verifikasi</button>
            </div>
        </form>
    </div>
</div>

<script>
const verificationModal = document.getElementById('verificationModal');
const openVerificationModal = document.getElementById('openVerificationModal');
const closeVerificationModal = document.getElementById('closeVerificationModal');
const cancelVerificationModal = document.getElementById('cancelVerificationModal');

function showVerificationModal() {
    verificationModal.classList.remove('hidden');
    verificationModal.classList.add('flex');
}

function hideVerificationModal() {
    verificationModal.classList.add('hidden');
    verificationModal.classList.remove('flex');
}

if (openVerificationModal) {
    openVerificationModal.addEventListener('click', showVerificationModal);
}

if (closeVerificationModal) {
    closeVerificationModal.addEventListener('click', hideVerificationModal);
}

if (cancelVerificationModal) {
    cancelVerificationModal.addEventListener('click', hideVerificationModal);
}

if (verificationModal) {
    verificationModal.addEventListener('click', (event) => {
        if (event.target === verificationModal) {
            hideVerificationModal();
        }
    });
}
</script>
@endsection
