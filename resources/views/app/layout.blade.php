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
    @php
        $notificationCount = collect($notifications ?? [])->where('type', '!=', 'success')->count();
    @endphp

    <aside class="w-full md:w-72 md:h-screen md:sticky md:top-0 bg-gradient-to-b from-softi-900 via-indigo-900 to-blue-900 text-white flex flex-col">
        <div class="px-5 py-6 border-b border-white/10">
            <h1 class="text-2xl font-black tracking-wide">SOFTIFY</h1>
            <p class="text-xs text-blue-100 mt-1">Platform belajar untuk pelajar</p>
        </div>

        <nav class="px-3 py-4 space-y-1 text-sm flex-1">
            @php
                $is = function (string $name): string {
                    return request()->routeIs($name)
                        ? 'bg-white/20 text-white shadow-lg shadow-black/10'
                        : 'text-blue-100 hover:bg-white/10 hover:text-white';
                };
            @endphp
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ $is('dashboard') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 2.5a.75.75 0 00-1.5 0v.757a7.5 7.5 0 00-5.493 5.493H3a.75.75 0 000 1.5h.757a7.5 7.5 0 005.493 5.493V17a.75.75 0 001.5 0v-.757a7.5 7.5 0 005.493-5.493H17a.75.75 0 000-1.5h-.757a7.5 7.5 0 00-5.493-5.493V2.5z"/></svg>
                Dashboard
            </a>
            <a href="{{ route('tasks.index') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ $is('tasks.*') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-7 9a.75.75 0 01-1.133.06l-3.5-3.5a.75.75 0 111.06-1.06l2.894 2.893 6.47-8.318a.75.75 0 011.052-.127z" clip-rule="evenodd"/></svg>
                Task
            </a>
            <a href="{{ route('targets.index') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ $is('targets.*') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M3 3.75A.75.75 0 013.75 3h12.5a.75.75 0 01.75.75v1.5a.75.75 0 01-.75.75H3.75A.75.75 0 013 5.25v-1.5zM3 8.75A.75.75 0 013.75 8h7.5a.75.75 0 01.75.75v7.5a.75.75 0 01-.75.75h-7.5A.75.75 0 013 16.25v-7.5zM13.5 9a.5.5 0 01.5-.5h2a.5.5 0 010 1h-2a.5.5 0 01-.5-.5zm0 3a.5.5 0 01.5-.5h2a.5.5 0 010 1h-2a.5.5 0 01-.5-.5zm.5 2.5a.5.5 0 000 1h2a.5.5 0 000-1h-2z"/></svg>
                Target
            </a>
            <a href="{{ route('ai.index') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ $is('ai.*') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a1 1 0 011 1v1.126a5 5 0 013.5 4.767V10h.5a2 2 0 110 4h-1.126A5 5 0 0111 17.874V19a1 1 0 11-2 0v-1.126A5 5 0 015.626 14H4.5a2 2 0 110-4H5v-1.107A5 5 0 019 4.126V3a1 1 0 011-1z"/></svg>
                AI Assistant
            </a>
            <a href="{{ route('challenge.index') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ $is('challenge.*') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11a.75.75 0 00-1.5 0v3.25c0 .199.079.39.22.53l2 2a.75.75 0 101.06-1.06l-1.78-1.72V7z" clip-rule="evenodd"/></svg>
                Challenge
            </a>
            <a href="{{ route('leaderboard.index') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ $is('leaderboard.*') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15 2.75a.75.75 0 00-.75-.75h-8.5a.75.75 0 00-.75.75v3.628A4.5 4.5 0 008 10.5v1.757a1 1 0 00-.553.894V16h5.106v-2.849a1 1 0 00-.553-.894V10.5a4.5 4.5 0 002.75-4.122V2.75zM6.5 3.5v2.878a3 3 0 006 0V3.5h-6z" clip-rule="evenodd"/></svg>
                Leaderboard
            </a>
            <a href="{{ route('notifications.index') }}" class="flex items-center justify-between rounded-xl px-3 py-2 transition {{ $is('notifications.*') }}">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a4 4 0 00-4 4v1.586l-.707.707A1 1 0 005 10h10a1 1 0 00.707-1.707L15 7.586V6a4 4 0 00-4-4z"/><path d="M10 18a3 3 0 01-2.995-2.824L7 15h6a3 3 0 01-3 3z"/></svg>
                    Notifications
                </span>
                @if ($notificationCount > 0)
                    <span class="inline-flex items-center justify-center text-[10px] h-5 min-w-[20px] px-1 rounded-full bg-red-500 text-white font-bold">{{ $notificationCount }}</span>
                @endif
            </a>
            <a href="{{ route('profile.index') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 transition {{ $is('profile.*') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 8a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                Profile
            </a>
            <a href="{{ route('premium.index') }}" class="flex items-center justify-between rounded-xl px-3 py-2 transition {{ $is('premium.*') }}">
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
                <button class="w-full rounded-xl bg-red-500/80 hover:bg-red-500 px-3 py-2 text-sm font-semibold">Logout</button>
            </form>
            <div class="mt-3 rounded-xl bg-white/10 px-3 py-2">
                <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-blue-100/90 truncate">{{ auth()->user()->email }}</p>
                <p class="text-[11px] text-blue-100/90 mt-1">Plan: {{ auth()->user()->is_premium ? 'Premium' : 'Free' }}</p>
            </div>
        </div>
    </aside>

    <main class="flex-1">
        <header class="bg-white border-b border-slate-200 px-4 py-3 sm:px-6 flex items-center justify-between gap-3">
            <div>
                <p class="font-semibold">{{ $title ?? 'SoftiFY' }}</p>
                <p class="text-xs text-slate-500">{{ auth()->user()->name }} • {{ auth()->user()->email }}</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <button id="notifToggle" type="button" class="relative inline-flex items-center justify-center w-10 h-10 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50">
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

        <section class="p-4 sm:p-6 space-y-4">
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
<script>
const notifToggle = document.getElementById('notifToggle');
const notifDropdown = document.getElementById('notifDropdown');

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
</script>
</body>
</html>
