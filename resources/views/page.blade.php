<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bitcount+Grid+Double+Ink:wght@100..
900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,
800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/page.css') }}">
    <title>SOFTIFY</title>
</head>
<body>
    @php
        $displayHowItWorks = !empty($howItWorksSteps ?? [])
            ? $howItWorksSteps
            : [
                ['title' => 'Masuk dan lengkapi profil belajar', 'description' => 'Login ke akun SoftiFy untuk membuka dashboard pribadi, mengatur preferensi belajar, dan memulai alur yang sudah dipersonalisasi.'],
                ['title' => 'Rencanakan tugas dan jadwal harian', 'description' => 'Susun prioritas belajar harian di Task Manager agar waktu belajar, deadline, dan sesi fokus lebih terkontrol.'],
                ['title' => 'Catat progres di Diary', 'description' => 'Tulis catatan harian, refleksi materi, dan insight belajar agar perkembangan Anda terdokumentasi dengan rapi dari waktu ke waktu.'],
                ['title' => 'Belajar kolaboratif lewat fitur teman', 'description' => 'Tambahkan teman, bangun koneksi, dan lanjutkan diskusi melalui chat privat untuk saling dukung mencapai target belajar.'],
                ['title' => 'Optimalkan dengan AI dan notifikasi', 'description' => 'Gunakan AI Asisten untuk strategi belajar dan biarkan notifikasi cerdas menjaga konsistensi sesi harian Anda.'],
                ['title' => 'Naikkan level dengan Premium dan evaluasi', 'description' => 'Aktifkan Premium untuk fitur lanjutan, lalu review statistik secara rutin agar strategi belajar tetap efektif.'],
            ];

        $displayPremiumPrice = $premiumPriceMonthly ?? 49000;
        $displayPremiumFeatures = !empty($premiumFeatureLines ?? [])
            ? $premiumFeatureLines
            : [
                'Semua fitur Paket Gratis',
                'Analitik lanjutan belajar',
                'Dukungan prioritas 24/7',
                'Rencana belajar kustom',
                'Akses offline materi',
                'Penyimpanan tak terbatas',
            ];
    @endphp
    
    <header>
        <nav>
            <div class="logo">
                <h1><a href="">SOFTI<span style="color: #1e56a0;">FY</span></a></h1>
            </div>
            <button class="menu-toggle" type="button" aria-label="Buka navigasi" aria-expanded="false" aria-controls="main-nav-links">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <ul id="main-nav-links">
                <li><a href="">Beranda</a></li>
                <li><a href="#fitur">Fitur</a></li>
                <li><a href="#cara-kerja">Cara Kerja</a></li>
                <li><a href="#premium">Premium</a></li>
                <li><a href="">Tentang Kami</a></li>
            </ul>
            <div class="right-nav">
                <a href="" class="contact">Kontak</a>
                <p style="color: black; font-size: 20px;">|</p>
                <a href="{{ route('daftar') }}" class="sign">Daftar</a>
            </div>
        </nav>
    </header>

    <main>
<section class="hero" id="beranda">
    <div class="heros">
{{-- Penjelasan dan tombool hero --}}
        <div class="hero-content">
            <h3>Ubah Produktivitasmu Menjadi Permainan.</h3>
            <p><span>SOFTIFY</span> adalah platform produktivitas pelajar yang menggabungkan sistem AI cerdas, gamifikasi motivasi, dan manajemen tugas dalam satu dashboard yang kuat.</p>
            <div class="tombol">
                <a href="" class="mulai">Coba Sekarang</a>
                <button type="button" class="demo" id="demo-btn">Tonton Demo</button>
            </div>
{{-- Total aktif serta total rating website --}}
            <div class="aktif">
                <div class="pengguna">
                    <p style="font-weight: bold; font-size: 30px;">1.000+</p>
                    <p>Pengguna Online</p>
                </div>
                <div class="rating">
                    <p style="font-weight: bold; font-size: 30px;">4.8/5</p>
                    <p>Rating Pengguna</p>
                </div>

                <div class="pengguna-aktif">
                    <p style="font-weight: bold; font-size: 30px;">500+</p>
                    <p>Pengguna Aktif</p>
                </div>
            </div>
        </div>
{{-- Gambar dari halaman dashboard user --}}
        <div class="content">
            <img src="{{ asset('img/contoh.png') }}" alt="Hero Image">
        </div>
    </div>
    <img src="{{ asset('img/bg.png') }}" alt="Background Image" style="width: 100%;">
