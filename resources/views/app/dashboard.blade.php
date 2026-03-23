@extends('app.layout')

@section('content')
<div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
    <div class="rounded-2xl bg-white p-4 border border-slate-200">
        <p class="text-xs text-slate-500">Task Hari Ini</p>
        <p class="text-3xl font-bold text-softi-700">{{ $todayTaskCount }}</p>
    </div>
    <div class="rounded-2xl bg-white p-4 border border-slate-200">
        <p class="text-xs text-slate-500">Task Selesai Hari Ini</p>
        <p class="text-3xl font-bold text-emerald-600">{{ $todayCompletedCount }}</p>
    </div>
    <div class="rounded-2xl bg-white p-4 border border-slate-200">
        <p class="text-xs text-slate-500">Progress Target</p>
        <p class="text-3xl font-bold text-indigo-600">{{ $targetProgress }}%</p>
    </div>
    <div class="rounded-2xl bg-white p-4 border border-slate-200">
        <p class="text-xs text-slate-500">Jam Belajar Minggu Ini</p>
        <p class="text-3xl font-bold text-blue-600">{{ $weeklyHours }}</p>
    </div>
    <div class="rounded-2xl bg-gradient-to-r from-softi-700 to-blue-700 p-4 border border-softi-700 text-white">
        <p class="text-xs text-blue-100">Streak • Grace {{ $graceRemaining }}x</p>
        <p class="text-3xl font-bold">🔥 {{ auth()->user()->current_streak }}</p>
        <p class="text-xs text-blue-100 mt-1">Task selesai penuh atau sesi challenge juga menjaga streak.</p>
    </div>
</div>

<div class="grid gap-4 lg:grid-cols-3 mt-2">
    <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200 p-4">
        <div class="flex items-center justify-between mb-2">
            <h2 class="font-semibold">Grafik Aktivitas Belajar</h2>
            <a href="{{ route('challenge.index') }}" class="text-sm text-softi-700">Buka Challenge</a>
        </div>
        <canvas id="activityChart" height="120"></canvas>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 p-4 space-y-3">
        <h2 class="font-semibold">Aksi Cepat</h2>
        <a href="{{ route('tasks.index') }}" class="block rounded-xl bg-softi-600 text-white px-4 py-2 text-sm">Kelola Task</a>
        <a href="{{ route('targets.index') }}" class="block rounded-xl bg-indigo-600 text-white px-4 py-2 text-sm">Kelola Target</a>
        <a href="{{ route('ai.index') }}" class="block rounded-xl bg-blue-600 text-white px-4 py-2 text-sm">Chat AI Assistant</a>
        <p class="text-xs text-slate-500">Skor leaderboard kamu: <span class="font-semibold text-softi-700">{{ $leaderboardScore }}</span></p>
    </div>
</div>

<div class="grid gap-4 lg:grid-cols-2">
    <div class="rounded-2xl bg-white border border-slate-200 p-4">
        <h3 class="font-semibold mb-2">Task Terbaru</h3>
        <div class="space-y-2">
            @forelse ($tasks as $task)
                <div class="rounded-xl border border-slate-200 p-3 flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium">{{ $task->title }}</p>
                        <p class="text-xs text-slate-500">{{ $task->due_date?->format('d M Y') }} • {{ $task->time ? \Carbon\Carbon::parse($task->time)->format('H:i') : '-' }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full {{ ($task->status ?? ($task->is_done ? 'done' : 'pending')) === 'done' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">{{ ($task->status ?? ($task->is_done ? 'done' : 'pending')) === 'done' ? 'Selesai' : 'Pending' }}</span>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada task.</p>
            @endforelse
        </div>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 p-4">
        <h3 class="font-semibold mb-2">Target Terbaru</h3>
        <div class="space-y-3">
            @forelse ($targets as $target)
                @php($pct = $target->target_hours > 0 ? min(100, (int) round(($target->current_hours / $target->target_hours) * 100)) : 0)
                <div class="rounded-xl border border-slate-200 p-3">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium">{{ $target->title }}</p>
                        <span class="text-xs text-slate-500 uppercase">{{ $target->period_type }}</span>
                    </div>
                    <div class="h-2 bg-slate-200 rounded-full mt-2 overflow-hidden">
                        <div class="h-2 bg-gradient-to-r from-softi-600 to-blue-600" style="width: {{ $pct }}%"></div>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">{{ $target->current_hours }}/{{ $target->target_hours }} jam • {{ $pct }}%</p>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada target.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
const labels = @json($activityLabels);
const values = @json($activityHours);
const canvas = document.getElementById('activityChart');
if (canvas) {
    const ctx = canvas.getContext('2d');
    const width = canvas.width = canvas.offsetWidth * window.devicePixelRatio;
    const height = canvas.height = 220 * window.devicePixelRatio;
    const chartWidth = width - 60;
    const chartHeight = height - 40;
    const maxVal = Math.max(1, ...values);

    ctx.clearRect(0, 0, width, height);
    ctx.font = `${11 * window.devicePixelRatio}px sans-serif`;

    values.forEach((value, i) => {
        const x = 30 + (chartWidth / values.length) * i + 6;
        const barW = (chartWidth / values.length) - 10;
        const barH = (value / maxVal) * chartHeight;
        const y = 12 + (chartHeight - barH);

        ctx.fillStyle = '#e2e8f0';
        ctx.fillRect(x, 12, barW, chartHeight);
        ctx.fillStyle = '#6f5ef7';
        ctx.fillRect(x, y, barW, barH);

        ctx.fillStyle = '#475569';
        ctx.fillText(labels[i], x + 3, height - 8);
    });
}
</script>
@endsection
