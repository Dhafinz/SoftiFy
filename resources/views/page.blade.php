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
    
    <header>
        <nav>
            <div class="logo">
                <h1><a href="">SOFTI<span style="color: #1e56a0;">FY</span></a></h1>
            </div>
            <ul>
                <li><a href="">Beranda</a></li>
                <li><a href="">Fitur</a></li>
                <li><a href="">Cara Kerja</a></li>
                <li><a href="">Premium</a></li>
                <li><a href="">Tentang Kami</a></li>
            </ul>
            <div class="right-nav">
                <a href="" class="contact">Kontak</a>
                <p style="color: black; font-size: 20px;">|</p>
                <a href="" class="sign">Daftar</a>
            </div>
        </nav>
    </header>

    <main>
<section class="hero">
    <div class="heros">
{{-- Penjelasan dan tombool hero --}}
        <div class="hero-content">
            <h3>Ubah Produktivitasmu Menjadi Permainan.</h3>
            <p><span>SOFTIFY</span> adalah platform produktivitas pelajar yang menggabungkan sistem AI cerdas, gamifikasi motivasi, dan manajemen tugas dalam satu dashboard yang kuat.</p>
            <div class="tombol">
                <a href="" class="mulai">Coba Sekarang</a>
                <a href="" class="demo">Tonton Demo</a>
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
        <section class="feature">
            <div class="fitur">
                <div class="section-header">
                    <h2>Fitur Kami</h2>
                    <p>Alat bertenaga yang dirancang untuk membantu Anda belajar lebih cerdas, bukan lebih keras</p>
                </div>
                <div class="fiturs">
                    <div class="card">
                        <div class="header">
                    <div class="img-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path d="M20.083 15.2l1.202.721a.5.5 0 0 1 0 .858l-8.77 5.262a1 1 0 0 1-1.03 0l-8.77-5.262a.5.5 0 0 1 0-.858l1.202-.721L12 20.05l8.083-4.85zm0-4.7l1.202.721a.5.5 0 0 1 0 .858L12 17.65l-9.285-5.571a.5.5 0 0 1 0-.858l1.202-.721L12 15.35l8.083-4.85zm-7.569-9.191l8.771 5.262a.5.5 0 0 1 0 .858L12 13 2.715 7.429a.5.5 0 0 1 0-.858l8.77-5.262a1 1 0 0 1 1.03 0zM12 3.332L5.887 7 12 10.668 18.113 7 12 3.332z" fill="rgba(66,193,110,1)"></path>
                        </svg>
                    </div>
                    <span class="title">DashBoard</span>
                </div>
                    <div class="content">
                        <p>Dashboard ini menampilkan data statistik :</p>
                        <ul>
                            <li>- Jumlah jam belajar/hari</li>
                            <li>- Jumlah tugas yang telah selesai</li>
                            <li>- Progres target</li>
                            <li>- Streak belajar</li>
                        </ul>
                        <a class="btn-link">Selengkapnya...</a>
                    </div>
                </div><div class="card">
                        <div class="header">
                    <div class="img-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path d="M20.083 15.2l1.202.721a.5.5 0 0 1 0 .858l-8.77 5.262a1 1 0 0 1-1.03 0l-8.77-5.262a.5.5 0 0 1 0-.858l1.202-.721L12 20.05l8.083-4.85zm0-4.7l1.202.721a.5.5 0 0 1 0 .858L12 17.65l-9.285-5.571a.5.5 0 0 1 0-.858l1.202-.721L12 15.35l8.083-4.85zm-7.569-9.191l8.771 5.262a.5.5 0 0 1 0 .858L12 13 2.715 7.429a.5.5 0 0 1 0-.858l8.77-5.262a1 1 0 0 1 1.03 0zM12 3.332L5.887 7 12 10.668 18.113 7 12 3.332z" fill="rgba(66,193,110,1)"></path>
                        </svg>
                    </div>
                    <span class="title">DashBoard</span>
                </div>
                    <div class="content">
                        <p>Dashboard ini menampilkan data statistik :</p>
                        <ul>
                            <li>- Jumlah jam belajar/hari</li>
                            <li>- Jumlah tugas yang telah selesai</li>
                            <li>- Progres target</li>
                            <li>- Streak belajar</li>
                        </ul>
                        <a class="btn-link">Selengkapnya...</a>
                    </div>
                </div><div class="card">
                        <div class="header">
                    <div class="img-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path d="M20.083 15.2l1.202.721a.5.5 0 0 1 0 .858l-8.77 5.262a1 1 0 0 1-1.03 0l-8.77-5.262a.5.5 0 0 1 0-.858l1.202-.721L12 20.05l8.083-4.85zm0-4.7l1.202.721a.5.5 0 0 1 0 .858L12 17.65l-9.285-5.571a.5.5 0 0 1 0-.858l1.202-.721L12 15.35l8.083-4.85zm-7.569-9.191l8.771 5.262a.5.5 0 0 1 0 .858L12 13 2.715 7.429a.5.5 0 0 1 0-.858l8.77-5.262a1 1 0 0 1 1.03 0zM12 3.332L5.887 7 12 10.668 18.113 7 12 3.332z" fill="rgba(66,193,110,1)"></path>
                        </svg>
                    </div>
                    <span class="title">DashBoard</span>
                </div>
                    <div class="content">
                        <p>Dashboard ini menampilkan data statistik :</p>
                        <ul>
                            <li>- Jumlah jam belajar/hari</li>
                            <li>- Jumlah tugas yang telah selesai</li>
                            <li>- Progres target</li>
                            <li>- Streak belajar</li>
                        </ul>
                        <a class="btn-link">Selengkapnya...</a>
                    </div>
                </div><div class="card">
                        <div class="header">
                    <div class="img-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path d="M20.083 15.2l1.202.721a.5.5 0 0 1 0 .858l-8.77 5.262a1 1 0 0 1-1.03 0l-8.77-5.262a.5.5 0 0 1 0-.858l1.202-.721L12 20.05l8.083-4.85zm0-4.7l1.202.721a.5.5 0 0 1 0 .858L12 17.65l-9.285-5.571a.5.5 0 0 1 0-.858l1.202-.721L12 15.35l8.083-4.85zm-7.569-9.191l8.771 5.262a.5.5 0 0 1 0 .858L12 13 2.715 7.429a.5.5 0 0 1 0-.858l8.77-5.262a1 1 0 0 1 1.03 0zM12 3.332L5.887 7 12 10.668 18.113 7 12 3.332z" fill="rgba(66,193,110,1)"></path>
                        </svg>
                    </div>
                    <span class="title">DashBoard</span>
                </div>
                    <div class="content">
                        <p>Dashboard ini menampilkan data statistik :</p>
                        <ul>
                            <li>- Jumlah jam belajar/hari</li>
                            <li>- Jumlah tugas yang telah selesai</li>
                            <li>- Progres target</li>
                            <li>- Streak belajar</li>
                        </ul>
                        <a class="btn-link">Selengkapnya...</a>
                    </div>
                </div><div class="card">
                        <div class="header">
                    <div class="img-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path d="M20.083 15.2l1.202.721a.5.5 0 0 1 0 .858l-8.77 5.262a1 1 0 0 1-1.03 0l-8.77-5.262a.5.5 0 0 1 0-.858l1.202-.721L12 20.05l8.083-4.85zm0-4.7l1.202.721a.5.5 0 0 1 0 .858L12 17.65l-9.285-5.571a.5.5 0 0 1 0-.858l1.202-.721L12 15.35l8.083-4.85zm-7.569-9.191l8.771 5.262a.5.5 0 0 1 0 .858L12 13 2.715 7.429a.5.5 0 0 1 0-.858l8.77-5.262a1 1 0 0 1 1.03 0zM12 3.332L5.887 7 12 10.668 18.113 7 12 3.332z" fill="rgba(66,193,110,1)"></path>
                        </svg>
                    </div>
                    <span class="title">DashBoard</span>
                </div>
                    <div class="content">
                        <p>Dashboard ini menampilkan data statistik :</p>
                        <ul>
                            <li>- Jumlah jam belajar/hari</li>
                            <li>- Jumlah tugas yang telah selesai</li>
                            <li>- Progres target</li>
                            <li>- Streak belajar</li>
                        </ul>
                        <a class="btn-link">Selengkapnya...</a>
                    </div>
                </div><div class="card">
                        <div class="header">
                    <div class="img-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path d="M20.083 15.2l1.202.721a.5.5 0 0 1 0 .858l-8.77 5.262a1 1 0 0 1-1.03 0l-8.77-5.262a.5.5 0 0 1 0-.858l1.202-.721L12 20.05l8.083-4.85zm0-4.7l1.202.721a.5.5 0 0 1 0 .858L12 17.65l-9.285-5.571a.5.5 0 0 1 0-.858l1.202-.721L12 15.35l8.083-4.85zm-7.569-9.191l8.771 5.262a.5.5 0 0 1 0 .858L12 13 2.715 7.429a.5.5 0 0 1 0-.858l8.77-5.262a1 1 0 0 1 1.03 0zM12 3.332L5.887 7 12 10.668 18.113 7 12 3.332z" fill="rgba(66,193,110,1)"></path>
                        </svg>
                    </div>
                    <span class="title">DashBoard</span>
                </div>
                    <div class="content">
                        <p>Dashboard ini menampilkan data statistik :</p>
                        <ul>
                            <li>- Jumlah jam belajar/hari</li>
                            <li>- Jumlah tugas yang telah selesai</li>
                            <li>- Progres target</li>
                            <li>- Streak belajar</li>
                        </ul>
                        <a class="btn-link">Selengkapnya...</a>
                    </div>
                </div><div class="card">
                        <div class="header">
                    <div class="img-box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                            <path fill="none" d="M0 0h24v24H0z"></path>
                            <path d="M20.083 15.2l1.202.721a.5.5 0 0 1 0 .858l-8.77 5.262a1 1 0 0 1-1.03 0l-8.77-5.262a.5.5 0 0 1 0-.858l1.202-.721L12 20.05l8.083-4.85zm0-4.7l1.202.721a.5.5 0 0 1 0 .858L12 17.65l-9.285-5.571a.5.5 0 0 1 0-.858l1.202-.721L12 15.35l8.083-4.85zm-7.569-9.191l8.771 5.262a.5.5 0 0 1 0 .858L12 13 2.715 7.429a.5.5 0 0 1 0-.858l8.77-5.262a1 1 0 0 1 1.03 0zM12 3.332L5.887 7 12 10.668 18.113 7 12 3.332z" fill="rgba(66,193,110,1)"></path>
                        </svg>
                    </div>
                    <span class="title">DashBoard</span>
                </div>
                    <div class="content">
                        <p>Dashboard ini menampilkan data statistik :</p>
                        <ul>
                            <li>- Jumlah jam belajar/hari</li>
                            <li>- Jumlah tugas yang telah selesai</li>
                            <li>- Progres target</li>
                            <li>- Streak belajar</li>
                        </ul>
                        <a class="btn-link">Selengkapnya...</a>
                    </div>
                </div>
            </div>
            </div>
        </section>
        <section class="tutorial">
            <img src="{{ asset('img/tutor.png') }}" alt="Tutorial">
        </section>
        <section class="premium">
            <div class="judul">
                <h2>Tingkatkan ke Premium</h2>
                <p>Buka fitur eksklusif dan tingkatkan pengalaman belajar Anda dengan langganan premium kami.</p>
            </div>
            <div class="card-premium">
                <div class="card-premium1 free-plan">
                    <div class="card1">                        
                        <h3>Paket Gratis</h3>
                        <p class="price">Gratis</p>
                        <p>Cocok untuk pelajar yang ingin mulai mengatur kegiatan belajar dengan cara yang lebih terstruktur.</p>
                    </div>
                    <hr>
                    <ul>
                        <li>Manajemen Tugas</li>
                        <p>Fitur ini membantu Anda mengelola tugas belajar dengan lebih efisien.</p>
                        <li>Target Belajar</li>
                        <p>Fitur ini memungkinkan Anda menetapkan dan melacak target belajar Anda.</p>
                        <li>AI Asisten</li>
                        <p>Fitur ini menyediakan bantuan cerdas untuk menjawab pertanyaan, memberikan saran belajar, dan membantu Anda merencanakan jadwal belajar.</p>
                        <li>Tantangan Belajar</li>
                        <p>Fitur ini memberikan tantangan belajar yang menarik untuk meningkatkan motivasi dan keterlibatan Anda.</p>
                        <li>Papan Peringkat</li>
                        <p>Fitur ini memungkinkan Anda melihat performa belajar Anda dibandingkan dengan pengguna lain.</p>
                    </ul>
                    <a href="#" class="btn-free">Mulai</a>
                </div>
            </div>
            <div class="card-premium">
                <div class="card-premium1 premium-plan">
                    <div class="card1">                        
                        <h3>Paket Premium</h3>
                        <p class="price"><span class="currency">Rp</span>49.000<span class="period">/bulan</span></p>
                        <p>Untuk pelajar yang serius ingin memaksimalkan potensi belajar dengan fitur premium eksklusif.</p>
                    </div>
                    <hr>
                    <ul>
                        <li>Semua fitur Paket Gratis</li>
                        <p>Akses penuh ke semua fitur dasar yang kuat.</p>
                        <li>Analitik Lanjutan</li>
                        <p>Laporan analisis mendalam tentang pola belajar dan performa Anda.</p>
                        <li>Dukungan Prioritas</li>
                        <p>Dukungan prioritas 24/7 dari tim ahli kami.</p>
                        <li>Rencana Belajar Kustom</li>
                        <p>Rencana belajar yang disesuaikan dengan gaya belajar Anda.</p>
                        <li>Akses Offline</li>
                        <p>Akses materi belajar bahkan tanpa koneksi internet.</p>
                        <li>Penyimpanan Tak Terbatas</li>
                        <p>Penyimpanan tak terbatas untuk file dan materi belajar Anda.</p>
                    </ul>
                    <a href="#" class="btn-premium">Tingkatkan Sekarang</a>
                </div>
            </div>
        </section>
        <section class="">

        </section>
    </main>

    <script src="{{ asset('js/page.js') }}"></script>

