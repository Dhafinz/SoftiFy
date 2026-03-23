@extends('app.layout')

@section('content')
<div class="grid gap-4 lg:grid-cols-3">
    <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200 p-4">
        <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
            <h2 class="font-semibold">Mode 1: Tanya Jawab AI (Unlimited)</h2>
            <form action="{{ route('ai.clear') }}" method="POST" onsubmit="return confirm('Hapus semua chat?')">
                @csrf
                @method('DELETE')
                <button class="text-xs px-3 py-1 rounded-lg bg-red-100 text-red-700">Bersihkan Chat</button>
            </form>
        </div>

        <div class="space-y-2 max-h-[420px] overflow-y-auto pr-1">
            @forelse ($messages as $msg)
                <div class="rounded-xl p-3 text-sm {{ $msg->role === 'assistant' ? 'bg-blue-50 border border-blue-200' : 'bg-softi-50 border border-softi-200' }}">
                    <p class="text-xs font-semibold {{ $msg->role === 'assistant' ? 'text-blue-700' : 'text-softi-700' }} mb-1">{{ strtoupper($msg->role) }} • {{ $msg->mode }}</p>
                    <p class="whitespace-pre-line">{{ $msg->message }}</p>
                </div>
            @empty
                <p class="text-sm text-slate-500">Belum ada percakapan. Kirim pertanyaan pertamamu.</p>
            @endforelse
        </div>

        <form action="{{ route('ai.chat') }}" method="POST" class="mt-3 flex gap-2">
            @csrf
            <input name="message" class="flex-1 rounded-xl border-slate-300" placeholder="Tanyakan apa saja ke AI..." required>
            <button class="rounded-xl bg-softi-600 text-white px-4">Kirim</button>
        </form>
    </div>

    <div class="rounded-2xl bg-white border border-slate-200 p-4 space-y-3">
        <h2 class="font-semibold">Mode 2: Generate Jadwal</h2>
        <p class="text-sm text-slate-600">Klik tombol di bawah untuk generate jadwal dari task hari ini, lalu sistem otomatis menyimpan jam tugas ke Task List.</p>
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 text-sm">
            <p class="font-semibold text-slate-700">Paket kamu: {{ $user->is_premium ? 'Premium' : 'Free' }}</p>
            <p class="text-slate-600">Limit generate hari ini: maksimal {{ $scheduleLimit }} task.</p>
            @if (! $user->is_premium)
                <a href="{{ route('premium.index') }}" class="inline-flex mt-2 text-xs px-3 py-1 rounded-lg bg-softi-600 text-white">Upgrade Premium</a>
            @endif
        </div>
        <form action="{{ route('ai.generate.today') }}" method="POST">
            @csrf
            <button class="w-full rounded-xl bg-indigo-600 text-white py-2">Buat Jadwal Hari Ini</button>
        </form>

        <div class="rounded-xl bg-slate-50 border border-slate-200 p-3">
            <p class="text-xs text-slate-500 mb-1">Contoh output</p>
            <ul class="text-sm space-y-1 text-slate-700">
                <li>08:00 - Belajar Matematika</li>
                <li>10:00 - Coding</li>
                <li>13:00 - Review</li>
            </ul>
        </div>

        <p class="text-xs text-slate-500">Jika OPENAI_API_KEY tidak diisi, sistem tetap berjalan dengan respons fallback ramah pemula.</p>
        <p class="text-xs text-slate-500">Setelah generate, jadwal langsung masuk halaman Task tanpa input manual.</p>
    </div>
</div>
@endsection
