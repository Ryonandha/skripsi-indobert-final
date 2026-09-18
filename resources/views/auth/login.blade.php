@extends('layouts.app')
@section('title', 'Masuk')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <h1 class="text-2xl font-bold mb-1 text-teal-800">Masuk</h1>
    <p class="text-sm text-slate-500 mb-6">Khusus mahasiswa — masuk dengan akun Google kampus.</p>

    @if(session('info'))
        <div class="mb-4 bg-teal-50 border border-teal-200 text-teal-800 rounded-lg px-4 py-3 text-sm leading-relaxed">{{ session('info') }}</div>
    @endif
    @error('email') <div class="mb-4 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm leading-relaxed">{{ $message }}</div> @enderror

    <a href="{{ route('google.redirect') }}"
       class="flex items-center justify-center gap-2 w-full bg-teal-700 hover:bg-teal-600 text-white rounded-lg py-2.5 font-semibold transition-colors">
        <svg class="w-5 h-5" viewBox="0 0 24 24"><path fill="#fff" d="M23.5 12.3c0-.9-.1-1.5-.3-2.3H12v4.5h6.5c0 1.1-.7 2.7-2 3.6l-.1.1 2.9 2.2.2.1c1.8-1.6 2.9-4 2.9-6.9z"/><path fill="#fff" d="M12 24c3.2 0 6-1.1 7.9-2.9l-3.8-2.9c-1 .7-2.4 1.2-4.1 1.2-3.1 0-5.8-2.1-6.8-5l-.1.1-3 2.3v.1C3.9 21.3 7.7 24 12 24z"/><path fill="#fff" d="M5.2 14.4c-.3-.7-.4-1.5-.4-2.4s.1-1.7.4-2.4l-.1-.1-3-2.3-.1.1C1.3 9 1 10.5 1 12s.3 3 1 4.7l3.2-2.3z"/><path fill="#fff" d="M12 4.7c1.8 0 3 .8 3.7 1.4l3.3-3.2C17.9 1.1 15.2 0 12 0 7.7 0 3.9 2.7 2 6.3l3.2 2.4v-.1c1-2.8 3.7-3.9 6.8-3.9z"/></svg>
        Masuk dengan Google
    </a>
    <p class="text-xs text-center text-slate-400 mt-2">Wajib akun @student.stikomyos.ac.id. Akun diterbitkan kampus — hubungi prodi / kemahasiswaan bila belum terdaftar.</p>

    <p class="text-xs text-center text-slate-400 mt-5">
        <a href="{{ route('admin.login') }}" class="hover:text-teal-700 hover:underline">Staf (admin / psikolog) →</a>
    </p>
</div>
@endsection
