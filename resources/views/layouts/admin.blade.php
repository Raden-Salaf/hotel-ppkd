<!DOCTYPE html>
<html lang="id" x-data="{ dark: localStorage.getItem('theme') === 'dark', sidebarOpen: true }" x-init="dark ? $el.classList.add('dark') : $el.classList.remove('dark')" :class="{ 'dark': dark }" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Grand Paijo's Nusantara Hotel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="h-full bg-gray-50 dark:bg-[#0D0B1F] transition-colors duration-300">

    <div class="flex h-screen overflow-hidden">

        {{-- ══ SIDEBAR ══ --}}
        <aside class="w-64 flex-shrink-0 flex flex-col relative"
            style="background: linear-gradient(160deg, #2D0B6B 0%, #4C1D95 40%, #5B21B6 70%, #6D28D9 100%)">

            {{-- Glow effect --}}
            <div class="absolute inset-0 opacity-30 pointer-events-none"
                style="background: radial-gradient(ellipse at top left, rgba(167,139,250,0.4) 0%, transparent 60%)">
            </div>

            {{-- Logo --}}
            <div class="relative px-5 py-5 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <div
                        class="w-11 h-11 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center overflow-hidden flex-shrink-0">
                        <img src="{{ asset('images/logo.png') }}"
                            onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"
                            class="w-full h-full object-cover" alt="Logo">
                        <div class="hidden w-full h-full items-center justify-center">
                            <span class="text-white text-xl">✦</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-white text-sm font-semibold leading-tight">Grand Paijo's Nusantara</div>
                        <div class="text-purple-300 text-xs mt-0.5">Hotel Management</div>
                    </div>
                </div>
            </div>

            
            {{-- Navigation --}}
            <nav class="relative flex-1 px-3 py-4 overflow-y-auto space-y-0.5">

                {{-- Utama --}}
                <p class="px-3 mb-2 text-[10px] font-semibold text-purple-300/60 uppercase tracking-widest">
                    Utama
                </p>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
              {{ request()->routeIs('admin.dashboard')
                  ? 'bg-white/15 text-white font-medium shadow-sm'
                  : 'text-purple-200/70 hover:bg-white/8 hover:text-white' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z" />
                    </svg>
                    Dashboard
                </a>

                {{-- Hotel — tampil untuk superadmin & resepsionis --}}
                @if (in_array(auth()->user()->role->slug, ['superadmin', 'resepsionis']))
                    <p class="px-3 pt-4 mb-2 text-[10px] font-semibold text-purple-300/60 uppercase tracking-widest">
                        Hotel
                    </p>
                    <a href="{{ route('admin.rooms.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
              {{ request()->routeIs('admin.rooms*')
                  ? 'bg-white/15 text-white font-medium'
                  : 'text-purple-200/70 hover:bg-white/8 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Kamar
                    </a>
                    <a href="{{ route('admin.bookings.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
              {{ request()->routeIs('admin.bookings*')
                  ? 'bg-white/15 text-white font-medium'
                  : 'text-purple-200/70 hover:bg-white/8 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Booking
                    </a>
                    <a href="{{ route('admin.reviews.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
              {{ request()->routeIs('admin.reviews*')
                  ? 'bg-white/15 text-white font-medium'
                  : 'text-purple-200/70 hover:bg-white/8 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Ulasan
                    </a>
                @endif

                {{-- F&B — tampil untuk superadmin & admin_fnb --}}
                @if (in_array(auth()->user()->role->slug, ['superadmin', 'admin_fnb']))
                    <p class="px-3 pt-4 mb-2 text-[10px] font-semibold text-purple-300/60 uppercase tracking-widest">
                        F&amp;B
                    </p>
                    <a href="{{ route('admin.fnb-menus.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
              {{ request()->routeIs('admin.fnb-menus*')
                  ? 'bg-white/15 text-white font-medium'
                  : 'text-purple-200/70 hover:bg-white/8 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Menu F&amp;B
                    </a>
                    <a href="{{ route('admin.fnb-orders.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
              {{ request()->routeIs('admin.fnb-orders*')
                  ? 'bg-white/15 text-white font-medium'
                  : 'text-purple-200/70 hover:bg-white/8 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 14l2 2 4-4" />
                        </svg>
                        Order F&amp;B
                    </a>
                @endif

                {{-- Manajemen — superadmin only --}}
                @if (auth()->user()->isSuperAdmin())
                    <p class="px-3 pt-4 mb-2 text-[10px] font-semibold text-purple-300/60 uppercase tracking-widest">
                        Manajemen
                    </p>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
              {{ request()->routeIs('admin.users*')
                  ? 'bg-white/15 text-white font-medium'
                  : 'text-purple-200/70 hover:bg-white/8 hover:text-white' }}">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Users
                    </a>
                @endif

            </nav>

            {{-- User Footer --}}
            <div class="relative px-3 py-4 border-t border-white/10">
                <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-white/5 mb-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 font-semibold text-xs text-white"
                        style="background: linear-gradient(135deg, #7C3AED, #4F46E5)">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-purple-300/60 truncate">{{ auth()->user()->role->name }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl
                               text-xs text-purple-300/70 hover:text-white hover:bg-white/10
                               transition-all duration-200 border border-white/10">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- ══ MAIN ══ --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            {{-- Topbar --}}
            <header
                class="flex-shrink-0 h-14 flex items-center justify-between px-6
                       bg-white dark:bg-white/3 border-b border-gray-100 dark:border-white/8
                       backdrop-blur-sm">
                <div>
                    <h1 class="text-sm font-semibold text-gray-800 dark:text-white">
                        @yield('title', 'Dashboard')
                    </h1>
                    <p class="text-xs text-gray-400 dark:text-white/30 mt-0.5">
                        @yield('subtitle', 'Grand Nusantara Hotel Management System')
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    {{-- Dark mode toggle --}}
                    <button
                        @click="dark = !dark; dark ? $el.closest('html').classList.add('dark') : $el.closest('html').classList.remove('dark'); localStorage.setItem('theme', dark ? 'dark' : 'light')"
                        class="w-9 h-9 rounded-xl flex items-center justify-center
                               text-gray-400 dark:text-purple-300
                               hover:bg-gray-100 dark:hover:bg-white/10
                               border border-gray-100 dark:border-white/10
                               transition-all duration-200">
                        <svg x-show="!dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="dark" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                    @yield('topbar-actions')
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50 dark:bg-[#0D0B1F]">
                @if (session('success'))
                    <div
                        class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl
                        bg-green-50 dark:bg-green-500/10
                        border border-green-200 dark:border-green-500/20">
                        <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-sm text-green-700 dark:text-green-400">{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('error'))
                    <div
                        class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl
                        bg-red-50 dark:bg-red-500/10
                        border border-red-200 dark:border-red-500/20">
                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <p class="text-sm text-red-700 dark:text-red-400">{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
