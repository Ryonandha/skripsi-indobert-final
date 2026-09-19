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
                            50: '#fffbeb', 100: '#fef3c7', 200: '#fde68a', 300: '#fcd34d', 400: '#fbbf24',
                            500: '#f59e0b', 600: '#d97706', 700: '#b45309', 800: '#92400e', 900: '#78350f',
                        },
                        slate: {
                            50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1', 400: '#94a3b8',
                            500: '#64748b', 600: '#475569', 700: '#334155', 800: '#1e293b', 900: '#0f172a', 950: '#020617',
                        },
                        calm: {
                            50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1', 400: '#94a3b8',
                            500: '#64748b', 600: '#475569', 700: '#334155', 800: '#1e293b', 900: '#0f172a',
                        },
                        danger: {
                            50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171',
                            500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d',
                        },
                        glass: {
                            DEFAULT: 'rgba(255,255,255,0.08)',
                            border: 'rgba(255,255,255,0.15)',
                            hover: 'rgba(255,255,255,0.12)',
                            card: 'rgba(255,255,255,0.06)',
                        }
                    },
                    backdropBlur: {
                        xs: '2px',
                    },
                    boxShadow: {
                        'glass': '0 8px 32px 0 rgba(0, 0, 0, 0.3)',
                        'glass-sm': '0 4px 16px 0 rgba(0, 0, 0, 0.2)',
                        'amber': '0 4px 20px rgba(245, 158, 11, 0.3)',
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

        /* ===== Global background ===== */
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed;
            top: -20%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(245,158,11,0.08) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -20%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(59,130,246,0.07) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* ===== Glass components ===== */
        .glass-sidebar {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255,255,255,0.08);
        }
        .glass-topbar {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.10);
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        }
        .glass-card-hover:hover {
            background: rgba(255, 255, 255, 0.09);
            border-color: rgba(255,255,255,0.18);
            transform: translateY(-1px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.3);
        }
        .glass-input {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            color: #f1f5f9;
        }
        .glass-input:focus {
            background: rgba(255,255,255,0.10);
            border-color: rgba(245,158,11,0.5);
            outline: none;
            box-shadow: 0 0 0 3px rgba(245,158,11,0.15);
        }
        .glass-input::placeholder { color: #64748b; }
        .nav-item {
            color: #94a3b8;
            border-radius: 0.75rem;
            padding: 0.625rem 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.08);
            color: #f1f5f9;
        }
        .nav-item.active {
            background: rgba(245,158,11,0.15);
            color: #fbbf24;
            font-weight: 500;
            border: 1px solid rgba(245,158,11,0.2);
        }
        .nav-item.active svg { color: #f59e0b; }
        .btn-amber {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #0f172a;
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.625rem 1.25rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 20px rgba(245,158,11,0.25);
        }
        .btn-amber:hover {
            box-shadow: 0 6px 28px rgba(245,158,11,0.4);
            transform: translateY(-1px);
        }
        .text-muted { color: #64748b; }
        .text-body { color: #cbd5e1; }
        .text-heading { color: #f1f5f9; }
        .badge-amber {
            background: rgba(245,158,11,0.15);
            color: #fbbf24;
            border: 1px solid rgba(245,158,11,0.25);
            border-radius: 9999px;
            padding: 0.125rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-danger {
            background: rgba(239,68,68,0.15);
            color: #f87171;
            border: 1px solid rgba(239,68,68,0.2);
            border-radius: 9999px;
            padding: 0.125rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-success {
            background: rgba(34,197,94,0.15);
            color: #4ade80;
            border: 1px solid rgba(34,197,94,0.2);
            border-radius: 9999px;
            padding: 0.125rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .divider { border-color: rgba(255,255,255,0.08); }
        select.glass-input option { background: #1e293b; color: #f1f5f9; }
        .glass-table th {
            background: rgba(255,255,255,0.04);
            color: #64748b;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .glass-table td {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            color: #cbd5e1;
            font-size: 0.875rem;
        }
        .glass-table tr:hover td { background: rgba(255,255,255,0.03); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 99px; }
    </style>
    @stack('styles')
</head>
<?php header('Cache-Control: no-cache, no-store, must-revalidate; max-age=0');
header('Pragma: no-cache');
header('Expires: 0'); ?>
<body class="font-sans antialiased relative" x-data="{ sidebarOpen: false }">

    <!-- Mobile sidebar overlay -->
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-150"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden" @click="sidebarOpen = false" aria-hidden="true"></div>

    <!-- Sidebar Navigation -->
    @auth
    <aside x-cloak x-show="sidebarOpen" x-transition:enter="transition-transform ease-out duration-300"
           x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
           x-transition:leave="transition-transform ease-in duration-200"
           x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
           class="glass-sidebar fixed inset-y-0 left-0 z-50 w-64 transform lg:!translate-x-0 lg:!block"
           aria-label="Navigasi utama">
        <div class="flex flex-col h-full">
            <!-- Logo & Brand -->
            <div class="flex items-center justify-between h-16 px-5" style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <span class="font-display font-bold text-white text-lg tracking-tight">SiPeka</span>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-colors" aria-label="Tutup menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto" aria-label="Menu navigasi">
                @if(auth()->user()->isMahasiswa())
                    @include('partials.nav-mahasiswa')
                @elseif(auth()->user()->isAdmin())
                    @include('partials.nav-admin')
                @elseif(auth()->user()->isPsikolog())
                    @include('partials.nav-psikolog')
                @endif
            </nav>

            <!-- User Profile Bottom -->
            <div class="p-4" style="border-top: 1px solid rgba(255,255,255,0.08);">
                <div class="flex items-center gap-3 p-3 rounded-xl" style="background: rgba(255,255,255,0.05);">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-display font-bold text-sm text-slate-900" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        {{ strtoupper(auth()->user()->name[0]) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-white text-sm truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs capitalize" style="color: #64748b;">{{ auth()->user()->role }}</p>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="p-1.5 rounded-lg text-slate-400 hover:text-amber-400 hover:bg-white/10 transition-colors" aria-label="Pengaturan profil">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </aside>
    @endauth

    <!-- Main Content Wrapper -->
    <div class="{{ auth()->check() ? 'lg:ml-64' : '' }} min-h-screen flex flex-col relative z-10">
        <!-- Top Bar -->
        <header class="glass-topbar sticky top-0 z-30">
            <div class="flex items-center justify-between h-16 px-4 lg:px-8">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-colors" aria-label="Buka menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <!-- Page Title / Brand for mobile -->
                <div class="flex items-center gap-3 lg:hidden flex-1 ml-3">
                    <div class="w-7 h-7 rounded-md flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <svg class="w-4 h-4 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <span class="font-display font-bold text-white">SiPeka</span>
                </div>

                <!-- Right side actions -->
                <div class="flex items-center gap-2 ml-auto">
                    @if(session('success'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)"
                             x-show="show" x-transition.opacity
                             class="flex items-center gap-2 px-3 py-1.5 rounded-xl text-sm" style="background: rgba(34,197,94,0.15); color: #4ade80; border: 1px solid rgba(34,197,94,0.2);">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)"
                             x-show="show" x-transition.opacity
                             class="flex items-center gap-2 px-3 py-1.5 rounded-xl text-sm" style="background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.2);">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    @auth
                        <div class="hidden lg:flex items-center gap-2">
                            <a href="{{ route('home') }}" class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-slate-400 hover:text-white hover:bg-white/10 transition-colors text-sm" title="Ke Halaman Utama">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3m10-11v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span>Beranda</span>
                            </a>
                            <div class="w-px h-5" style="background: rgba(255,255,255,0.1);"></div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-white/10 transition-colors">
                                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-slate-900" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                                    {{ strtoupper(auth()->user()->name[0]) }}
                                </div>
                                <span class="text-sm font-medium text-slate-300">{{ auth()->user()->name }}</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="p-2 rounded-xl text-slate-400 hover:text-red-400 hover:bg-white/10 transition-colors" aria-label="Keluar" title="Keluar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="hidden lg:flex items-center gap-3">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-300 hover:text-amber-400 transition-colors">Masuk</a>
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
        <footer class="py-5 px-4 lg:px-8" style="border-top: 1px solid rgba(255,255,255,0.06);">
            <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-2 text-xs" style="color: #475569;">
                <p>&copy; {{ date('Y') }} SiPeka — Sistem Skrining Kecemasan Mahasiswa</p>
                <p>Dikembangkan dengan IndoBERT + HARS · STIKOM Yos Sudarso Purwokerto</p>
            </div>
        </footer>
    </div>

    <script defer src="/assets/alpine.js"></script>
    @stack('scripts')
</body>
</html>