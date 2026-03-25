@extends('app.layout')

@section('content')
<div class="max-w-3xl mx-auto rounded-2xl bg-white border border-slate-200 p-4 md:p-6">
    <h2 class="text-lg font-semibold">Tulis Diary Baru</h2>
    <p class="text-sm text-slate-500 mt-1">Cerita singkat tentang progres, tantangan, dan targetmu hari ini.</p>

    <form action="{{ route('diary.store') }}" method="POST" class="mt-4 space-y-3">
        @csrf
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Judul</label>
            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                class="w-full rounded-xl border-slate-300"
                placeholder="Contoh: Hari ini fokus latihan soal"
                required
            >
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Mood</label>
            <select name="mood" class="w-full rounded-xl border-slate-300">
                <option value="">Pilih mood (opsional)</option>
                @foreach ($moodOptions as $value => $label)
                    <option value="{{ $value }}" @selected(old('mood') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Isi Catatan</label>
            <textarea
                name="content"
                rows="10"
                class="w-full rounded-xl border-slate-300"
                placeholder="Tulis catatan harianmu minimal 10 karakter..."
                required
            >{{ old('content') }}</textarea>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit" class="rounded-xl bg-softi-600 text-white px-4 py-2 text-sm">Simpan Diary</button>
            <a href="{{ route('diary.index') }}" class="rounded-xl bg-slate-100 text-slate-700 px-4 py-2 text-sm">Kembali</a>
        </div>
    </form>
</div>
@endsection