<footer class="footer-section">
        <div class="container">
            <div class="footer-cta pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="cta-text">
                                <h4>Temukan Kami</h4>
                                <span>1010 Avenue, sw 54321, chandigarh</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="fas fa-phone"></i>
                            <div class="cta-text">
                                <h4>Telepon Kami</h4>
                                <span>9876543210 0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="far fa-envelope-open"></i>
                            <div class="cta-text">
                                <h4>Email Kami</h4>
                                <span>mail@info.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-content pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 mb-50">
                        <div class="footer-widget">
                            <div class="footer-logo">
                                <a href="index.html"><img src="https://i.ibb.co/QDy827D/ak-logo.png" class="img-fluid" alt="logo"></a>
                            </div>
                            <div class="footer-text">
                                <p>Softify membantu Anda mencatat kemajuan belajar, meningkatkan fokus, dan tetap termotivasi setiap hari.</p>
                            </div>
                            <div class="footer-social-icon">
                                <span>Ikuti kami</span>
                                <a href="#"><i class="fab fa-facebook-f facebook-bg"></i></a>
                                <a href="#"><i class="fab fa-twitter twitter-bg"></i></a>
                                <a href="#"><i class="fab fa-google-plus-g google-bg"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <h3>Link Berguna</h3>
                            </div>
                            <ul>
                                <li><a href="#">Beranda</a></li>
                                <li><a href="#">Tentang</a></li>
                                <li><a href="#">Layanan</a></li>
                                <li><a href="#">Portofolio</a></li>
                                <li><a href="#">Kontak</a></li>
                                <li><a href="#">Tentang Kami</a></li>
                                <li><a href="#">Layanan Kami</a></li>
                                <li><a href="#">Tim Ahli</a></li>
                                <li><a href="#">Kontak Kami</a></li>
                                <li><a href="#">Berita Terbaru</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <h3>Berlangganan</h3>
                            </div>
                            <div class="footer-text mb-25">
                                <p>Jangan lewatkan update terbaru kami, isi formulir di bawah ini.</p>
                            </div>
                            <div class="subscribe-form">
                                <form action="#">
                                    <input type="text" placeholder="Alamat Email">
                                    <button><i class="fab fa-telegram-plane"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                        <div class="copyright-text">
                            <p>Hak Cipta &copy; 2018, Semua Hak Dilindungi <a href="https://codepen.io/anupkumar92/">Anup</a></p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                        <div class="footer-menu">
                            <ul>
                                <li><a href="#">Beranda</a></li>
                                <li><a href="#">Ketentuan</a></li>
                                <li><a href="#">Privasi</a></li>
                                <li><a href="#">Kebijakan</a></li>
                                <li><a href="#">Kontak</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
