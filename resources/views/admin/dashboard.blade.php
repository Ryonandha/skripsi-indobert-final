@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="animate-fade-in">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="font-display text-3xl font-bold text-calm-900">Dashboard Admin</h1>
        <p class="text-calm-500 mt-1">Data ditampilkan secara agregat tanpa identitas & isi curhatan individu, sesuai kebijakan privasi sistem.</p>
    </div>

    <!-- Peringatan krisis (agregat, tanpa identitas — sesuai kebijakan privasi admin) -->
    @php
        $crisisBelum = App\Models\Screening::where('crisis_flag', true)
            ->where('handling_status', 'belum')->count();
        $crisisTotal = App\Models\Screening::where('crisis_flag', true)->count();
    @endphp
    @if($crisisTotal > 0)
        <div class="mb-8 {{ $crisisBelum > 0 ? 'bg-danger-600 border-danger-700 text-white' : 'bg-danger-50 border-danger-200' }} border rounded-2xl p-5">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl {{ $crisisBelum > 0 ? 'bg-white/20' : 'bg-danger-500' }} flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 {{ $crisisBelum > 0 ? 'text-white' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="flex-1">
                    @if($crisisBelum > 0)
                        <h3 class="font-display font-semibold">{{ $crisisBelum }} Indikasi Krisis Menunggu Penanganan</h3>
                        <p class="text-sm mt-1 opacity-90">Total {{ $crisisTotal }} skrining terdeteksi mengandung indikasi bunuh diri/self-harm (angka agregat). Identitas & penanganan ditangani psikolog — pastikan tim konseling menindaklanjuti segera.</p>
                    @else
                        <h3 class="font-display font-semibold text-danger-800">Semua Kasus Krisis Sudah Ditangani</h3>
                        <p class="text-danger-700 text-sm mt-1">Total {{ $crisisTotal }} skrining dengan indikasi krisis tercatat; seluruhnya berstatus ditangani.</p>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
        @foreach([
            'Total Mahasiswa' => [$stats['total_mahasiswa'], 'primary', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
            'Total Skrining' => [$stats['total_screening'], 'calm', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
            'Risiko Rendah' => [$stats['risk_rendah'], 'primary', 'M5 13l4 4L19 7'],
            'Risiko Sedang' => [$stats['risk_sedang'], 'warm', 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
            'Risiko Tinggi' => [$stats['risk_tinggi'], 'danger', 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
            'Consent Follow-up' => [$stats['consent_count'], 'calm', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ] as $label => [$value, $color, $path])
        <div class="bg-white rounded-2xl shadow-card border border-calm-100 p-5 hover:shadow-card-hover transition-shadow duration-300">
            <div class="flex items-center justify-between mb-3">
                <p class="text-calm-500 text-xs font-medium">{{ $label }}</p>
                <div class="w-9 h-9 rounded-xl bg-{{ $color }}-50 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-{{ $color }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/></svg>
                </div>
            </div>
            <p class="font-display text-3xl font-bold text-calm-900">{{ $value }}</p>
        </div>
    @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Distribusi Emosi -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-card border border-calm-100 p-6">
            <h2 class="font-display text-lg font-semibold text-calm-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Distribusi Emosi Dominan (Agregat)
            </h2>
            @if($emotionStats->count())
                @php $max = $emotionStats->max(); @endphp
                <div class="space-y-3">
                    @foreach($emotionStats as $emotion => $total)
                        <div class="flex items-center gap-3">
                            <span class="w-48 text-sm text-calm-600 truncate capitalize">{{ $emotion }}</span>
                            <div class="flex-1 h-5 bg-calm-100 rounded-full overflow-hidden">
                                <div class="h-5 bg-gradient-to-r from-primary-400 to-primary-600 rounded-full transition-all duration-500" style="width: {{ round($total/$max*100) }}%"></div>
                            </div>
                            <span class="text-sm font-semibold text-calm-900 w-12 text-right">{{ $total }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <p class="text-calm-400 text-sm">Belum ada data skrining.</p>
                </div>
            @endif
        </div>

        <!-- Tindakan Cepat -->
        <div class="space-y-4">
            <div class="bg-white rounded-2xl shadow-card border border-calm-100 p-6">
                <h2 class="font-display text-lg font-semibold text-calm-900 mb-4">Tindakan Cepat</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.educations') }}" class="group flex items-center gap-3 p-3 rounded-xl border border-transparent hover:border-primary-200 hover:bg-primary-50 transition-all">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 group-hover:bg-primary-200 transition-colors flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-calm-900 text-sm">Kelola Artikel Edukasi</h3>
                            <p class="text-xs text-calm-500">Tambah, ubah & hapus bacaan</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.users') }}" class="group flex items-center gap-3 p-3 rounded-xl border border-transparent hover:border-primary-200 hover:bg-primary-50 transition-all">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 group-hover:bg-primary-200 transition-colors flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-calm-900 text-sm">Kelola Pengguna</h3>
                            <p class="text-xs text-calm-500">Data mahasiswa & psikolog</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl p-5 border border-primary-200">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display font-semibold text-primary-900 text-sm">Kebijakan Privasi</h3>
                        <p class="text-primary-700 text-xs mt-1">Sebagai admin teknis, Anda hanya melihat data agregat. Isi curhatan mahasiswa hanya dapat diakses psikolog dengan consent.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
