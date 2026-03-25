@extends('app.layout')

@section('content')
<div class="grid gap-4 lg:grid-cols-3">
    <section class="lg:col-span-2 space-y-4">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900">Teman</h2>
            <p class="mt-1 text-sm text-slate-600">Cari user lain, kirim request, dan kelola pertemananmu.</p>

            <form method="GET" action="{{ route('friends.index') }}" class="mt-4 flex flex-wrap items-center gap-2">
                <input
                    type="text"
                    name="q"
                    value="{{ $query }}"
                    placeholder="Cari nama atau email"
                    class="min-w-[220px] flex-1 rounded-xl border border-slate-300 px-3 py-2.5 text-sm focus:border-softi-500 focus:outline-none focus:ring-2 focus:ring-softi-100"
                >
                <button type="submit" class="rounded-xl bg-gradient-to-r from-softi-600 to-cyan-600 px-4 py-2.5 text-sm font-semibold text-white">Cari</button>
            </form>

            <div class="mt-4 space-y-2">
                @forelse ($searchResults as $candidate)
                    <div class="flex flex-wrap items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5">
                        <div>
                            <p class="font-semibold text-slate-800">{{ $candidate->name }}</p>
                            <p class="text-xs text-slate-500">{{ $candidate->email }}</p>
                        </div>
                        <div>
                            @if ($candidate->friend_relation_status === \App\Models\Friend::STATUS_ACCEPTED)
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Sudah teman</span>
                            @elseif ($candidate->friend_relation_status === \App\Models\Friend::STATUS_PENDING)
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Request pending</span>
                            @else
                                <form action="{{ route('friends.request') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="friend_id" value="{{ $candidate->id }}">
                                    <button type="submit" class="rounded-xl bg-gradient-to-r from-softi-600 to-cyan-600 px-3 py-2 text-xs font-semibold text-white">Tambah Teman</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    @if ($query !== '')
                        <p class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-600">Tidak ada user ditemukan.</p>
                    @endif
                @endforelse
            </div>
        </article>

        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900">Daftar Teman</h3>
            <div class="mt-3 space-y-2">
                @forelse ($friends as $friend)
                    @php
                        $isOnline = optional($friend->updated_at)->gt(now()->subMinutes(5));
                    @endphp
                    <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5">
                        <div>
                            <p class="font-semibold text-slate-800">{{ $friend->name }}</p>
                            <p class="text-xs text-slate-500">{{ $friend->email }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-semibold {{ $isOnline ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                            <span class="h-2 w-2 rounded-full {{ $isOnline ? 'bg-emerald-500' : 'bg-slate-500' }}"></span>
                            {{ $isOnline ? 'Online' : 'Offline' }}
                        </span>
                    </div>
                @empty
                    <p class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-600">Belum ada teman yang accepted.</p>
                @endforelse
            </div>
        </article>
    </section>

    <aside class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <h3 class="text-lg font-bold text-slate-900">Request Masuk</h3>
        <div class="mt-3 space-y-2">
            @forelse ($incomingRequests as $request)
                <div class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5">
                    <p class="font-semibold text-slate-800">{{ $request->requester?->name }}</p>
                    <p class="text-xs text-slate-500">{{ $request->requester?->email }}</p>
                    <div class="mt-2 flex items-center gap-2">
                        <form action="{{ route('friends.accept', $request) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white">Accept</button>
                        </form>
                        <form action="{{ route('friends.reject', $request) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-lg bg-slate-500 px-3 py-1.5 text-xs font-semibold text-white">Reject</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-600">Tidak ada request masuk.</p>
            @endforelse
        </div>
    </aside>
</div>
@endsection
