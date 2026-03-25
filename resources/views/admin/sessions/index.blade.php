@extends('admin.layout')

@section('content')
<section class="rounded-3xl border border-indigo-100 bg-gradient-to-r from-white via-indigo-50 to-blue-50 p-6 shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-softi-700">Session Management</p>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-800 mt-1">Challenge/Timer {{ $user->name }}</h2>
            <p class="text-sm text-slate-600 mt-2">Lihat semua sesi studi/challenge milik user ini.</p>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200 px-4 py-3 shadow-sm">
            <p class="text-xs text-slate-500">Total Session</p>
            <p class="text-3xl font-black text-softi-700">{{ $sessions->total() }}</p>
        </div>
    </div>
</section>

<section class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-slate-800">Daftar Session</h3>
        <a href="{{ route('admin.users.edit', $user) }}" class="text-sm text-blue-600 hover:underline">← Kembali ke User</a>
    </div>

    @if($sessions->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-100 border-y border-slate-200">
                    <tr>
                        <th class="text-left px-4 py-3 font-semibold">Target/Materi</th>
                        <th class="text-left px-4 py-3 font-semibold">Durasi</th>
                        <th class="text-left px-4 py-3 font-semibold">Tanggal</th>
                        <th class="text-left px-4 py-3 font-semibold">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($sessions as $session)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-3">
                                <p class="font-semibold text-slate-800">{{ $session->target?->title ?? 'N/A' }}</p>
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ intval($session->duration_minutes) }} menit
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                {{ $session->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                @if($session->notes)
                                    <span class="line-clamp-1">{{ $session->notes }}</span>
                                @else
                                    <span class="text-slate-400">Tidak ada catatan</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($sessions->hasPages())
            <div class="mt-4">
                {{ $sessions->links('pagination::tailwind') }}
            </div>
        @endif
    @else
        <div class="rounded-xl border border-dashed border-slate-300 p-8 text-center">
            <p class="text-slate-500">User ini tidak memiliki session studi</p>
        </div>
    @endif
</section>
@endsection
