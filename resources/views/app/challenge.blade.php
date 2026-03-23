@extends('app.layout')

@section('content')
<div class="grid gap-4 lg:grid-cols-3">
    <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200 p-6 text-center">
        <h2 class="font-semibold text-lg">Focus Challenge Timer</h2>
        <p class="text-sm text-slate-500 mb-4">Atur menit sesuka kamu, beri judul sesi, lalu jalankan timer.</p>

        <div class="max-w-md mx-auto rounded-xl border border-slate-200 p-3 mb-4">
            <label for="setMinutesInput" class="block text-xs text-slate-600 text-left mb-1">Set durasi timer (menit)</label>
            <input id="setMinutesInput" type="number" min="1" max="600" value="10" class="w-full rounded-xl border-slate-300">
            <p class="text-xs text-slate-500 mt-1 text-left">Timer akan mengikuti angka ini saat kamu klik Start.</p>
        </div>

        <div id="timerDisplay" class="text-6xl font-black text-softi-700">10:00</div>

        <div class="mt-5 flex justify-center gap-2">
            <button id="startBtn" class="rounded-xl bg-softi-600 text-white px-4 py-2">Start</button>
            <button id="stopBtn" class="rounded-xl bg-amber-500 text-white px-4 py-2">Stop</button>
            <button id="resetBtn" class="rounded-xl bg-slate-700 text-white px-4 py-2">Reset</button>
        </div>

        <form id="saveSessionForm" action="{{ route('challenge.sessions.store') }}" method="POST" class="mt-4 max-w-md mx-auto space-y-2 text-left">
            @csrf
            <div>
                <label for="topicInput" class="block text-xs text-slate-600 mb-1">Judul Challenge</label>
                <input id="topicInput" name="topic" value="{{ old('topic') }}" placeholder="Contoh: Belajar buat ulangan selama 10 menit" class="w-full rounded-xl border-slate-300" required>
            </div>
            <div>
                <label for="minutesInput" class="block text-xs text-slate-600 mb-1">Durasi yang tersimpan (menit)</label>
                <input id="minutesInput" type="number" name="minutes" min="1" max="600" value="{{ old('minutes', 10) }}" class="w-full rounded-xl border-slate-300" required>
            </div>
            <button class="w-full rounded-xl bg-indigo-600 text-white py-2">Simpan Sesi Challenge</button>
        </form>
        <p class="text-xs text-slate-500 mt-2">Tip: saat timer selesai/di-stop, durasi otomatis diisi ke form. Sesi challenge akan ikut perhitungan streak.</p>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 p-4">
        <h3 class="font-semibold mb-2">Riwayat Challenge</h3>
        <div class="space-y-2 text-sm">
            @forelse ($recentSessions as $session)
                <div class="rounded-xl border border-slate-200 p-2">
                    <p class="font-medium">{{ $session->topic ?: 'Focus challenge' }}</p>
                    <p class="text-xs text-slate-500">{{ $session->minutes }} menit • {{ $session->created_at->format('d M Y H:i') }}</p>
                </div>
            @empty
                <p class="text-slate-500">Belum ada sesi challenge.</p>
            @endforelse
        </div>
    </div>
</div>

<script>
let totalSeconds = 10 * 60;
let currentSeconds = totalSeconds;
let timerId = null;

const timerDisplay = document.getElementById('timerDisplay');
const startBtn = document.getElementById('startBtn');
const stopBtn = document.getElementById('stopBtn');
const resetBtn = document.getElementById('resetBtn');
const setMinutesInput = document.getElementById('setMinutesInput');
const minutesInput = document.getElementById('minutesInput');

function render() {
    const m = String(Math.floor(currentSeconds / 60)).padStart(2, '0');
    const s = String(currentSeconds % 60).padStart(2, '0');
    timerDisplay.textContent = `${m}:${s}`;
}

function startTimer() {
    const configuredMinutes = Math.max(1, Math.min(600, parseInt(setMinutesInput.value || '10', 10)));

    if (!timerId && currentSeconds === totalSeconds) {
        totalSeconds = configuredMinutes * 60;
        currentSeconds = totalSeconds;
        minutesInput.value = configuredMinutes;
        render();
    }

    if (timerId) return;

    timerId = setInterval(() => {
        if (currentSeconds > 0) {
            currentSeconds -= 1;
            render();
        } else {
            clearInterval(timerId);
            timerId = null;
            alert('Sesi fokus selesai! Simpan sesi kamu.');
        }
    }, 1000);
}

function stopTimer() {
    if (!timerId) return;
    clearInterval(timerId);
    timerId = null;
    const studiedMinutes = Math.max(1, Math.round((totalSeconds - currentSeconds) / 60));
    minutesInput.value = studiedMinutes;
}

function resetTimer() {
    stopTimer();
    const configuredMinutes = Math.max(1, Math.min(600, parseInt(setMinutesInput.value || '10', 10)));
    totalSeconds = configuredMinutes * 60;
    currentSeconds = totalSeconds;
    minutesInput.value = configuredMinutes;
    render();
}

setMinutesInput.addEventListener('change', () => {
    if (!timerId) {
        const configuredMinutes = Math.max(1, Math.min(600, parseInt(setMinutesInput.value || '10', 10)));
        totalSeconds = configuredMinutes * 60;
        currentSeconds = totalSeconds;
        minutesInput.value = configuredMinutes;
        render();
    }
});

startBtn.addEventListener('click', startTimer);
stopBtn.addEventListener('click', stopTimer);
resetBtn.addEventListener('click', resetTimer);

render();
</script>
@endsection
