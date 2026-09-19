@extends('layouts.app')
@section('title', 'Login Staf')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
<div class="w-full max-w-sm">
    <div class="text-center mb-6">
        <img src="{{ asset('images/logo_web.png') }}" alt="SiPeka" class="w-16 h-16 object-contain mx-auto mb-3">
        <h1 class="font-display text-xl font-bold text-slate-900">Portal Staf</h1>
        <p class="text-sm text-slate-500 mt-1">Khusus admin teknis &amp; psikolog</p>
    </div>

    <div class="card p-7">
        @if(session('info'))
            <div class="mb-4 rounded-lg px-4 py-3 text-sm" style="background:#eff6ff; border:1px solid #bfdbfe; color:#1d4ed8;">{{ session('info') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 rounded-lg px-4 py-3 text-sm" style="background:#fff1f2; border:1px solid #fecdd3; color:#be123c;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="input-field" placeholder="admin@stikomyos.ac.id">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Password</label>
                <input type="password" name="password" required
                       class="input-field" placeholder="••••••••">
            </div>
            <label class="flex items-center gap-2 text-xs text-slate-500 cursor-pointer">
                <input type="checkbox" name="remember" value="1" style="accent-color: #0284c7;">
                Ingat saya
            </label>
            <button type="submit" class="btn-primary w-full justify-center py-2.5">
                Masuk sebagai Staf
            </button>
        </form>

        <div class="mt-5 pt-4 border-t border-slate-100">
            <a href="{{ route('login') }}" class="flex items-center justify-center gap-1.5 text-xs text-slate-400 hover:text-slate-600 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke login mahasiswa
            </a>
        </div>
    </div>

    @if(session('logout_success'))
    <div id="logoutSplash" style="position:fixed;inset:0;z-index:9999;background:rgba(255,255,255,0.95);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;transition:opacity 0.5s ease;backdrop-filter:blur(4px);">
        <img src="{{ asset('images/logout_berhasil.png') }}" alt="Logout Berhasil"
             style="width:200px;height:200px;object-fit:contain;mix-blend-mode:multiply;animation:bounceIn 0.6s ease;">
        <div style="text-align:center;">
            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:1.5rem;color:#0f172a;margin-bottom:6px;">Berhasil Keluar</p>
            <p style="font-size:0.95rem;color:#64748b;max-width:300px;line-height:1.5;">Kamu telah keluar dari portal dengan aman.</p>
        </div>
        <div style="display:flex;gap:6px;margin-top:8px;">
            <span style="width:8px;height:8px;border-radius:50%;background:#0284c7;animation:dot 1.2s 0s infinite;"></span>
            <span style="width:8px;height:8px;border-radius:50%;background:#0284c7;animation:dot 1.2s 0.2s infinite;"></span>
            <span style="width:8px;height:8px;border-radius:50%;background:#0284c7;animation:dot 1.2s 0.4s infinite;"></span>
        </div>
    </div>
    <style>
        @keyframes bounceIn { 0% { transform: scale(0.5); opacity: 0; } 70% { transform: scale(1.1); opacity: 1; } 100% { transform: scale(1); } }
        @keyframes dot { 0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; } 40% { transform: scale(1); opacity: 1; } }
    </style>
    <script>
        setTimeout(function() {
            var splash = document.getElementById('logoutSplash');
            if (splash) { splash.style.opacity = '0'; setTimeout(function(){ splash.remove(); }, 300); }
        }, 1200);
    </script>
    @endif
</div>
@endsection
