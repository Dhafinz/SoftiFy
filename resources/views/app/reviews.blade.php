@extends('app.layout')

@section('content')
<div class="mx-auto w-full max-w-5xl space-y-4">
    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <h2 class="text-xl font-black text-slate-800">Beri Ulasan SoftiFy</h2>
        <p class="mt-1 text-sm text-slate-600">Bagikan pengalaman kamu menggunakan platform ini.</p>

        <div class="mt-4 grid gap-3 sm:grid-cols-3">
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                <p class="text-xs uppercase tracking-wide text-slate-500">Rata-rata Rating</p>
                <p class="mt-1 text-2xl font-black text-softi-700">{{ number_format((float) ($averageRating ?? 0), 1) }}/5</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                <p class="text-xs uppercase tracking-wide text-slate-500">Total Ulasan</p>
                <p class="mt-1 text-2xl font-black text-slate-800">{{ number_format((int) ($totalReviews ?? 0), 0, ',', '.') }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                <p class="text-xs uppercase tracking-wide text-slate-500">Status Ulasan Kamu</p>
                <p class="mt-1 text-sm font-bold {{ $myReview ? 'text-emerald-700' : 'text-amber-700' }}">{{ $myReview ? 'Sudah mengirim ulasan' : 'Belum mengirim ulasan' }}</p>
            </div>
        </div>

        <form action="{{ route('reviews.store') }}" method="POST" class="mt-4 grid gap-3">
            @csrf
            <div>
                <label for="rating" class="mb-1 block text-sm font-semibold text-slate-700">Rating</label>
                <select id="rating" name="rating" class="h-11 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm text-slate-700 focus:border-softi-500 focus:outline-none focus:ring-2 focus:ring-softi-200" required>
                    <option value="">Pilih rating</option>
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ (int) old('rating', $myReview->rating ?? 0) === $i ? 'selected' : '' }}>
                            {{ $i }} - {{ str_repeat('★', $i) }}{{ str_repeat('☆', 5 - $i) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label for="message" class="mb-1 block text-sm font-semibold text-slate-700">Pesan Ulasan</label>
                <textarea id="message" name="message" rows="5" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-softi-500 focus:outline-none focus:ring-2 focus:ring-softi-200" placeholder="Tulis pengalaman kamu menggunakan SoftiFy" required>{{ old('message', $myReview->message ?? '') }}</textarea>
            </div>

            <div class="flex flex-wrap gap-2">
                <button type="submit" class="inline-flex h-11 items-center justify-center rounded-xl bg-softi-700 px-4 text-sm font-bold text-white transition hover:bg-softi-600">Simpan Ulasan</button>
                <a href="{{ route('reviews.public') }}" class="inline-flex h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-4 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Lihat Halaman Ulasan</a>
            </div>
        </form>
    </section>

    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-5">
        <h3 class="text-lg font-black text-slate-800">Ulasan Terbaru</h3>
        <div class="mt-3 grid gap-3 sm:grid-cols-2">
            @forelse ($recentReviews as $review)
                <article class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                    <div class="flex items-start justify-between gap-2">
                        <p class="font-bold text-slate-800">{{ $review->user->name ?? 'Pengguna SoftiFy' }}</p>
                        <p class="text-amber-500">{{ str_repeat('★', (int) $review->rating) }}{{ str_repeat('☆', max(0, 5 - (int) $review->rating)) }}</p>
                    </div>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $review->message }}</p>
                    <p class="mt-2 text-xs text-slate-400">{{ $review->created_at->format('d M Y H:i') }}</p>
                </article>
            @empty
                <p class="text-sm text-slate-500">Belum ada ulasan tersedia.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
