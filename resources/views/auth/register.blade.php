@extends('layouts.app')
@section('title', 'Informasi Akun')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-xl shadow p-8">
    <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-100 flex items-center justify-center mb-4">
        <svg class="w-6 h-6 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
    </div>
    <h1 class="text-2xl font-bold mb-3 text-teal-800">Akun Mahasiswa Dibuat oleh Kampus</h1>
    <p class="text-sm leading-relaxed text-slate-600">
        Untuk menjaga keabsahan data skrining dan kerahasiaan identitas mahasiswa,
        pendaftaran mandiri <strong>tidak dibuka</strong>. Setiap mahasiswa aktif menerima
        akun SiPeka dari pihak kampus melalui program studi masing-masing.
    </p>
    <ul class="mt-4 space-y-2.5 text-sm text-slate-600">
        <li class="flex items-start gap-2.5">
            <span class="w-1.5 h-1.5 rounded-full bg-teal-600 mt-1.5 flex-shrink-0"></span>
            <span>Gunakan email kampus yang telah diterima dari prodi untuk masuk.</span>
        </li>
        <li class="flex items-start gap-2.5">
            <span class="w-1.5 h-1.5 rounded-full bg-teal-600 mt-1.5 flex-shrink-0"></span>
            <span>Lupa password atau belum menerima akun? Hubungi bagian kemahasiswaan / BKK kampus.</span>
        </li>
    </ul>
    <a href="{{ route('login') }}"
       class="mt-6 w-full inline-flex justify-center items-center gap-2 bg-teal-700 hover:bg-teal-600 text-white rounded-lg py-2.5 px-4 font-semibold transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
        Masuk ke Akun
    </a>
</div>
@endsection
