@extends('layouts.app')
@section('title', 'Kelola Pasien')

@section('content')
<div class="animate-fade-in">
    <!-- Header + Filter -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="font-display text-3xl font-bold text-calm-900">Kelola Pasien</h1>
                <p class="text-calm-500 mt-1">Daftar semua mahasiswa. Filter, cari, dan hubungi proaktif.</p>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white rounded-2xl shadow-card border border-calm-100 p-4">
            <form method="GET" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1 sm:w-64">
                    <label class="sr-only" for="search">Cari nama/NIM/email</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-calm-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" id="search"
                               value="{{ request('search') }}"
                               placeholder="Cari nama, NIM, email..."
                               class="w-full pl-10 pr-4 py-2.5 border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none text-sm"
                               autocomplete="off">
                    </div>
                </div>

                <select name="risk" class="sm:w-40 px-4 py-2.5 border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none text-sm bg-white"
                        onchange="this.form.submit()">
                    <option value="">Semua Risiko</option>
                    @foreach(['tinggi', 'sedang', 'rendah'] as $r)
                        <option value="{{ $r }}" {{ request('risk') === $r ? 'selected' : '' }}>
                            Risiko {{ ucfirst($r) }}
                        </option>
                    @endforeach
                </select>

                <select name="consent_only" class="sm:w-40 px-4 py-2.5 border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none text-sm bg-white"
                        onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="1" {{ request('consent_only') ? 'selected' : '' }}>Sudah Consent</option>
                </select>

                @if(request()->hasAny(['search', 'risk', 'consent_only']))
                    <a href="{{ route('psikolog.patients') }}"
                       class="px-4 py-2.5 text-calm-600 hover:text-calm-900 text-sm font-medium flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Patient Cards -->
    <div class="space-y-4">
        @forelse($query as $student)
            @php
                $latestScreening = $student->screenings->first();
                $hasHighRisk = $student->screenings->contains('risk_level', 'tinggi');
                $hasConsent = $student->screenings->contains('consent_followup', true);
            @endphp
            <div class="bg-white rounded-2xl shadow-card border border-calm-100 overflow-hidden hover:shadow-card-hover transition-shadow duration-300">
                <div class="p-5">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                        <!-- Avatar & Info -->
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            <div class="w-14 h-14 rounded-full bg-primary-100 flex items-center justify-center flex-shrink-0">
                                <span class="font-display font-bold text-primary-700 text-lg">{{ strtoupper($student->name[0]) }}</span>
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-3 flex-wrap">
                                    <h3 class="font-semibold text-calm-900 truncate">{{ $student->name }}</h3>
                                    @if($hasHighRisk)
                                        <span class="px-2 py-0.5 bg-danger-50 text-danger-700 text-xs font-semibold rounded-full">Risiko Tinggi</span>
                                    @elseif($latestScreening && $latestScreening->risk_level === 'sedang')
                                        <span class="px-2 py-0.5 bg-warm-50 text-warm-700 text-xs font-semibold rounded-full">Risiko Sedang</span>
                                    @endif
                                    @if($hasConsent)
                                        <span class="px-2 py-0.5 bg-primary-50 text-primary-700 text-xs font-semibold rounded-full">Consent</span>
                                    @endif
                                </div>
                                <p class="text-sm text-calm-500 mt-1 truncate">NIM: {{ $student->nim }} • {{ $student->phone ?? $student->email }}</p>
                            </div>
                        </div>

                        <!-- Latest Screening Summary -->
                        @if($latestScreening)
                            <div class="flex flex-wrap items-center gap-3 px-4 py-3 bg-calm-50 rounded-xl sm:w-auto">
                                <div class="text-center sm:text-left min-w-[140px]">
                                    <p class="text-xs text-calm-500">Emosi Dominan</p>
                                    <p class="font-semibold text-calm-900">{{ $latestScreening->emotion_label }}</p>
                                    <p class="text-xs text-calm-500">{{ number_format($latestScreening->emotion_confidence*100,0) }}% confidence</p>
                                </div>
                                <div class="w-px h-8 bg-calm-200 mx-3 sm:my-0 hidden sm:block"></div>
                                <div class="text-center sm:text-left min-w-[100px]">
                                    <p class="text-xs text-calm-500">Skor HARS</p>
                                    <p class="font-display text-lg font-bold text-calm-900">{{ $latestScreening->hars_score }}/56</p>
                                </div>
                                <div class="w-px h-8 bg-calm-200 mx-3 sm:my-0 hidden sm:block"></div>
                                <div class="text-center sm:text-left min-w-[140px]">
                                    <?php $rc = ['rendah'=>'bg-primary-50 text-primary-700','sedang'=>'bg-warm-50 text-warm-700','tinggi'=>'bg-danger-50 text-danger-700'][$latestScreening->risk_level] ?? 'bg-calm-50 text-calm-700'; ?>
                                    <p class="text-xs text-calm-500">Risk Level</p>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $rc }}">
                                        {{ ucfirst($latestScreening->risk_level) }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex flex-wrap gap-2 sm:ml-auto">
                            <a href="{{ route('psikolog.patient-detail', $student) }}"
                               class="px-4 py-2 bg-calm-100 hover:bg-calm-200 text-calm-700 rounded-xl text-sm font-medium transition-colors flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Detail
                            </a>

                            @if($hasConsent)
                                <a href="{{ route('psikolog.patient-detail', $student) }}#contact"
                                   class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-medium transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    Hubungi
                                </a>
                            @else
                                @if($latestScreening && in_array($latestScreening->risk_level, ['sedang','tinggi']))
                                    <button onclick="openContactModal({{ $student->id }}, '{{ $student->name }}', '{{ $latestScreening->id }}')"
                                            class="px-4 py-2 bg-warm-600 hover:bg-warm-700 text-white rounded-xl text-sm font-medium transition-colors flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        Hubungi Proaktif
                                    </button>
                                @else
                                    <button disabled class="px-4 py-2 bg-calm-100 text-calm-400 rounded-xl text-sm font-medium cursor-not-allowed flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Belum Butuh
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-card border border-calm-100 p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-calm-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-calm-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="font-display text-lg font-semibold text-calm-900 mb-1">Tidak ada data mahasiswa</h3>
                <p class="text-calm-500 text-sm">Coba ubah filter pencarian</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($query->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $query->links() }}
        </div>
    @endif
