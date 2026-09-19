@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
@php
    $screeningsCount = auth()->user()->screenings()->count();
    $highRiskCount = auth()->user()->screenings()->where('risk_level', 'tinggi')->count();
    $latest = auth()->user()->screenings()->latest()->first();
@endphp

<!-- Header -->
<div class="mb-8">
    <p class="text-xs font-semibold uppercase tracking-widest mb-1" style="color: #f59e0b;">Selamat {{ now()->hour < 12 ? 'pagi' : (now()->hour < 15 ? 'siang' : 'sore') }}</p>
    <h1 class="font-display text-3xl font-bold text-white">{{ auth()->user()->name }} 👋</h1>
    <p class="mt-1 text-sm" style="color: #64748b;">Kondisi emosionalmu penting. Yuk cek risiko kecemasanmu hari ini.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <!-- Total Skrining -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider" style="color: #64748b;">Total Skrining</p>
                <p class="font-display text-4xl font-bold text-white mt-2">{{ $screeningsCount }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.2);">
                <svg class="w-6 h-6" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
        </div>
        <div class="mt-4 pt-4" style="border-top: 1px solid rgba(255,255,255,0.06);">
            <span class="text-xs" style="color: #64748b;">Semua skrining tercatat</span>
        </div>
    </div>

    <!-- Risiko Tinggi -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider" style="color: #64748b;">Risiko Tinggi</p>
                <p class="font-display text-4xl font-bold mt-2 {{ ($highRiskCount) > 0 ? '' : 'text-white' }}" style="{{ ($highRiskCount) > 0 ? 'color: #f87171;' : '' }}">{{ $highRiskCount }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.2);">
                <svg class="w-6 h-6" style="color: #f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>
        <div class="mt-4 pt-4" style="border-top: 1px solid rgba(255,255,255,0.06);">
            <span class="text-xs" style="color: #64748b;">{{ $highRiskCount > 0 ? 'Perlu perhatian konselor' : 'Tidak ada risiko tinggi' }}</span>
        </div>
    </div>

    <!-- Skrining Terakhir -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider" style="color: #64748b;">Skrining Terakhir</p>
                <p class="font-display text-2xl font-bold text-white mt-2">
                    {{ $latest ? $latest->created_at->diffForHumans() : 'Belum ada' }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: rgba(96,165,250,0.12); border: 1px solid rgba(96,165,250,0.2);">
                <svg class="w-6 h-6" style="color: #60a5fa;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="mt-4 pt-4" style="border-top: 1px solid rgba(255,255,255,0.06);">
            @if($latest)
                <span class="badge-{{ $latest->risk_level === 'tinggi' ? 'danger' : ($latest->risk_level === 'sedang' ? 'amber' : 'success') }}">
                    Risiko {{ ucfirst($latest->risk_level) }}
                </span>
            @else
                <span class="text-xs" style="color: #64748b;">Mulai skrining pertama Anda</span>
            @endif
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid lg:grid-cols-3 gap-6">
    <!-- Left: Latest Screening & Quick Actions -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Latest Screening Card -->
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.07);">
                <h2 class="font-display text-base font-semibold text-white flex items-center gap-2">
                    <svg class="w-4 h-4" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Skrining Terakhir
                </h2>
                @if($latest)
                    <a href="{{ route('mahasiswa.screening.show', $latest) }}"
                       class="text-xs font-medium flex items-center gap-1 transition-colors" style="color: #f59e0b;">
                        Lihat Detail
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif
            </div>
            <div class="p-6">
                @if($latest)
                    <div class="flex items-center gap-3 mb-5">
                        <span class="badge-{{ $latest->risk_level === 'tinggi' ? 'danger' : ($latest->risk_level === 'sedang' ? 'amber' : 'success') }} text-sm px-3 py-1">
                            Risiko {{ ucfirst($latest->risk_level) }}
                        </span>
                        <span class="text-xs" style="color: #64748b;">{{ $latest->created_at->format('d M Y, H:i') }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-xl p-4" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);">
                            <p class="text-xs uppercase tracking-wider font-semibold mb-1" style="color: #64748b;">Skor HARS</p>
                            <p class="font-display text-3xl font-bold text-white">{{ $latest->hars_score ?? '—' }}</p>
                            <p class="text-xs mt-1" style="color: #64748b;">dari 56 poin</p>
                        </div>
                        <div class="rounded-xl p-4" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);">
                            <p class="text-xs uppercase tracking-wider font-semibold mb-1" style="color: #64748b;">Sentimen AI</p>
                            <p class="font-display text-xl font-bold text-white mt-1">{{ $latest->sentiment_label ?? '—' }}</p>
                            @if($latest->sentiment_score)
                                <p class="text-xs mt-1" style="color: #64748b;">Skor: {{ number_format($latest->sentiment_score * 100, 1) }}%</p>
                            @endif
                        </div>
                    </div>

                    @if($latest->handling_status === 'ditangani')
                        <div class="mt-4 flex items-center gap-2 rounded-xl px-4 py-3" style="background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.15);">
                            <svg class="w-4 h-4 flex-shrink-0" style="color: #4ade80;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-sm" style="color: #4ade80;">Sudah ditangani oleh konselor</span>
                        </div>
                    @elseif($latest->risk_level === 'tinggi')
                        <div class="mt-4 flex items-center gap-2 rounded-xl px-4 py-3" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.15);">
                            <svg class="w-4 h-4 flex-shrink-0" style="color: #f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span class="text-sm" style="color: #f87171;">Menunggu penanganan konselor</span>
                        </div>
                    @endif
                @else
                    <div class="text-center py-10">
                        <div class="w-16 h-16 rounded-2xl mx-auto mb-4 flex items-center justify-center" style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.15);">
                            <svg class="w-8 h-8" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <p class="font-medium text-white mb-1">Belum ada data skrining</p>
                        <p class="text-sm mb-5" style="color: #64748b;">Mulai skrining pertama Anda sekarang</p>
                        <a href="{{ route('mahasiswa.screening.create') }}" class="btn-amber inline-flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Mulai Skrining
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('mahasiswa.screening.create') }}"
               class="glass-card glass-card-hover rounded-2xl p-5 flex items-center gap-4 transition-all duration-200 group">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.2);">
                    <svg class="w-6 h-6" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-white">Skrining Baru</h3>
                    <p class="text-xs mt-0.5" style="color: #64748b;">Tulis curhatan & isi HARS</p>
                </div>
                <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

            <a href="{{ route('mahasiswa.history') }}"
               class="glass-card glass-card-hover rounded-2xl p-5 flex items-center gap-4 transition-all duration-200 group">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(96,165,250,0.12); border: 1px solid rgba(96,165,250,0.2);">
                    <svg class="w-6 h-6" style="color: #60a5fa;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-white">Riwayat Skrining</h3>
                    <p class="text-xs mt-0.5" style="color: #64748b;">Lihat perkembangan risiko</p>
                </div>
                <svg class="w-4 h-4 ml-auto opacity-0 group-hover:opacity-100 transition-opacity" style="color: #60a5fa;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <!-- Right: Tips & Education -->
    <div class="space-y-6">
        <!-- Breathing Tips Card -->
        <div class="glass-card rounded-2xl p-6" style="background: linear-gradient(135deg, rgba(245,158,11,0.12), rgba(217,119,6,0.06)); border-color: rgba(245,158,11,0.2);">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(245,158,11,0.2);">
                    <svg class="w-5 h-5" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-display font-semibold text-white text-sm">Teknik 4-7-8</h3>
                    <p class="text-xs" style="color: #94a3b8;">Tips menenangkan diri</p>
                </div>
            </div>
            <div class="space-y-2">
                @foreach([['1', 'Tarik napas 4 detik'], ['2', 'Tahan napas 7 detik'], ['3', 'Hembuskan pelan 8 detik']] as [$num, $step])
                <div class="flex items-center gap-3 rounded-xl px-3 py-2.5" style="background: rgba(0,0,0,0.2);">
                    <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-slate-900 flex-shrink-0" style="background: #f59e0b;">{{ $num }}</span>
                    <span class="text-sm" style="color: #cbd5e1;">{{ $step }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Educational Articles -->
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="px-5 py-4" style="border-bottom: 1px solid rgba(255,255,255,0.07);">
                <h2 class="font-display text-sm font-semibold text-white flex items-center gap-2">
                    <svg class="w-4 h-4" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Bacaan Edukasi
                </h2>
            </div>
            <div class="p-4 space-y-1">
                @php $educations = \App\Models\Education::where('is_published', true)->latest()->take(4)->get(); @endphp
                @forelse($educations as $edu)
                    <a href="{{ route('education.show', $edu->slug) }}"
                       class="block p-3 rounded-xl transition-all group" style="border: 1px solid transparent;"
                       onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.borderColor='rgba(255,255,255,0.1)'"
                       onmouseout="this.style.background=''; this.style.borderColor='transparent'">
                        <h3 class="text-sm font-medium text-white group-hover:text-amber-400 transition-colors">{{ $edu->title }}</h3>
                        <p class="text-xs mt-1 line-clamp-1" style="color: #64748b;">{{ Str::limit(strip_tags($edu->content), 70) }}</p>
                    </a>
                @empty
                    <p class="text-xs text-center py-6" style="color: #64748b;">Belum ada artikel edukasi</p>
                @endforelse
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="glass-card rounded-2xl p-5" style="background: rgba(239,68,68,0.08); border-color: rgba(239,68,68,0.2);">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background: rgba(239,68,68,0.2);">
                    <svg class="w-5 h-5" style="color: #f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-sm" style="color: #fca5a5;">Butuh Bantuan Darurat?</h3>
                    <p class="text-xs" style="color: #94a3b8;">Layanan bantuan tersedia 24 jam</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <a href="tel:119" class="flex items-center justify-center gap-1.5 py-2 rounded-xl text-sm font-semibold transition-colors"
                   style="background: rgba(239,68,68,0.25); color: #fca5a5; border: 1px solid rgba(239,68,68,0.3);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    119
                </a>
                <a href="{{ route('mahasiswa.notifikasi.index') }}" class="flex items-center justify-center gap-1.5 py-2 rounded-xl text-sm font-semibold transition-colors"
                   style="background: rgba(255,255,255,0.05); color: #94a3b8; border: 1px solid rgba(255,255,255,0.1);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Konselor
                </a>
            </div>
        </div>
    </div>
</div>
@endsection