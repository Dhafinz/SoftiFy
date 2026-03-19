<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Softify - Learning Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --sidebar-bg: #1e3a6e;
    --sidebar-active: #2d52a0;
    --sidebar-text: #a8c0e8;
    --blue-primary: #2563eb;
    --blue-dark: #1e3a6e;
    --bg: #f0f4f8;
    --card-bg: #ffffff;
    --text: #1e293b;
    --text-light: #64748b;
    --text-muted: #94a3b8;
    --border: #e2e8f0;
    --radius: 12px;
    --shadow: 0 1px 4px rgba(0,0,0,0.08);
  }

  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    display: flex;
    min-height: 100vh;
    font-size: 13px;
  }

  /* SIDEBAR */
  .sidebar {
    width: 158px; background: var(--sidebar-bg);
    display: flex; flex-direction: column;
    position: fixed; top:0; left:0; bottom:0; z-index:100;
  }
  .sidebar-logo {
    display:flex; align-items:center; gap:10px;
    padding:18px 16px 20px;
    border-bottom:1px solid rgba(255,255,255,.08);
  }
  .logo-icon {
    width:34px; height:34px; background:#4a7fe5; border-radius:8px;
    display:flex; align-items:center; justify-content:center;
    font-weight:800; color:#fff; font-size:16px; flex-shrink:0;
  }
  .logo-text { color:#fff; font-weight:700; font-size:13px; line-height:1.2; }
  .logo-sub  { color:var(--sidebar-text); font-size:10px; }
  .sidebar-section-label {
    font-size:9px; font-weight:700; color:rgba(168,192,232,.5);
    letter-spacing:1.2px; text-transform:uppercase; padding:18px 16px 6px;
  }
  .sidebar-nav { list-style:none; }
  .sidebar-nav li a {
    display:flex; align-items:center; gap:10px; padding:9px 16px;
    color:var(--sidebar-text); text-decoration:none;
    font-size:12.5px; font-weight:500; transition:background .15s;
  }
  .sidebar-nav li a .nav-icon {
    width:18px; height:18px; display:flex; align-items:center; justify-content:center; font-size:14px;
  }
  .sidebar-nav li.active a {
    background:var(--sidebar-active); color:#fff;
    border-left:3px solid #60a5fa; padding-left:13px;
  }
  .sidebar-nav li a:hover { background:rgba(255,255,255,.06); }
  .sidebar-bottom { margin-top:auto; border-top:1px solid rgba(255,255,255,.08); padding:8px 0; }
  .sidebar-user { display:flex; align-items:center; gap:8px; padding:10px 14px; }
  .user-avatar {
    width:32px; height:32px; background:#4a7fe5; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    font-weight:700; color:#fff; font-size:13px; flex-shrink:0;
  }
  .user-info { flex:1; min-width:0; }
  .user-name { color:#fff; font-weight:600; font-size:12px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
  .user-role { color:var(--sidebar-text); font-size:10px; }
  .user-dots { color:var(--sidebar-text); font-size:16px; cursor:pointer; }

  /* MAIN */
  .main { margin-left:158px; flex:1; display:flex; flex-direction:column; min-height:100vh; }

  /* TOPBAR */
  .topbar {
    background:#fff; border-bottom:1px solid var(--border);
    padding:0 24px; height:52px;
    display:flex; align-items:center; justify-content:space-between;
  }
  .topbar-title { font-size:13px; color:var(--text-light); }
  .btn-primary {
    background:var(--blue-primary); color:#fff; border:none;
    padding:8px 16px; border-radius:8px; font-family:inherit;
    font-size:12.5px; font-weight:600; cursor:pointer;
    display:flex; align-items:center; gap:6px;
  }

  /* CONTENT */
  .content { padding:20px 24px; flex:1; }

  /* PAGE HEADER */
  .page-header { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:18px; }
  .page-header h1 { font-size:22px; font-weight:800; color:var(--text); }
  .page-header p  { font-size:12.5px; color:var(--text-light); margin-top:2px; }
  .streak-badge {
    background:var(--blue-dark); color:#fff;
    padding:8px 14px; border-radius:20px;
    font-size:12.5px; font-weight:600;
    display:flex; align-items:center; gap:6px;
  }

  /* STAT CARDS */
  .stat-cards { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:18px; }
  .stat-card {
    background:var(--card-bg); border-radius:var(--radius);
    padding:16px 18px; border:1.5px solid var(--border);
  }
  .stat-card.green  { border-color:#bbf7d0; }
  .stat-card.orange { border-color:#fed7aa; }
  .stat-card.purple { border-color:#ddd6fe; }
  .stat-label {
    font-size:10px; font-weight:700; text-transform:uppercase;
    letter-spacing:.8px; color:var(--text-muted); margin-bottom:8px;
    display:flex; align-items:center; justify-content:space-between;
  }
  .stat-icon { width:28px; height:28px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:14px; }
  .stat-icon.blue   { background:#dbeafe; }
  .stat-icon.green  { background:#dcfce7; }
  .stat-icon.orange { background:#fef3c7; }
  .stat-icon.purple { background:#ede9fe; }
  .stat-value { font-size:32px; font-weight:800; color:var(--text); line-height:1; margin-bottom:6px; }
  .stat-card.orange .stat-value { color:#f59e0b; }
  .stat-card.purple .stat-value { color:#7c3aed; }
  .stat-footer { display:flex; align-items:center; justify-content:space-between; font-size:11px; color:var(--text-light); }
  .badge-small { padding:3px 8px; border-radius:20px; font-size:10.5px; font-weight:600; }
  .badge-blue   { background:#dbeafe; color:#1d4ed8; }
  .badge-green  { background:#dcfce7; color:#15803d; }
  .badge-orange { background:#fef3c7; color:#b45309; }
  .badge-purple { background:#ede9fe; color:#6d28d9; }

  /* MID ROW */
  .mid-row { display:grid; grid-template-columns:1fr 310px 310px; gap:14px; margin-bottom:18px; }
  .card { background:var(--card-bg); border-radius:var(--radius); border:1px solid var(--border); padding:18px; box-shadow:var(--shadow); }
  .card-header { display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:14px; }
  .card-title { font-size:14px; font-weight:700; color:var(--text); }
  .card-sub   { font-size:11px; color:var(--text-muted); margin-top:1px; }
  .link-btn   { font-size:11.5px; color:var(--blue-primary); font-weight:600; text-decoration:none; cursor:pointer; }

  /* Bar chart */
  .bar-row { display:flex; align-items:center; gap:10px; margin-bottom:9px; }
  .bar-label { width:24px; font-size:11px; color:var(--text-light); text-align:right; flex-shrink:0; }
  .bar-track { flex:1; background:#f1f5f9; border-radius:4px; height:9px; overflow:hidden; }
  .bar-fill  { height:100%; background:var(--blue-primary); border-radius:4px; }
  .bar-value { width:28px; font-size:11px; color:var(--text); font-weight:600; text-align:right; flex-shrink:0; }

  /* Donut */
  .donut-container { display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; }
  .donut-wrap { position:relative; width:130px; height:130px; margin-bottom:20px; }
  .donut-wrap svg { transform:rotate(-90deg); }
  .donut-center { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center; }
  .donut-pct { font-size:22px; font-weight:800; color:var(--text); }
  .donut-lbl { font-size:10px; color:var(--text-muted); font-weight:600; }
  .legend { width:100%; }
  .legend-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:6px; font-size:12px; }
  .legend-dot { width:9px; height:9px; border-radius:50%; margin-right:6px; flex-shrink:0; }
  .legend-left { display:flex; align-items:center; color:var(--text-light); }
  .legend-val  { font-weight:700; color:var(--text); }

  /* Streak card */
  .streak-header-card {
    background:linear-gradient(135deg,#1e3a6e,#2d52a0);
    border-radius:10px; padding:14px 16px;
    display:flex; align-items:center; gap:14px; margin-bottom:14px;
  }
  .streak-fire { font-size:28px; }
  .streak-num  { font-size:36px; font-weight:800; color:#fff; line-height:1; display:inline-block; }
  .streak-days { font-size:12px; color:rgba(255,255,255,.7); margin-top:2px; }
  .calendar-label { font-size:11px; color:var(--text-muted); font-weight:600; margin-bottom:8px; }

  .cal-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:4px; margin-bottom:10px; }
  .cal-day {
    aspect-ratio:1; border-radius:6px; background:#f1f5f9;
    display:flex; align-items:center; justify-content:center;
    font-size:10px; font-weight:600; color:var(--text-light);
    cursor:pointer; user-select:none;
    transition:background .15s, transform .1s, box-shadow .15s;
  }
  .cal-day:not(.today):hover { transform:scale(1.18); box-shadow:0 2px 8px rgba(37,99,235,.25); }
  .cal-day.active           { background:var(--blue-primary); color:#fff; }
  .cal-day.active:not(.today):hover { filter:brightness(1.2); }
  .cal-day.today            { background:var(--blue-dark); color:#fff; cursor:default; }

  .streak-tip { background:#fef9c3; border-radius:8px; padding:8px 10px; font-size:11px; color:#713f12; line-height:1.4; }

  @keyframes pop { 0%{transform:scale(1)} 45%{transform:scale(1.4)} 100%{transform:scale(1)} }
  .streak-num.popping { animation:pop .32s ease; }

  /* BOTTOM ROW */
  .bottom-row { display:grid; grid-template-columns:1fr 510px; gap:14px; }

  /* Task list */
  .task-item {
    display:flex; align-items:center; gap:10px;
    padding:9px 4px; border-bottom:1px solid var(--border);
    cursor:pointer; border-radius:6px; transition:background .12s;
  }
  .task-item:last-child { border-bottom:none; }
  .task-item:hover { background:#f8fafc; }
  .task-check {
    width:18px; height:18px; border-radius:5px; flex-shrink:0;
    display:flex; align-items:center; justify-content:center;
    font-size:11px; cursor:pointer; user-select:none;
    transition:background .15s, transform .1s, box-shadow .15s;
  }
  .task-check:hover { transform:scale(1.15); box-shadow:0 0 0 3px rgba(37,99,235,.15); }
  .task-check.done { background:var(--blue-primary); color:#fff; }
  .task-check.todo { border:1.5px solid var(--border); }
  .task-check.todo:hover { border-color:var(--blue-primary); background:#eff6ff; }
  .task-name { flex:1; font-size:12.5px; color:var(--text); transition:color .15s; }
  .task-name.done { color:var(--text-muted); text-decoration:line-through; }
  .task-tag { padding:2px 8px; border-radius:4px; font-size:10px; font-weight:700; flex-shrink:0; }
  .tag-mat  { background:#eff6ff; color:#1d4ed8; }
  .tag-prog { background:#eff6ff; color:#1d4ed8; }
  .tag-ing  { background:#fef9c3; color:#92400e; }
  .tag-piok { background:#f0fdf4; color:#166534; }
  .tag-ski  { background:#f0fdf4; color:#166534; }
  .tag-bk   { background:#fef3c7; color:#b45309; }
  .tag-dtp  { background:#fef9c3; color:#92400e; }

  /* Progress tabs */
  .tabs { display:flex; background:#f1f5f9; border-radius:8px; padding:3px; margin-bottom:16px; }
  .tab {
    flex:1; padding:6px; text-align:center; font-size:12px; font-weight:600;
    color:var(--text-light); border-radius:6px; cursor:pointer;
    transition:background .15s, color .15s, box-shadow .15s;
  }
  .tab.active { background:#fff; color:var(--text); box-shadow:0 1px 3px rgba(0,0,0,.1); }

  .progress-row { margin-bottom:14px; }
  .progress-info { display:flex; justify-content:space-between; align-items:center; margin-bottom:5px; }
  .progress-subject { font-size:12.5px; font-weight:600; color:var(--text); display:flex; align-items:center; gap:6px; }
  .progress-hours { font-size:11px; color:var(--text-muted); }
  .progress-pct   { font-size:12px; font-weight:700; }
  .progress-track { height:7px; background:#f1f5f9; border-radius:20px; overflow:hidden; }
  .progress-fill  { height:100%; border-radius:20px; transition:width .45s ease; }
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">S</div>
    <div>
      <div class="logo-text">Softify</div>
      <div class="logo-sub">Learning Dashboard</div>
    </div>
  </div>
  <div class="sidebar-section-label">Menu</div>
  <ul class="sidebar-nav">
    <li class="active"><a href="#"><span class="nav-icon">⊞</span>Dashboard</a></li>
    <li><a href="#"><span class="nav-icon">✓</span>Tugas</a></li>
    <li><a href="#"><span class="nav-icon">📅</span>Jadwal</a></li>
    <li><a href="#"><span class="nav-icon">📝</span>Catatan</a></li>
    <li><a href="#"><span class="nav-icon">🎯</span>Target</a></li>
  </ul>
  <div class="sidebar-bottom">
    <ul class="sidebar-nav">
      <li><a href="#"><span class="nav-icon">⚙️</span>Pengaturan</a></li>
      <li><a href="#"><span class="nav-icon">⏻</span>Keluar</a></li>
    </ul>
    <div class="sidebar-user">
      <div class="user-avatar">A</div>
      <div class="user-info">
        <div class="user-name">Agus Ibad</div>
        <div class="user-role">Pelajar Aktif</div>
      </div>
      <div class="user-dots">···</div>
    </div>
  </div>
</aside>

<!-- MAIN -->
<main class="main">
  <div class="topbar">
    <span class="topbar-title">Dashboard</span>
    <button class="btn-primary">+ Catat Sesi</button>
  </div>

  <div class="content">

    <!-- PAGE HEADER -->
    <div class="page-header">
      <div>
        <h1>Dashboard Belajar</h1>
        <p>Selamat datang kembali, Agus 👋 — Tetap semangat hari ini!</p>
      </div>
      <div class="streak-badge" id="header-streak-badge">🔥 Streak: 0 hari berturut-turut</div>
    </div>

    <!-- STAT CARDS -->
    <div class="stat-cards">
      <div class="stat-card">
        <div class="stat-label">Jam Belajar Hari Ini <div class="stat-icon blue">🕐</div></div>
        <div class="stat-value">4.5</div>
        <div class="stat-footer"><span>target: 6 jam</span><span class="badge-small badge-blue">↑ +0.5 jam</span></div>
      </div>
      <div class="stat-card green">
        <div class="stat-label">Tugas Selesai <div class="stat-icon green">✅</div></div>
        <div class="stat-value" id="stat-tugas">7</div>
        <div class="stat-footer"><span>dari 10 tugas</span><span class="badge-small badge-green" id="stat-pct-badge">70% selesai</span></div>
      </div>
      <div class="stat-card orange">
        <div class="stat-label">Progress Mingguan <div class="stat-icon orange">📊</div></div>
        <div class="stat-value">68%</div>
        <div class="stat-footer"><span>24 / 35 jam</span><span class="badge-small badge-orange">→ 11 jam lagi</span></div>
      </div>
      <div class="stat-card purple">
        <div class="stat-label">Streak Belajar <div class="stat-icon purple">🔥</div></div>
        <div class="stat-value" id="stat-streak">0</div>
        <div class="stat-footer"><span>hari berturut-turut</span><span class="badge-small badge-purple">🏆 Rekor!</span></div>
      </div>
    </div>

    <!-- MID ROW -->
    <div class="mid-row">

      <!-- Bar Chart -->
      <div class="card">
        <div class="card-header">
          <div>
            <div class="card-title">Jam Belajar per Hari</div>
            <div class="card-sub">Minggu ini — total 24 jam</div>
          </div>
          <a class="link-btn">Lihat Semua</a>
        </div>
        <div class="bar-row"><div class="bar-label">Sen</div><div class="bar-track"><div class="bar-fill" style="width:80%"></div></div><div class="bar-value">4.8h</div></div>
        <div class="bar-row"><div class="bar-label">Sel</div><div class="bar-track"><div class="bar-fill" style="width:60%"></div></div><div class="bar-value">3.6h</div></div>
        <div class="bar-row"><div class="bar-label">Rab</div><div class="bar-track"><div class="bar-fill" style="width:90%"></div></div><div class="bar-value">5.4h</div></div>
        <div class="bar-row"><div class="bar-label">Kam</div><div class="bar-track"><div class="bar-fill" style="width:50%"></div></div><div class="bar-value">3.0h</div></div>
        <div class="bar-row"><div class="bar-label">Jum</div><div class="bar-track"><div class="bar-fill" style="width:70%"></div></div><div class="bar-value">4.2h</div></div>
        <div class="bar-row"><div class="bar-label">Sab</div><div class="bar-track"><div class="bar-fill" style="width:45%"></div></div><div class="bar-value">2.7h</div></div>
        <div class="bar-row"><div class="bar-label">Min</div><div class="bar-track"><div class="bar-fill" style="width:75%"></div></div><div class="bar-value">4.5h</div></div>
      </div>

      <!-- Donut -->
      <div class="card">
        <div class="card-header">
          <div><div class="card-title">Total Tugas</div><div class="card-sub">Hari ini</div></div>
          <a class="link-btn">Detail</a>
        </div>
        <div class="donut-container">
          <div class="donut-wrap">
            <svg width="130" height="130" viewBox="0 0 130 130">
              <circle cx="65" cy="65" r="50" fill="none" stroke="#f1f5f9" stroke-width="16"/>
              <circle id="donut-circle" cx="65" cy="65" r="50" fill="none" stroke="#1e3a6e"
                stroke-width="16" stroke-dasharray="314.16" stroke-dashoffset="94.25" stroke-linecap="round"/>
            </svg>
            <div class="donut-center">
              <div class="donut-pct" id="donut-pct">70%</div>
              <div class="donut-lbl">SELESAI</div>
            </div>
          </div>
          <div class="legend" style="width:160px">
            <div class="legend-row"><div class="legend-left"><div class="legend-dot" style="background:#22c55e"></div>Selesai</div><div class="legend-val" id="leg-done">7</div></div>
            <div class="legend-row"><div class="legend-left"><div class="legend-dot" style="background:#f59e0b"></div>Pending</div><div class="legend-val" id="leg-pend" style="color:#f59e0b">3</div></div>
            <div class="legend-row"><div class="legend-left"><div class="legend-dot" style="background:#cbd5e1"></div>Total</div><div class="legend-val">10</div></div>
          </div>
        </div>
      </div>

      <!-- Streak -->
      <div class="card" style="padding:16px">
        <div class="card-title" style="margin-bottom:12px">🔥 Streak Belajar</div>
        <div class="streak-header-card">
          <div class="streak-fire">🔥</div>
          <div>
            <div><span class="streak-num" id="streak-num">0</span></div>
            <div class="streak-days">hari berturut-turut</div>
          </div>
        </div>
        <div class="calendar-label">21 HARI TERAKHIR</div>
        <!--
          State awal:
          Hari 16–20 aktif berurutan + today(21) = streak 6
          Hari 15 tidak aktif → memutus streak
        -->
        <div class="cal-grid" id="cal-grid"></div>
        <div class="streak-tip" id="streak-tip">
          🏆 <strong>Rekor pribadi!</strong> Hanya 22 hari lagi untuk badge <strong>Bintang Emas</strong>.
        </div>
      </div>
    </div>

    <!-- BOTTOM ROW -->
    <div class="bottom-row">

      <!-- Task List -->
      <div class="card">
        <div class="card-header">
          <div>
            <div class="card-title">Daftar Tugas Hari Ini</div>
            <div class="card-sub" id="task-sub">7 selesai · 3 tersisa</div>
          </div>
          <a class="link-btn">Lihat Semua</a>
        </div>
        <div class="task-item">
          <div class="task-check done">✓</div>
          <div class="task-name done">Latihan soal Matematika Bab 5</div>
          <div class="task-tag tag-mat">Matematika</div>
        </div>
        <div class="task-item">
          <div class="task-check done">✓</div>
          <div class="task-name done">Baca Biologi halaman 40–60</div>
          <div class="task-tag tag-prog">Pemrograman</div>
        </div>
        <div class="task-item">
          <div class="task-check done">✓</div>
          <div class="task-name done">Essay Bahasa Inggris – draft 1</div>
          <div class="task-tag tag-ing">B. Inggris</div>
        </div>
        <div class="task-item">
          <div class="task-check done">✓</div>
          <div class="task-name done">Rangkuman Fisika Bab Gelombang</div>
          <div class="task-tag tag-piok">PIOK</div>
        </div>
        <div class="task-item">
          <div class="task-check todo"></div>
          <div class="task-name">Review catatan Sejarah Bab 7</div>
          <div class="task-tag tag-ski">SKI</div>
        </div>
        <div class="task-item">
          <div class="task-check todo"></div>
          <div class="task-name">Kerjakan PR Fisika no. 11–15</div>
          <div class="task-tag tag-bk">BK</div>
        </div>
        <div class="task-item">
          <div class="task-check todo"></div>
          <div class="task-name">Latihan vocabulary B. Inggris</div>
          <div class="task-tag tag-dtp">DTP</div>
        </div>
      </div>

      <!-- Progress Target -->
      <div class="card">
        <div class="card-title" style="margin-bottom:4px">Progress Target</div>
        <div style="font-size:11px;color:var(--text-muted);margin-bottom:10px">Per mata pelajaran</div>
        <div class="tabs">
          <div class="tab active" id="tab-week">Minggu Ini</div>
          <div class="tab"        id="tab-month">Bulan Ini</div>
        </div>
        <div id="progress-rows"></div>
      </div>

    </div>
  </div><!-- /content -->
</main>

<script>
// ═══════════════════════════════════════════════════════
// 1. PROGRESS TARGET — tab Minggu / Bulan
// ═══════════════════════════════════════════════════════
const PROGRESS_DATA = {
  week: [
    { icon:'📐', label:'Matematika',  done:8.5, total:12, color:'#1e3a6e' },
    { icon:'🔬', label:'IPA / Sains', done:6,   total:10, color:'#22c55e' },
    { icon:'🌐', label:'B. Inggris',  done:5,   total:8,  color:'#f59e0b' },
    { icon:'📚', label:'Sejarah',     done:2.5, total:6,  color:'#ef4444' },
  ],
  month: [
    { icon:'📐', label:'Matematika',  done:34,  total:48, color:'#1e3a6e' },
    { icon:'🔬', label:'IPA / Sains', done:22,  total:40, color:'#22c55e' },
    { icon:'🌐', label:'B. Inggris',  done:18,  total:32, color:'#f59e0b' },
    { icon:'📚', label:'Sejarah',     done:9,   total:24, color:'#ef4444' },
  ]
};

function renderProgress(tab) {
  const container = document.getElementById('progress-rows');
  container.innerHTML = PROGRESS_DATA[tab].map(d => {
    const pct = Math.round(d.done / d.total * 100);
    const unit = tab === 'month' ? 'jam' : 'jam';
    return `
      <div class="progress-row">
        <div class="progress-info">
          <div class="progress-subject">${d.icon} ${d.label}</div>
          <div class="progress-hours">${d.done} / ${d.total} ${unit}</div>
        </div>
        <div class="progress-track">
          <div class="progress-fill" style="width:0%;background:${d.color};transition:width .5s ease" data-w="${pct}"></div>
        </div>
        <div style="text-align:right;margin-top:3px">
          <span class="progress-pct" style="color:${d.color}">${pct}%</span>
        </div>
      </div>`;
  }).join('');

  // Animate bars in after paint
  requestAnimationFrame(() => requestAnimationFrame(() => {
    container.querySelectorAll('.progress-fill').forEach(el => {
      el.style.width = el.dataset.w + '%';
    });
  }));
}

let currentTab = 'week';
document.getElementById('tab-week').addEventListener('click', () => {
  if (currentTab === 'week') return;
  currentTab = 'week';
  document.getElementById('tab-week').classList.add('active');
  document.getElementById('tab-month').classList.remove('active');
  renderProgress('week');
});
document.getElementById('tab-month').addEventListener('click', () => {
  if (currentTab === 'month') return;
  currentTab = 'month';
  document.getElementById('tab-month').classList.add('active');
  document.getElementById('tab-week').classList.remove('active');
  renderProgress('month');
});
renderProgress('week'); // init


// ═══════════════════════════════════════════════════════
// 2. CHECKLIST TOGGLE
// ═══════════════════════════════════════════════════════
const taskItems  = document.querySelectorAll('.task-item');
const TOTAL_TASK = taskItems.length;

taskItems.forEach(item => {
  const check = item.querySelector('.task-check');
  const name  = item.querySelector('.task-name');

  function toggleTask() {
    const isDone = check.classList.contains('done');
    check.classList.toggle('done', !isDone);
    check.classList.toggle('todo',  isDone);
    check.textContent = isDone ? '' : '✓';
    name.classList.toggle('done', !isDone);
    syncTaskUI();
  }

  check.addEventListener('click', e => { e.stopPropagation(); toggleTask(); });
  item.addEventListener('click', toggleTask);
});

function syncTaskUI() {
  const done   = document.querySelectorAll('.task-check.done').length;
  const remain = TOTAL_TASK - done;
  const pct    = Math.round(done / TOTAL_TASK * 100);
  const circ   = 2 * Math.PI * 50; // ≈ 314.16

  document.getElementById('task-sub').textContent       = `${done} selesai · ${remain} tersisa`;
  document.getElementById('stat-tugas').textContent     = done;
  document.getElementById('stat-pct-badge').textContent = pct + '% selesai';
  document.getElementById('donut-pct').textContent      = pct + '%';
  document.getElementById('donut-circle')
    .setAttribute('stroke-dashoffset', (circ * (1 - pct / 100)).toFixed(2));
  document.getElementById('leg-done').textContent = done;
  document.getElementById('leg-pend').textContent = remain;
}


// ═══════════════════════════════════════════════════════
// 3. STREAK KALENDER
//
// Logika:
//   - Ada 21 kotak (hari 1–21). Hari ke-21 = "hari ini".
//   - State disimpan di array `active[]` berisi true/false.
//   - Semua kotak bisa diklik untuk toggle, termasuk hari ini.
//   - Streak = hitung mundur dari hari ke-21 (index 20)
//     ke hari ke-1 (index 0), selama active[i] === true.
//     Begitu ketemu false → berhenti.
//   - Contoh: active = [F,F,...,F, T,T,T] (3 terakhir true)
//     → streak = 3
//   - Kalau semua true → streak = 21
// ═══════════════════════════════════════════════════════

const TOTAL_DAYS = 21;

// State: semua mulai false (belum ada yang aktif)
const active = new Array(TOTAL_DAYS).fill(false);

// Bangun kotak kalender dari JS
const grid = document.getElementById('cal-grid');
const cells = [];

for (let i = 0; i < TOTAL_DAYS; i++) {
  const cell = document.createElement('div');
  cell.className = 'cal-day';
  cell.textContent = i + 1;

  // Klik → toggle state lalu render ulang
  cell.addEventListener('click', function() {
    // Toggle hari ini
    active[i] = !active[i];

    // Setelah toggle, bersihkan semua hari yang "terisolasi"
    // — yaitu hari aktif yang tidak terhubung ke hari aktif paling akhir
    cleanIsolated();

    renderCalendar();
    updateStreak();
  });

  grid.appendChild(cell);
  cells.push(cell);
}

function cleanIsolated() {
  // Cari hari aktif paling akhir
  let lastActive = -1;
  for (let i = TOTAL_DAYS - 1; i >= 0; i--) {
    if (active[i]) { lastActive = i; break; }
  }

  // Tidak ada yang aktif → tidak perlu bersihkan
  if (lastActive === -1) return;

  // Hitung streak berurutan mundur dari lastActive
  // → semua hari di dalam rentang ini boleh aktif
  let streakStart = lastActive;
  for (let i = lastActive - 1; i >= 0; i--) {
    if (active[i]) streakStart = i;
    else break;
  }

  // Reset semua hari DI LUAR rentang streakStart..lastActive
  for (let i = 0; i < TOTAL_DAYS; i++) {
    if (i < streakStart || i > lastActive) {
      active[i] = false;
    }
  }
}

function renderCalendar() {
  for (let i = 0; i < TOTAL_DAYS; i++) {
    cells[i].className = 'cal-day' + (active[i] ? ' active' : '');
    // Hari ke-21 (index 20) diberi tanda khusus "today"
    if (i === TOTAL_DAYS - 1) {
      cells[i].classList.add('today');
    }
  }
}

function updateStreak() {
  // Cari index aktif paling akhir (paling kanan)
  let lastActive = -1;
  for (let i = TOTAL_DAYS - 1; i >= 0; i--) {
    if (active[i]) { lastActive = i; break; }
  }

  // Tidak ada yang aktif sama sekali
  if (lastActive === -1) {
    applyStreak(0);
    return;
  }

  // Hitung mundur dari lastActive ke 0, selama aktif berurutan
  let streak = 0;
  for (let i = lastActive; i >= 0; i--) {
    if (active[i]) {
      streak++;
    } else {
      break;
    }
  }

  applyStreak(streak);
}

function applyStreak(streak) {
  // Update angka dengan animasi pop
  const numEl = document.getElementById('streak-num');
  numEl.classList.remove('popping');
  void numEl.offsetWidth;
  numEl.textContent = streak;
  numEl.classList.add('popping');
  setTimeout(() => numEl.classList.remove('popping'), 360);

  document.getElementById('stat-streak').textContent = streak;
  document.getElementById('header-streak-badge').textContent =
    '🔥 Streak: ' + streak + ' hari berturut-turut';

  const tip = document.getElementById('streak-tip');
  if (streak === 0) {
    tip.innerHTML = '💡 Klik hari untuk mulai streak belajarmu!';
  } else if (streak >= 28) {
    tip.innerHTML = '🏆 <strong>Badge Bintang Emas sudah terbuka!</strong> Luar biasa! 🎉';
  } else {
    const sisa = 28 - streak;
    tip.innerHTML = '🔥 <strong>Keren!</strong> Hanya ' + sisa + ' hari lagi untuk badge <strong>Bintang Emas</strong>.';
  }
}

// Render awal
renderCalendar();
updateStreak();

// Init task UI
syncTaskUI();
</script>
</body>
</html>