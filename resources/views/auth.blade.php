<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SOFTIFY — Masuk / Daftar</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #EFF6FF;
    position: relative;
    overflow: hidden;
  }

  .blob {
    position: fixed;
    border-radius: 50%;
    filter: blur(90px);
    opacity: .3;
    pointer-events: none;
  }
  .blob-1 { width: 500px; height: 500px; background: #3B82F6; top: -150px; left: -150px; }
  .blob-2 { width: 380px; height: 380px; background: #6EE7B7; bottom: -100px; right: -100px; }

  .sp { position: fixed; font-size: 20px; opacity: .55; pointer-events: none; animation: twinkle 3s ease-in-out infinite; }
  .sp1 { top: 14%; left: 9%; color: #1D4ED8; }
  .sp2 { top: 22%; right: 11%; color: #F59E0B; animation-delay: .9s; }
  .sp3 { bottom: 18%; left: 11%; color: #10B981; animation-delay: 1.6s; }
  .sp4 { bottom: 26%; right: 9%; color: #1D4ED8; animation-delay: .4s; }
  @keyframes twinkle {
    0%,100% { transform: scale(1); }
    50%      { transform: scale(1.35) rotate(18deg); opacity: .9; }
  }

  .card {
    background: #fff;
    border-radius: 28px;
    box-shadow: 0 24px 64px rgba(29,78,216,.13);
    width: 100%;
    max-width: 440px;
    padding: 48px 44px;
    position: relative;
    z-index: 5;
    animation: fadeUp .55s ease both;
  }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .logo {
    text-align: center;
    font-size: 22px;
    font-weight: 800;
    color: #0F172A;
    letter-spacing: -.4px;
    margin-bottom: 28px;
  }
  .logo span { color: #3B82F6; }

  .tabs {
    display: flex;
    background: #F1F5F9;
    border-radius: 12px;
    padding: 4px;
    margin-bottom: 32px;
  }
  .tab {
    flex: 1; padding: 10px;
    border: none; background: transparent;
    border-radius: 9px;
    font-family: inherit; font-size: 14px; font-weight: 600;
    color: #64748B; cursor: pointer; transition: all .22s;
  }
  .tab.active {
    background: #fff; color: #1D4ED8;
    box-shadow: 0 2px 8px rgba(29,78,216,.1);
  }

  .section { display: none; animation: fadeIn .28s ease; }
  .section.active { display: block; }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .section-title { font-size: 20px; font-weight: 800; color: #0F172A; margin-bottom: 4px; }
  .section-sub   { font-size: 13px; color: #64748B; margin-bottom: 24px; }

  .field { margin-bottom: 16px; }
  .field label { display: block; font-size: 13px; font-weight: 600; color: #0F172A; margin-bottom: 6px; }
  .field-wrap { position: relative; }
  .field-wrap input {
    width: 100%; padding: 12px 15px;
    background: #F1F5F9;
    border: 1.5px solid transparent;
    border-radius: 11px;
    font-family: inherit; font-size: 14px; color: #0F172A;
    outline: none;
    transition: border-color .2s, box-shadow .2s, background .2s;
  }
  .field-wrap input::placeholder { color: #94A3B8; }
  .field-wrap input:focus {
    border-color: #3B82F6;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(59,130,246,.1);
  }
  .eye {
    position: absolute; right: 13px; top: 50%;
    transform: translateY(-50%);
    cursor: pointer; font-size: 15px; color: #94A3B8;
    user-select: none; transition: color .2s;
  }
  .eye:hover { color: #1D4ED8; }

  .extras {
    display: flex; justify-content: space-between; align-items: center;
    font-size: 13px; margin-bottom: 20px;
  }
  .remember { display: flex; align-items: center; gap: 7px; color: #64748B; cursor: pointer; }
  .remember input { accent-color: #1D4ED8; width: 14px; height: 14px; }
  .forgot { color: #1D4ED8; font-weight: 600; text-decoration: none; }
  .forgot:hover { text-decoration: underline; }

  .btn-main {
    width: 100%; padding: 13px;
    background: #1D4ED8; color: #fff;
    border: none; border-radius: 12px;
    font-family: inherit; font-size: 15px; font-weight: 700;
    cursor: pointer; transition: all .22s; margin-bottom: 12px;
  }
  .btn-main:hover {
    background: #1E3A8A;
    transform: translateY(-2px);
    box-shadow: 0 8px 22px rgba(29,78,216,.28);
  }
  .btn-main:active { transform: translateY(0); }

  .divider {
    text-align: center; position: relative;
    font-size: 12px; color: #94A3B8; margin: 4px 0 12px;
  }
  .divider::before, .divider::after {
    content: ''; position: absolute; top: 50%;
    width: 40%; height: 1px; background: #E2E8F0;
  }
  .divider::before { left: 0; }
  .divider::after  { right: 0; }

  .btn-google {
    width: 100%; padding: 12px;
    background: #fff; color: #0F172A;
    border: 1.5px solid #E2E8F0; border-radius: 12px;
    font-family: inherit; font-size: 14px; font-weight: 600;
    cursor: pointer; transition: all .2s;
    display: flex; align-items: center; justify-content: center; gap: 9px;
    margin-bottom: 20px;
  }
  .btn-google:hover { background: #F8FAFC; border-color: #CBD5E1; }
  .btn-google svg { width: 18px; height: 18px; }

  .switch { text-align: center; font-size: 13px; color: #64748B; }
  .switch a { color: #1D4ED8; font-weight: 700; text-decoration: none; cursor: pointer; }
  .switch a:hover { text-decoration: underline; }

  .terms { font-size: 11.5px; color: #94A3B8; text-align: center; margin-top: 12px; line-height: 1.6; }
  .terms a { color: #3B82F6; text-decoration: none; }

  @media (max-width: 480px) {
    .card { padding: 36px 24px; margin: 16px; }
  }
</style>
</head>
<body>

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>
<div class="sp sp1">✦</div>
<div class="sp sp2">✦</div>
<div class="sp sp3">✦</div>
<div class="sp sp4">✦</div>

<div class="card">
  <div class="logo">SOFT<span>IFY</span></div>

  <div class="tabs">
    <button class="tab active" id="tab-login" onclick="show('login')">Masuk</button>
    <button class="tab" id="tab-register" onclick="show('register')">Daftar</button>
  </div>

  <!-- LOGIN -->
<div class="section active" id="s-login">
  <p class="section-title">Selamat Datang 👋</p>
  <p class="section-sub">Masuk ke akun Softify kamu.</p>

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="field">
      <label>Email</label>
      <div class="field-wrap">
        <input type="email" name="email" placeholder="nama@email.com" required>
      </div>
    </div>

    <div class="field">
      <label>Password</label>
      <div class="field-wrap">
        <input type="password" name="password" id="l-pw" placeholder="Masukkan password" required>
        <span class="eye" onclick="toggle('l-pw',this)">👁</span>
      </div>
    </div>

    <div class="extras">
      <label class="remember">
        <input type="checkbox" name="remember"> Ingat saya
      </label>
      <a href="#" class="forgot">Lupa password?</a>
    </div>

    <button type="submit" class="btn-main">Masuk</button>
  </form>

  <div class="divider">atau</div>

  <button class="btn-google">Masuk dengan Google</button>

  <p class="switch">Belum punya akun? <a onclick="show('register')">Daftar</a></p>
</div>

  <!-- REGISTER -->
<div class="section" id="s-register">
  <p class="section-title">Buat Akun 🚀</p>
  <p class="section-sub">Bergabung dan mulai belajar bersama Softify.</p>

  <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="field">
      <label>Nama Lengkap</label>
      <div class="field-wrap">
        <input type="text" name="name" placeholder="Nama kamu" required>
      </div>
    </div>

    <div class="field">
      <label>Email</label>
      <div class="field-wrap">
        <input type="email" name="email" placeholder="nama@email.com" required>
      </div>
    </div>

    <div class="field">
      <label>Password</label>
      <div class="field-wrap">
        <input type="password" name="password" id="r-pw" placeholder="Min. 8 karakter" required>
        <span class="eye" onclick="toggle('r-pw',this)">👁</span>
      </div>
    </div>

    <div class="field" style="margin-bottom:20px">
      <label>Konfirmasi Password</label>
      <div class="field-wrap">
        <input type="password" name="password_confirmation" id="r-pw2" placeholder="Ulangi password" required>
        <span class="eye" onclick="toggle('r-pw2',this)">👁</span>
      </div>
    </div>

    <button type="submit" class="btn-main">Daftar Sekarang</button>
  </form>

  <div class="divider">atau</div>

  <button class="btn-google">Daftar dengan Google</button>

  <p class="switch">Sudah punya akun? <a onclick="show('login')">Masuk</a></p>
</div>

<script>
  function show(tab) {
    ['login','register'].forEach(t => {
      document.getElementById('tab-'+t).classList.toggle('active', t===tab);
      document.getElementById('s-'+t).classList.toggle('active', t===tab);
    });
  }
  function toggle(id, el) {
    const i = document.getElementById(id);
    i.type = i.type === 'password' ? 'text' : 'password';
    el.textContent = i.type === 'password' ? '👁' : '🙈';
  }
</script>
</body>
</html>