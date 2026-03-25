@extends('app.layout')

@section('content')
<div class="max-w-3xl mx-auto rounded-2xl bg-white border border-slate-200 p-4 md:p-6 space-y-4">
    <div class="flex items-start justify-between gap-3">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">{{ $diary->title }}</h2>
            <p class="text-xs text-slate-500 mt-1">{{ $diary->created_at->format('d M Y, H:i') }}</p>
        </div>
        @if ($diary->mood)
            <span class="text-xs rounded-full bg-slate-100 px-2 py-1 text-slate-700">
                {{ $moodLabels[$diary->mood] ?? $diary->mood }}
            </span>
        @endif
    </div>

    <div class="rounded-xl bg-slate-50 border border-slate-200 p-4 whitespace-pre-line text-sm text-slate-700 leading-relaxed">{{ $diary->content }}</div>

    <div class="flex items-center gap-2">
        <a href="{{ route('diary.edit', $diary) }}" class="rounded-xl bg-amber-100 text-amber-700 px-4 py-2 text-sm">Edit</a>
        <form method="POST" action="{{ route('diary.destroy', $diary) }}" onsubmit="return confirm('Hapus diary ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-xl bg-red-100 text-red-700 px-4 py-2 text-sm">Hapus</button>
        </form>
        <a href="{{ route('diary.index') }}" class="rounded-xl bg-slate-100 text-slate-700 px-4 py-2 text-sm">Kembali</a>
    </div>
</div>
@endsection
