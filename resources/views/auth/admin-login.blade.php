@extends('layouts.app')
@section('title', 'Login Staf')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
<div class="w-full max-w-sm">
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl mb-3" style="background: #0284c7;">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
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
</div>
</div>
@endsection
