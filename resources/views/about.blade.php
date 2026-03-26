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
    <title>Tentang Kami - SoftiFy</title>
    <style>
        .about-page {
            width: min(1120px, 92%);
            margin: 138px auto 80px;
            display: grid;
            gap: 18px;
        }

        .about-hero {
            border-radius: 18px;
            border: 1px solid rgba(30, 86, 160, 0.2);
            background: linear-gradient(155deg, #ffffff 0%, #f5faff 100%);
            box-shadow: 0 16px 34px rgba(30, 86, 160, 0.08);
            padding: 22px;
        }

        .about-kicker {
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #1e56a0;
            font-weight: 700;
        }

        .about-hero h2 {
            margin-top: 8px;
            font-size: clamp(1.5rem, 2.6vw, 2.2rem);
            color: #103f7f;
        }

        .about-hero p {
            margin-top: 8px;
            color: #334155;
            line-height: 1.8;
        }

        .about-stats {
            margin-top: 14px;
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .about-stat {
            border-radius: 12px;
            border: 1px solid rgba(30, 86, 160, 0.15);
            background: #ffffff;
            padding: 12px;
        }

        .about-stat p:first-child {
            color: #64748b;
            font-size: 0.8rem;
            margin: 0;
        }

        .about-stat p:last-child {
            margin: 4px 0 0;
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
        }

        .about-section {
            border-radius: 16px;
            border: 1px solid rgba(30, 86, 160, 0.16);
            background: #ffffff;
            box-shadow: 0 10px 24px rgba(30, 86, 160, 0.08);
            padding: 20px;
        }

        .about-section h3 {
            color: #103f7f;
            font-size: 1.2rem;
        }

        .about-section p {
            margin-top: 8px;
            color: #334155;
            line-height: 1.8;
        }

        .feature-catalog {
            margin-top: 14px;
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .feature-catalog article {
            border: 1px solid rgba(30, 86, 160, 0.15);
            border-radius: 12px;
            background: #f8fbff;
            padding: 12px;
        }

        .feature-catalog h4 {
            color: #0f172a;
            font-size: 0.98rem;
        }

        .feature-catalog p {
            margin-top: 6px;
            color: #475569;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .about-list {
            margin-top: 10px;
            display: grid;
            gap: 8px;
        }

        .about-list li {
            list-style: none;
            border: 1px solid rgba(30, 86, 160, 0.14);
            border-radius: 10px;
            background: #f8fbff;
            padding: 10px 12px;
            color: #334155;
            line-height: 1.7;
        }

        .about-cta {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 12px;
        }

        @media (max-width: 980px) {
            .about-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .feature-catalog {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .about-page {
                margin-top: 118px;
            }

            .about-stats,
            .feature-catalog {
                grid-template-columns: 1fr;
            }

            .about-cta a {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
@php
    $safeAverageRating = ($heroAverageRating ?? null) ? number_format((float) $heroAverageRating, 1) : '0.0';
@endphp

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
                <a href="{{ route('dashboard') }}" class="contact">Dashboard</a>
                <p style="color: black; font-size: 20px;">|</p>
                <a href="{{ route('reviews.index') }}" class="sign">Beri Ulasan</a>
            @else
                <a href="{{ route('login') }}" class="contact">Masuk</a>
                <p style="color: black; font-size: 20px;">|</p>
                <a href="{{ route('daftar') }}" class="sign">Daftar</a>
            @endauth
        </div>
    </nav>
</header>

<main class="about-page">
    <section class="about-hero">
        <p class="about-kicker">Tentang SoftiFy</p>
        <h2>Platform produktivitas pelajar dengan AI, challenge, dan sistem progres terintegrasi.</h2>
        <p>SoftiFy membantu pengguna mengelola tugas, target belajar, diary, challenge fokus, pertemanan, chat, leaderboard, notifikasi, hingga premium dan panel admin dalam satu ekosistem yang rapi.</p>

        <div class="about-stats">
            <article class="about-stat">
                <p>Total Pengguna</p>
                <p>{{ number_format((int) ($heroTotalUsers ?? 0), 0, ',', '.') }}</p>
            </article>
            <article class="about-stat">
                <p>Pengguna Aktif</p>
                <p>{{ number_format((int) ($heroActiveUsers ?? 0), 0, ',', '.') }}</p>
            </article>
            <article class="about-stat">
                <p>Rating Pengguna</p>
                <p>{{ $safeAverageRating }}/5</p>
            </article>
            <article class="about-stat">
                <p>Total Ulasan</p>
                <p>{{ number_format((int) ($totalReviews ?? 0), 0, ',', '.') }}</p>
            </article>
        </div>
    </section>

    <section class="about-section">
        <h3>Semua Fitur Utama di SoftiFy</h3>
        <p>Halaman ini merangkum semua komponen inti yang ada di web kamu, dari sisi pengguna hingga admin.</p>

        <div class="feature-catalog">
            <article>
                <h4>Dashboard Belajar</h4>
                <p>Ringkasan progres, streak, statistik sesi, dan gambaran performa belajar harian.</p>
            </article>
            <article>
                <h4>Task & Target</h4>
                <p>Kelola tugas, deadline, target mingguan/bulanan, dan log progres secara konsisten.</p>
            </article>
            <article>
                <h4>AI Assistant</h4>
                <p>Bantuan strategi belajar, ide jadwal, dan rekomendasi tindakan belajar berikutnya.</p>
            </article>
            <article>
                <h4>Challenge Focus Timer</h4>
                <p>Mode fokus dengan timer challenge, visual objek, dan penyimpanan hasil sesi.</p>
            </article>
            <article>
                <h4>Diary & Catatan</h4>
                <p>Pencatatan refleksi harian agar proses belajar tetap terukur dan terdokumentasi.</p>
            </article>
            <article>
                <h4>Pertemanan & Chat</h4>
                <p>Tambah teman, terima request, dan diskusi privat untuk belajar kolaboratif.</p>
            </article>
            <article>
                <h4>Leaderboard</h4>
                <p>Papan peringkat untuk meningkatkan motivasi dan menjaga konsistensi progres.</p>
            </article>
            <article>
                <h4>Notifikasi Cerdas</h4>
                <p>Reminder deadline, task pending, serta aktivitas penting agar tidak terlewat.</p>
            </article>
            <article>
                <h4>Premium & Admin Panel</h4>
                <p>Fitur lanjutan premium serta kontrol admin untuk user, konten, dan settings.</p>
            </article>
        </div>
    </section>

    <section class="about-section">
        <h3>Alur Penggunaan SoftiFy</h3>
        <ul class="about-list">
            @foreach (($howItWorksSteps ?? []) as $step)
                <li><strong>{{ $step['title'] }}</strong><br>{{ $step['description'] }}</li>
            @endforeach
        </ul>
    </section>

    <section class="about-section">
        <h3>Paket Premium</h3>
        <p>SoftiFy menyediakan paket premium untuk pengguna yang ingin insight dan kemampuan lebih lanjut.</p>
        <ul class="about-list">
            @foreach (($displayPremiumFeatures ?? []) as $line)
                <li>{{ $line }}</li>
            @endforeach
        </ul>
        <p><strong>Harga saat ini:</strong> Rp{{ number_format((int) ($displayPremiumPrice ?? 0), 0, ',', '.') }}/bulan</p>

        <div class="about-cta">
            <a href="{{ route('reviews.public') }}" class="btn-premium">Lihat Ulasan Pengguna</a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn-free">Masuk ke Dashboard</a>
            @else
                <a href="{{ route('daftar') }}" class="btn-free">Mulai Daftar Sekarang</a>
            @endauth
        </div>
    </section>
</main>

<script src="{{ asset('js/page.js') }}"></script>
</body>
</html>
