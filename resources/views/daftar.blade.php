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
    <link rel="stylesheet" href="{{ asset('css/daftar.css') }}">
    <title>Daftar - SOFTIFY</title>
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
                <a href="{{ route('login') }}" class="sign">Masuk</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="register-container">
            <div class="register-box">
                <div class="register-header">
                    <h2>Buat Akun Baru</h2>
                    <p>Bergabunglah dengan ribuan pelajar yang produktif</p>
                </div>

                @if ($errors->any())
                    <p style="background:#fee2e2;color:#991b1b;padding:10px;border-radius:10px;margin-bottom:12px;font-size:13px;">{{ $errors->first() }}</p>
                @endif

                <form action="{{ route('daftar.process') }}" method="POST">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama">Nama Depan</label>
                            <input type="text" id="nama" name="nama" required placeholder="Nama depan Anda" value="{{ old('nama') }}">
                        </div>
                        <div class="form-group">
                            <label for="nama_belakang">Nama Belakang</label>
                            <input type="text" id="nama_belakang" name="nama_belakang" placeholder="Nama belakang (opsional)" value="{{ old('nama_belakang') }}">
                        </div>
                    </div>

                    <div class="form-group form-row full">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required placeholder="nama@example.com" value="{{ old('email') }}">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="kelas">Kelas/Tingkat</label>
                            <select id="kelas" name="kelas" required>
                                <option value="">Pilih kelas Anda</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="Mahasiswa">Mahasiswa</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tujuan">Tujuan Belajar</label>
                            <select id="tujuan" name="tujuan" required>
                                <option value="">Pilih tujuan</option>
                                <option value="Akademik">Akademik</option>
                                <option value="Persiapan Tes">Persiapan Tes</option>
                                <option value="Pengembangan Diri">Pengembangan Diri</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group form-row full">
                        <label for="password">Kata Sandi</label>
                        <input type="password" id="password" name="password" required placeholder="Minimal 8 karakter" onchange="checkPasswordStrength()">
                        <div class="password-strength" id="passwordStrength">
                            <div class="strength-bar"></div>
                            <div class="strength-bar"></div>
                            <div class="strength-bar"></div>
                        </div>
                    </div>

                    <div class="form-group form-row full">
                        <label for="confirm_password">Konfirmasi Kata Sandi</label>
                        <input type="password" id="confirm_password" name="password_confirmation" required placeholder="Ulangi kata sandi Anda">
                    </div>

                    <div class="terms-checkbox">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">Saya setuju dengan <a href="#">Syarat dan Ketentuan</a> serta <a href="#">Kebijakan Privasi</a></label>
                    </div>

                    <button type="submit" class="btn-register">Buat Akun</button>
                </form>

                <div class="divider">
                    <span>atau</span>
                </div>

                <div class="social-register">
                    <button class="social-btn">Google</button>
                    <button class="social-btn">GitHub</button>
                </div>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
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

        // Password strength indicator
        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBars = document.querySelectorAll('.strength-bar');
            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            strengthBars.forEach((bar, index) => {
                bar.style.backgroundColor = '#e0e0e0';
            });

            const colors = ['#ff4444', '#ff9800', '#ffc107', '#4caf50'];
            for (let i = 0; i < strength; i++) {
                strengthBars[i].style.backgroundColor = colors[i];
            }
        }

        // Validate password match
        const form = document.querySelector('form');
        form.addEventListener('submit', (e) => {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Kata sandi tidak cocok!');
            }
        });
    </script>
</body>
</html>
