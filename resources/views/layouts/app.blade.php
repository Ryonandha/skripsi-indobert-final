<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Skrining Kecemasan') — STIKOM Yos Sudarso</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_stikom.png') }}">
    <script src="/assets/tailwind.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0fdfa', 100: '#ccfbf1', 200: '#99f6e4', 300: '#5eead4', 400: '#2dd4bf',
                            500: '#14b8a6', 600: '#0d9488', 700: '#0f766e', 800: '#115e59', 900: '#134e4a',
                            950: '#042f2e',
                        },
                        calm: {
                            50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1', 400: '#94a3b8',
                            500: '#64748b', 600: '#475569', 700: '#334155', 800: '#1e293b', 900: '#0f172a',
                        },
                        warm: {
                            50: '#fefce8', 100: '#fef9c3', 200: '#fef08a', 300: '#fde047', 400: '#facc15',
                            500: '#eab308', 600: '#ca8a04', 700: '#a16207', 800: '#854d0e', 900: '#713f12',
                        },
                        danger: {
                            50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171',
                            500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d',
                        }
                    },
                    boxShadow: {
                        'sm': '0 1px 2px 0 rgba(0, 0, 0, 0.04)',
                        'card': '0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.03)',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        @media (min-width: 1024px) {
            aside[x-cloak] { display: block !important; }
        }
    </style>
    @stack('styles')
</head>
<?php header('Cache-Control: no-cache, no-store, must-revalidate; max-age=0');
header('Pragma: no-cache');
header('Expires: 0'); ?>
<body class="bg-calm-50 min-h-screen font-sans antialiased" x-data="{ sidebarOpen: false }">
    <!-- Mobile sidebar overlay -->
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-150"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/30 z-40 lg:hidden" @click="sidebarOpen = false" aria-hidden="true"></div>

    <!-- Sidebar Navigation -->
    @auth
    <aside x-cloak x-show="sidebarOpen" x-transition:enter="transition-transform ease-out duration-300"
           x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
           x-transition:leave="transition-transform ease-in duration-200"
           x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
           class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-calm-200 transform lg:!translate-x-0 lg:!block"
           aria-label="Navigasi utama">
        <div class="flex flex-col h-full">
            <!-- Logo & Brand -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-calm-200">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo_stikom.png') }}" alt="Logo STIKOM Yos Sudarso" class="w-9 h-9 object-contain flex-shrink-0">
                    <span class="font-display font-bold text-calm-900 text-lg">SiPeka</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden p-2 rounded-lg hover:bg-calm-100 text-calm-500" aria-label="Tutup menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto" aria-label="Menu navigasi">
                @if(auth()->user()->isMahasiswa())
                    @include('partials.nav-mahasiswa')
                @elseif(auth()->user()->isAdmin())
                    @include('partials.nav-admin')
                @elseif(auth()->user()->isPsikolog())
                    @include('partials.nav-psikolog')
                @endif
            </nav>

            <!-- User Profile Bottom -->
            <div class="p-4 border-t border-calm-200">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-calm-50">
                    <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center">
                        <span class="text-primary-700 font-display font-semibold text-sm">
                            {{ strtoupper(auth()->user()->name[0]) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-calm-900 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-calm-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="p-2 rounded-lg text-calm-500 hover:bg-calm-100 hover:text-primary-600 transition-colors" aria-label="Pengaturan profil">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </aside>
    @endauth

    <!-- Main Content Wrapper -->
    <div class="{{ auth()->check() ? 'lg:ml-64' : '' }} min-h-screen flex flex-col">
        <!-- Top Bar -->
        <header class="sticky top-0 z-30 bg-white border-b border-calm-200">
            <div class="flex items-center justify-between h-16 px-4 lg:px-8">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-calm-600 hover:bg-calm-100" aria-label="Buka menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <!-- Page Title / Brand for mobile -->
                <div class="flex items-center gap-3 lg:hidden flex-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo_stikom.png') }}" alt="Logo STIKOM Yos Sudarso" class="w-8 h-8 object-contain flex-shrink-0">
                        <span class="font-display font-bold text-calm-900">SiPeka</span>
                    </a>
                </div>

                <!-- Right side actions -->
                <div class="flex items-center gap-3 ml-auto">
                    @if(session('success'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)"
                             x-show="show" x-transition.opacity
                             class="bg-primary-50 text-primary-800 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)"
                             x-show="show" x-transition.opacity
                             class="bg-danger-50 text-danger-800 px-4 py-2 rounded-lg text-sm flex items-center gap-2 border border-danger-200">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    @auth
                        <div class="hidden lg:flex items-center gap-2">
                            <a href="{{ route('home') }}" class="flex items-center gap-1.5 p-2 rounded-lg text-calm-500 hover:bg-calm-100 hover:text-primary-600 transition-colors" aria-label="Ke Halaman Utama" title="Ke Halaman Utama">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3m10-11v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span class="text-sm font-medium">Halaman Utama</span>
                            </a>
                            <span class="w-px h-5 bg-calm-200"></span>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 p-2 rounded-xl hover:bg-calm-100 transition-colors">
                                <span class="text-sm font-medium text-calm-700">{{ auth()->user()->name }}</span>
                                <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center">
                                    <span class="text-primary-700 font-display font-semibold text-sm">{{ strtoupper(auth()->user()->name[0]) }}</span>
                                </div>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="p-2 rounded-lg text-calm-500 hover:bg-calm-100 hover:text-primary-600 transition-colors" aria-label="Keluar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="hidden lg:flex items-center gap-3">
                            <a href="{{ route('home') }}" class="flex items-center gap-1.5 p-2 rounded-lg text-calm-500 hover:bg-calm-100 hover:text-primary-600 transition-colors" aria-label="Ke Halaman Utama" title="Ke Halaman Utama">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3m10-11v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span class="text-sm font-medium">Beranda</span>
                            </a>
                            <span class="w-px h-5 bg-calm-200"></span>
                            <a href="{{ route('login') }}" class="text-sm font-medium text-calm-600 hover:text-primary-600 transition-colors">Masuk</a>
                        </div>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-4 lg:p-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-calm-900 text-calm-400 py-6 px-4 lg:px-8">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 text-sm">
                <p>&copy; {{ date('Y') }} SiPeka — Sistem Skrining Kecemasan Mahasiswa</p>
                <p>Dikembangkan dengan IndoBERT + HARS untuk STIKOM Yos Sudarso Purwokerto</p>
            </div>
        </footer>
    </div>

    <!-- Alpine.js for interactions (lokal, agar tampilan stabil tanpa internet) -->
    <script defer src="/assets/alpine.js"></script>
    @stack('scripts')
</body>
</html>