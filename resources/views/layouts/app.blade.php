<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Skrining Kecemasan') — STIKOM Yos Sudarso</title>
    <link rel="icon" type="image/png" href="{{ asset('images/icon_kecil.png') }}">
    <script src="/assets/tailwind.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
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
                            50: '#f0f9ff', 100: '#e0f2fe', 200: '#bae6fd', 300: '#7dd3fc',
                            400: '#38bdf8', 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1',
                            800: '#075985', 900: '#0c4a6e',
                        },
                        calm: {
                            50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1',
                            400: '#94a3b8', 500: '#64748b', 600: '#475569', 700: '#334155',
                            800: '#1e293b', 900: '#0f172a',
                        },
                        danger: {
                            50: '#fff1f2', 100: '#ffe4e6', 400: '#fb7185',
                            500: '#ef4444', 600: '#dc2626', 700: '#b91c1c',
                        },
                        warn: {
                            50: '#fffbeb', 100: '#fef3c7', 400: '#fbbf24',
                            500: '#f59e0b', 600: '#d97706', 700: '#b45309',
                        },
                        success: {
                            50: '#f0fdf4', 100: '#dcfce7', 400: '#4ade80',
                            500: '#22c55e', 600: '#16a34a', 700: '#15803d',
                        }
                    },
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        @media (min-width: 1024px) { aside[x-cloak] { display: block !important; } }

        body { background-color: #f8fafc; }

        .sidebar {
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
        }
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: #475569;
            transition: all 0.15s ease;
            font-weight: 500;
        }
        .nav-item:hover { background: #f1f5f9; color: #0f172a; }
        .nav-item.active {
            background: #eff6ff;
            color: #1d4ed8;
        }
        .nav-item.active svg { color: #2563eb; }

        .card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .btn-primary {
            background: #0284c7;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: background 0.15s ease;
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover { background: #0369a1; }

        .btn-secondary {
            background: #ffffff;
            color: #334155;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            transition: all 0.15s ease;
            cursor: pointer;
        }
        .btn-secondary:hover { background: #f8fafc; border-color: #cbd5e1; }

        .badge-high { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; border-radius: 9999px; padding: 0.125rem 0.625rem; font-size: 0.75rem; font-weight: 600; }
        .badge-med { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; border-radius: 9999px; padding: 0.125rem 0.625rem; font-size: 0.75rem; font-weight: 600; }
        .badge-low { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; border-radius: 9999px; padding: 0.125rem 0.625rem; font-size: 0.75rem; font-weight: 600; }
        .badge-blue { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; border-radius: 9999px; padding: 0.125rem 0.625rem; font-size: 0.75rem; font-weight: 600; }

        .input-field {
            width: 100%;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.5rem 0.875rem;
            font-size: 0.875rem;
            color: #0f172a;
            background: #ffffff;
            transition: all 0.15s ease;
            outline: none;
        }
        .input-field:focus { border-color: #0284c7; box-shadow: 0 0 0 3px rgba(2,132,199,0.1); }
        .input-field::placeholder { color: #94a3b8; }

        .divider { border: none; border-top: 1px solid #e2e8f0; margin: 0.75rem 0; }

        .toast-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .toast-error { background: #fff1f2; border: 1px solid #fecdd3; color: #be123c; }

        table th {
            background: #f8fafc;
            color: #64748b;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }
        table td {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 0.875rem;
        }
        table tbody tr:hover td { background: #f8fafc; }
        table tbody tr:last-child td { border-bottom: none; }

        select { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 1rem; padding-right: 2.5rem; -webkit-appearance: none; appearance: none; }
    </style>
    @stack('styles')
</head>
<?php header('Cache-Control: no-cache, no-store, must-revalidate; max-age=0'); header('Pragma: no-cache'); header('Expires: 0'); ?>
<body class="font-sans antialiased" x-data="{ sidebarOpen: false }">

    <!-- Login Success Splash -->
    @if(session('login_success'))
    <div id="loginSplash" style="position:fixed;inset:0;z-index:9999;background:#fff;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;transition:opacity 0.5s ease;">
        <img src="{{ asset('images/login_berhasil.png') }}" alt="Login Berhasil"
             style="width:180px;height:180px;object-fit:contain;mix-blend-mode:multiply;animation:bounceIn 0.6s ease;">
        <div style="text-align:center;">
            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:1.25rem;color:#0f172a;margin-bottom:4px;">Selamat Datang!</p>
            <p style="font-size:0.875rem;color:#64748b;">{{ auth()->user()->name }}</p>
        </div>
        <div style="display:flex;gap:6px;margin-top:4px;">
            <span style="width:8px;height:8px;border-radius:50%;background:#0284c7;animation:dot 1.2s 0s infinite;"></span>
            <span style="width:8px;height:8px;border-radius:50%;background:#0284c7;animation:dot 1.2s 0.2s infinite;"></span>
            <span style="width:8px;height:8px;border-radius:50%;background:#0284c7;animation:dot 1.2s 0.4s infinite;"></span>
        </div>
    </div>
    <style>
        @keyframes bounceIn {
            0% { transform: scale(0.5); opacity: 0; }
            70% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); }
        }
        @keyframes dot {
            0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
            40% { transform: scale(1); opacity: 1; }
        }
    </style>
    <script>
        setTimeout(function() {
            var splash = document.getElementById('loginSplash');
            if (splash) { splash.style.opacity = '0'; setTimeout(function(){ splash.remove(); }, 500); }
        }, 1800);
    </script>
    @endif

    <!-- Mobile overlay -->
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-150"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-150"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/40 z-40 lg:hidden" @click="sidebarOpen = false"></div>

    <!-- Sidebar -->
    @auth
    <aside x-cloak x-show="sidebarOpen"
           x-transition:enter="transition-transform ease-out duration-200"
           x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
           x-transition:leave="transition-transform ease-in duration-150"
           x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
           class="sidebar fixed inset-y-0 left-0 z-50 w-60 flex flex-col lg:!translate-x-0 lg:!block">

        <!-- Brand -->
        <div class="flex items-center justify-between h-14 px-4" style="border-bottom: 1px solid #e2e8f0;">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo_web.png') }}" alt="SiPeka" class="w-8 h-8 object-contain">
                <span class="font-display font-bold text-slate-900 text-base">SiPeka</span>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-md text-slate-400 hover:bg-slate-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-3 space-y-0.5 overflow-y-auto">
            @if(auth()->user()->isMahasiswa())
                @include('partials.nav-mahasiswa')
            @elseif(auth()->user()->isAdmin())
                @include('partials.nav-admin')
            @elseif(auth()->user()->isPsikolog())
                @include('partials.nav-psikolog')
            @endif
        </nav>

        <!-- User -->
        <div class="p-3" style="border-top: 1px solid #e2e8f0;">
            <div class="flex items-center gap-2.5 px-2 py-2 rounded-lg hover:bg-slate-50 transition-colors">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0" style="background: #0284c7;">
                    {{ strtoupper(auth()->user()->name[0]) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 capitalize">{{ auth()->user()->role }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="p-1 rounded text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </a>
            </div>
        </div>
    </aside>
    @endauth

    <!-- Main -->
    <div class="{{ auth()->check() ? 'lg:ml-60' : '' }} min-h-screen flex flex-col">
        <!-- Topbar -->
        <header class="topbar sticky top-0 z-30">
            <div class="flex items-center h-14 px-4 lg:px-6 gap-3">
                <button @click="sidebarOpen = true" class="lg:hidden p-1.5 rounded-md text-slate-400 hover:bg-slate-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="flex items-center gap-2 lg:hidden">
                    <img src="{{ asset('images/logo_web.png') }}" alt="SiPeka" class="w-8 h-8 object-contain">
                    <span class="font-display font-bold text-slate-900 text-sm">SiPeka</span>
                </div>

                <div class="ml-auto flex items-center gap-2">
                    @if(session('success'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)"
                             x-show="show" x-transition.opacity
                             class="toast-success flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)"
                             x-show="show" x-transition.opacity
                             class="toast-error flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ session('error') }}
                        </div>
                    @endif

                    @auth
                    <a href="{{ route('home') }}" class="hidden lg:flex items-center gap-1.5 px-2.5 py-1.5 rounded-md text-slate-500 hover:text-slate-900 hover:bg-slate-100 text-xs font-medium transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3m10-11v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Beranda
                    </a>
                    <div class="hidden lg:block w-px h-4 bg-slate-200"></div>
                    <a href="{{ route('profile.edit') }}" class="hidden lg:flex items-center gap-1.5 px-2.5 py-1.5 rounded-md hover:bg-slate-100 transition-colors">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white" style="background: #0284c7;">
                            {{ strtoupper(auth()->user()->name[0]) }}
                        </div>
                        <span class="text-xs font-medium text-slate-700">{{ auth()->user()->name }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="hidden lg:flex p-1.5 rounded-md text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors" title="Keluar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="btn-primary text-xs">Masuk</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 p-4 lg:p-6">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="px-6 py-4" style="border-top: 1px solid #f1f5f9;">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-1 text-xs text-slate-400">
                <span>&copy; {{ date('Y') }} SiPeka — Sistem Skrining Kecemasan Mahasiswa</span>
                <span>STIKOM Yos Sudarso Purwokerto · IndoBERT + HARS</span>
            </div>
        </footer>
    </div>

    <script defer src="/assets/alpine.js"></script>
    @stack('scripts')
</body>
</html>