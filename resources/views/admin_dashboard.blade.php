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
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }
  .sidebar { width: 180px; background: var(--sidebar-bg); color: #fff; display: flex; flex-direction: column; position: fixed; top:0; left:0; bottom:0; z-index: 1000; }
  .sidebar-logo { padding: 22px 18px; font-weight: 800; font-size: 18px; letter-spacing: 1px; }
  .sidebar-nav { list-style: none; padding: 0; margin: 0; }
  .sidebar-nav li a { display: block; color: var(--sidebar-text); text-decoration: none; padding: 12px 24px; font-weight: 600; border-left: 4px solid transparent; transition: background .15s, border-color .15s; }
  .sidebar-nav li.active a, .sidebar-nav li a:hover { background: var(--sidebar-active); color: #fff; border-left: 4px solid #60a5fa; }
  .sidebar-bottom { margin-top: auto; padding: 18px; font-size: 13px; color: var(--sidebar-text); }
  .main { margin-left: 180px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
  .topbar { background: #fff; border-bottom: 1px solid var(--border); padding: 0 32px; height: 60px; display: flex; align-items: center; justify-content: space-between; }
  .topbar-title { font-size: 18px; font-weight: 700; color: var(--text-light); }
  .admin-avatar { width: 36px; height: 36px; border-radius: 50%; background: #2563eb; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 16px; }
  .content { padding: 32px; flex: 1; overflow-y: auto; }
  .cards { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; margin-bottom: 32px; }
  .card { background: var(--card-bg); border-radius: var(--radius); box-shadow: var(--shadow); padding: 24px; border: 1px solid var(--border); }
  .card-title { font-size: 15px; font-weight: 700; margin-bottom: 8px; }
  .card-value { font-size: 28px; font-weight: 800; margin-bottom: 4px; }
  .card-desc { font-size: 12px; color: var(--text-light); }
  .table-wrap { background: var(--card-bg); border-radius: var(--radius); box-shadow: var(--shadow); padding: 24px; border: 1px solid var(--border); overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; font-size: 13px; }
  th, td { padding: 10px 8px; text-align: left; white-space: nowrap; }
  th { background: #f1f5f9; color: var(--text-light); font-weight: 700; }
  tr:nth-child(even) { background: #f9fafb; }
  .manage-link { color: var(--blue-primary); text-decoration: none; font-weight: 600; }
  
  /* Mobile Responsiveness */
  @media (max-width: 1024px) {
    .cards { grid-template-columns: repeat(2,1fr); }
    .content { padding: 20px; }
  }
  
  @media (max-width: 768px) {
    .sidebar {
      width: 100%;
      height: auto;
      position: relative;
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
      padding: 16px;
      z-index: 100;
    }
    .sidebar-logo { padding: 0; margin: 0; }
    .sidebar-nav {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: var(--sidebar-bg);
      flex-direction: column;
      width: 100%;
    }
    .sidebar-nav.active { display: flex; }
    .sidebar-nav li a { padding: 10px 16px; border-left: none; border-bottom: 1px solid rgba(255,255,255,0.1); }
    .sidebar-bottom {
      display: none;
    }
    .sidebar::after {
      content: "☰";
      font-size: 24px;
      color: #fff;
      cursor: pointer;
      margin: 0;
    }
    .main { margin-left: 0; margin-top: 0; }
    .topbar { padding: 0 16px; }
    .topbar-title { font-size: 16px; }
    .cards { grid-template-columns: 1fr; gap: 16px; margin-bottom: 20px; }
    .content { padding: 16px; }
    .table-wrap { padding: 16px; }
    table { font-size: 12px; }
    th, td { padding: 8px 4px; }
  }
  
  @media (max-width: 480px) {
    .topbar { height: auto; padding: 12px; flex-direction: column; align-items: flex-start; gap: 8px; }
    .topbar-title { font-size: 14px; }
    .admin-avatar { width: 32px; height: 32px; font-size: 14px; }
    .cards { gap: 12px; }
    .card { padding: 16px; }
    .card-title { font-size: 13px; }
    .card-value { font-size: 22px; }
    .card-desc { font-size: 11px; }
    .content { padding: 12px; }
    .table-wrap { padding: 12px; }
    table { font-size: 11px; }
    th, td { padding: 6px 2px; }
  }
</style>
</head>
<body>
<aside class="sidebar" id="adminSidebar">
  <div class="sidebar-logo">Softify Admin</div>
  <ul class="sidebar-nav" id="sidebarNav">
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
            @if($user)
            <tr>
              <td>{{ $user->name ?? '-' }}</td>
              <td>{{ $user->email ?? '-' }}</td>
              <td>{{ optional($user->created_at)->format('Y-m-d') ?? '-' }}</td>
            </tr>
            @endif
          @endforeach
        </tbody>
      </table>
      <div style="margin-top:16px;"><a class="manage-link" href="#">View all users</a></div>
    </div>
  </div>
</main>

<script>
  // Mobile sidebar toggle
  const adminSidebar = document.getElementById('adminSidebar');
  const sidebarNav = document.getElementById('sidebarNav');

  if (adminSidebar && sidebarNav && window.innerWidth <= 768) {
    adminSidebar.addEventListener('click', (e) => {
      if (e.target !== sidebarNav && e.target.tagName !== 'A') {
        sidebarNav.classList.toggle('active');
      }
    });

    // Close menu when a link is clicked
    sidebarNav.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        sidebarNav.classList.remove('active');
      });
    });
  }
</script>
</body>
</html>
