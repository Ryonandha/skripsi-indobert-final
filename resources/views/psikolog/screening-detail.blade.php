@extends('layouts.app')
@section('title', 'Detail Skrining Pasien')

@php
    $riskStyles = [
        'rendah' => ['bg' => 'bg-primary-50',   'text' => 'text-primary-800', 'border' => 'border-primary-200', 'dot' => 'bg-primary-500'],
        'sedang' => ['bg' => 'bg-warm-50',      'text' => 'text-warm-800',    'border' => 'border-warm-300',    'dot' => 'bg-warm-500'],
        'tinggi' => ['bg' => 'bg-danger-50',    'text' => 'text-danger-800',  'border' => 'border-danger-200',  'dot' => 'bg-danger-500'],
    ];
    $r = $riskStyles[$screening->risk_level] ?? ['bg' => 'bg-calm-50', 'text' => 'text-calm-800', 'border' => 'border-calm-200', 'dot' => 'bg-calm-500'];
    $harsLabel = $screening->hars_score < 14 ? 'Tidak cemas'
               : ($screening->hars_score < 21 ? 'Ringan'
               : ($screening->hars_score < 28 ? 'Sedang' : 'Berat'));
@endphp

@section('content')
<div class="max-w-4xl mx-auto">

    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('psikolog.patient-detail', $student) }}"
           class="inline-flex items-center gap-2 text-sm text-calm-500 hover:text-calm-700 mb-4 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke {{ $student->name }}
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="font-display text-2xl font-bold text-calm-900">Hasil Skrining</h1>
                <p class="text-sm text-calm-500 mt-1">{{ $screening->created_at->setTimezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB</p>
            </div>
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border text-sm font-medium w-fit {{ $r['bg'] }} {{ $r['text'] }} {{ $r['border'] }}">
                <span class="w-2 h-2 rounded-full {{ $r['dot'] }}"></span>
                Risiko {{ ucfirst($screening->risk_level) }}
            </span>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-5">

        <!-- Identitas pasien -->
        <div class="bg-white rounded-xl border border-calm-200 p-5">
            <h2 class="text-xs font-semibold uppercase tracking-wide text-calm-400 mb-4">Pasien</h2>
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-primary-100 flex items-center justify-center">
                    <span class="font-display font-bold text-primary-700">{{ strtoupper($student->name[0]) }}</span>
                </div>
                <div>
                    <p class="font-semibold text-calm-900">{{ $student->name }}</p>
                    <p class="text-sm text-calm-500">NIM {{ $student->nim }}</p>
                </div>
            </div>
            <dl class="mt-4 pt-4 border-t border-calm-100 space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-calm-500">Consent tindak lanjut</dt><dd class="font-medium {{ $screening->consent_followup ? 'text-primary-700' : 'text-calm-700' }}">{{ $screening->consent_followup ? 'Ya' : 'Belum' }}</dd></div>
                <div class="flex justify-between"><dt class="text-calm-500">Status penanganan</dt><dd class="font-medium text-calm-700 capitalize">{{ $screening->handling_status }}</dd></div>
            </dl>
        </div>

        <!-- Ringkasan klinis -->
        <div class="bg-white rounded-xl border border-calm-200 p-5">
            <h2 class="text-xs font-semibold uppercase tracking-wide text-calm-400 mb-4">Ringkasan Penilaian</h2>
            <div class="grid grid-cols-2 gap-3">
                <div class="rounded-lg bg-calm-50 p-3">
                    <p class="text-xs text-calm-500 mb-1">Emosi dominan</p>
                    <p class="font-display font-bold text-lg text-calm-900">{{ $screening->emotion_label }}</p>
                    <p class="text-xs text-primary-700 mt-0.5">{{ number_format($screening->emotion_confidence * 100, 1) }}% keyakinan model</p>
                </div>
                <div class="rounded-lg bg-calm-50 p-3">
                    <p class="text-xs text-calm-500 mb-1">Skor HARS</p>
                    <p class="font-display font-bold text-lg text-calm-900">{{ $screening->hars_score }}<span class="text-sm text-calm-400 font-normal">/56</span></p>
                    <p class="text-xs text-calm-500 mt-0.5">Kategori {{ strtolower($harsLabel) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribusi emosi -->
    @if($screening->emotion_probabilities)
    <div class="mt-5 bg-white rounded-xl border border-calm-200 p-5">
        <h2 class="text-xs font-semibold uppercase tracking-wide text-calm-400 mb-4">Distribusi Emosi (IndoBERT)</h2>
        <div class="space-y-2.5">
            @foreach($screening->emotion_probabilities as $label => $prob)
                <div class="flex items-center gap-3">
                    <span class="w-20 text-sm text-calm-600">{{ $label }}</span>
                    <div class="flex-1 h-1.5 bg-calm-100 rounded-full overflow-hidden">
                        <div class="h-full bg-primary-500 rounded-full" style="width: {{ number_format($prob * 100, 1) }}%"></div>
                    </div>
                    <span class="w-14 text-right text-xs tabular-nums text-calm-500">{{ number_format($prob * 100, 1) }}%</span>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Rekomendasi sistem + catatan penanganan -->
    <div class="mt-5 grid md:grid-cols-2 gap-5">
        <div class="bg-white rounded-xl border border-calm-200 p-5">
            <h2 class="text-xs font-semibold uppercase tracking-wide text-calm-400 mb-3">Rekomendasi Sistem</h2>
            <p class="text-sm leading-relaxed text-calm-700">{{ $screening->recommendation }}</p>
        </div>
        <div class="bg-white rounded-xl border border-calm-200 p-5">
            <h2 class="text-xs font-semibold uppercase tracking-wide text-calm-400 mb-3">Update Penanganan</h2>
            <form method="POST" action="{{ route('psikolog.handling', $screening) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-calm-600 mb-1">Status Penanganan</label>
                    <select name="handling_status" class="w-full px-3 py-2 border border-calm-200 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none text-sm">
                        @foreach(['belum','diproses','selesai'] as $st)
                            <option value="{{ $st }}" {{ $screening->handling_status === $st ? 'selected' : '' }}>
                                {{ ucfirst($st) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-calm-600 mb-1">Catatan Progres</label>
                    <textarea name="handling_notes" rows="3"
                              placeholder="Tulis catatan sesi konseling, observasi, dll."
                              class="w-full px-3 py-2 border border-calm-200 rounded-lg focus:ring-2 focus:ring-primary-500 outline-none text-sm resize-none">{{ $screening->handling_notes }}</textarea>
                </div>
                <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium transition-colors w-full sm:w-auto">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>

    <p class="text-xs text-calm-400 text-center mt-8 mb-2">
        Catatan privasi: isi curahan mahasiswa bersifat rahasia dan tidak ditampilkan pada halaman ini.
        Gunakan sesi konseling untuk menggali lebih dalam.
    </p>
</div>
@endsection
