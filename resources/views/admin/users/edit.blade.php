@extends('admin.layout')

@section('content')
<section class="rounded-3xl border border-indigo-100 bg-gradient-to-r from-white via-indigo-50 to-blue-50 p-6 shadow-sm">
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-softi-700">Edit User</p>
        <h2 class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">{{ $user->name }}</h2>
        <p class="text-sm text-slate-600 mt-2">Update informasi profile user.</p>
    </div>
</section>

<div class="grid gap-4 lg:grid-cols-3">
    <!-- Edit Form -->
    <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium mb-2 text-slate-700">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border-slate-300" required>
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2 text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-xl border-slate-300" required>
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2 text-slate-700">Kelas / Tingkat</label>
                <input type="text" name="class_level" value="{{ old('class_level', $user->class_level) }}" class="w-full rounded-xl border-slate-300" placeholder="misal: SMA 2, Semester 4">
                @error('class_level')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-2 text-slate-700">Tujuan Belajar</label>
                <textarea name="learning_goal" class="w-full rounded-xl border-slate-300" rows="3" placeholder="Apa tujuan belajar user?">{{ old('learning_goal', $user->learning_goal) }}</textarea>
                @error('learning_goal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="w-full rounded-xl bg-softi-600 hover:bg-softi-700 text-white py-2 font-semibold transition">Simpan Perubahan</button>
        </form>
    </div>

    <!-- User Info -->
    <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm space-y-4">
        <div>
            <h3 class="font-semibold text-slate-800 mb-3">Informasi Akun</h3>
            <div class="space-y-2 text-sm">
                <div>
                    <p class="text-slate-500">ID</p>
                    <p class="font-semibold">#{{ $user->id }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Bergabung</p>
                    <p class="font-semibold">{{ $user->created_at->format('d M Y H:i') }}</p>
                </div>
                @if($user->email_verified_at)
                    <div>
                        <p class="text-slate-500">Email Verified</p>
                        <p class="font-semibold">{{ $user->email_verified_at->format('d M Y') }} ✓</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="border-t pt-4">
            <h3 class="font-semibold text-slate-800 mb-3">Status</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between items-center">
                    <span class="text-slate-600">Akun</span>
                    @if($user->is_banned)
                        <span class="px-2 py-1 rounded bg-red-100 text-red-700 text-xs font-medium">Diblokir</span>
                    @else
                        <span class="px-2 py-1 rounded bg-green-100 text-green-700 text-xs font-medium">Aktif</span>
                    @endif
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-600">Plan</span>
                    @if($user->is_premium)
                        <span class="px-2 py-1 rounded bg-amber-100 text-amber-700 text-xs font-medium">Premium ⭐</span>
                    @else
                        <span class="px-2 py-1 rounded bg-slate-100 text-slate-700 text-xs font-medium">Free</span>
                    @endif
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-600">Streak</span>
                    <span class="text-lg">🔥 {{ $user->current_streak }}</span>
                </div>
            </div>
        </div>

        <div class="border-t pt-4 space-y-2">
            <form action="{{ route('admin.users.role.toggle', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full rounded-xl bg-amber-600 hover:bg-amber-700 text-white py-2 text-sm font-semibold transition">
                    {{ $user->is_admin ? 'Turunkan ke User Biasa' : 'Promosikan ke Admin' }}
                </button>
            </form>

            <form action="{{ route('admin.users.status.toggle', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full rounded-xl {{ $user->is_banned ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }} text-white py-2 text-sm font-semibold transition">
                    {{ $user->is_banned ? '🔓 Buka Blokir' : '🔒 Blokir User' }}
                </button>
            </form>

            @if($user->current_streak > 0)
                <form action="{{ route('admin.users.streak.reset', $user) }}" method="POST" onsubmit="return confirm('Reset streak user ini?');">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full rounded-xl bg-slate-600 hover:bg-slate-700 text-white py-2 text-sm font-semibold transition">
                        Reset Streak ({{ $user->current_streak }})
                    </button>
                </form>
            @endif

            <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="return confirm('Yakin hapus user? Ini tidak bisa dibatalkan!');">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full rounded-xl bg-red-600 hover:bg-red-700 text-white py-2 text-sm font-semibold transition">
                    🗑️ Hapus User
                </button>
            </form>

            <a href="{{ route('admin.users.list') }}" class="block text-center rounded-xl border border-slate-300 hover:bg-slate-50 text-slate-700 py-2 text-sm font-semibold transition">
                ← Kembali
            </a>
        </div>
    </div>
</div>
@endsection
