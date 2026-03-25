# 📋 Admin Panel Documentation - SoftiFY

## Ikhtisar
Admin Panel SoftiFY adalah sistem kontrol lengkap untuk mengelola seluruh aspek platform, termasuk user management, task management, premium verification, dan website settings.

## ✅ Fitur yang Sudah Diimplementasikan

### 1. Role System ✓
- Field `is_admin` pada tabel users (boolean, default: false)
- Admin dapat diakses melalui `/admin/dashboard` (middleware: `['auth', 'not.banned', 'admin']`)
- User biasa akan di-reject otomatis ke 403 jika mencoba akses `/admin`

### 2. Middleware Admin ✓
- **File**: `app/Http/Middleware/EnsureAdmin.php`
- **Alias**: `'admin'` di `bootstrap/app.php`
- Hanya user dengan `is_admin = true` yang bisa akses
- User non-admin mendapat pesan: "Akses hanya untuk admin."

### 3. Admin Dashboard ✓
- **Route**: `GET /admin/dashboard` (alias: `admin.dashboard`)
- **View**: `resources/views/admin/dashboard.blade.php`
- **Statistik**:
  - Total User
  - Total Premium User
  - Total Task
  - Total Study Sessions
- Verifikasi premium user (ACC/Reject)
- Website settings management
- Recent user listing

### 4. Manajemen User ✓
- **Route**: `GET /admin/users` (alias: `admin.users.list`)
- **View**: `resources/views/admin/users/index.blade.php`
- **Fitur**:
  - ✓ Lihat semua user (table dengan pagination)
  - ✓ Search user (by nama/email)
  - ✓ Edit user (nama, email, class_level, learning_goal)
  - ✓ Hapus user
  - ✓ Ubah role user (user ↔ admin)
  - ✓ Aktif/nonaktif akun user (toggle ban)
  - ✓ Lihat task user
  - ✓ Lihat study sessions user

### 5. Manajemen Data User ✓
- **Task Management**:
  - Route: `GET /admin/users/{user}/tasks` (alias: `admin.users.tasks`)
  - Lihat semua task milik user (dengan pagination)
  - Hapus task: `DELETE /admin/tasks/{task}` (alias: `admin.tasks.delete`)

- **Sessions/Challenge Management**:
  - Route: `GET /admin/users/{user}/sessions` (alias: `admin.users.sessions`)
  - Lihat semua study session milik user
  - Duration tracking

- **Streak Management**:
  - Route: `PATCH /admin/users/{user}/streak/reset` (alias: `admin.users.streak.reset`)
  - Reset streak user ke 0

### 6. Premium Control ✓
- **Toggle Premium Status**:
  - Route: `PATCH /admin/users/{user}/premium-toggle` (alias: `admin.users.premium.toggle`)
  - Enable/disable premium plan

- **Premium Verification**:
  - Route: `PATCH /admin/users/{user}/premium` (alias: `admin.users.premium.update`)
  - Accept/reject premium applications

- **Website Settings**:
  - Atur harga premium per bulan
  - Atur fitur premium (list)
  - Atur konten landing page

### 7. UI Admin Panel ✓
- **Sidebar Navigation**:
  - Dashboard
  - Manajemen User
  - Pengaturan Website
  - Verifikasi Premium
  - Lihat Landing Page

- **Desain**: Tailwind CSS dengan color scheme SoftiFY
- **Responsive**: Full responsive untuk mobile/tablet/desktop

### 8. Security ✓
- Middleware `auth`: User harus login
- Middleware `not.banned`: User tidak boleh di-ban
- Middleware `admin`: User harus admin
- Semua route admin dilindungi dengan prefix `/admin`

