@extends('admin.layout')

@section('content')
<section class="rounded-3xl border border-indigo-100 bg-gradient-to-r from-white via-indigo-50 to-blue-50 p-6 shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-softi-700">Task Management</p>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">Task {{ $user->name }}</h2>
            <p class="text-sm text-slate-600 mt-2">Kelola semua task milik user ini.</p>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200 px-4 py-3 shadow-sm">
            <p class="text-xs text-slate-500">Total Task</p>
            <p class="text-3xl font-black text-softi-700">{{ $tasks->total() }}</p>
        </div>
    </div>
</section>

<section class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-800">Daftar Task</h3>
        <a href="{{ route('admin.users.edit', $user) }}" class="text-sm text-blue-600 hover:underline">← Kembali ke User</a>
    </div>

    @if($tasks->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-100 border-y border-slate-200">
                    <tr>
                        <th class="text-left px-4 py-3 font-semibold">Judul</th>
                        <th class="text-left px-4 py-3 font-semibold">Tanggal</th>
                        <th class="text-left px-4 py-3 font-semibold">Status</th>
                        <th class="text-left px-4 py-3 font-semibold">Prioritas</th>
                        <th class="text-center px-4 py-3 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($tasks as $task)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-slate-800 line-clamp-1">{{ $task->title }}</p>
                                @if($task->description)
                                    <p class="text-xs text-slate-500 line-clamp-1">{{ $task->description }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $task->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                @if($task->is_completed)
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">Selesai ✓</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">Aktif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($task->priority === 'high')
                                    <span class="text-red-600 font-semibold">🔴 Tinggi</span>
                                @elseif($task->priority === 'medium')
                                    <span class="text-amber-600 font-semibold">🟡 Sedang</span>
                                @else
                                    <span class="text-green-600 font-semibold">🟢 Rendah</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2 justify-center">
                                    <form action="{{ route('admin.tasks.delete', $task) }}" method="POST" class="inline" onsubmit="return confirm('Hapus task ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium transition">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($tasks->hasPages())
            <div class="mt-4">
                {{ $tasks->links('pagination::tailwind') }}
            </div>
        @endif
    @else
        <div class="rounded-xl border border-dashed border-slate-300 p-8 text-center">
            <p class="text-slate-500">User ini tidak memiliki task</p>
        </div>
    @endif
</section>
@endsection
