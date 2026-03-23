@extends('app.layout')

@section('content')
<div class="rounded-2xl bg-white border border-slate-200 p-4">
    <h2 class="font-semibold mb-3">Notifications</h2>
    <p class="text-sm text-slate-500 mb-4">Semua pengingat penting terkait task, target, dan streak.</p>

    <div class="space-y-2">
        @forelse ($notifications as $item)
            @php
                $map = [
                    'danger' => 'border-red-200 bg-red-50 text-red-700',
                    'warning' => 'border-amber-200 bg-amber-50 text-amber-700',
                    'success' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                    'info' => 'border-blue-200 bg-blue-50 text-blue-700',
                ];
                $cls = $map[$item['type']] ?? $map['info'];
            @endphp
            <div class="rounded-xl border px-3 py-3 text-sm {{ $cls }}">
                {{ $item['text'] }}
            </div>
        @empty
            <p class="text-sm text-slate-500">Belum ada notifikasi.</p>
        @endforelse
    </div>
</div>
@endsection