</div>

<!-- Contact Modal (JavaScript polos — tanpa ketergantungan framework) -->
<div id="contact-modal" class="fixed inset-0 z-50 hidden">
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" data-close-contact></div>
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full relative z-10">
            <div class="p-5 border-b border-calm-100 flex items-center justify-between">
                <h2 class="font-display text-xl font-semibold text-calm-900">Hubungi Mahasiswa</h2>
                <button type="button" data-close-contact class="p-1 rounded-lg hover:bg-calm-100 text-calm-500" aria-label="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <p class="px-5 pt-5 text-sm text-calm-600">Kirim undangan konseling ke <strong id="contact-student-name"></strong> (proaktif). Pesan ini akan dikirim via notifikasi sistem.</p>
            <form method="POST" action="" id="contact-form" class="p-5 space-y-4">
                @csrf
                <input type="hidden" name="student_id" value="">
                <input type="hidden" name="screening_id" value="">
                <textarea name="message" rows="4" required
                          placeholder="Tulis pesan singkat (contoh: Halo, aku konselor kampus. Mau nggak kita jadwalin sesi konseling singkat minggu ini?)"
                          class="w-full px-4 py-3 border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none text-sm resize-none"></textarea>
                <div class="flex gap-3 pt-2">
                    <button type="button" data-close-contact class="flex-1 px-4 py-2.5 bg-calm-100 hover:bg-calm-200 text-calm-700 rounded-xl font-medium transition-colors">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium transition-colors">Kirim Undangan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    (function () {
        var modal = document.getElementById('contact-modal');
        var form = document.getElementById('contact-form');
        var action = '{{ route('psikolog.contact', ':sid') }}';

        function openModal(studentId, studentName, screeningId) {
            form.setAttribute('action', action.replace(':sid', screeningId));
            form.querySelector('input[name=student_id]').value = studentId;
            form.querySelector('input[name=screening_id]').value = screeningId;
            document.getElementById('contact-student-name').textContent = studentName;
            modal.classList.remove('hidden');
            var ta = form.querySelector('textarea');
            if (ta) ta.focus();
        }
        function closeModal() { modal.classList.add('hidden'); }

        window.openContactModal = openModal;

        document.querySelectorAll('[data-close-contact]').forEach(function (el) {
            el.addEventListener('click', closeModal);
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });
    })();
</script>
@endpush