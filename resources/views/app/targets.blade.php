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
            <input type="number" name="current_hours" min="0" class="w-full rounded-xl border-slate-300" placeholder="Jam tercapai">
            <input type="date" name="deadline" class="w-full rounded-xl border-slate-300">
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
                            <p class="text-xs text-slate-500">{{ ucfirst($target->period_type) }} • Deadline {{ $target->deadline?->format('d M Y') ?: '-' }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full {{ $target->is_completed ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ $target->is_completed ? 'Selesai' : 'Belum' }}</span>
                    </div>

                    <div class="h-2 bg-slate-200 rounded-full overflow-hidden"><div class="h-2 bg-gradient-to-r from-softi-600 to-blue-600" style="width: {{ $pct }}%"></div></div>
                    <p class="text-xs text-slate-500">{{ $target->current_hours }}/{{ $target->target_hours }} jam ({{ $pct }}%)</p>

                    <form action="{{ route('targets.progress', $target) }}" method="POST" class="flex gap-2">
                        @csrf
                        @method('PATCH')
                        <input type="number" min="0" max="2000" name="current_hours" value="{{ $target->current_hours }}" class="flex-1 rounded-xl border-slate-300">
                        <button class="rounded-xl bg-indigo-600 text-white px-3">Update Progress</button>
                    </form>

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
                            <input type="number" name="current_hours" min="0" value="{{ $target->current_hours }}" class="rounded-xl border-slate-300" required>
                            <input type="date" name="deadline" value="{{ $target->deadline?->toDateString() }}" class="rounded-xl border-slate-300 sm:col-span-2">
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
