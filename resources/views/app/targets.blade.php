@extends('app.layout')

@section('content')
<div class="grid gap-4 lg:grid-cols-3">
    <div class="rounded-2xl bg-white border border-slate-200 p-4">
        <h2 class="font-semibold mb-3">Tambah Target</h2>
        <form action="{{ route('targets.store') }}" method="POST" class="space-y-2">
            @csrf
            <input name="title" class="w-full rounded-xl border-slate-300" placeholder="Nama target" required>
            <select name="period_type" class="w-full rounded-xl border-slate-300" required>
                <option value="daily">Harian</option>
                <option value="weekly">Mingguan</option>
                <option value="monthly">Bulanan</option>
            </select>
            <input type="number" name="target_hours" min="1" class="w-full rounded-xl border-slate-300" placeholder="Target jam" required>
            <div class="grid gap-2 sm:grid-cols-2">
                <input type="date" name="start_date" value="{{ now()->toDateString() }}" class="w-full rounded-xl border-slate-300" required>
                <input type="date" name="end_date" value="{{ now()->addWeek()->toDateString() }}" class="w-full rounded-xl border-slate-300" required>
            </div>
            <button class="w-full rounded-xl bg-softi-600 text-white py-2">Simpan Target</button>
        </form>
    </div>

    <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200 p-4">
        <h2 class="font-semibold mb-3">Daftar Target</h2>
        <div class="space-y-3">
            @forelse ($targets as $target)
                @php($pct = $target->target_hours > 0 ? min(100, (int) round(($target->current_hours / $target->target_hours) * 100)) : 0)
                <div class="rounded-xl border border-slate-200 p-3 space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-medium">{{ $target->title }}</p>
                            <p class="text-xs text-slate-500">{{ ucfirst($target->period_type) }} • {{ $target->start_date?->format('d M Y') ?: '-' }} s/d {{ $target->end_date?->format('d M Y') ?: '-' }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full {{ $target->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : ($target->status === 'expired' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">{{ ucfirst($target->status) }}</span>
                    </div>

                    <div class="h-2 bg-slate-200 rounded-full overflow-hidden"><div class="h-2 bg-gradient-to-r from-softi-600 to-blue-600" style="width: {{ $pct }}%"></div></div>
                    <p class="text-xs text-slate-500">{{ $target->current_hours }}/{{ $target->target_hours }} jam ({{ $pct }}%)</p>

                    <form action="{{ route('targets.logs.store', $target) }}" method="POST" class="grid gap-2 sm:grid-cols-[140px_1fr_auto]">
                        @csrf
                        <input type="number" min="1" max="2000" name="added_hours" placeholder="Tambah jam" class="rounded-xl border-slate-300" required>
                        <input type="text" name="note" placeholder="Catatan belajar (opsional)" class="rounded-xl border-slate-300">
                        <button class="rounded-xl bg-indigo-600 text-white px-3 disabled:opacity-50" {{ $target->status !== 'active' ? 'disabled' : '' }}>Tambah</button>
                    </form>

                    @if ($target->logs->isNotEmpty())
                        <details>
                            <summary class="cursor-pointer text-xs text-softi-700">Riwayat log</summary>
                            <ul class="mt-2 space-y-1">
                                @foreach ($target->logs as $log)
                                    <li class="text-xs text-slate-600">{{ $log->date->format('d M Y') }} • +{{ $log->added_hours }} jam @if($log->note) • {{ $log->note }} @endif</li>
                                @endforeach
                            </ul>
                        </details>
                    @endif

                    <details>
                        <summary class="cursor-pointer text-xs text-softi-700">Edit target</summary>
                        <form action="{{ route('targets.update', $target) }}" method="POST" class="grid mt-2 gap-2 sm:grid-cols-2">
                            @csrf
                            @method('PATCH')
                            <input name="title" value="{{ $target->title }}" class="rounded-xl border-slate-300" required>
                            <select name="period_type" class="rounded-xl border-slate-300" required>
                                <option value="daily" @selected($target->period_type==='daily')>Harian</option>
                                <option value="weekly" @selected($target->period_type==='weekly')>Mingguan</option>
                                <option value="monthly" @selected($target->period_type==='monthly')>Bulanan</option>
                            </select>
                            <input type="number" name="target_hours" min="1" value="{{ $target->target_hours }}" class="rounded-xl border-slate-300" required>
                            <input type="date" name="start_date" value="{{ $target->start_date?->toDateString() }}" class="rounded-xl border-slate-300" required>
                            <input type="date" name="end_date" value="{{ $target->end_date?->toDateString() }}" class="rounded-xl border-slate-300" required>
                            <button class="sm:col-span-2 rounded-xl bg-softi-600 text-white py-2 text-sm">Simpan Perubahan</button>
                        </form>
                    </details>

                    <form method="POST" action="{{ route('targets.destroy', $target) }}" onsubmit="return confirm('Hapus target ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="text-xs px-3 py-1 rounded-lg bg-red-100 text-red-700">Hapus</button>
                    </form>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada target.</p>
            @endforelse
        </div>

        <div class="mt-4">{{ $targets->links() }}</div>
    </div>
</div>
@endsection
