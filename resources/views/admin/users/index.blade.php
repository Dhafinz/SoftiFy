@extends('admin.layout')

@section('content')
<section class="rounded-3xl border border-indigo-100 bg-gradient-to-r from-white via-indigo-50 to-blue-50 p-6 shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-softi-700">User Management</p>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">Manajemen Semua User</h2>
            <p class="text-sm text-slate-600 mt-2">Lihat, edit, hapus, dan atur role seluruh user platform.</p>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200 px-4 py-3 shadow-sm">
            <p class="text-xs text-slate-500">Total User</p>
            <p class="text-3xl font-black text-softi-700">{{ \App\Models\User::where('is_admin', false)->count() }}</p>
        </div>
    </div>
</section>

<section id="user-management" class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
    <h2 class="text-lg font-semibold text-slate-800 mb-4">Daftar User</h2>

    <!-- Search -->
    <form action="{{ route('admin.users.list') }}" method="GET" class="flex gap-2 mb-4">
        <input type="text" name="search" value="{{ $search }}" placeholder="Cari user (nama/email)..." class="flex-1 rounded-xl border-slate-300">
        <button type="submit" class="rounded-xl bg-softi-600 hover:bg-softi-700 text-white px-4 py-2 font-semibold transition">Cari</button>
        @if($search)
            <a href="{{ route('admin.users.list') }}" class="rounded-xl bg-slate-300 hover:bg-slate-400 text-slate-800 px-4 py-2 font-semibold transition">Reset</a>
        @endif
    </form>

    <!-- Users Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-100 border-y border-slate-200">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold">Nama</th>
                    <th class="text-left px-4 py-3 font-semibold">Email</th>
                    <th class="text-left px-4 py-3 font-semibold">Join</th>
                    <th class="text-left px-4 py-3 font-semibold">Status</th>
                    <th class="text-left px-4 py-3 font-semibold">Plan</th>
                    <th class="text-left px-4 py-3 font-semibold">Streak</th>
                    <th class="text-center px-4 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3">
                            <p class="font-semibold text-slate-800">{{ $user->name }}</p>
                            <p class="text-xs text-slate-500">{{ $user->class_level ?? 'Tidak diisi' }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-slate-600">{{ $user->email }}</p>
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3">
                            @if($user->is_banned)
                                <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">Diblokir</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Aktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($user->is_premium)
                                <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-800">Premium ⭐</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800">Free</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-600">
                            🔥 {{ $user->current_streak }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-1 justify-center">
                                <a href="{{ route('admin.users.edit', $user) }}" class="rounded px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-medium transition" title="Edit">✏️</a>
                                <a href="{{ route('admin.users.tasks', $user) }}" class="rounded px-2 py-1 bg-purple-100 hover:bg-purple-200 text-purple-700 text-xs font-medium transition" title="Tasks">📋</a>
                                <a href="{{ route('admin.users.sessions', $user) }}" class="rounded px-2 py-1 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 text-xs font-medium transition" title="Sessions">⏱️</a>
                                <form action="{{ route('admin.users.role.toggle', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="rounded px-2 py-1 bg-amber-100 hover:bg-amber-200 text-amber-700 text-xs font-medium transition" title="Toggle Role" onclick="return confirm('Ubah role user ini?')">👤</button>
                                </form>
                                <form action="{{ route('admin.users.status.toggle', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="{{ $user->is_banned ? 'bg-green-100 hover:bg-green-200 text-green-700' : 'bg-red-100 hover:bg-red-200 text-red-700' }} rounded px-2 py-1 text-xs font-medium transition" title="Toggle Status">🔒</button>
                                </form>
                                <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded px-2 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium transition" title="Delete">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8">
                            <p class="text-slate-500">Tidak ada user ditemukan</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="mt-4">
            {{ $users->links('pagination::tailwind') }}
        </div>
    @endif
</section>

<!-- Legend -->
<section class="rounded-2xl bg-slate-50 border border-slate-200 p-5">
    <h3 class="font-semibold text-slate-800 mb-3">Petunjuk Tombol Aksi</h3>
    <div class="grid gap-2 sm:grid-cols-3">
        <div class="flex items-center gap-2">
            <span class="text-sm">✏️ = Edit user</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm">📋 = Lihat tasks</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm">⏱️ = Lihat sessions</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm">👤 = Toggle role admin/user</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm">🔒 = Blokir/Aktifkan</span>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-sm">🗑️ = Hapus user</span>
        </div>
    </div>
</section>
@endsection
