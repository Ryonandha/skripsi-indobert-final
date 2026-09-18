@extends('layouts.app')
@section('title', 'Dashboard Konseling')

@section('content')
<div class="animate-fade-in">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-display text-3xl font-bold text-calm-900">Dashboard Konseling</h1>
                <p class="text-calm-500 mt-1">Ringkasan kasus & akses cepat ke mahasiswa yang butuh bantuan</p>
            </div>
            <a href="{{ route('psikolog.patients') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium transition-colors w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Lihat Semua Mahasiswa
            </a>
        </div>
    </div>

    <!-- Alert: Risiko tinggi tanpa consent -->
    @php $noConsentHigh = App\Models\Screening::where('risk_level', 'tinggi')->where('consent_followup', false)->count(); @endphp
    @if($noConsentHigh > 0)
        <div class="mb-6 bg-danger-50 border border-danger-200 rounded-2xl p-5 animate-slide-down">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-danger-500 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-display font-semibold text-danger-800">{{ $noConsentHigh }} Mahasiswa Risiko Tinggi Belum Consent</h3>
                    <p class="text-danger-700 text-sm mt-1">Mereka belum menyetujui didampingi. Pertimbangkan hubungi proaktif via menu <a href="{{ route('psikolog.patients') }}" class="font-medium underline hover:text-danger-600">Daftar Pasien</a>.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- KRISIS: peringatan segera (safety net kata krisis) -->
    @php
        $crisisCases = App\Models\Screening::where('crisis_flag', true)
            ->where('handling_status', 'belum')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
        $crisisTotal = App\Models\Screening::where('crisis_flag', true)
            ->where('handling_status', 'belum')->count();
    @endphp
    @if($crisisCases->count())
        <div class="mb-6 bg-danger-600 border border-danger-700 rounded-2xl p-5 text-white">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div class="flex-1">
                    <h3 class="font-display font-semibold">Perlu Tindakan Segera — {{ $crisisTotal }} Kasus Krisis Belum Ditangani</h3>
                    <p class="text-danger-50 text-sm mt-1">Terdeteksi indikasi bunuh diri/self-harm pada curahan mahasiswa berikut. Disarankan hubungi langsung hari ini.</p>
                    <ul class="mt-3 space-y-1.5">
                        @foreach($crisisCases as $case)
                            <li class="flex items-center gap-2 text-sm bg-white/10 rounded-lg px-3 py-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-white flex-shrink-0"></span>
                                <span class="font-medium">{{ $case->user->name }}</span>
                                <span class="text-danger-100 text-xs">{{ $case->created_at->translatedFormat('d M Y, H:i') }}</span>
                                <a href="{{ route('psikolog.screening-detail', $case) }}" class="ml-auto text-xs font-medium underline hover:text-danger-100">Tinjau</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        @foreach([
            'total_butuh_dampingan' => ['label' => 'Butuh Dampingan', 'icon' => 'users', 'color' => 'primary', 'count' => $stats['total_butuh_dampingan']],
            'belum_ditangani' => ['label' => 'Belum Ditangani', 'icon' => 'alert', 'color' => 'danger', 'count' => $stats['belum_ditangani']],
            'sedang_diproses' => ['label' => 'Diproses', 'icon' => 'process', 'color' => 'warm', 'count' => $stats['sedang_diproses']],
            'selesai_bulan_ini' => ['label' => 'Selesai Bulan Ini', 'icon' => 'done', 'color' => 'primary', 'count' => $stats['selesai_bulan_ini']],
            'risiko_tinggi_tanpa_consent' => ['label' => 'Risiko Tinggi Tanpa Consent', 'icon' => 'alert', 'color' => 'danger', 'count' => $stats['risiko_tinggi_tanpa_consent']],
        ] as $key => $stat)
            <div class="bg-white rounded-2xl shadow-card p-5 border border-calm-100 hover:shadow-card-hover transition-shadow duration-300">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-{{ $stat['color'] }}-100 flex items-center justify-center">
                        @if($stat['icon'] === 'users')
                            <svg class="w-5 h-5 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        @elseif($stat['icon'] === 'alert')
                            <svg class="w-5 h-5 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        @elseif($stat['icon'] === 'process')
                            <svg class="w-5 h-5 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        @elseif($stat['icon'] === 'done')
                            <svg class="w-5 h-5 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-calm-500 text-xs font-medium">{{ $stat['label'] }}</p>
                        <p class="font-display text-2xl font-bold text-calm-900">{{ $stat['count'] }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Urgent Cases -->
    <div class="bg-white rounded-2xl shadow-card border border-calm-100 overflow-hidden">
        <div class="p-5 border-b border-calm-100 flex items-center justify-between">
            <h2 class="font-display text-xl font-semibold text-calm-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-danger-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Perlu Perhatian Segera
            </h2>
            <a href="{{ route('psikolog.patients', ['status' => 'belum']) }}"
               class="text-sm font-medium text-primary-600 hover:text-primary-700">Lihat semua</a>
        </div>

        <div class="p-5">
            @if($urgentCases->count())
                <div class="space-y-3">
                    @foreach($urgentCases as $s)
                        <?php
                            $rc = ['rendah'=>'bg-primary-50 text-primary-700 border-primary-200',
                                   'sedang'=>'bg-warm-50 text-warm-700 border-warm-200',
                                   'tinggi'=>'bg-danger-50 text-danger-700 border-danger-200'][$s->risk_level];
                        ?>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 rounded-xl {{ $rc }} border">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-white/70 flex items-center justify-center">
                                    <span class="font-display font-semibold text-calm-900 text-sm">{{ strtoupper($s->user->name[0]) }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-calm-900">{{ $s->user->name }}</p>
                                    <p class="text-sm text-calm-500">NIM: {{ $s->user->nim }} • {{ $s->user->phone ?? $s->user->email }}</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold capitalize {{ $rc }} border">
                                    Risiko {{ $s->risk_level }}
                                </span>
                                <span class="text-xs text-calm-500 bg-white/50 px-2 py-1 rounded">HARS: {{ $s->hars_score }}/56</span>
                                <span class="text-xs text-calm-500 bg-white/50 px-2 py-1 rounded">{{ $s->emotion_label }} {{ number_format($s->emotion_confidence*100,0) }}%</span>
                                <a href="{{ route('psikolog.patient-detail', $s->user) }}"
                                   class="px-3 py-1.5 bg-white/80 hover:bg-white text-calm-700 rounded-lg text-xs font-medium transition-colors">
                                    Buka Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-display text-lg font-semibold text-calm-900 mb-1">Tidak ada kasus mendesak</h3>
                    <p class="text-calm-500 text-sm">Semua mahasiswa yang consent sudah ditangani dengan baik.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <a href="{{ route('psikolog.patients') }}"
           class="bg-white rounded-2xl shadow-card border border-calm-100 p-6 hover:shadow-card-hover transition-all duration-300 group flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-primary-100 group-hover:bg-primary-200 transition-colors flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-calm-900">Kelola Pasien</h3>
                <p class="text-sm text-calm-500 mt-0.5">Lihat & hubungi semua mahasiswa</p>
            </div>
        </a>

        <a href="{{ route('psikolog.schedule') }}"
           class="bg-white rounded-2xl shadow-card border border-calm-100 p-6 hover:shadow-card-hover transition-all duration-300 group flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-warm-100 group-hover:bg-warm-200 transition-colors flex items-center justify-center">
                <svg class="w-6 h-6 text-warm-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-calm-900">Jadwal Konseling</h3>
                <p class="text-sm text-calm-500 mt-0.5">Atur jadwal sesi mingguan</p>
            </div>
        </a>

        <a href="{{ route('psikolog.notes') }}"
           class="bg-white rounded-2xl shadow-card border border-calm-100 p-6 hover:shadow-card-hover transition-all duration-300 group flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-calm-100 group-hover:bg-calm-200 transition-colors flex items-center justify-center">
                <svg class="w-6 h-6 text-calm-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div>
                <h3 class="font-semibold text-calm-900">Catatan Progres</h3>
                <p class="text-sm text-calm-500 mt-0.5">Kelola catatan sesi konseling</p>
            </div>
        </a>
    </div>
</div>
@endsection