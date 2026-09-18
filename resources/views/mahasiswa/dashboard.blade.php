@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
@php
    $screeningsCount = auth()->user()->screenings()->count();
    $highRiskCount = auth()->user()->screenings()->where('risk_level', 'tinggi')->count();
    $weeklyStreak = 0; // TODO: implement streak calculation
@endphp
<div class="animate-fade-in">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="font-display text-3xl font-bold text-calm-900">
            Selamat {{ now()->hour < 12 ? 'pagi' : (now()->hour < 15 ? 'siang' : 'sore') }}, {{ auth()->user()->name }}
        </h1>
        <p class="text-calm-500 mt-1">Kondisi emosionalmu penting. Yuk cek risiko kecemasanmu hari ini.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-calm-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-calm-500 text-sm font-medium">Total Skrining</p>
                    <p class="font-display text-3xl font-bold text-calm-900 mt-1">{{ $screeningsCount ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-primary-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-calm-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-calm-500 text-sm font-medium">Risiko Tinggi</p>
                    <p class="font-display text-3xl font-bold {{ ($highRiskCount ?? 0) > 0 ? 'text-danger-600' : 'text-calm-900' }} mt-1">{{ $highRiskCount ?? 0 }}</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-danger-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-danger-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-calm-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-calm-500 text-sm font-medium">Streak Mingguan</p>
                    <p class="font-display text-3xl font-bold text-primary-600 mt-1">{{ $weeklyStreak ?? 0 }} minggu</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-warm-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-warm-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Left: Latest Screening & Quick Actions -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Latest Screening Card -->
            <div class="bg-white rounded-2xl border border-calm-200 overflow-hidden">
                <div class="p-6 border-b border-calm-100 flex items-center justify-between">
                    <h2 class="font-display text-xl font-semibold text-calm-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Skrining Terakhir
                    </h2>
                    @if($latest)
                        <a href="{{ route('mahasiswa.screening.show', $latest) }}"
                           class="text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center gap-1">
                            Lihat Detail
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endif
                </div>

                <div class="p-6">
                    @if($latest)
                        <?php
                            $riskColors = [
                                'rendah' => ['bg' => 'bg-primary-50', 'text' => 'text-primary-700', 'border' => 'border-primary-200', 'dot' => 'bg-primary-500'],
                                'sedang' => ['bg' => 'bg-warm-50', 'text' => 'text-warm-700', 'border' => 'border-warm-200', 'dot' => 'bg-warm-500'],
                                'tinggi' => ['bg' => 'bg-danger-50', 'text' => 'text-danger-700', 'border' => 'border-danger-200', 'dot' => 'bg-danger-500'],
                            ];
                            $c = $riskColors[$latest->risk_level];
                        ?>
                        <div class="flex flex-col lg:flex-row lg:items-stretch gap-4">
                            <div class="flex items-center gap-4 lg:w-56 flex-shrink-0">
                                <div class="w-12 h-12 rounded-xl {{ $c['bg'] }} border {{ $c['border'] }} flex items-center justify-center">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $c['dot'] }}"></span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-calm-900">{{ $latest->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-calm-500">{{ $latest->created_at->format('H:i') }} WIB</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-semibold {{ $c['bg'] }} {{ $c['text'] }} capitalize">
                                        Risiko {{ $latest->risk_level }}
                                    </span>
                                </div>
                            </div>

                            <!-- Metrik -->
                            <div class="grid grid-cols-2 gap-3 lg:flex-1">
                                <div class="p-4 rounded-xl bg-calm-50 border border-calm-100">
                                    <p class="font-display text-xl font-bold text-calm-900">{{ $latest->emotion_label }}</p>
                                    <p class="text-xs text-calm-500 mt-0.5">Emosi Dominan</p>
                                    <p class="text-xs text-primary-700 font-medium mt-1">{{ number_format($latest->emotion_confidence * 100, 1) }}% keyakinan</p>
                                </div>
                                <div class="p-4 rounded-xl bg-calm-50 border border-calm-100">
                                    <p class="font-display text-xl font-bold text-calm-900">{{ $latest->hars_score }}<span class="text-sm text-calm-400 font-normal">/56</span></p>
                                    <p class="text-xs text-calm-500 mt-0.5">Skor HARS</p>
                                    @php
                                        $harsLabel = $latest->hars_score < 14 ? 'Tidak cemas' : ($latest->hars_score < 21 ? 'Ringan' : ($latest->hars_score < 28 ? 'Sedang' : 'Berat'));
                                    @endphp
                                    <p class="text-xs text-calm-500 mt-1">{{ $harsLabel }}</p>
                                </div>
                            </div>
                        </div>

                        @if(in_array($latest->risk_level, ['sedang','tinggi']) && !$latest->consent_followup)
                            <!-- Aksi consent: baris tersendiri di bawah agar metrik tidak tergencet -->
                            <div class="mt-4 pt-4 border-t border-calm-100 flex justify-end">
                                <form method="POST" action="{{ route('mahasiswa.consent', $latest) }}">
                                    @csrf
                                    <button class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium transition-colors inline-flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Minta Pendampingan Konselor
                                    </button>
                                </form>
                            </div>
                        @elseif($latest->consent_followup)
                            <div class="mt-4 pt-4 border-t border-calm-100 flex justify-end">
                                <div class="inline-flex items-center gap-2 text-primary-700 bg-primary-50 px-3.5 py-2 rounded-xl border border-primary-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span class="font-medium text-sm">Permintaan pendampingan terkirim — konselor akan menghubungi</span>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 rounded-full bg-calm-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-calm-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </div>
                            <h3 class="font-display text-lg font-semibold text-calm-900 mb-1">Belum ada skrining</h3>
                            <p class="text-calm-500 text-sm mb-4">Mulai skrining pertamamu untuk memahami kondisi emosionalmu</p>
                            <a href="{{ route('mahasiswa.screening.create') }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Mulai Skrining Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('mahasiswa.screening.create') }}"
                   class="bg-white rounded-2xl border border-calm-200 p-6 transition-all duration-300 group flex items-center gap-4 hover:bg-calm-50">
                    <div class="w-12 h-12 rounded-xl bg-primary-100 group-hover:bg-primary-200 transition-colors flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-calm-900">Skrining Baru</h3>
                        <p class="text-sm text-calm-500 mt-0.5">Tulis curhatan & isi HARS</p>
                    </div>
                </a>

                <a href="{{ route('mahasiswa.history') }}"
                   class="bg-white rounded-2xl border border-calm-200 p-6 transition-all duration-300 group flex items-center gap-4 hover:bg-calm-50">
                    <div class="w-12 h-12 rounded-xl bg-calm-100 group-hover:bg-calm-200 transition-colors flex items-center justify-center">
                        <svg class="w-6 h-6 text-calm-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0l1-1m-1 1l-1-1"/></svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-calm-900">Riwayat Skrining</h3>
                        <p class="text-sm text-calm-500 mt-0.5">Lihat perkembangan risiko</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Right: Educational Articles & Tips -->
        <div class="space-y-6">
            <!-- Tips Card -->
            <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl p-6 border border-primary-200">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-display font-semibold text-primary-900">Tips Cepat Menenangkan Diri</h3>
                        <p class="text-primary-700 text-sm mt-1">Tekan emosi tinggi dengan teknik 4-7-8</p>
                    </div>
                </div>
                <div class="mt-4 space-y-2 text-sm text-primary-700">
                    <div class="flex items-center gap-2 p-2 bg-white/50 rounded-lg">
                        <span class="w-6 h-6 rounded-full bg-primary-600 text-white text-xs flex items-center justify-center font-bold">1</span>
                        <span>Tarik napas 4 detik</span>
                    </div>
                    <div class="flex items-center gap-2 p-2 bg-white/50 rounded-lg">
                        <span class="w-6 h-6 rounded-full bg-primary-600 text-white text-xs flex items-center justify-center font-bold">2</span>
                        <span>Tahan napas 7 detik</span>
                    </div>
                    <div class="flex items-center gap-2 p-2 bg-white/50 rounded-lg">
                        <span class="w-6 h-6 rounded-full bg-primary-600 text-white text-xs flex items-center justify-center font-bold">3</span>
                        <span>Hembuskan pelan 8 detik</span>
                    </div>
                </div>
                <button class="mt-4 w-full text-sm font-medium text-primary-600 hover:text-primary-700 flex items-center justify-center gap-1"
                        onclick="navigator.clipboard.writeText('4-7-8: Tarik 4s, tahan 7s, hembuskan 8s. Ulangi 4x')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2 2 2 0 012-2h10a2 2 0 002-2V5a2 2 0 01-2-2H6a2 2 0 01-2 2z"/></svg>
                    Salin Teknik
                </button>
            </div>

            <!-- Educational Articles -->
            <div class="bg-white rounded-2xl border border-calm-200 overflow-hidden">
                <div class="p-4 border-b border-calm-100 flex items-center justify-between">
                    <h2 class="font-display text-lg font-semibold text-calm-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Bacaan Edukasi
                    </h2>
                </div>
                <div class="p-4 space-y-3">
                    @php $educations = \App\Models\Education::where('is_published', true)->latest()->take(4)->get(); @endphp
                    @forelse($educations as $edu)
                        <a href="{{ route('education.show', $edu->slug) }}"
                           class="block p-3 rounded-xl hover:bg-calm-50 transition-colors group border border-transparent hover:border-calm-200">
                            <h3 class="font-medium text-calm-900 group-hover:text-primary-600 transition-colors">{{ $edu->title }}</h3>
                            <p class="text-sm text-calm-500 mt-1 line-clamp-2">{{ Str::limit(strip_tags($edu->content), 100) }}</p>
                            <span class="inline-flex items-center gap-1 text-xs text-primary-600 mt-2 group-hover:gap-2 transition-all">
                                Baca selengkapnya
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </a>
                    @empty
                        <p class="text-calm-400 text-sm text-center py-4">Belum ada artikel edukasi</p>
                    @endforelse
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="bg-danger-50 border border-danger-200 rounded-2xl p-5">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-danger-500 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-display font-semibold text-danger-800">Butuh Bantuan Darurat?</h3>
                        <p class="text-danger-700 text-sm mt-1">Jangan ragu menghubungi layanan darurat atau konselor kampus</p>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-3">
                    <a href="tel:119" class="flex items-center justify-center gap-2 px-3 py-2 bg-danger-600 hover:bg-danger-700 text-white rounded-xl text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        119 (Darurat)
                    </a>
                    <a href="tel:081234567890" class="flex items-center justify-center gap-2 px-3 py-2 border border-danger-300 text-danger-700 hover:bg-danger-50 rounded-xl text-sm font-medium transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Konselor: 0812-3456-7890
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection