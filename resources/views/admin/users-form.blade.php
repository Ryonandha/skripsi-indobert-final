@extends('layouts.app')
@section('title', isset($user->id) ? 'Edit Pengguna' : 'Tambah Psikolog')

@php
    // $role: 'psikolog' saat membuat akun baru (create selalu untuk psikolog),
    // atau role user yang sedang diedit ('mahasiswa'/'psikolog').
    $isMahasiswa = $role === 'mahasiswa';
@endphp

@section('content')
<div class="animate-fade-in max-w-2xl">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.users', ['role' => $role]) }}" class="inline-flex items-center gap-1 text-sm text-calm-500 hover:text-primary-600 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke daftar pengguna
        </a>
        <h1 class="font-display text-3xl font-bold text-calm-900">
            {{ isset($user->id) ? 'Edit ' . ($isMahasiswa ? 'Data Mahasiswa' : 'Psikolog') : 'Tambah Psikolog' }}
        </h1>
        <p class="text-calm-500 mt-1">
            @if($isMahasiswa)
                Akun ini login dengan Google (email kampus). Admin hanya dapat melengkapi/mengubah data profil.
            @else
                Akun ini login dengan email + password.
            @endif
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-card border border-calm-100 p-6 md:p-8">
        <form method="POST"
              action="{{ isset($user->id) ? route('admin.users.update', $user) : route('admin.users.store') }}">
            @csrf
            @if(isset($user->id))
                @method('PUT')
            @endif

            <div class="space-y-5">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-calm-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required
                           class="w-full border border-calm-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
                    @error('name') <p class="text-danger-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-calm-700 mb-1.5">Email</label>
                    @if(isset($user->id))
                        <input type="email" value="{{ $user->email }}" readonly
                               class="w-full border border-calm-200 rounded-xl px-4 py-2.5 bg-calm-50 text-calm-500 outline-none cursor-not-allowed">
                        <p class="text-xs text-calm-500 mt-1">Email tidak dapat diubah (digunakan sebagai identitas login).</p>
                    @else
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full border border-calm-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
                        @error('email') <p class="text-danger-600 text-sm mt-1">{{ $message }}</p> @enderror
                    @endif
                </div>

                <!-- Role (read-only, informatif saja — tidak bisa diubah lewat form ini) -->
                <div>
                    <label class="block text-sm font-medium text-calm-700 mb-1.5">Role</label>
                    <div class="w-full border border-calm-200 rounded-xl px-4 py-2.5 bg-calm-50 text-calm-600">
                        {{ $isMahasiswa ? 'Mahasiswa (login via Google)' : 'Psikolog / Konselor (login via password)' }}
                    </div>
                </div>

                @if($isMahasiswa)
                    <!-- NIM -->
                    <div>
                        <label class="block text-sm font-medium text-calm-700 mb-1.5">NIM <span class="text-calm-400 font-normal">(9 digit angka)</span></label>
                        <input type="text" name="nim" value="{{ old('nim', $user->nim ?? '') }}" maxlength="9" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               class="w-full border border-calm-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
                        @error('nim') <p class="text-danger-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Prodi -->
                    <div>
                        <label class="block text-sm font-medium text-calm-700 mb-1.5">Program Studi</label>
                        <select name="prodi"
                                class="w-full border border-calm-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none bg-white">
                            <option value="" disabled {{ old('prodi', $user->prodi ?? '') ? '' : 'selected' }}>— Pilih Prodi —</option>
                            @foreach(['S1 Sistem Informasi', 'S1 Teknik Informatika', 'S1 Desain Komunikasi Visual', 'D3 Komputer Akuntansi'] as $p)
                                <option value="{{ $p }}" {{ old('prodi', $user->prodi ?? '') === $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                        @error('prodi') <p class="text-danger-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                @endif

                <!-- No HP -->
                <div>
                    <label class="block text-sm font-medium text-calm-700 mb-1.5">No. HP <span class="text-calm-400 font-normal">(opsional)</span></label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                           class="w-full border border-calm-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
                    @error('phone') <p class="text-danger-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                @unless($isMahasiswa)
                    <!-- Password (hanya untuk psikolog; mahasiswa login via Google) -->
                    <div>
                        <label class="block text-sm font-medium text-calm-700 mb-1.5">
                            Password
                            @if(isset($user->id))
                                <span class="text-calm-400 font-normal">(kosongkan jika tidak diubah)</span>
                            @endif
                        </label>
                        <input type="password" name="password" {{ isset($user->id) ? '' : 'required' }} minlength="8"
                               class="w-full border border-calm-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none">
                        @error('password') <p class="text-danger-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                @endunless
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-calm-100">
                <button type="submit"
                        class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium transition-colors shadow-soft">
                    {{ isset($user->id) ? 'Simpan Perubahan' : 'Tambah Psikolog' }}
                </button>
                <a href="{{ route('admin.users', ['role' => $role]) }}"
                   class="px-6 py-2.5 bg-white border border-calm-200 text-calm-600 hover:bg-calm-50 rounded-xl font-medium transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
