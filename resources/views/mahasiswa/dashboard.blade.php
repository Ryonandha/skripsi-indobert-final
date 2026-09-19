@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
@php
    $screeningsCount = auth()->user()->screenings()->count();
    $highRiskCount = auth()->user()->screenings()->where('risk_level', 'tinggi')->count();
    $latest = auth()->user()->screenings()->latest()->first();
@endphp

<!-- Page Header -->
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display text-xl font-bold text-slate-900">
            Selamat {{ now()->hour < 12 ? 'pagi' : (now()->hour < 15 ? 'siang' : 'sore') }}, {{ auth()->user()->name }}
        </h1>
        <p class="text-sm text-slate-500 mt-0.5">Pantau kondisi kesehatanmu dari sini.</p>
    </div>
    <a href="{{ route('mahasiswa.screening.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Skrining Baru
    </a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="card p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Skrining</p>
        <p class="font-display text-3xl font-bold text-slate-900 mt-1">{{ $screeningsCount }}</p>
        <p class="text-xs text-slate-400 mt-1">Semua skrining tercatat</p>
    </div>
    <div class="card p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Risiko Tinggi</p>
        <p class="font-display text-3xl font-bold mt-1 {{ $highRiskCount > 0 ? 'text-red-600' : 'text-slate-900' }}">{{ $highRiskCount }}</p>
        <p class="text-xs text-slate-400 mt-1">{{ $highRiskCount > 0 ? 'Perlu perhatian konselor' : 'Tidak ada risiko tinggi' }}</p>
    </div>
    <div class="card p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Skrining Terakhir</p>
        <p class="font-display text-xl font-bold text-slate-900 mt-1">{{ $latest ? $latest->created_at->diffForHumans() : '—' }}</p>
        @if($latest)
            <span class="badge-{{ $latest->risk_level === 'tinggi' ? 'high' : ($latest->risk_level === 'sedang' ? 'med' : 'low') }} mt-2 inline-block">
                Risiko {{ ucfirst($latest->risk_level) }}
            </span>
        @else
            <p class="text-xs text-slate-400 mt-1">Belum ada skrining</p>
        @endif
    </div>
</div>

