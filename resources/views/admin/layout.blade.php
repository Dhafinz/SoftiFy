<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Admin SoftiFY' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        softi: {
                            50: '#f4f3ff',
                            100: '#ece9ff',
                            500: '#6f5ef7',
                            600: '#5f4ce8',
                            700: '#4f3bcc',
                            900: '#20195f'
                        }
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-slate-100 text-slate-800">
<div class="min-h-screen md:flex">
    <aside class="w-full md:w-72 md:h-screen md:sticky md:top-0 bg-gradient-to-b from-slate-950 via-softi-900 to-indigo-950 text-white flex flex-col">
        <div class="px-5 py-6 border-b border-white/10">
            <p class="text-[11px] tracking-[0.2em] uppercase text-blue-100/80">Control Center</p>
            <h1 class="text-2xl font-black tracking-wide mt-1">SOFTIFY ADMIN</h1>
            <p class="text-xs text-blue-100 mt-1">Kelola seluruh sistem website</p>
        </div>

        <nav class="px-3 py-4 space-y-1 text-sm flex-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 bg-white/20 text-white shadow-lg shadow-black/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 2.5a.75.75 0 00-1.5 0v.757a7.5 7.5 0 00-5.493 5.493H3a.75.75 0 000 1.5h.757a7.5 7.5 0 005.493 5.493V17a.75.75 0 001.5 0v-.757a7.5 7.5 0 005.493-5.493H17a.75.75 0 000-1.5h-.757a7.5 7.5 0 00-5.493-5.493V2.5z"/></svg>
                Dashboard Admin
            </a>
            <a href="{{ route('admin.users.list') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-blue-100 hover:bg-white/10 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 8a7 7 0 1114 0H3z"/></svg>
                Manajemen User
            </a>
            <a href="#settings" class="flex items-center gap-2 rounded-xl px-3 py-2 text-blue-100 hover:bg-white/10 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.84 1.804a1 1 0 011.32.54l.148.4a1 1 0 00.95.676h.484a1 1 0 00.95-.676l.148-.4a1 1 0 011.86.682l-.149.4a1 1 0 00.274 1.118l.343.342a1 1 0 001.118.274l.4-.149a1 1 0 11.682 1.86l-.4.148a1 1 0 00-.676.95v.484a1 1 0 00.676.95l.4.148a1 1 0 11-.682 1.86l-.4-.149a1 1 0 00-1.118.274l-.343.342a1 1 0 00-.274 1.118l.149.4a1 1 0 11-1.86.682l-.148-.4a1 1 0 00-.95-.676h-.484a1 1 0 00-.95.676l-.148.4a1 1 0 11-1.86-.682l.149-.4a1 1 0 00-.274-1.118l-.343-.342a1 1 0 00-1.118-.274l-.4.149a1 1 0 11-.682-1.86l.4-.148a1 1 0 00.676-.95v-.484a1 1 0 00-.676-.95l-.4-.148a1 1 0 11.682-1.86l.4.149a1 1 0 001.118-.274l.343-.342a1 1 0 00.274-1.118l-.149-.4a1 1 0 01.54-1.32zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/></svg>
                Pengaturan Website
            </a>
            <a href="#premium-verify" class="flex items-center gap-2 rounded-xl px-3 py-2 text-blue-100 hover:bg-white/10 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2l2.12 4.296 4.743.689-3.431 3.344.81 4.724L10 12.824l-4.242 2.23.81-4.724L3.137 6.985l4.743-.689L10 2z"/></svg>
                Verifikasi Premium
            </a>
            <a href="{{ route('page') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-blue-100 hover:bg-white/10 hover:text-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M4 3a1 1 0 00-1 1v12a1 1 0 001.447.894L10 14.118l5.553 2.776A1 1 0 0017 16V4a1 1 0 00-1-1H4z"/></svg>
                Lihat Landing Page
            </a>
        </nav>

        <div class="px-4 py-4 border-t border-white/10 bg-black/20">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full rounded-xl bg-red-500/80 hover:bg-red-500 px-3 py-2 text-sm font-semibold">Logout Admin</button>
            </form>
            <div class="mt-3 rounded-xl bg-white/10 px-3 py-2">
                <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-blue-100/90 truncate">{{ auth()->user()->email }}</p>
                <p class="text-[11px] text-blue-100/90 mt-1">Role: Super Admin</p>
            </div>
        </div>
    </aside>

    <main class="flex-1">
        <header class="bg-white border-b border-slate-200 px-4 py-4 sm:px-6 flex items-center justify-between gap-3">
            <div>
                <p class="font-semibold">{{ $title ?? 'Admin Dashboard' }}</p>
                <p class="text-xs text-slate-500">Kelola harga, premium, user, dan alur website dalam satu tempat.</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-slate-500">Waktu server</p>
                <p class="text-sm font-semibold text-slate-700">{{ now()->format('d M Y H:i') }}</p>
            </div>
        </header>

        <section class="p-4 sm:p-6 space-y-4">
            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
            @endif

            @yield('content')
        </section>
    </main>
</div>
</body>
</html>
