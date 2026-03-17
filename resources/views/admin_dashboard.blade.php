<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Softify - Admin Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  :root {
    --sidebar-bg: #1e293b;
    --sidebar-active: #2563eb;
    --sidebar-text: #a8c0e8;
    --blue-primary: #2563eb;
    --bg: #f0f4f8;
    --card-bg: #fff;
    --text: #1e293b;
    --text-light: #64748b;
    --border: #e2e8f0;
    --radius: 12px;
    --shadow: 0 1px 4px rgba(0,0,0,0.08);
  }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }
  .sidebar { width: 180px; background: var(--sidebar-bg); color: #fff; display: flex; flex-direction: column; position: fixed; top:0; left:0; bottom:0; }
  .sidebar-logo { padding: 22px 18px; font-weight: 800; font-size: 18px; letter-spacing: 1px; }
  .sidebar-nav { list-style: none; padding: 0; margin: 0; }
  .sidebar-nav li a { display: block; color: var(--sidebar-text); text-decoration: none; padding: 12px 24px; font-weight: 600; border-left: 4px solid transparent; transition: background .15s, border-color .15s; }
  .sidebar-nav li.active a, .sidebar-nav li a:hover { background: var(--sidebar-active); color: #fff; border-left: 4px solid #60a5fa; }
  .sidebar-bottom { margin-top: auto; padding: 18px; font-size: 13px; color: var(--sidebar-text); }
  .main { margin-left: 180px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
  .topbar { background: #fff; border-bottom: 1px solid var(--border); padding: 0 32px; height: 60px; display: flex; align-items: center; justify-content: space-between; }
  .topbar-title { font-size: 18px; font-weight: 700; color: var(--text-light); }
  .admin-avatar { width: 36px; height: 36px; border-radius: 50%; background: #2563eb; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 16px; }
  .content { padding: 32px; flex: 1; }
  .cards { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; margin-bottom: 32px; }
  .card { background: var(--card-bg); border-radius: var(--radius); box-shadow: var(--shadow); padding: 24px; border: 1px solid var(--border); }
  .card-title { font-size: 15px; font-weight: 700; margin-bottom: 8px; }
  .card-value { font-size: 28px; font-weight: 800; margin-bottom: 4px; }
  .card-desc { font-size: 12px; color: var(--text-light); }
  .table-wrap { background: var(--card-bg); border-radius: var(--radius); box-shadow: var(--shadow); padding: 24px; border: 1px solid var(--border); }
  table { width: 100%; border-collapse: collapse; font-size: 13px; }
  th, td { padding: 10px 8px; text-align: left; }
  th { background: #f1f5f9; color: var(--text-light); font-weight: 700; }
  tr:nth-child(even) { background: #f9fafb; }
  .manage-link { color: var(--blue-primary); text-decoration: none; font-weight: 600; }
</style>
</head>
<body>
<aside class="sidebar">
  <div class="sidebar-logo">Softify Admin</div>
  <ul class="sidebar-nav">
    <li class="active"><a href="#">Dashboard</a></li>
    <li><a href="#">User Management</a></li>
    <li><a href="#">Content</a></li>
    <li><a href="#">Reports</a></li>
    <li><a href="#">Settings</a></li>
  </ul>
  <div class="sidebar-bottom">Logged in as <b>Admin</b></div>
</aside>
<main class="main">
  <div class="topbar">
    <span class="topbar-title">Admin Dashboard</span>
    <div class="admin-avatar">A</div>
  </div>
  <div class="content">
    <div class="cards">
      <div class="card">
        <div class="card-title">Total Users</div>
        <div class="card-value">{{ number_format($totalUsers ?? 0) }}</div>
        <div class="card-desc">Active this month</div>
      </div>
      <div class="card">
        <div class="card-title">New Registrations</div>
        <div class="card-value">{{ number_format($newRegistrations ?? 0) }}</div>
        <div class="card-desc">Last 7 days</div>
      </div>
      <div class="card">
        <div class="card-title">Reports</div>
        <div class="card-value">{{ $reports ?? 0 }}</div>
        <div class="card-desc">Pending review</div>
      </div>
    </div>
    <div class="table-wrap">
      <div style="font-size:16px;font-weight:700;margin-bottom:12px;">Recent User Activity</div>
      <table>
        <thead>
          <tr><th>User</th><th>Email</th><th>Registered</th></tr>
        </thead>
        <tbody>
          @foreach(($recentUsers ?? []) as $user)
            <tr>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->created_at->format('Y-m-d') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div style="margin-top:16px;"><a class="manage-link" href="#">View all users</a></div>
    </div>
  </div>
</main>
</body>
</html>
