<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard - SoftiFY</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1e56a0;
            --primary-dark: #153d73;
            --ink: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --bg: #f2f7ff;
            --card: #ffffff;
            --success: #16a34a;
            --warning: #d97706;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 10% -10%, #dbeafe 0%, transparent 38%),
                radial-gradient(circle at 100% 10%, #dbeafe 0%, transparent 32%),
                var(--bg);
        }

        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--line);
            padding: 14px 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-dot {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), #57a0ff);
            box-shadow: 0 10px 20px rgba(30, 86, 160, 0.22);
        }

        .brand h1 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .brand p {
            margin: 0;
            font-size: 12px;
            color: var(--muted);
        }

        .btn {
            border: none;
            border-radius: 10px;
            padding: 10px 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-soft {
            background: #eff6ff;
            color: var(--primary-dark);
        }

        .layout {
            max-width: 1180px;
            margin: 22px auto 40px;
            padding: 0 16px;
            display: grid;
            gap: 14px;
        }

        .flash {
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 13px;
        }

        .flash.ok {
            background: #dcfce7;
            color: #166534;
        }

        .flash.err {
            background: #fee2e2;
            color: #991b1b;
        }

        .hero {
            background: linear-gradient(135deg, #0f2c56, #1e56a0 55%, #2f78db);
            color: #fff;
            border-radius: 16px;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 16px;
            align-items: center;
        }

        .hero h2 {
            margin: 0;
            font-size: 24px;
        }

        .hero p {
            margin: 8px 0 0;
            color: #dbeafe;
            max-width: 680px;
            font-size: 13px;
        }

        .streak-pill {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 14px;
            padding: 12px 14px;
            min-width: 220px;
        }

        .streak-pill h3 {
            margin: 0;
            font-size: 28px;
            line-height: 1;
        }

        .streak-pill p {
            margin: 6px 0 0;
            font-size: 12px;
            color: #bfdbfe;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(150px, 1fr));
            gap: 12px;
        }

        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.04);
        }

        .stat {
            padding: 14px;
        }

        .stat small {
            color: var(--muted);
            font-size: 12px;
        }

        .stat h3 {
            margin: 6px 0 2px;
            font-size: 28px;
            line-height: 1;
        }

        .stat p {
            margin: 0;
            font-size: 12px;
            color: var(--muted);
        }

        .grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 14px;
        }

        .panel {
            padding: 16px;
        }

        .panel h3 {
            margin: 0;
            font-size: 16px;
        }

        .panel p {
            margin: 4px 0 14px;
            color: var(--muted);
            font-size: 12px;
        }

        form { margin: 0; }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin-bottom: 8px;
        }

        input,
        textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            padding: 10px;
            font: inherit;
            font-size: 13px;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        .list {
            margin-top: 12px;
            display: grid;
            gap: 8px;
        }

        .item {
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 10px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            align-items: center;
        }

        .item h4 {
            margin: 0;
            font-size: 14px;
        }

        .item p {
            margin: 3px 0 0;
            font-size: 12px;
            color: var(--muted);
        }

        .item .actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .target-bar {
            margin-top: 8px;
            width: 100%;
            height: 8px;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .target-bar span {
            display: block;
            height: 100%;
            background: linear-gradient(90deg, #16a34a, #86efac);
        }

        .session-list li {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            border-bottom: 1px dashed #dbe2ec;
            padding: 8px 0;
            font-size: 13px;
        }

        .session-list li:last-child {
            border-bottom: none;
        }

        .chart-wrap {
            border: 1px solid #dbe2ec;
            border-radius: 10px;
            padding: 10px;
            background: #f8fbff;
        }

        @media (max-width: 960px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .hero {
                grid-template-columns: 1fr;
            }

            .streak-pill {
                min-width: 0;
            }
        }
    </style>
</head>
<body>
<header class="topbar">
    <div class="brand">
        <div class="logo-dot"></div>
        <div>
            <h1>SOFTIFY Dashboard</h1>
            <p>{{ auth()->user()->name }} • {{ auth()->user()->class_level ?: 'Pelajar SoftiFY' }}</p>
        </div>
    </div>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</header>

<main class="layout">
    @if (session('success'))
        <div class="flash ok">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="flash err">{{ $errors->first() }}</div>
    @endif

    <section class="hero card">
        <div>
            <h2>Belajar konsisten, raih target lebih cepat.</h2>
            <p>
                Streak akan bertambah jika semua task harian selesai. Jika ada hari terlewat, sistem grace akan dipakai otomatis hingga 3 kali dalam 1 bulan.
                Grace terpakai bulan ini: {{ $graceUsed }}x.
            </p>
        </div>
        <div class="streak-pill">
            <h3>🔥 {{ auth()->user()->current_streak }} Hari</h3>
            <p>{{ $todayAllDone ? 'Semua task hari ini sudah selesai.' : 'Selesaikan semua task hari ini untuk menjaga streak.' }}</p>
            <p>Grace tersisa bulan ini: {{ $graceRemaining }}x</p>
        </div>
    </section>

    <section class="stats">
        <article class="card stat">
            <small>Jumlah Task Hari Ini</small>
            <h3>{{ $todayTaskCount }}</h3>
            <p>Total task due hari ini</p>
        </article>
        <article class="card stat">
            <small>Task Sudah Selesai</small>
            <h3>{{ $todayCompletedCount }}</h3>
            <p>Dari task due hari ini</p>
        </article>
        <article class="card stat">
            <small>Progress Target</small>
            <h3>{{ $targetProgress }}%</h3>
            <p>Akumulasi semua target belajar</p>
        </article>
        <article class="card stat">
            <small>Jam Belajar Minggu Ini</small>
            <h3>{{ $weeklyHours }}</h3>
            <p>Berdasarkan sesi belajar</p>
        </article>
    </section>

    <section class="grid">
        <article class="card panel">
            <h3>Grafik Aktivitas Belajar</h3>
            <p>Ringkasan jam belajar 7 hari terakhir.</p>
            <div class="chart-wrap">
                <canvas id="activityChart" height="120"></canvas>
            </div>
        </article>

        <article class="card panel">
            <h3>Catat Sesi Belajar</h3>
            <p>Input sesi untuk memperkaya data grafik dan progres.</p>
            <form method="POST" action="{{ route('study-session.store') }}">
                @csrf
                <div class="form-row">
                    <input type="number" name="minutes" min="5" max="600" value="60" required placeholder="Durasi (menit)">
                    <input type="date" name="study_date" value="{{ now()->toDateString() }}" required>
                </div>
                <input type="text" name="topic" placeholder="Topik belajar (opsional)">
                <button class="btn btn-primary" type="submit">Simpan Sesi</button>
            </form>
            <ul class="session-list" style="margin: 12px 0 0; padding-left: 0; list-style: none;">
                @forelse ($latestSessions as $session)
                    <li>
                        <span>{{ $session->study_date->format('d M Y') }} • {{ $session->topic ?: 'Sesi belajar' }}</span>
                        <strong>{{ $session->minutes }} m</strong>
                    </li>
                @empty
                    <li><span>Belum ada sesi belajar.</span></li>
                @endforelse
            </ul>
        </article>
    </section>

    <section class="grid">
        <article class="card panel">
            <h3>Manajemen Task Harian</h3>
            <p>Task adalah acuan utama perhitungan streak harian.</p>
            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf
                <div class="form-row">
                    <input type="text" name="title" required placeholder="Judul task">
                    <input type="date" name="due_date" value="{{ now()->toDateString() }}" required>
                </div>
                <div class="form-row">
                    <input type="text" name="subject" placeholder="Mapel / kategori">
                    <input type="text" name="description" placeholder="Catatan singkat (opsional)">
                </div>
                <button class="btn btn-primary" type="submit">Tambah Task</button>
            </form>

            <div class="list">
                @forelse ($tasks as $task)
                    <div class="item">
                        <div>
                            <h4>{{ $task->title }}</h4>
                            <p>
                                {{ $task->subject ?: 'Tanpa kategori' }} •
                                due {{ $task->due_date->format('d M Y') }} •
                                {{ $task->is_done ? 'Selesai' : 'Belum selesai' }}
                            </p>
                        </div>
                        <div class="actions">
                            <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ $task->is_done ? 'btn-soft' : 'btn-primary' }}">
                                    {{ $task->is_done ? 'Batalkan' : 'Selesai' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Hapus task ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p style="margin: 8px 0 0; color: var(--muted); font-size: 13px;">Belum ada task.</p>
                @endforelse
            </div>
        </article>

        <article class="card panel">
            <h3>Target Belajar</h3>
            <p>Pantau progress target agar konsisten dengan rencana belajar berbasis rentang waktu.</p>
            <form method="POST" action="{{ route('targets.store') }}">
                @csrf
                <input type="text" name="title" required placeholder="Nama target">
                <div class="form-row">
                    <select name="period_type" required>
                        <option value="daily">Harian</option>
                        <option value="weekly" selected>Mingguan</option>
                        <option value="monthly">Bulanan</option>
                    </select>
                    <input type="number" name="target_hours" min="1" max="2000" placeholder="Target jam" required>
                </div>
                <div class="form-row">
                    <input type="date" name="start_date" value="{{ now()->toDateString() }}" required>
                    <input type="date" name="end_date" value="{{ now()->addWeek()->toDateString() }}" required>
                </div>
                <button class="btn btn-primary" type="submit">Tambah Target</button>
            </form>

            <div class="list">
                @forelse ($targets as $target)
                    @php
                        $progress = $target->target_hours > 0 ? min(100, (int) round(($target->current_hours / $target->target_hours) * 100)) : 0;
                        $statusText = $target->status === 'completed' ? 'Completed' : ($target->status === 'expired' ? 'Expired' : 'Active');
                        $statusStyle = $target->status === 'completed'
                            ? 'background: #dcfce7; color: #166534;'
                            : ($target->status === 'expired' ? 'background: #fee2e2; color: #991b1b;' : 'background: #dbeafe; color: #1e3a8a;');
                    @endphp
                    <div class="item" style="grid-template-columns: 1fr;">
                        <div>
                            <h4>{{ $target->title }}</h4>
                            <p>
                                {{ $target->current_hours }} / {{ $target->target_hours }} jam •
                                {{ $target->start_date ? $target->start_date->format('d M Y') : '-' }} s/d {{ $target->end_date ? $target->end_date->format('d M Y') : '-' }}
                            </p>
                            <p>
                                <span style="{{ $statusStyle }} padding: 3px 8px; border-radius: 999px; font-size: 11px; font-weight: 600;">{{ $statusText }}</span>
                            </p>
                            <div class="target-bar"><span style="width: {{ $progress }}%"></span></div>
                        </div>
                        <div class="actions" style="justify-content: flex-start;">
                            <form method="POST" action="{{ route('targets.progress', $target) }}" style="display: grid; gap: 6px; align-items: center; grid-template-columns: minmax(90px, 120px) minmax(0, 1fr) auto; width: 100%;">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="added_hours" min="1" max="2000" placeholder="+ jam" style="margin: 0;">
                                <input type="text" name="note" placeholder="Catatan belajar (opsional)" style="margin: 0;">
                                <button type="submit" class="btn btn-soft" {{ $target->status !== 'active' ? 'disabled' : '' }}>Tambah</button>
                            </form>
                            <form method="POST" action="{{ route('targets.destroy', $target) }}" onsubmit="return confirm('Hapus target ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                        @if ($target->logs->isNotEmpty())
                            <details style="margin-top: 4px;">
                                <summary style="cursor: pointer; color: var(--primary-dark); font-size: 12px; font-weight: 600;">Riwayat Progress</summary>
                                <ul class="session-list" style="margin: 6px 0 0; padding-left: 0; list-style: none;">
                                    @foreach ($target->logs as $log)
                                        <li>
                                            <span>{{ $log->date->format('d M Y') }} • +{{ $log->added_hours }} jam{{ $log->note ? ' - ' . $log->note : '' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </details>
                        @endif
                    </div>
                @empty
                    <p style="margin: 8px 0 0; color: var(--muted); font-size: 13px;">Belum ada target belajar.</p>
                @endforelse
            </div>
        </article>
    </section>

    <section class="card panel">
        <h3>Profil User</h3>
        <p>Perbarui data dasar agar pengalaman dashboard lebih personal.</p>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PATCH')
            <div class="form-row">
                <input name="name" value="{{ old('name', auth()->user()->name) }}" required placeholder="Nama lengkap">
                <input name="class_level" value="{{ old('class_level', auth()->user()->class_level) }}" placeholder="Kelas / tingkat">
            </div>
            <div class="form-row">
                <input name="learning_goal" value="{{ old('learning_goal', auth()->user()->learning_goal) }}" placeholder="Tujuan belajar">
                <input name="bio" value="{{ old('bio', auth()->user()->profile?->bio) }}" placeholder="Bio singkat">
            </div>
            <button class="btn btn-primary" type="submit">Simpan Profil</button>
        </form>
    </section>
</main>

<script>
    const labels = @json($activityLabels);
    const values = @json($activityHours);
    const canvas = document.getElementById('activityChart');
    const ctx = canvas.getContext('2d');

    const width = canvas.width = canvas.offsetWidth * window.devicePixelRatio;
    const height = canvas.height = 220 * window.devicePixelRatio;

    const padLeft = 34 * window.devicePixelRatio;
    const padRight = 12 * window.devicePixelRatio;
    const padTop = 12 * window.devicePixelRatio;
    const padBottom = 24 * window.devicePixelRatio;

    const chartWidth = width - padLeft - padRight;
    const chartHeight = height - padTop - padBottom;
    const maxVal = Math.max(1, ...values);

    ctx.clearRect(0, 0, width, height);
    ctx.font = `${11 * window.devicePixelRatio}px Poppins`;
    ctx.textAlign = 'center';

    values.forEach((val, i) => {
        const x = padLeft + (chartWidth / values.length) * i + (chartWidth / values.length) * 0.18;
        const barW = (chartWidth / values.length) * 0.64;
        const barH = (val / maxVal) * chartHeight;
        const y = padTop + (chartHeight - barH);

        const gradient = ctx.createLinearGradient(0, y, 0, y + barH);
        gradient.addColorStop(0, '#1e56a0');
        gradient.addColorStop(1, '#60a5fa');

        ctx.fillStyle = '#e2e8f0';
        ctx.fillRect(x, padTop, barW, chartHeight);

        ctx.fillStyle = gradient;
        ctx.fillRect(x, y, barW, barH);

        ctx.fillStyle = '#64748b';
        ctx.fillText(labels[i], x + barW / 2, height - (6 * window.devicePixelRatio));

        ctx.fillStyle = '#0f172a';
        ctx.fillText(`${val}j`, x + barW / 2, y - (4 * window.devicePixelRatio));
    });
</script>
</body>
</html>