### 9. Routing ✓
Struktur routing admin:
```php
Route::middleware(['auth', 'not.banned', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'listUsers'])->name('users.list');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::patch('/users/{user}/role', [AdminController::class, 'toggleUserRole'])->name('users.role.toggle');
    Route::patch('/users/{user}/status', [AdminController::class, 'toggleUserStatus'])->name('users.status.toggle');
    
    // Task Management
    Route::get('/users/{user}/tasks', [AdminController::class, 'listUserTasks'])->name('users.tasks');
    Route::delete('/tasks/{task}', [AdminController::class, 'deleteTask'])->name('tasks.delete');
    
    // Sessions Management
    Route::get('/users/{user}/sessions', [AdminController::class, 'listUserSessions'])->name('users.sessions');
    
    // Streak Management
    Route::patch('/users/{user}/streak/reset', [AdminController::class, 'resetUserStreak'])->name('users.streak.reset');
    
    // Premium Management
    Route::patch('/users/{user}/ban', [AdminController::class, 'toggleBan'])->name('users.ban.toggle');
    Route::patch('/users/{user}/premium', [AdminController::class, 'updatePremiumStatus'])->name('users.premium.update');
    Route::patch('/users/{user}/premium-toggle', [AdminController::class, 'togglePremium'])->name('users.premium.toggle');
});
```

### 10. Pagination & Search ✓
- Pagination: 15 user per halaman
- Search: By nama atau email
- Live search form di halaman user list

## 📁 File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── AdminController.php (Updated - 250+ lines)
│   └── Middleware/
│       ├── EnsureAdmin.php (Existing)
│       └── EnsureUserNotBanned.php (Existing)

routes/
└── web.php (Updated with admin routes)

resources/views/
├── admin/
│   ├── layout.blade.php (Updated - sidebar)
│   ├── dashboard.blade.php (Updated - statistics)
│   ├── users/
│   │   ├── index.blade.php (NEW - user list)
│   │   └── edit.blade.php (NEW - edit user)
│   ├── tasks/
│   │   └── index.blade.php (NEW - task list)
│   └── sessions/
│       └── index.blade.php (NEW - session list)
```

## 🚀 Cara Menggunakan

### 1. Set User sebagai Admin
```php
// Via tinker atau seeding
$user = User::find(1);
$user->update(['is_admin' => true]);
```

### 2. Akses Admin Panel
- Login dengan user yang `is_admin = true`
- Buka: `http://localhost:8000/admin/dashboard`

### 3. Navigasi Admin
- **Dashboard**: Lihat statistik & recent users
- **Manajemen User**: Edit, hapus, ubah role, lock/unlock
- **Task User**: Lihat & hapus task user tertentu
- **Sessions**: Lihat study sessions user
- **Premium**: ACC/reject premium applications
- **Settings**: Atur harga & fitur premium

## 🔒 Security Checklist

- [x] Middleware auth (user harus login)
- [x] Middleware not.banned (user tidak boleh di-ban)
- [x] Middleware admin (hanya admin bisa akses)
- [x] Route prefix `/admin` untuk isolasi
- [x] Protection dari admin lain mengubah admin user
- [x] Protection dari ban user admin
- [x] Validation on form input
- [x] Cascade delete protection

## 📊 Database Fields Used

- `users.is_admin` (boolean, default: false)
- `users.is_premium` (boolean)
- `users.is_banned` (boolean)
- `users.banned_at` (timestamp)
- `users.current_streak` (unsigned integer)
- `tasks.user_id` (foreign key)
- `study_sessions.user_id` (foreign key)

## ✨ Bonus Features

- Search functionality dengan like query
- Pagination dengan Tailwind styling
- Responsive table design
- Status badges (Active/Banned, Free/Premium)
- Streak display dengan emoji 🔥
- Session/Task counter
- User bio & class level display
- Email verification status

## 🧪 Testing Admin Panel

```bash
# 1. Set user sebagai admin
php artisan tinker
> User::first()->update(['is_admin' => true])

# 2. Login dengan user tersebut
# 3. Buka http://localhost/admin/dashboard
# 4. Test semua menu & fitur

# Alternative: Seed admin user
php artisan tinker
> User::factory()->create(['is_admin' => true])
```

## 📝 Notes

- Semua kode clean dan rapi
- Menggunakan Tailwind CSS untuk styling
- Responsive design untuk semua ukuran
- Error handling dengan flash messages
- Pagination dengan default 15-20 items per page
- Search case-insensitive

## 🎨 UI Colors

- Primary: `softi-600` (#5f4ce8)
- Success: `emerald-600` (#059669)
- Warning: `amber-600` (#d97706)
- Danger: `red-600` (#dc2626)
- Info: `blue-600` (#2563eb)

---

**Status**: ✅ Completed & Ready to Use
