@extends('admin.layout')

@section('content')
<section class="rounded-3xl border border-indigo-100 bg-gradient-to-r from-white via-indigo-50 to-blue-50 p-6 shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-softi-700">Admin Workspace</p>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">Dashboard Kontrol SoftiFY</h2>
            <p class="text-sm text-slate-600 mt-2">Atur harga premium, kelola approval pembayaran, dan kontrol status seluruh user dari satu panel.</p>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200 px-4 py-3 shadow-sm">
            <p class="text-xs text-slate-500">Total user aktif sistem</p>
            <p class="text-3xl font-black text-softi-700">{{ $users->count() }}</p>
        </div>
    </div>
</section>

<div class="grid gap-4 md:grid-cols-4">
    <div class="rounded-2xl bg-gradient-to-br from-slate-900 to-slate-800 text-white p-4 shadow-lg shadow-slate-900/20">
        <p class="text-xs text-slate-300 uppercase tracking-wide">Total User</p>
        <p class="text-3xl font-black mt-1">{{ $users->count() }}</p>
        <p class="text-xs text-slate-300 mt-2">Semua akun non-admin</p>
    </div>
    <div class="rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white p-4 shadow-lg shadow-emerald-500/25">
        <p class="text-xs text-emerald-100 uppercase tracking-wide">User Premium</p>
        <p class="text-3xl font-black mt-1">{{ $users->where('is_premium', true)->count() }}</p>
        <p class="text-xs text-emerald-100 mt-2">Sudah berlangganan</p>
    </div>
    <div class="rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 text-white p-4 shadow-lg shadow-amber-500/25">
        <p class="text-xs text-amber-100 uppercase tracking-wide">Pending Premium</p>
        <p class="text-3xl font-black mt-1">{{ $pendingPremiumUsers->count() }}</p>
        <p class="text-xs text-amber-100 mt-2">Menunggu ACC admin</p>
    </div>
    <div class="rounded-2xl bg-gradient-to-br from-rose-500 to-red-600 text-white p-4 shadow-lg shadow-rose-500/25">
        <p class="text-xs text-rose-100 uppercase tracking-wide">User Diblokir</p>
        <p class="text-3xl font-black mt-1">{{ $users->where('is_banned', true)->count() }}</p>
        <p class="text-xs text-rose-100 mt-2">Status ban aktif</p>
    </div>
</div>

