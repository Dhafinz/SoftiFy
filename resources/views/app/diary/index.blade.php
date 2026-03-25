@extends('app.layout')

@section('content')
<div class="space-y-4">
    <div class="rounded-2xl bg-white border border-slate-200 p-4">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-lg font-semibold">Diary Harian</h2>
                <p class="text-sm text-slate-500">Simpan cerita belajar dan refleksi harian kamu.</p>
            </div>
            <a href="{{ route('diary.create') }}" class="inline-flex items-center justify-center rounded-xl bg-softi-600 text-white px-4 py-2 text-sm">+ Tulis Diary</a>
        </div>

        <form method="GET" action="{{ route('diary.index') }}" class="mt-4 grid gap-2 md:grid-cols-4">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                class="rounded-xl border-slate-300 md:col-span-2"
                placeholder="Cari judul diary..."
            >
            <input
                type="date"
                name="date"
                value="{{ $date }}"
                class="rounded-xl border-slate-300"
            >
            <div class="grid grid-cols-2 gap-2">
                <button type="submit" class="rounded-xl bg-softi-600 text-white py-2 text-sm">Filter</button>
                <a href="{{ route('diary.index') }}" class="rounded-xl bg-slate-100 text-slate-700 py-2 text-sm text-center">Reset</a>
            </div>
        </form>
    </div>

    @if ($diaries->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center">
            <p class="text-slate-600">Belum ada catatan hari ini, yuk mulai nulis!</p>
        </div>
    @else
        <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($diaries as $diary)
                <article class="rounded-2xl bg-white border border-slate-200 p-4 shadow-sm">
                    <div class="flex items-start justify-between gap-2">
                        <h3 class="font-semibold text-slate-900 line-clamp-2">{{ $diary->title }}</h3>
                        @if ($diary->mood)
                            <span class="text-xs rounded-full bg-slate-100 px-2 py-1 text-slate-700">{{ $moodLabels[$diary->mood] ?? $diary->mood }}</span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 mt-2">{{ $diary->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-sm text-slate-600 mt-2 line-clamp-3">{{ $diary->content }}</p>
                    <div class="mt-4 flex items-center gap-2">
                        <a href="{{ route('diary.show', $diary) }}" class="text-xs px-3 py-1.5 rounded-lg bg-softi-100 text-softi-700">Lihat</a>
                        <a href="{{ route('diary.edit', $diary) }}" class="text-xs px-3 py-1.5 rounded-lg bg-amber-100 text-amber-700">Edit</a>
                        <form method="POST" action="{{ route('diary.destroy', $diary) }}" onsubmit="return confirm('Hapus diary ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs px-3 py-1.5 rounded-lg bg-red-100 text-red-700">Hapus</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $diaries->links() }}
        </div>
    @endif
</div>
@endsection
