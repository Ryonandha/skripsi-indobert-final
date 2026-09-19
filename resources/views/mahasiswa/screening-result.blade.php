@extends('layouts.app')
@section('title', 'Hasil Skrining')

@php
    $riskStyles = [
        'rendah' => ['bg' => 'bg-primary-50',   'text' => 'text-primary-800', 'border' => 'border-primary-200', 'dot' => 'bg-primary-500'],
        'sedang' => ['bg' => 'bg-warm-50',      'text' => 'text-warm-800',    'border' => 'border-warm-300',    'dot' => 'bg-warm-500'],
        'tinggi' => ['bg' => 'bg-danger-50',    'text' => 'text-danger-800',  'border' => 'border-danger-200',  'dot' => 'bg-danger-500'],
    ];
    $r = $riskStyles[$screening->risk_level];
@endphp

@section('content')
<div class="max-w-4xl mx-auto">

    <!-- Header -->
    <div class="mb-6 flex items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-bold text-calm-900">Hasil Skrining</h1>
            <p class="text-sm text-calm-500 mt-1">Diperiksa {{ $screening->created_at->format('d F Y, H:i') }} WIB</p>
        </div>
        <div class="no-print flex items-center gap-2 flex-shrink-0">
            <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-calm-200 bg-white text-sm font-medium text-calm-700 hover:bg-calm-50 hover:border-calm-300 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Ekspor PDF
            </button>
            <form action="{{ route('mahasiswa.screening.destroy', $screening) }}" method="POST"
                  onsubmit="return confirm('Hapus permanen riwayat skrining ini? Tindakan ini tidak bisa dibatalkan.{{ $screening->consent_followup ? ' Catatan: kamu sudah menyetujui pendampingan konselor untuk riwayat ini — menghapusnya tidak membatalkan proses pendampingan yang sedang berjalan.' : '' }}')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-danger-200 bg-white text-sm font-medium text-danger-600 hover:bg-danger-50 hover:border-danger-300 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <!-- Tingkat Risiko -->
    <div class="rounded-xl border p-6 mb-5 {{ $r['bg'] }} {{ $r['border'] }}">
        <div class="flex flex-col sm:flex-row sm:items-center gap-5">
            @php
                // Map IndoBERT emotion label to mascot image
                $emotionImages = [
                    'fear'      => 'fear.png',
                    'sadness'   => 'saddnes.png',
                    'anger'     => 'anger.png',
                    'happy'     => 'happy.png',
                    'neutral'   => 'non_distres.png',
                    'non_distress' => 'non_distres.png',
                    'joy'       => 'happy.png',
                    'surprise'  => 'awal_menyambut.png',
                ];
                $emotionKey = strtolower($screening->emotion_label ?? '');
                $emotionImg = $emotionImages[$emotionKey] ?? 'awal_menyambut.png';
            @endphp
            <img src="{{ asset('images/' . $emotionImg) }}" alt="{{ $screening->emotion_label }}"
                 class="w-20 h-20 object-contain flex-shrink-0 hidden sm:block"
                 style="mix-blend-mode: multiply;">
            <div class="flex-1">
                <p class="text-xs uppercase tracking-wide {{ $r['text'] }} opacity-70 font-semibold">Tingkat Risiko Kecemasan</p>
                <p class="font-display text-3xl font-bold {{ $r['text'] }} capitalize mt-0.5">{{ $screening->risk_level }}</p>
                @if($screening->emotion_label)
                    <p class="text-sm {{ $r['text'] }} opacity-75 mt-1">
                        Emosi terdeteksi: <b>{{ $screening->emotion_label }}</b>
                        @if($screening->emotion_confidence)
                            · {{ number_format($screening->emotion_confidence * 100, 1) }}% keyakinan
                        @endif
                    </p>
                @endif
            </div>
        </div>
    </div>


    @if($screening->crisis_flag)
        {{-- Dukungan krisis: bahasa menenangkan + langkah nyata --}}
        <div class="rounded-xl border border-danger-300 bg-white p-6 mb-5">
            <div class="flex items-start gap-4">
                <div class="w-11 h-11 rounded-xl bg-danger-50 border border-danger-200 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-danger-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <div class="flex-1">
                    <h2 class="font-display font-semibold text-calm-900">Kamu tidak sendiri — bantuan tersedia sekarang</h2>
                    <p class="text-sm leading-relaxed text-calm-600 mt-1">{{ App\Services\CrisisKeywordService::supportMessage() }}</p>
                    <div class="grid sm:grid-cols-2 gap-3 mt-4">
                        <div class="bg-calm-50 border border-calm-200 rounded-lg p-3.5">
                            <p class="text-xs font-semibold text-calm-500 uppercase tracking-wide">Layanan darurat kesehatan jiwa</p>
                            <p class="font-display font-bold text-calm-900 text-lg mt-1">119 &mdash; tekan 8</p>
                            <p class="text-xs text-calm-500 mt-0.5">SEJIWA (Kemenkes RI), layanan 24 jam, gratis</p>
                        </div>
                        <div class="bg-calm-50 border border-calm-200 rounded-lg p-3.5">
                            <p class="text-xs font-semibold text-calm-500 uppercase tracking-wide">Konseling krisis (Yayasan SETO)</p>
                            <p class="font-display font-bold text-calm-900 text-lg mt-1">0811-1110-222</p>
                            <p class="text-xs text-calm-500 mt-0.5">Chat/telepon, respons cepat setiap hari</p>
                        </div>
                    </div>
                    <p class="text-xs text-calm-500 mt-3">Tim konselor kampus juga telah menerima notifikasi hasil skrining ini.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-5">

        {{-- Komponen penilaian --}}
        <div class="bg-white rounded-xl border border-calm-200 p-5">
            <h2 class="text-xs font-semibold uppercase tracking-wide text-calm-400 mb-4">Komponen Penilaian</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between bg-calm-50 rounded-lg p-3.5 border border-calm-100">
                    <div>
                        <span class="text-xs text-calm-400 block">Emosi dominan — IndoBERT</span>
                        <span class="font-semibold text-calm-900">{{ $screening->emotion_label }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-calm-400 block">Keyakinan model</span>
                        <span class="font-semibold tabular-nums text-calm-900">{{ number_format($screening->emotion_confidence * 100, 1) }}%</span>
                    </div>
                </div>

                @if($screening->emotion_probabilities)
                    <div>
                        <span class="text-xs text-calm-400">Distribusi emosi:</span>
                        <div class="mt-2 space-y-2">
                            @foreach($screening->emotion_probabilities as $label => $prob)
                                <div class="flex items-center gap-3">
                                    <span class="w-20 text-xs text-calm-600">{{ $label }}</span>
                                    <div class="flex-1 h-1.5 bg-calm-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-primary-500 rounded-full" style="width: {{ number_format($prob * 100, 1) }}%"></div>
                                    </div>
                                    <span class="w-12 text-right text-xs tabular-nums text-calm-500">{{ number_format($prob * 100, 1) }}%</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-between bg-calm-50 rounded-lg p-3.5 border border-calm-100">
                    <div>
                        <span class="text-xs text-calm-400 block">Skor HARS — instrumen klinis</span>
                        <span class="font-semibold text-calm-900">{{ $screening->hars_score }}/56</span>
                    </div>
                    <span class="text-xs px-2.5 py-1 rounded-full bg-white border border-calm-200 text-calm-600 font-medium">
                        @if($screening->hars_score < 14) Tidak cemas @elseif($screening->hars_score < 21) Ringan @elseif($screening->hars_score < 28) Sedang @else Berat @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Rekomendasi --}}
        <div class="bg-white rounded-xl border border-calm-200 p-5 flex flex-col">
            <h2 class="text-xs font-semibold uppercase tracking-wide text-calm-400 mb-4">Saran Tindak Lanjut</h2>
            <p class="text-sm leading-relaxed text-calm-700">{{ $screening->recommendation }}</p>

            @if(in_array($screening->risk_level, ['sedang','tinggi']) && !$screening->consent_followup)
                <div class="mt-auto pt-5 border-t border-calm-100 mt-5">
                    <form method="POST" action="{{ route('mahasiswa.consent', $screening) }}">
                        @csrf
                        <p class="text-sm text-calm-600 mb-3">Apakah kamu bersedia dihubungi Konselor Kampus untuk pendampingan?</p>
                        <button class="w-full bg-primary-700 hover:bg-primary-800 text-white rounded-xl px-4 py-2.5 text-sm font-semibold transition-colors">
                            Ya, saya setuju didampingi
                        </button>
                    </form>
                </div>
            @elseif($screening->consent_followup)
                <div class="mt-5 bg-primary-50 border border-primary-200 rounded-xl p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-primary-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <p class="text-sm text-primary-800">Permintaan pendampingan terkirim. Konselor kampus akan menghubungimu.</p>
                </div>
            @endif
        </div>
    </div>

    <p class="text-xs text-calm-400 text-center mt-8">
        Hasil ini adalah skrining awal, bukan diagnosis medis.
        <a href="{{ route('mahasiswa.history') }}" class="text-primary-700 hover:underline">Lihat riwayat skrining →</a>
    </p>
</div>
@endsection

@push('styles')
<style>
    /* Mode cetak/PDF: sembunyikan chrome aplikasi, sisakan laporan */
    @media print {
        aside, header, footer, .no-print { display: none !important; }
        .lg\:ml-64 { margin-left: 0 !important; }
        main { padding: 0 !important; }
        @page { size: A4 portrait; margin: 16mm; }
        * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
</style>
@endpush