<div class="grid gap-4 lg:grid-cols-2">
    <section id="settings" class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-800">Pengaturan Website</h2>
        <p class="text-sm text-slate-500 mb-4">Atur harga premium, isi fitur premium, dan konten cara kerja landing page.</p>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1 text-slate-700" for="premium_price_monthly">Harga Premium per Bulan (Rp)</label>
                <input id="premium_price_monthly" name="premium_price_monthly" type="number" min="0" value="{{ old('premium_price_monthly', $settings['premium_price_monthly']) }}" class="w-full rounded-xl border-slate-300 focus:border-softi-600 focus:ring-softi-600" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1 text-slate-700" for="premium_feature_lines">Fitur Premium (satu baris satu fitur)</label>
                <textarea id="premium_feature_lines" name="premium_feature_lines" rows="5" class="w-full rounded-xl border-slate-300 focus:border-softi-600 focus:ring-softi-600" required>{{ old('premium_feature_lines', $settings['premium_feature_lines']) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1 text-slate-700" for="homepage_how_it_works">Cara Kerja (format: Judul|Deskripsi, satu baris satu langkah)</label>
                <textarea id="homepage_how_it_works" name="homepage_how_it_works" rows="8" class="w-full rounded-xl border-slate-300 focus:border-softi-600 focus:ring-softi-600" required>{{ old('homepage_how_it_works', $settings['homepage_how_it_works']) }}</textarea>
            </div>
            <button type="submit" class="rounded-xl bg-softi-600 hover:bg-softi-700 text-white px-4 py-2 font-semibold transition">Simpan Pengaturan</button>
        </form>
    </section>

    <section id="premium-verify" class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-800">Verifikasi Premium</h2>
        <p class="text-sm text-slate-500 mb-4">ACC atau tolak user yang sudah upload bukti pembayaran.</p>

        <div class="space-y-3 max-h-[520px] overflow-y-auto pr-1">
            @forelse ($pendingPremiumUsers as $pendingUser)
                <article class="rounded-xl border border-slate-200 p-3 bg-slate-50/60">
                    <p class="font-semibold text-slate-800">{{ $pendingUser->name }}</p>
                    <p class="text-xs text-slate-500">{{ $pendingUser->email }}</p>
                    <p class="text-xs text-slate-500 mt-1">Email verifikasi: {{ $pendingUser->premium_verification_email }}</p>
                    @if ($pendingUser->premium_payment_submitted_at)
                        <p class="text-xs text-slate-500">Dikirim: {{ $pendingUser->premium_payment_submitted_at->format('d M Y H:i') }}</p>
                    @endif
                    @if ($pendingUser->premium_payment_proof_path)
                        <a href="{{ asset('storage/' . $pendingUser->premium_payment_proof_path) }}" target="_blank" class="inline-block mt-2 text-sm text-blue-700 hover:underline font-medium">Lihat Bukti Pembayaran</a>
                    @endif

                    <div class="mt-3 flex gap-2 flex-wrap">
                        <form action="{{ route('admin.users.premium.update', $pendingUser) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="action" value="approve">
                            <button type="submit" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 text-sm transition">ACC Premium</button>
                        </form>
                        <form action="{{ route('admin.users.premium.update', $pendingUser) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="action" value="reject">
                            <button type="submit" class="rounded-lg bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 text-sm transition">Tolak</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="rounded-xl border border-dashed border-slate-300 p-6 text-center">
                    <p class="text-sm text-slate-500">Tidak ada pengajuan premium yang menunggu.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>

<section id="user-management" class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-800">Manajemen User</h2>
            <p class="text-sm text-slate-500">Kelola status premium dan ban user.</p>
        </div>
        <span class="text-xs px-3 py-1 rounded-full bg-slate-100 text-slate-700">{{ $users->count() }} user terdaftar</span>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm rounded-xl overflow-hidden">
            <thead>
                <tr class="text-left border-b border-slate-200 bg-slate-50 text-slate-700">
                    <th class="py-3 pr-3 font-semibold">Nama</th>
                    <th class="py-3 pr-3 font-semibold">Email</th>
                    <th class="py-3 pr-3 font-semibold">Plan</th>
                    <th class="py-3 pr-3 font-semibold">Status</th>
                    <th class="py-3 pr-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                        <td class="py-3 pr-3 font-medium text-slate-800">{{ $user->name }}</td>
                        <td class="py-3 pr-3 text-slate-600">{{ $user->email }}</td>
                        <td class="py-3 pr-3">
                            <span class="text-xs px-2.5 py-1 rounded-full font-semibold {{ $user->is_premium ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                {{ $user->is_premium ? 'Premium' : 'Free' }}
                            </span>
                        </td>
                        <td class="py-3 pr-3">
                            <span class="text-xs px-2.5 py-1 rounded-full font-semibold {{ $user->is_banned ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                                {{ $user->is_banned ? 'Banned' : 'Aktif' }}
                            </span>
                        </td>
                        <td class="py-3 pr-3">
                            <div class="flex flex-wrap gap-2">
                                <form action="{{ route('admin.users.premium.toggle', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold transition {{ $user->is_premium ? 'bg-amber-500 hover:bg-amber-600 text-white' : 'bg-emerald-600 hover:bg-emerald-700 text-white' }}">
                                        {{ $user->is_premium ? 'Jadikan Free' : 'Jadikan Premium' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.ban.toggle', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded-lg px-3 py-1.5 text-xs font-semibold transition {{ $user->is_banned ? 'bg-slate-800 hover:bg-slate-900 text-white' : 'bg-red-600 hover:bg-red-700 text-white' }}">
                                        {{ $user->is_banned ? 'Buka Ban' : 'Ban User' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-slate-500">Belum ada data user.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
