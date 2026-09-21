@extends('layouts.app')
@section('title', 'Detail Pasien')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('psikolog.patients') }}" class="inline-flex items-center gap-2 text-calm-500 hover:text-calm-700 text-sm font-medium mb-6 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Pasien
        </a>

        <div class="bg-white rounded-2xl shadow-card border border-calm-100 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                <div class="w-20 h-20 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
                    <span class="font-display font-bold text-primary-700 text-2xl">{{ strtoupper($student->name[0]) }}</span>
                </div>
                <div class="flex-1">
                    <h1 class="font-display text-2xl font-bold text-calm-900">{{ $student->name }}</h1>
                    <div class="flex flex-wrap gap-3 mt-3 text-sm">
                        <span class="px-3 py-1 bg-calm-100 text-calm-700 rounded-full">NIM: {{ $student->nim }}</span>
                        <span class="px-3 py-1 bg-calm-100 text-calm-700 rounded-full">{{ $student->email }}</span>
                        @if($student->phone)
                            <span class="px-3 py-1 bg-calm-100 text-calm-700 rounded-full">{{ $student->phone }}</span>
                        @endif
                        <span class="px-3 py-1 bg-primary-100 text-primary-700 rounded-full">Terdaftar: {{ $student->created_at->setTimezone('Asia/Jakarta')->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section (Proactive) -->
    @if($latestScreening)
    <div id="contact" class="mb-6 bg-warm-50 rounded-2xl shadow-card border border-warm-200 p-6">
        <h2 class="font-display text-xl font-semibold text-warm-800 flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-warm-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            Hubungi Mahasiswa (Proaktif)
        </h2>
        <p class="text-warm-700 text-sm mb-4">Kirim undangan konseling ke mahasiswa ini. Cocok untuk kasus risiko tinggi yang belum consent atau follow-up rutin.</p>
        <form method="POST" action="{{ route('psikolog.contact', $latestScreening) }}" class="space-y-4">
            @csrf
            <input type="hidden" name="screening_id" value="{{ $latestScreening->id }}">
            <textarea name="message" rows="4" required
                      placeholder="Tulis pesan undangan konseling (contoh: Halo [Nama], aku konselor kampus. Ingin mengajakmu sesi konseling singkat minggu ini. Kapan waktu yang cocok untukmu?)"
                      class="w-full px-4 py-3 border border-warm-300 rounded-xl focus:ring-2 focus:ring-warm-500 focus:border-warm-500 outline-none text-sm resize-none"></textarea>
            <button type="submit" class="inline-flex justify-center items-center gap-2 px-5 py-2.5 bg-warm-600 hover:bg-warm-700 text-white rounded-xl font-medium transition-colors w-full sm:w-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Kirim Email Undangan
            </button>
        </form>
    </div>
    @endif

    <!-- Riwayat Percakapan & Balasan Mahasiswa -->
    @if(isset($messages) && $messages->count())
    <div id="percakapan" class="mb-6 bg-white rounded-2xl shadow-card border border-calm-100 p-6">
        <h2 class="font-display text-lg font-semibold text-calm-900 flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            Riwayat Komunikasi & Balasan Mahasiswa
            <span class="text-xs px-2 py-0.5 rounded-full bg-calm-100 text-calm-600 font-normal">({{ $messages->count() }} pesan)</span>
        </h2>
        <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
            @foreach($messages as $m)
                @if($m->is_from_student)
                    {{-- Balasan dari Mahasiswa --}}
                    <div class="bg-primary-50 border border-primary-200 rounded-xl p-4 mr-4 sm:mr-8">
                        <div class="flex items-center justify-between text-xs text-primary-800 font-semibold mb-1">
                            <span class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-primary-600"></span>
                                Balasan dari {{ $student->name }} (Mahasiswa)
                            </span>
                            <span class="text-calm-400 font-normal">{{ $m->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</span>
                        </div>
                        <p class="text-calm-800 text-sm whitespace-pre-line leading-relaxed mt-1">{{ $m->body }}</p>
                    </div>
                @else
                    {{-- Pesan dari Psikolog --}}
                    <div class="bg-calm-50 border border-calm-200 rounded-xl p-4 ml-4 sm:ml-8">
                        <div class="flex items-center justify-between text-xs text-calm-600 font-semibold mb-1">
                            <span>Undangan dari: {{ $m->psychologist->name ?? 'Konselor' }}</span>
                            <span class="text-calm-400 font-normal">{{ $m->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</span>
                        </div>
                        <p class="text-calm-700 text-sm whitespace-pre-line leading-relaxed mt-1">{{ $m->body }}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    <!-- Screening History Timeline -->
    <div class="bg-white rounded-2xl shadow-card border border-calm-100 overflow-hidden overflow-x-auto">
        <div class="p-5 border-b border-calm-100">
            <h2 class="font-display text-xl font-semibold text-calm-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0l1-1m-1 1l-1-1"/></svg>
                Riwayat Skrining
            </h2>
        </div>

        <div class="divide-y divide-calm-100">
            @forelse($screenings as $index => $s)
                <?php
                    $rc = ['rendah'=>'bg-primary-50 text-primary-700 border-primary-200',
                           'sedang'=>'bg-warm-50 text-warm-700 border-warm-200',
                           'tinggi'=>'bg-danger-50 text-danger-700 border-danger-200'][$s->risk_level];
                ?>
                <div class="p-5 relative">
                    <!-- Timeline dot -->
                    <div class="absolute left-0 top-5 h-full w-px bg-calm-200 {{ $loop->last ? 'hidden' : '' }}"></div>
                    <div class="absolute left-0 top-5 w-3 h-3 rounded-full bg-primary-600 border-2 border-white z-10"></div>

                    <div class="ml-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl {{ $rc }} flex items-center justify-center flex-shrink-0">
                                    <span class="font-display font-semibold text-sm capitalize">{{ $s->risk_level }}</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-calm-900">{{ $s->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                                    <p class="text-sm text-calm-500">Emosi: {{ $s->emotion_label }} ({{ number_format($s->emotion_confidence*100,0) }}%) • HARS: {{ $s->hars_score }}/56</p>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center gap-2 sm:ml-auto">
                                @if($s->consent_followup)
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary-50 text-primary-700 text-xs font-semibold rounded-full"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>Consent Diberikan</span>
                                @else
                                    <span class="px-3 py-1 bg-calm-100 text-calm-600 text-xs font-semibold rounded-full">Belum Consent</span>
                                @endif
                                @if($s->handling_status !== 'belum')
                                    <span class="px-3 py-1 bg-{{ $s->handling_status === 'selesai' ? 'primary' : 'warm' }}-50 text-{{ $s->handling_status === 'selesai' ? 'primary' : 'warm' }}-700 text-xs font-semibold rounded-full">
                                        {{ ucfirst($s->handling_status) }}
                                    </span>
                                @endif
                                <a href="{{ route('psikolog.screening-detail', $s) }}"
                                   class="px-3 py-1.5 text-xs font-medium text-primary-700 border border-primary-200 rounded-lg hover:bg-primary-50 transition-colors">Lihat Detail Skrining</a>
                            </div>
                        </div>

                        @if($s->handling_notes)
                            <div class="mt-4 ml-4 pl-4 border-l-2 border-calm-200">
                                <p class="text-sm text-calm-600">{{ $s->handling_notes }}</p>
                                <p class="text-xs text-calm-400 mt-1">Oleh: {{ $s->handler->name ?? '—' }} • {{ $s->updated_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <p class="text-calm-500">Belum ada riwayat skrining</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Handling Notes Form (untuk update status & catatan) -->
    @if($latestScreening)
    <div class="mt-6 bg-white rounded-2xl shadow-card border border-calm-100 p-6">
        <h2 class="font-display text-lg font-semibold text-calm-900 mb-4">Update Penanganan</h2>
        <form method="POST" action="{{ route('psikolog.handling', $latestScreening) }}" class="space-y-4">
            @csrf
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-calm-700 mb-1">Status Penanganan</label>
                    <select name="handling_status" class="w-full px-4 py-2.5 border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none">
                        @foreach(['belum','diproses','selesai'] as $st)
                            <option value="{{ $st }}" {{ $latestScreening->handling_status === $st ? 'selected' : '' }}>
                                {{ ucfirst($st) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-calm-700 mb-1">Catatan Progres</label>
                <textarea name="handling_notes" rows="4"
                          placeholder="Tulis catatan sesi konseling, observasi, rekomendasi, dll."
                          class="w-full px-4 py-3 border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none text-sm resize-none">{{ $latestScreening->handling_notes }}</textarea>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium transition-colors">
                Simpan Perubahan
            </button>
        </form>
    </div>
    @endif
</div>
@endsection