</section>
        <section class="feature" id="fitur">
            <div class="feature-shell">
                <div class="feature-header scroll-fade">
                    <p class="feature-kicker">SoftiFy Platform</p>
                    <h2>Semua Fitur Produktivitas Pelajar Dalam Satu Alur Belajar</h2>
                    <p>Dirancang dengan AI, task management, diary digital, kolaborasi pertemanan, dan sistem premium untuk membantu pelajar tetap konsisten setiap hari.</p>
                </div>

                <div class="feature-grid">
                    <div class="feature-list" role="tablist" aria-label="Daftar fitur SoftiFy">
                        <article class="feature-item is-active scroll-fade" data-feature="stats" role="tab" aria-selected="true" tabindex="0">
                            <span class="feature-index">01</span>
                            <h3>Study Statistics Dashboard</h3>
                            <p>Lihat total jam belajar hari ini, jumlah tugas selesai, progres mingguan-bulanan, dan streak belajar hingga 7 hari berturut-turut.</p>
                        </article>

                        <article class="feature-item scroll-fade" data-feature="notif" role="tab" aria-selected="false" tabindex="-1">
                            <span class="feature-index">02</span>
                            <h3>Smart Notifications</h3>
                            <p>Notifikasi cerdas mengingatkan saat deadline tugas mendekat atau saat waktunya mulai sesi belajar.</p>
                        </article>

                        <article class="feature-item scroll-fade" data-feature="ai" role="tab" aria-selected="false" tabindex="-1">
                            <span class="feature-index">03</span>
                            <h3>AI Study Assistant</h3>
                            <p>AI membantu menyusun strategi belajar, memberi referensi, membuat jadwal belajar, dan mengisi jurnal studi pada halaman tugas.</p>
                        </article>

                        <article class="feature-item scroll-fade" data-feature="task" role="tab" aria-selected="false" tabindex="-1">
                            <span class="feature-index">04</span>
                            <h3>Task Manager</h3>
                            <p>Atur jadwal tugas harian dan lacak progres assignment dengan sistem manajemen tugas yang rapi dan fokus.</p>
                        </article>

                        <article class="feature-item scroll-fade" data-feature="diary" role="tab" aria-selected="false" tabindex="-1">
                            <span class="feature-index">05</span>
                            <h3>Diary / Catatan Harian</h3>
                            <p>Simpan jurnal belajar, refleksi harian, dan mood belajar agar progres Anda terdokumentasi secara konsisten.</p>
                        </article>

                        <article class="feature-item scroll-fade" data-feature="friends" role="tab" aria-selected="false" tabindex="-1">
                            <span class="feature-index">06</span>
                            <h3>Pertemanan & Chat Privat</h3>
                            <p>Bangun relasi belajar, kelola daftar teman, dan diskusikan materi langsung melalui fitur chat privat.</p>
                        </article>

                        <article class="feature-item scroll-fade" data-feature="premium" role="tab" aria-selected="false" tabindex="-1">
                            <span class="feature-index">07</span>
                            <h3>Premium Membership</h3>
                            <p>Tingkatkan akun untuk membuka fitur eksklusif, insight lebih dalam, serta pengalaman belajar yang lebih maksimal.</p>
                        </article>

                        <article class="feature-item scroll-fade" data-feature="admin" role="tab" aria-selected="false" tabindex="-1">
                            <span class="feature-index">08</span>
                            <h3>Admin Control Panel</h3>
                            <p>Pengelolaan konten, pengguna, dan pengaturan platform dilakukan terpusat agar sistem tetap aman dan terstruktur.</p>
                        </article>
                    </div>

                    <aside class="feature-preview sticky-preview scroll-fade" aria-live="polite">
                        <div class="preview-bg-orb"></div>

                        <section class="preview-screen is-active" data-preview="stats">
                            <header>
                                <p>Analytics</p>
                                <span>Live Overview</span>
                            </header>
                            <div class="screen-grid two">
                                <div class="screen-card">
                                    <p>Total Study Hours</p>
                                    <h4>5j 24m</h4>
                                    <small>Hari ini</small>
                                </div>
                                <div class="screen-card">
                                    <p>Completed Tasks</p>
                                    <h4>14</h4>
                                    <small>+3 dari kemarin</small>
                                </div>
                            </div>
                            <div class="screen-chart">
                                <span>Progress Mingguan</span>
                                <div class="bars">
                                    <i style="--h:48%"></i><i style="--h:65%"></i><i style="--h:54%"></i><i style="--h:78%"></i><i style="--h:72%"></i><i style="--h:86%"></i><i style="--h:92%"></i>
                                </div>
                            </div>
                            <footer>
                                <strong>Study Streak</strong>
                                <p>7 hari berturut-turut</p>
                            </footer>
                        </section>

                        <section class="preview-screen" data-preview="notif">
                            <header>
                                <p>Smart Alerts</p>
                                <span>AI Reminder Center</span>
                            </header>
                            <ul class="notify-list">
                                <li><strong>Matematika</strong><span>Deadline 3 jam lagi</span></li>
                                <li><strong>Focus Session</strong><span>Mulai pukul 19:00</span></li>
                                <li><strong>Jurnal Belajar</strong><span>Belum diisi hari ini</span></li>
                                <li><strong>Weekly Review</strong><span>Jadwalkan malam ini</span></li>
                            </ul>
                        </section>

                        <section class="preview-screen" data-preview="ai">
                            <header>
                                <p>AI Study Assistant</p>
                                <span>Prompt to Plan</span>
                            </header>
                            <div class="chat-bubble from-user">Buatkan strategi belajar ujian Fisika dalam 10 hari.</div>
                            <div class="chat-bubble from-ai">Siap. Saya susun rencana harian: konsep, latihan soal, review, dan simulasi akhir.</div>
                            <div class="ai-pill-group">
                                <span>Referensi Materi</span>
                                <span>Jadwal Otomatis</span>
                                <span>Isi Jurnal</span>
                            </div>
                        </section>

                        <section class="preview-screen" data-preview="task">
                            <header>
                                <p>Task Manager</p>
                                <span>Daily Planner</span>
                            </header>
                            <div class="task-row done"><label><input type="checkbox" checked> Review Biologi Bab 2</label><span>08:00</span></div>
                            <div class="task-row"><label><input type="checkbox"> Kerjakan 20 soal Kalkulus</label><span>13:00</span></div>
                            <div class="task-row"><label><input type="checkbox"> Buat ringkasan Sejarah</label><span>16:30</span></div>
                            <div class="task-row"><label><input type="checkbox" checked> Riset materi presentasi</label><span>20:00</span></div>
                        </section>

                        <section class="preview-screen" data-preview="diary">
                            <header>
                                <p>Diary Belajar</p>
                                <span>Daily Reflection</span>
                            </header>
                            <div class="goal-item"><span>Judul Catatan</span><em>Bab Elektromagnetik</em><b style="--goal:92%"></b></div>
                            <div class="goal-item"><span>Mood Belajar</span><em>Semangat</em><b style="--goal:84%"></b></div>
                            <div class="goal-item"><span>Ringkasan</span><em>25 menit refleksi</em><b style="--goal:74%"></b></div>
                            <div class="goal-item"><span>Update Terakhir</span><em>Hari ini, 20:10</em><b style="--goal:68%"></b></div>
                        </section>

                        <section class="preview-screen" data-preview="friends">
                            <header>
                                <p>Friendship Hub</p>
                                <span>Connect and Chat</span>
                            </header>
                            <div class="timer-circle">
                                <strong>12</strong>
                                <p>Teman Aktif</p>
                            </div>
                            <div class="reward-row">
                                <span>Pesan Baru Hari Ini</span>
                                <b>28 Chat</b>
                            </div>
                            <div class="badge-track">
                                <i></i><i></i><i></i><i class="locked"></i>
                            </div>
                        </section>

                        <section class="preview-screen" data-preview="premium">
                            <header>
                                <p>Premium Membership</p>
                                <span>Plan and Benefits</span>
                            </header>
                            <div class="profile-card">
                                <div class="avatar">AF</div>
                                <div>
                                    <h4>Alif Fadlan</h4>
                                    <p>Status: Premium Active</p>
                                </div>
                            </div>
                            <ul class="profile-list">
                                <li>Paket <span>Premium Bulanan</span></li>
                                <li>Mulai <span>12 Maret 2026</span></li>
                                <li>Benefit <span>Analitik Lanjutan</span></li>
                            </ul>
                        </section>

                        <section class="preview-screen" data-preview="admin">
                            <header>
                                <p>Admin Console</p>
                                <span>Platform Monitoring</span>
                            </header>
                            <ol class="leaderboard-list">
                                <li><strong>1</strong><p>Total Pengguna</p><span>1,532 akun</span></li>
                                <li><strong>2</strong><p>Laporan Masuk</p><span>7 tiket baru</span></li>
                                <li><strong>3</strong><p>Konten Aktif</p><span>214 item</span></li>
                                <li><strong>4</strong><p>Status Sistem</p><span>Normal</span></li>
                            </ol>
                        </section>
                    </aside>
                </div>

                <div class="feature-modal" id="feature-modal" aria-hidden="true">
                    <div class="feature-modal-backdrop" data-close-feature-modal></div>
                    <div class="feature-modal-dialog" role="dialog" aria-modal="true" aria-label="Detail fitur SoftiFy">
                        <button class="feature-modal-close" type="button" aria-label="Tutup detail fitur" data-close-feature-modal>&times;</button>
                        <div class="feature-modal-content"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="cara-kerja" id="cara-kerja">
            <div class="section-header scroll-fade">
                <h2>Cara Kerja</h2>
                <p>Ikuti langkah-langkah ini untuk mulai belajar lebih terarah bersama Softify.</p>
            </div>

            <div class="cara-steps">
                @foreach ($displayHowItWorks as $index => $step)
                    <div class="cara-step scroll-fade">
                        <div class="cara-image">
                            <img src="{{ asset('img/logo.png') }}" alt="Langkah {{ $index + 1 }} Softify">
                        </div>
                        <div class="cara-content">
                            <h3>{{ $index + 1 }}. {{ $step['title'] }}</h3>
                            <p>{{ $step['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="premium" id="premium">
            <div class="judul scroll-fade">
                <h2>Tingkatkan ke Premium</h2>
                <p>Buka fitur eksklusif dan tingkatkan pengalaman belajar Anda dengan langganan premium kami.</p>
            </div>

            <div class="premium-grid">
                <article class="plan-card free-plan scroll-fade">
                    <div class="plan-head">
                        <span class="plan-tag">Starter</span>
                        <h3>Paket Gratis</h3>
                        <p class="price">Gratis</p>
                        <p class="plan-desc">Cocok untuk pelajar yang ingin mulai mengatur kegiatan belajar dengan cara yang lebih terstruktur.</p>
                    </div>

                    <ul class="plan-features">
                        <li>Manajemen tugas harian</li>
                        <li>Target belajar mingguan</li>
                        <li>AI Asisten dasar</li>
                        <li>Tantangan belajar</li>
                        <li>Papan peringkat komunitas</li>
                    </ul>

                    <a href="#" class="btn-free">Mulai Gratis</a>
                </article>

                <article class="plan-card premium-plan scroll-fade">
                    <div class="plan-head">
                        <span class="plan-tag plan-tag-premium">Best Value</span>
                        <h3>Paket Premium</h3>
                        <p class="price"><span class="currency">Rp</span>{{ number_format((int) $displayPremiumPrice, 0, ',', '.') }}<span class="period">/bulan</span></p>
                        <p class="plan-desc">Untuk pelajar yang serius memaksimalkan potensi belajar dengan fitur premium eksklusif.</p>
                    </div>

                    <ul class="plan-features">
                        @foreach ($displayPremiumFeatures as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>

                    <a href="#" class="btn-premium">Tingkatkan Sekarang</a>
                </article>
            </div>
        </section>
    </main>

    <script src="{{ asset('js/page.js') }}"></script>

<footer class="footer">
    <div class="footer-top">
        <!-- Brand -->
        <div class="footer-brand">
            <h2 class="footer-logo-text">SOFTI<span>FY</span></h2>
            <p class="footer-tagline">Platform produktivitas pelajar yang menggabungkan AI cerdas, gamifikasi motivasi, dan manajemen tugas dalam satu dashboard.</p>
            <div class="footer-socials">
                {{-- Instagram --}}
                <a href="#" class="footer-social-link" aria-label="Instagram">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </a>
                {{-- Twitter / X --}}
                <a href="#" class="footer-social-link" aria-label="Twitter">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                {{-- YouTube --}}
                <a href="#" class="footer-social-link" aria-label="YouTube">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </a>
                {{-- LinkedIn --}}
                <a href="#" class="footer-social-link" aria-label="LinkedIn">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </a>
            </div>
        </div>

        <!-- Navigasi -->
        <div class="footer-links-group">
            <h4>Navigasi</h4>
            <ul>
                <li><a href="#">Beranda</a></li>
                <li><a href="#">Fitur</a></li>
                <li><a href="#">Cara Kerja</a></li>
                <li><a href="#">Premium</a></li>
                <li><a href="#">Tentang Kami</a></li>
                <li><a href="#">Kontak</a></li>
            </ul>
        </div>

        <!-- Fitur -->
        <div class="footer-links-group">
            <h4>Fitur</h4>
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard Belajar</a></li>
                <li><a href="#">AI Asisten</a></li>
                <li><a href="#">Diary / Catatan Harian</a></li>
                <li><a href="#">Pertemanan & Chat</a></li>
                <li><a href="#">Manajemen Tugas</a></li>
                <li><a href="#">Premium Membership</a></li>
                <li><a href="#">Admin Control Panel</a></li>
            </ul>
        </div>

        <!-- Newsletter -->
        <div class="footer-newsletter">
            <h4>Tetap Terhubung</h4>
            <p>Dapatkan tips belajar dan update fitur terbaru langsung di email Anda.</p>
            <form class="footer-subscribe-form" action="#">
                <input type="email" placeholder="Alamat email Anda" required>
                <button type="submit">Kirim</button>
            </form>
            <div class="footer-contact">
                <div class="footer-contact-item">
                    <span>📍</span>
                    <span>Jakarta, Indonesia</span>
                </div>
                <div class="footer-contact-item">
                    <span>✉️</span>
                    <span>hello@softify.id</span>
                </div>
                <div class="footer-contact-item">
                    <span>📞</span>
                    <span>+62 812-3456-7890</span>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2024 SOFTIFY. Semua hak dilindungi.</p>
        <ul class="footer-bottom-links">
            <li><a href="#">Kebijakan Privasi</a></li>
            <li><a href="#">Ketentuan Layanan</a></li>
            <li><a href="#">Cookie</a></li>
        </ul>
    </div>
</footer>

    {{-- Video Demo Modal --}}
    <div id="demo-modal" class="demo-modal" aria-hidden="true">
        <div class="demo-modal-backdrop" id="demo-modal-backdrop"></div>
        <div class="demo-modal-dialog" role="dialog" aria-modal="true" aria-label="Video Demo SoftiFy">
            <button class="demo-modal-close" id="demo-modal-close" type="button" aria-label="Tutup video demo">&times;</button>
            <div class="demo-modal-content">
                <iframe 
                    width="100%" 
                    height="600" 
                    src="about:blank"
                    data-src="https://www.youtube.com/embed/m1EcBLRLNqU?autoplay=1&amp;loop=1&amp;playlist=m1EcBLRLNqU" 
                    title="Demo Video SoftiFy" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    referrerpolicy="strict-origin-when-cross-origin" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>

    <style>
        .demo-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
        }

        .demo-modal.is-open {
            display: block;
        }

        .demo-modal-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            cursor: pointer;
        }

        .demo-modal-dialog {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 800px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            z-index: 10000;
        }

        .demo-modal-close {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            padding: 0;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            font-size: 28px;
            color: #333;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 10001;
        }

        .demo-modal-close:hover {
            background: rgba(255, 255, 255, 1);
            transform: rotate(90deg);
        }

        .demo-modal-content {
            width: 100%;
            aspect-ratio: 16 / 9;
        }

        .demo-modal-content iframe {
            width: 100% !important;
            height: 100% !important;
        }

        @media (max-width: 768px) {
            .demo-modal-dialog {
                width: 95%;
            }

            .demo-modal-content {
                aspect-ratio: 16 / 9;
            }
        }
    </style>

    <script>
        // Demo Modal Functionality
        const demoBtn = document.getElementById('demo-btn');
        const demoModal = document.getElementById('demo-modal');
        const demoModalBackdrop = document.getElementById('demo-modal-backdrop');
        const demoModalClose = document.getElementById('demo-modal-close');
        const demoIframe = demoModal ? demoModal.querySelector('iframe') : null;

        if (demoBtn && demoModal) {
            const openDemoModal = () => {
                if (demoIframe && demoIframe.dataset.src) {
                    demoIframe.src = demoIframe.dataset.src;
                }

                demoModal.classList.add('is-open');
                demoModal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            };

            const closeDemoModal = () => {
                demoModal.classList.remove('is-open');
                demoModal.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = 'auto';

                // Reset iframe source to force YouTube player to stop.
                if (demoIframe) {
                    demoIframe.src = 'about:blank';
                }
            };

            // Open modal on button click
            demoBtn.addEventListener('click', (e) => {
                e.preventDefault();
                openDemoModal();
            });

            // Close on X button click
            if (demoModalClose) {
                demoModalClose.addEventListener('click', closeDemoModal);
            }

            // Close on backdrop click
            if (demoModalBackdrop) {
                demoModalBackdrop.addEventListener('click', closeDemoModal);
            }

            // Close on Escape key
            window.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && demoModal.classList.contains('is-open')) {
                    closeDemoModal();
                }
            });
        }
    </script>
</body>
</html>
