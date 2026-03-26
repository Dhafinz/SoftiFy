<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/page.css') }}">
    <title>Ulasan Pengguna - SoftiFy</title>
    <style>
        .reviews-page {
            width: min(1120px, 92%);
            margin: 140px auto 80px;
        }

        .reviews-hero {
            border: 1px solid rgba(30, 86, 160, 0.18);
            border-radius: 18px;
            background: linear-gradient(170deg, #ffffff, #f7fbff);
            box-shadow: 0 16px 30px rgba(30, 86, 160, 0.08);
            padding: 22px;
        }

        .reviews-hero h2 {
            color: #103f7f;
            font-size: clamp(1.4rem, 2.2vw, 2rem);
        }

        .reviews-hero p {
            margin-top: 8px;
            color: #334155;
            line-height: 1.7;
        }

        .reviews-stats {
            margin-top: 16px;
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .reviews-stats .stat {
            border: 1px solid rgba(30, 86, 160, 0.15);
            border-radius: 12px;
            background: #ffffff;
            padding: 12px;
        }

        .reviews-stats .stat p {
            margin: 0;
        }

        .reviews-stats .stat p:first-child {
            color: #64748b;
            font-size: 0.82rem;
        }

        .reviews-stats .stat p:last-child {
            margin-top: 4px;
            color: #0f172a;
            font-size: 1.4rem;
            font-weight: 800;
        }

        .reviews-cta {
            margin-top: 14px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .reviews-list {
            margin-top: 18px;
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .reviews-card {
            border: 1px solid rgba(30, 86, 160, 0.16);
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 10px 22px rgba(30, 86, 160, 0.08);
            padding: 14px;
        }

        .reviews-card-head {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 8px;
        }

        .reviews-card h3 {
            color: #0f172a;
            font-size: 0.98rem;
        }

        .reviews-stars {
            color: #f59e0b;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        .reviews-card p {
            color: #475569;
            line-height: 1.7;
            font-size: 0.92rem;
        }

        .reviews-card time {
            display: block;
            margin-top: 10px;
            color: #94a3b8;
            font-size: 0.78rem;
        }

        .reviews-pagination {
            margin-top: 16px;
        }

        @media (max-width: 980px) {
            .reviews-list {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .reviews-page {
                margin-top: 118px;
            }

            .reviews-list,
            .reviews-stats {
                grid-template-columns: 1fr;
            }

            .reviews-cta a {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
<header>
    <nav>
        <div class="logo">
            <h1><a href="{{ route('welcome') }}">SOFTI<span style="color: #1e56a0;">FY</span></a></h1>
        </div>
        <button class="menu-toggle" type="button" aria-label="Buka navigasi" aria-expanded="false" aria-controls="main-nav-links">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <ul id="main-nav-links">
            <li><a href="{{ route('welcome') }}">Beranda</a></li>
            <li><a href="{{ route('welcome') }}#fitur">Fitur</a></li>
            <li><a href="{{ route('welcome') }}#cara-kerja">Cara Kerja</a></li>
            <li><a href="{{ route('welcome') }}#premium">Premium</a></li>
            <li><a href="{{ route('reviews.public') }}">Ulasan</a></li>
            <li><a href="{{ route('about') }}">Tentang Kami</a></li>
        </ul>
        <div class="right-nav">
            @auth
                <a href="{{ route('reviews.index') }}" class="contact">Tulis Ulasan</a>
                <p style="color: black; font-size: 20px;">|</p>
                <a href="{{ route('dashboard') }}" class="sign">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="contact">Masuk</a>
                <p style="color: black; font-size: 20px;">|</p>
                <a href="{{ route('daftar') }}" class="sign">Daftar</a>
            @endauth
        </div>
    </nav>
</header>

<main class="reviews-page">
    <section class="reviews-hero">
        <h2>Ulasan Pengguna SoftiFy</h2>
        <p>Lihat pengalaman pengguna lain dan bantu kami meningkatkan kualitas platform dengan rating dan pesan kamu.</p>

        <div class="reviews-stats">
            <div class="stat">
                <p>Rata-rata Rating</p>
                <p>{{ number_format((float) ($averageRating ?? 0), 1) }}/5</p>
            </div>
            <div class="stat">
                <p>Total Ulasan</p>
                <p>{{ number_format((int) ($totalReviews ?? 0), 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="reviews-cta">
            @auth
                <a href="{{ route('reviews.index') }}" class="btn-premium">Tulis Ulasan Sekarang</a>
            @else
                <a href="{{ route('login') }}" class="btn-premium">Login Untuk Menilai</a>
            @endauth
            <a href="{{ route('welcome') }}" class="btn-free">Kembali ke Beranda</a>
        </div>
    </section>

    <section class="reviews-list" aria-live="polite">
        @forelse ($reviews as $review)
            <article class="reviews-card">
                <div class="reviews-card-head">
                    <h3>{{ $review->user->name ?? 'Pengguna SoftiFy' }}</h3>
                    <p class="reviews-stars">{{ str_repeat('★', (int) $review->rating) }}{{ str_repeat('☆', max(0, 5 - (int) $review->rating)) }}</p>
                </div>
                <p>{{ $review->message }}</p>
                <time datetime="{{ $review->created_at->toIso8601String() }}">{{ $review->created_at->format('d M Y H:i') }}</time>
            </article>
        @empty
            <article class="reviews-card">
                <div class="reviews-card-head">
                    <h3>Belum ada ulasan</h3>
                    <p class="reviews-stars">☆☆☆☆☆</p>
                </div>
                <p>Belum ada pengguna yang memberikan ulasan. Jadilah yang pertama.</p>
            </article>
        @endforelse
    </section>

    <div class="reviews-pagination">
        {{ $reviews->links() }}
    </div>
</main>

<script src="{{ asset('js/page.js') }}"></script>
</body>
</html>
