<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'SoftiFY App' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        softi: {
                            50: '#eef6ff',
                            100: '#dbeafe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0b2440'
                        }
                    },
                    boxShadow: {
                        float: '0 16px 40px -24px rgba(2, 132, 199, 0.55)'
                    }
                }
            }
        };
    </script>
</head>
<body class="bg-slate-100 text-slate-800 antialiased">
<div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(14,165,233,0.14),_transparent_55%),_linear-gradient(to_bottom,_#f8fbff,_#f1f5f9)] md:flex">
    @php
        $notificationCount = collect($notifications ?? [])->where('type', '!=', 'success')->count();
        $friendRequestCount = auth()->check()
            ? \App\Models\Friend::query()
                ->where('friend_id', auth()->id())
                ->where('status', \App\Models\Friend::STATUS_PENDING)
                ->count()
            : 0;
        $unreadChatCount = auth()->check()
            ? \App\Models\Message::query()
                ->where('receiver_id', auth()->id())
                ->whereNull('read_at')
                ->count()
            : 0;
    @endphp

    <div id="mobileOverlay" class="fixed inset-0 z-40 bg-slate-950/45 backdrop-blur-sm hidden md:hidden pointer-events-none"></div>

    <header class="md:hidden fixed top-0 inset-x-0 z-30 px-4 pt-4">
        <div class="rounded-2xl bg-white/90 backdrop-blur border border-slate-200/70 shadow-float px-3 py-2.5 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold tracking-[0.18em] uppercase text-softi-700">SoftiFy</p>
                <p class="text-sm font-bold text-slate-900 leading-tight">{{ $title ?? 'Dashboard' }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('notifications.index') }}" class="relative inline-flex items-center justify-center h-10 w-10 rounded-xl border border-slate-200 bg-white text-slate-700 active:scale-95 transition">
                    <span class="text-lg">🔔</span>
                    @if ($notificationCount > 0)
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center text-[10px] h-5 min-w-[20px] px-1 rounded-full bg-red-500 text-white font-bold">{{ $notificationCount }}</span>
                    @endif
                </a>
                <button id="mobileMenuOpen" type="button" class="inline-flex items-center justify-center h-10 w-10 rounded-xl border border-slate-200 bg-white text-slate-700 active:scale-95 transition" aria-label="Buka menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 5.75A.75.75 0 013.75 5h12.5a.75.75 0 010 1.5H3.75A.75.75 0 013 5.75zm0 4.5a.75.75 0 01.75-.75h12.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75zm0 4.5a.75.75 0 01.75-.75h12.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z" clip-rule="evenodd"/></svg>
                </button>
            </div>
        </div>
    </header>

    <aside id="mobileSidebar" class="fixed right-0 top-0 bottom-0 z-50 w-[88%] max-w-xs translate-x-full transition-transform duration-300 bg-gradient-to-b from-softi-900 via-sky-900 to-cyan-950 text-white flex flex-col md:translate-x-0 md:sticky md:left-0 md:top-0 md:z-auto md:h-screen md:w-72">
        <div class="px-5 py-6 border-b border-white/10 flex items-start justify-between gap-3">
            <div>
                <h1 class="text-2xl font-black tracking-wide">SOFTIFY</h1>
                <p class="text-xs text-sky-100 mt-1">Belajar fokus, progres makin jelas</p>
            </div>
            <button id="mobileMenuClose" type="button" class="md:hidden inline-flex items-center justify-center h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 transition" aria-label="Tutup menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.22 4.22a.75.75 0 011.06 0L10 8.94l4.72-4.72a.75.75 0 111.06 1.06L11.06 10l4.72 4.72a.75.75 0 11-1.06 1.06L10 11.06l-4.72 4.72a.75.75 0 11-1.06-1.06L8.94 10 4.22 5.28a.75.75 0 010-1.06z" clip-rule="evenodd"/></svg>
            </button>
        </div>

        <nav class="px-3 py-4 space-y-1.5 text-sm flex-1 overflow-y-auto">
            @php
                $is = function (string $name): string {
                    return request()->routeIs($name)
                        ? 'bg-white/20 text-white shadow-lg shadow-black/15'
                        : 'text-sky-100 hover:bg-white/10 hover:text-white';
                };
            @endphp
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 transition {{ $is('dashboard') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 2.5a.75.75 0 00-1.5 0v.757a7.5 7.5 0 00-5.493 5.493H3a.75.75 0 000 1.5h.757a7.5 7.5 0 005.493 5.493V17a.75.75 0 001.5 0v-.757a7.5 7.5 0 005.493-5.493H17a.75.75 0 000-1.5h-.757a7.5 7.5 0 00-5.493-5.493V2.5z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('tasks.index') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 transition {{ $is('tasks.*') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-7 9a.75.75 0 01-1.133.06l-3.5-3.5a.75.75 0 111.06-1.06l2.894 2.893 6.47-8.318a.75.75 0 011.052-.127z" clip-rule="evenodd"/></svg>
                Task
            </a>
            <a href="{{ route('diary.index') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 transition {{ $is('diary.*') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M4.75 2A2.75 2.75 0 002 4.75v10.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25V4.75A2.75 2.75 0 0015.25 2H4.75zM5.5 6.25a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zm0 3.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zm0 3.5a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75z"/></svg>
                Diary
            </a>
            <a href="{{ route('targets.index') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 transition {{ $is('targets.*') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M3 3.75A.75.75 0 013.75 3h12.5a.75.75 0 01.75.75v1.5a.75.75 0 01-.75.75H3.75A.75.75 0 013 5.25v-1.5zM3 8.75A.75.75 0 013.75 8h7.5a.75.75 0 01.75.75v7.5a.75.75 0 01-.75.75h-7.5A.75.75 0 013 16.25v-7.5zM13.5 9a.5.5 0 01.5-.5h2a.5.5 0 010 1h-2a.5.5 0 01-.5-.5zm0 3a.5.5 0 01.5-.5h2a.5.5 0 010 1h-2a.5.5 0 01-.5-.5zm.5 2.5a.5.5 0 000 1h2a.5.5 0 000-1h-2z"/></svg>
                Target
            </a>
            <a href="{{ route('ai.index') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 transition {{ $is('ai.*') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a1 1 0 011 1v1.126a5 5 0 013.5 4.767V10h.5a2 2 0 110 4h-1.126A5 5 0 0111 17.874V19a1 1 0 11-2 0v-1.126A5 5 0 015.626 14H4.5a2 2 0 110-4H5v-1.107A5 5 0 019 4.126V3a1 1 0 011-1z"/></svg>
                AI Assistant
            </a>
            <a href="{{ route('challenge.index') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 transition {{ $is('challenge.*') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11a.75.75 0 00-1.5 0v3.25c0 .199.079.39.22.53l2 2a.75.75 0 101.06-1.06l-1.78-1.72V7z" clip-rule="evenodd"/></svg>
                Challenge
            </a>
            <a href="{{ route('leaderboard.index') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 transition {{ $is('leaderboard.*') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15 2.75a.75.75 0 00-.75-.75h-8.5a.75.75 0 00-.75.75v3.628A4.5 4.5 0 008 10.5v1.757a1 1 0 00-.553.894V16h5.106v-2.849a1 1 0 00-.553-.894V10.5a4.5 4.5 0 002.75-4.122V2.75zM6.5 3.5v2.878a3 3 0 006 0V3.5h-6z" clip-rule="evenodd"/></svg>
                Leaderboard
            </a>
            <a href="{{ route('notifications.index') }}" class="flex items-center justify-between rounded-xl px-3 py-2.5 transition {{ $is('notifications.*') }}">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a4 4 0 00-4 4v1.586l-.707.707A1 1 0 005 10h10a1 1 0 00.707-1.707L15 7.586V6a4 4 0 00-4-4z"/><path d="M10 18a3 3 0 01-2.995-2.824L7 15h6a3 3 0 01-3 3z"/></svg>
                    Notifications
                </span>
                @if ($notificationCount > 0)
                    <span class="inline-flex items-center justify-center text-[10px] h-5 min-w-[20px] px-1 rounded-full bg-red-500 text-white font-bold">{{ $notificationCount }}</span>
                @endif
            </a>
            <a href="{{ route('friends.index') }}" class="flex items-center justify-between rounded-xl px-3 py-2.5 transition {{ $is('friends.*') }}">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M7 9a3 3 0 100-6 3 3 0 000 6zm6 1a2.5 2.5 0 10-2.5-2.5A2.5 2.5 0 0013 10zm0 1c-1.6 0-3.85.8-4.34 2.4A3.66 3.66 0 007 12c-2 0-6 1-6 3v1h10v-1a3.2 3.2 0 00-.16-1c.79-.63 1.99-1 2.16-1 .88 0 2.58.37 2.96 1.36V16h4v-.76c0-2.2-3.1-4.24-7-4.24z"/></svg>
                    Teman
                </span>
                @if ($friendRequestCount > 0)
                    <span class="inline-flex items-center justify-center text-[10px] h-5 min-w-[20px] px-1 rounded-full bg-amber-400 text-slate-900 font-bold">{{ $friendRequestCount }}</span>
                @endif
            </a>
            <a href="{{ route('chat.index') }}" class="flex items-center justify-between rounded-xl px-3 py-2.5 transition {{ $is('chat.*') }}">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a8 8 0 100 16 8 8 0 000-16zM7.25 8a.75.75 0 000 1.5h5.5a.75.75 0 000-1.5h-5.5zm0 3a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd"/></svg>
                    Chat
                </span>
                @if ($unreadChatCount > 0)
                    <span class="inline-flex items-center justify-center text-[10px] h-5 min-w-[20px] px-1 rounded-full bg-red-500 text-white font-bold">{{ $unreadChatCount }}</span>
                @endif
            </a>
            <a href="{{ route('profile') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 transition {{ $is('profile.*') }} {{ request()->routeIs('profile') ? 'bg-white/20 text-white shadow-lg shadow-black/15' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 8a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                Profile
            </a>
            <a href="{{ route('premium') }}" class="flex items-center justify-between rounded-xl px-3 py-2.5 transition {{ $is('premium.*') }} {{ request()->routeIs('premium') ? 'bg-white/20 text-white shadow-lg shadow-black/15' : '' }}">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2l2.12 4.296 4.743.689-3.431 3.344.81 4.724L10 12.824l-4.242 2.23.81-4.724L3.137 6.985l4.743-.689L10 2z"/></svg>
                    Premium
                </span>
                <span class="text-[10px] px-2 py-0.5 rounded-full {{ auth()->user()->is_premium ? 'bg-emerald-500 text-white' : 'bg-amber-400 text-slate-900' }}">
                    {{ auth()->user()->is_premium ? 'ACTIVE' : 'FREE' }}
                </span>
            </a>
        </nav>

        <div class="px-4 py-4 border-t border-white/10 bg-black/10">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full rounded-xl bg-red-500/85 hover:bg-red-500 px-3 py-2.5 text-sm font-semibold transition">Logout</button>
            </form>
            <div class="mt-3 rounded-xl bg-white/10 px-3 py-2">
                <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-sky-100/90 truncate">{{ auth()->user()->email }}</p>
                <p class="text-[11px] text-sky-100/90 mt-1">Plan: {{ auth()->user()->is_premium ? 'Premium' : 'Free' }}</p>
            </div>
        </div>
    </aside>

    <main class="flex-1 min-w-0">
        <header class="hidden md:flex bg-white/85 backdrop-blur border-b border-slate-200 px-4 py-3 sm:px-6 items-center justify-between gap-3">
            <div>
                <p class="font-semibold">{{ $title ?? 'SoftiFY' }}</p>
                <p class="text-xs text-slate-500">{{ auth()->user()->name }} • {{ auth()->user()->email }}</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <button id="notifToggle" type="button" class="relative inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition">
                        <span class="text-lg">🔔</span>
                        @if ($notificationCount > 0)
                            <span class="absolute -top-1 -right-1 inline-flex items-center justify-center text-[10px] h-5 min-w-[20px] px-1 rounded-full bg-red-500 text-white font-bold">{{ $notificationCount }}</span>
                        @endif
                    </button>
                    <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white border border-slate-200 rounded-xl shadow-lg p-2 z-20">
                        <p class="px-2 py-1 text-xs text-slate-500">Notifikasi terbaru</p>
                        <div class="max-h-72 overflow-y-auto space-y-1">
                            @forelse (($notifications ?? []) as $item)
                                <div class="rounded-lg px-2 py-2 text-sm {{ $item['type'] === 'danger' ? 'bg-red-50 text-red-700' : ($item['type'] === 'warning' ? 'bg-amber-50 text-amber-700' : ($item['type'] === 'success' ? 'bg-emerald-50 text-emerald-700' : 'bg-blue-50 text-blue-700')) }}">
                                    {{ $item['text'] }}
                                </div>
                            @empty
                                <p class="px-2 py-2 text-sm text-slate-500">Tidak ada notifikasi.</p>
                            @endforelse
                        </div>
                        <a href="{{ route('notifications.index') }}" class="block mt-2 text-center text-xs text-softi-700 hover:underline">Lihat semua notifikasi</a>
                    </div>
                </div>
                <div class="text-xs text-slate-500 hidden sm:block">{{ now()->format('d M Y H:i') }}</div>
            </div>
        </header>

        <section class="p-4 pt-24 pb-24 sm:p-6 md:pt-6 md:pb-6 space-y-4">
            @if (session('success'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
            @endif

            @if (!empty($notifications))
                <div class="grid gap-2 md:grid-cols-2">
                    @foreach ($notifications as $item)
                        @php
                            $map = [
                                'danger' => 'border-red-200 bg-red-50 text-red-700',
                                'warning' => 'border-amber-200 bg-amber-50 text-amber-700',
                                'success' => 'border-emerald-200 bg-emerald-50 text-emerald-700',
                                'info' => 'border-blue-200 bg-blue-50 text-blue-700',
                            ];
                            $cls = $map[$item['type']] ?? $map['info'];
                        @endphp
                        <div class="rounded-xl border px-3 py-2 text-sm {{ $cls }}">{{ $item['text'] }}</div>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </section>
    </main>
</div>

<nav class="md:hidden fixed bottom-0 inset-x-0 z-30 p-3 pb-4">
    <div class="mx-auto max-w-md rounded-2xl border border-slate-200/80 bg-white/95 backdrop-blur shadow-float px-2 py-2">
        <div class="grid grid-cols-7 gap-1 text-[11px] font-medium">
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 rounded-xl px-1 py-1.5 {{ request()->routeIs('dashboard') ? 'text-softi-700 bg-softi-50' : 'text-slate-500 active:bg-slate-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 2.5a.75.75 0 00-1.5 0v.757a7.5 7.5 0 00-5.493 5.493H3a.75.75 0 000 1.5h.757a7.5 7.5 0 005.493 5.493V17a.75.75 0 001.5 0v-.757a7.5 7.5 0 005.493-5.493H17a.75.75 0 000-1.5h-.757a7.5 7.5 0 00-5.493-5.493V2.5z"/></svg>
                Home
            </a>
            <a href="{{ route('tasks.index') }}" class="flex flex-col items-center gap-1 rounded-xl px-1 py-1.5 {{ request()->routeIs('tasks.*') ? 'text-softi-700 bg-softi-50' : 'text-slate-500 active:bg-slate-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-7 9a.75.75 0 01-1.133.06l-3.5-3.5a.75.75 0 111.06-1.06l2.894 2.893 6.47-8.318a.75.75 0 011.052-.127z" clip-rule="evenodd"/></svg>
                Task
            </a>
            <a href="{{ route('diary.index') }}" class="flex flex-col items-center gap-1 rounded-xl px-1 py-1.5 {{ request()->routeIs('diary.*') ? 'text-softi-700 bg-softi-50' : 'text-slate-500 active:bg-slate-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M4.75 2A2.75 2.75 0 002 4.75v10.5A2.75 2.75 0 004.75 18h10.5A2.75 2.75 0 0018 15.25V4.75A2.75 2.75 0 0015.25 2H4.75zM5.5 6.25a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zm0 3.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zm0 3.5a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75z"/></svg>
                Diary
            </a>
            <a href="{{ route('targets.index') }}" class="flex flex-col items-center gap-1 rounded-xl px-1 py-1.5 {{ request()->routeIs('targets.*') ? 'text-softi-700 bg-softi-50' : 'text-slate-500 active:bg-slate-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M3 3.75A.75.75 0 013.75 3h12.5a.75.75 0 01.75.75v1.5a.75.75 0 01-.75.75H3.75A.75.75 0 013 5.25v-1.5zM3 8.75A.75.75 0 013.75 8h7.5a.75.75 0 01.75.75v7.5a.75.75 0 01-.75.75h-7.5A.75.75 0 013 16.25v-7.5zM13.5 9a.5.5 0 01.5-.5h2a.5.5 0 010 1h-2a.5.5 0 01-.5-.5zm0 3a.5.5 0 01.5-.5h2a.5.5 0 010 1h-2a.5.5 0 01-.5-.5zm.5 2.5a.5.5 0 000 1h2a.5.5 0 000-1h-2z"/></svg>
                Target
            </a>
            <a href="{{ route('ai.index') }}" class="flex flex-col items-center gap-1 rounded-xl px-1 py-1.5 {{ request()->routeIs('ai.*') ? 'text-softi-700 bg-softi-50' : 'text-slate-500 active:bg-slate-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a1 1 0 011 1v1.126a5 5 0 013.5 4.767V10h.5a2 2 0 110 4h-1.126A5 5 0 0111 17.874V19a1 1 0 11-2 0v-1.126A5 5 0 015.626 14H4.5a2 2 0 110-4H5v-1.107A5 5 0 019 4.126V3a1 1 0 011-1z"/></svg>
                AI
            </a>
            <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1 rounded-xl px-1 py-1.5 {{ request()->routeIs('profile.*') || request()->routeIs('profile') ? 'text-softi-700 bg-softi-50' : 'text-slate-500 active:bg-slate-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 8a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                Profil
            </a>
            <a href="{{ route('premium') }}" class="flex flex-col items-center gap-1 rounded-xl px-1 py-1.5 {{ request()->routeIs('premium.*') || request()->routeIs('premium') ? 'text-softi-700 bg-softi-50' : 'text-slate-500 active:bg-slate-100' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2l2.12 4.296 4.743.689-3.431 3.344.81 4.724L10 12.824l-4.242 2.23.81-4.724L3.137 6.985l4.743-.689L10 2z"/></svg>
                Premium
            </a>
        </div>
    </div>
</nav>

<script>
const notifToggle = document.getElementById('notifToggle');
const notifDropdown = document.getElementById('notifDropdown');
const mobileMenuOpen = document.getElementById('mobileMenuOpen');
const mobileMenuClose = document.getElementById('mobileMenuClose');
const mobileSidebar = document.getElementById('mobileSidebar');
const mobileOverlay = document.getElementById('mobileOverlay');

const openMenu = () => {
    if (!mobileSidebar || !mobileOverlay) {
        return;
    }

    mobileSidebar.classList.remove('translate-x-full');
    mobileOverlay.classList.remove('hidden');
    mobileOverlay.classList.remove('pointer-events-none');
    document.body.classList.add('overflow-hidden');
};

const closeMenu = () => {
    if (!mobileSidebar || !mobileOverlay) {
        return;
    }

    mobileSidebar.classList.add('translate-x-full');
    mobileOverlay.classList.add('hidden');
    mobileOverlay.classList.add('pointer-events-none');
    document.body.classList.remove('overflow-hidden');
};

if (mobileMenuOpen) {
    mobileMenuOpen.addEventListener('click', openMenu);
}

if (mobileMenuClose) {
    mobileMenuClose.addEventListener('click', closeMenu);
}

if (mobileOverlay) {
    mobileOverlay.addEventListener('click', closeMenu);
}

if (notifToggle && notifDropdown) {
    notifToggle.addEventListener('click', () => {
        notifDropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', (event) => {
        if (!notifToggle.contains(event.target) && !notifDropdown.contains(event.target)) {
            notifDropdown.classList.add('hidden');
        }
    });
}

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        closeMenu();
    }
});

window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
        closeMenu();
    }
});
</script>
</body>
</html>
