# 🛠️ Quick Setup - Admin Panel SoftiFY

## Langkah 1: Set User sebagai Admin

### Opsi A: Via Tinker (Cepat)
```bash
php artisan tinker
```

```php
> User::first()->update(['is_admin' => true])
```

### Opsi B: Via Seeding
Jika ingin seed data admin:
```bash
php artisan tinker
```

```php
> User::factory()->create([
    'name' => 'Admin SoftiFY',
    'email' => 'admin@softify.test',
    'password' => Hash::make('password123'),
    'is_admin' => true
])
```

### Opsi C: Direct Database Query
```sql
UPDATE users SET is_admin = 1 WHERE email = 'your-email@test.com';
```

## Langkah 2: Login sebagai Admin

1. Akses halaman login: `http://localhost:8000/login`
2. Masukkan email & password user yang `is_admin = true`
3. Klik "Masuk"

## Langkah 3: Akses Admin Panel

Setelah login, buka salah satu URL ini:
- **Dashboard**: `http://localhost:8000/admin/dashboard`
- **User Management**: `http://localhost:8000/admin/users`

Atau klik link "Kelola Semua User" di dashboard.

## 📋 Fitur Cepat

| Fitur | URL | Keterangan |
|-------|-----|-----------|
| Dashboard | `/admin/dashboard` | Statistik & overview |
| User List | `/admin/users` | Daftar semua user |
| Edit User | `/admin/users/{id}/edit` | Edit profil user |
| User Tasks | `/admin/users/{id}/tasks` | Lihat tasks user |
| User Sessions | `/admin/users/{id}/sessions` | Lihat study sessions |

## 🔑 Default Admin Credentials (jika di-seed)

```
Email: admin@softify.test
Password: password123
```

## ⚠️ Penting

- Hanya user dengan `is_admin = true` yang bisa akses `/admin`
- User non-admin akan mendapat error 403
- Admin tidak bisa ban/hapus admin lain
- User yang di-ban tidak bisa login

## 🧪 Test Checklist

- [ ] Login sebagai admin
- [ ] Buka admin dashboard
- [ ] Lihat statistik user/task/sessions
- [ ] Cari user
- [ ] Edit user
- [ ] Lihat tasks user
- [ ] Hapus task
- [ ] Ubah role user
- [ ] Blokir/unlock user
- [ ] Toggle premium plan

## 💡 Tips

1. **Search User**: Gunakan search box di halaman user list untuk cari nama/email
2. **Edit User**: Klik tombol ✏️ untuk edit profile user
3. **Lihat Tasks**: Klik 📋 untuk lihat semua tasks user
4. **Lihat Sessions**: Klik ⏱️ untuk lihat study sessions
5. **Ubah Role**: Klik 👤 untuk toggle admin status
6. **Blokir User**: Klik 🔒 untuk blokir/unlock
7. **Hapus**: Klik 🗑️ untuk delete (hati-hati, tidak bisa di-undo!)

## 📞 Troubleshooting

### Error: "Akses hanya untuk admin"
- User Anda tidak memiliki `is_admin = true`
- Update di database: `UPDATE users SET is_admin = 1 WHERE id = X`

### Tidak bisa login
- User sudah di-ban? Check `is_banned` field
- Password salah? Reset via tinker

### Button tidak bekerja
- Pastikan sudah login sebagai admin
- Refresh halaman
- Clear browser cache

---

**Status**: Ready to Use! 🚀
