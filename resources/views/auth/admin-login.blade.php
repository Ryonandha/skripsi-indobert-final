@extends('layouts.app')
@section('title', 'Login Staf')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
<div class="w-full max-w-md">
    <!-- Header -->
    <div class="text-center mb-7">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-4" style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 8px 25px rgba(245,158,11,0.3);">
            <svg class="w-7 h-7 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <h1 class="font-display text-2xl font-bold text-white">Portal Staf</h1>
        <p class="text-sm mt-1" style="color: #64748b;">Khusus admin teknis & psikolog</p>
    </div>

    <div class="glass-card rounded-2xl p-7">
        @if(session('info'))
            <div class="mb-5 rounded-xl px-4 py-3 text-sm flex items-start gap-2" style="background: rgba(96,165,250,0.1); border: 1px solid rgba(96,165,250,0.2); color: #93c5fd;">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('info') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-5 rounded-xl px-4 py-3 text-sm flex items-start gap-2" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #fca5a5;">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-2 text-white">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="glass-input w-full rounded-xl px-4 py-2.5 text-sm"
                       placeholder="admin@stikomyos.ac.id">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2 text-white">Password</label>
                <input type="password" name="password" required
                       class="glass-input w-full rounded-xl px-4 py-2.5 text-sm"
                       placeholder="••••••••">
            </div>
            <label class="flex items-center gap-2.5 text-sm cursor-pointer" style="color: #94a3b8;">
                <input type="checkbox" name="remember" value="1" class="rounded" style="accent-color: #f59e0b;">
                Ingat saya
            </label>
            <button type="submit" class="btn-amber w-full justify-center py-3 mt-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                Masuk sebagai Staf
            </button>
        </form>

        <div class="mt-5 pt-5" style="border-top: 1px solid rgba(255,255,255,0.07);">
            <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 text-xs transition-colors" style="color: #64748b;"
               onmouseover="this.style.color='#94a3b8'" onmouseout="this.style.color='#64748b'">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke login mahasiswa
            </a>
        </div>
    </div>
</div>
</div>
@endsection
