<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bitcount+Grid+Double+Ink:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Login - SOFTIFY</title>
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
                <li><a href="{{ route('page') }}#beranda">Beranda</a></li>
                <li><a href="{{ route('page') }}#fitur">Fitur</a></li>
                <li><a href="{{ route('page') }}#cara-kerja">Cara Kerja</a></li>
                <li><a href="{{ route('page') }}#premium">Premium</a></li>
                <li><a href="{{ route('page') }}">Tentang Kami</a></li>
            </ul>
            <div class="right-nav">
                <a href="#kontak" class="contact">Kontak</a>
                <p style="color: black; font-size: 20px;">|</p>
                <a href="{{ route('daftar') }}" class="sign">Daftar</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="login-container">
            <div class="login-box">
                <div class="login-header">
                    <h2>Masuk ke Akun</h2>
                    <p>Selamat datang kembali! Silakan masuk untuk melanjutkan</p>
                </div>

                @if (session('success'))
                    <p style="background:#dcfce7;color:#166534;padding:10px;border-radius:10px;margin-bottom:12px;font-size:13px;">{{ session('success') }}</p>
                @endif

                @if ($errors->any())
                    <p style="background:#fee2e2;color:#991b1b;padding:10px;border-radius:10px;margin-bottom:12px;font-size:13px;">{{ $errors->first() }}</p>
                @endif

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required placeholder="nama@example.com" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                        <input type="password" id="password" name="password" required placeholder="Masukkan kata sandi Anda">
                    </div>

                    <div class="remember-forgot">
                        <label>
                            <input type="checkbox" name="remember"> Ingat saya
                        </label>
                        <a href="#lupa">Lupa kata sandi?</a>
                    </div>

                    <button type="submit" class="btn-login">Masuk</button>
                </form>

                <div class="divider">
                    <span>atau</span>
                </div>

                <div class="social-login">
                    <button class="social-btn">Google</button>
                    <button class="social-btn">GitHub</button>
                </div>

                <div class="signup-link">
                    Belum punya akun? <a href="{{ route('daftar') }}">Daftar di sini</a>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Menu toggle untuk mobile
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.getElementById('main-nav-links');

        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
            menuToggle.setAttribute('aria-expanded', 
                menuToggle.getAttribute('aria-expanded') === 'false' ? 'true' : 'false');
        });
    </script>
</body>
</html>