<!-- Main Grid -->
<div class="grid lg:grid-cols-3 gap-5">
    <!-- Left -->
    <div class="lg:col-span-2 space-y-5">
        <!-- Latest Result -->
        <div class="card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <h2 class="font-display text-sm font-semibold text-slate-900">Hasil Skrining Terakhir</h2>
                @if($latest)
                    <a href="{{ route('mahasiswa.screening.show', $latest) }}" class="text-xs font-medium text-primary-600 hover:text-primary-700 flex items-center gap-1">
                        Lihat detail
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @endif
            </div>
            <div class="p-5">
                @if($latest)
                    <div class="flex items-center gap-2 mb-4">
                        <span class="badge-{{ $latest->risk_level === 'tinggi' ? 'high' : ($latest->risk_level === 'sedang' ? 'med' : 'low') }}">
                            Risiko {{ ucfirst($latest->risk_level) }}
                        </span>
                        <span class="text-xs text-slate-400">{{ $latest->created_at->format('d M Y · H:i') }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 font-medium">Skor HARS</p>
                            <p class="font-display text-2xl font-bold text-slate-900 mt-1">{{ $latest->hars_score ?? '—' }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">dari 56 poin</p>
                        </div>
                        <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 font-medium">Sentimen AI</p>
                            <p class="font-display text-lg font-bold text-slate-900 mt-1">{{ $latest->emotion_label ?? '—' }}</p>
                            @if($latest->emotion_confidence)
                                <p class="text-xs text-slate-400 mt-0.5">{{ number_format($latest->emotion_confidence * 100, 1) }}% keyakinan</p>
                            @endif
                        </div>
                    </div>
                    @if($latest->handling_status === 'ditangani')
                        <div class="mt-3 flex items-center gap-2 rounded-lg bg-green-50 border border-green-200 px-3 py-2.5">
                            <svg class="w-4 h-4 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-xs font-medium text-green-700">Sudah ditangani oleh konselor</span>
                        </div>
                    @elseif($latest->risk_level === 'tinggi')
                        <div class="mt-3 flex items-center gap-2 rounded-lg bg-red-50 border border-red-200 px-3 py-2.5">
                            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            <span class="text-xs font-medium text-red-700">Menunggu penanganan konselor</span>
                        </div>
                    @endif
                @else
                    <div class="text-center py-10">
                        <div class="w-12 h-12 rounded-full bg-primary-50 border border-primary-100 mx-auto mb-3 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <p class="text-sm font-medium text-slate-700 mb-1">Belum ada skrining</p>
                        <p class="text-xs text-slate-400 mb-4">Mulai skrining pertama untuk memantau kondisi emosionalmu</p>
                        <a href="{{ route('mahasiswa.screening.create') }}" class="btn-primary text-xs">Mulai Skrining</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Nav -->
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('mahasiswa.screening.create') }}" class="card p-4 flex items-center gap-3 hover:border-primary-300 hover:shadow-md transition-all group">
                <div class="w-10 h-10 rounded-lg bg-primary-50 border border-primary-100 flex items-center justify-center flex-shrink-0 group-hover:bg-primary-100 transition-colors">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-900">Skrining Baru</p>
                    <p class="text-xs text-slate-400">Tulis curhatan & isi HARS</p>
                </div>
            </a>
            <a href="{{ route('mahasiswa.history') }}" class="card p-4 flex items-center gap-3 hover:border-primary-300 hover:shadow-md transition-all group">
                <div class="w-10 h-10 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center flex-shrink-0 group-hover:bg-slate-100 transition-colors">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-900">Riwayat</p>
                    <p class="text-xs text-slate-400">Lihat perkembangan risiko</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Right -->
    <div class="space-y-4">
        <!-- Tips -->
        <div class="card p-5">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-7 h-7 rounded-lg bg-blue-50 border border-blue-100 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-900">Teknik 4-7-8</p>
                    <p class="text-xs text-slate-400">Pernapasan penenang</p>
                </div>
            </div>
            <div class="space-y-1.5">
                @foreach([['1','Tarik napas','4 detik'],['2','Tahan napas','7 detik'],['3','Hembuskan','8 detik perlahan']] as [$n,$t,$d])
                <div class="flex items-center gap-2.5 rounded-lg bg-slate-50 border border-slate-100 px-3 py-2">
                    <span class="w-5 h-5 rounded-full bg-primary-600 text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0">{{ $n }}</span>
                    <div>
                        <span class="text-xs font-medium text-slate-700">{{ $t }}</span>
                        <span class="text-xs text-slate-400 ml-1">· {{ $d }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Edukasi -->
        <div class="card overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-100">
                <h3 class="text-sm font-semibold text-slate-900">Bacaan Edukasi</h3>
            </div>
            <div class="p-3 space-y-0.5">
                @php $educations = \App\Models\Education::where('is_published', true)->latest()->take(4)->get(); @endphp
                @forelse($educations as $edu)
                    <a href="{{ route('education.show', $edu->slug) }}" class="block px-3 py-2.5 rounded-lg hover:bg-slate-50 transition-colors group">
                        <p class="text-xs font-medium text-slate-700 group-hover:text-primary-700 transition-colors leading-snug">{{ $edu->title }}</p>
                        <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">{{ Str::limit(strip_tags($edu->content), 60) }}</p>
                    </a>
                @empty
                    <p class="text-xs text-slate-400 text-center py-4">Belum ada artikel edukasi</p>
                @endforelse
            </div>
        </div>

        <!-- Darurat -->
        <div class="card p-4 border-red-200 bg-red-50">
            <p class="text-xs font-semibold text-red-700 mb-2 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Butuh Bantuan Darurat?
            </p>
            <div class="grid grid-cols-2 gap-2">
                <a href="tel:119" class="text-xs font-semibold text-center py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-colors">
                    📞 119
                </a>
                <a href="{{ route('mahasiswa.notifikasi.index') }}" class="text-xs font-semibold text-center py-2 rounded-lg bg-white text-red-700 border border-red-200 hover:bg-red-50 transition-colors">
                    Konselor
                </a>
            </div>
        </div>
    </div>
</div>
@endsection