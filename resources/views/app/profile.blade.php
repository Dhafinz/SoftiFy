@extends('app.layout')

@section('content')
<div class="grid gap-4 lg:grid-cols-3">
    <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200 p-4">
        <h2 class="font-semibold mb-3">Edit Profil User</h2>
        <form action="{{ route('profile.update') }}" method="POST" class="grid gap-2 sm:grid-cols-2">
            @csrf
            @method('PATCH')
            <input name="name" value="{{ old('name', $user->name) }}" class="rounded-xl border-slate-300" placeholder="Nama" required>
            <input name="class_level" value="{{ old('class_level', $user->class_level) }}" class="rounded-xl border-slate-300" placeholder="Kelas / tingkat">
            <input name="learning_goal" value="{{ old('learning_goal', $user->learning_goal) }}" class="rounded-xl border-slate-300 sm:col-span-2" placeholder="Tujuan belajar">
            <textarea name="bio" class="rounded-xl border-slate-300 sm:col-span-2" placeholder="Bio singkat">{{ old('bio', $user->profile?->bio) }}</textarea>
            <button class="rounded-xl bg-softi-600 text-white py-2 sm:col-span-2">Simpan Profil</button>
        </form>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 p-4 space-y-2">
        <h3 class="font-semibold">Data Akun</h3>
        <div class="text-sm space-y-1">
            <p><span class="text-slate-500">Nama:</span> {{ $user->name }}</p>
            <p><span class="text-slate-500">Email:</span> {{ $user->email }}</p>
            <p><span class="text-slate-500">Bergabung:</span> {{ $user->created_at->format('d M Y') }}</p>
            <p><span class="text-slate-500">Streak:</span> 🔥 {{ $user->current_streak }} hari</p>
            <p><span class="text-slate-500">Plan:</span> {{ $user->is_premium ? 'Premium' : 'Free' }}</p>
        </div>
        <a href="{{ route('premium.index') }}" class="inline-flex mt-2 rounded-lg bg-softi-600 text-white px-3 py-1 text-xs">Buka Premium</a>
    </div>
</div>
@endsection
