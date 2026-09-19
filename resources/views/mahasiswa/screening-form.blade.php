@extends('layouts.app')
@section('title', 'Skrining Baru')

@push('styles')
<style>
    /* Radio button HARS — override peer-checked dengan class langsung */
    .hars-btn { display: block; width: 40px; height: 40px; border-radius: 8px; border: 1px solid #e2e8f0; text-align: center; line-height: 38px; font-size: 0.875rem; color: #475569; cursor: pointer; transition: all 0.15s; user-select: none; }
    .hars-btn:hover { background: #eff6ff; border-color: #93c5fd; color: #1d4ed8; }
    .hars-btn.selected { background: #0284c7; border-color: #0284c7; color: #fff; font-weight: 700; }

    /* Loading overlay fullscreen */
    #loadingOverlay { position: fixed; inset: 0; z-index: 9998; background: rgba(255,255,255,0.97); display: none; flex-direction: column; align-items: center; justify-content: center; gap: 16px; }
    #loadingOverlay.show { display: flex; }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
    #loadingOverlay img { animation: float 1.5s ease-in-out infinite; }
    @keyframes ldot { 0%,80%,100%{transform:scale(0.6);opacity:.4} 40%{transform:scale(1);opacity:1} }
    .ldot { width:8px;height:8px;border-radius:50%;background:#0284c7;display:inline-block; }
    .ldot:nth-child(1){animation:ldot 1.2s 0s infinite}
    .ldot:nth-child(2){animation:ldot 1.2s .2s infinite}
    .ldot:nth-child(3){animation:ldot 1.2s .4s infinite}
</style>
@endpush

@section('content')

<!-- Loading overlay fullscreen -->
<div id="loadingOverlay">
    <img src="{{ asset('images/loding.png') }}" alt="Menganalisis..." style="width:160px;height:160px;object-fit:contain;mix-blend-mode:multiply;">
    <div style="text-align:center;">
        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:1.125rem;color:#0f172a;margin-bottom:6px;">Sedang menganalisis...</p>
        <p style="font-size:0.8125rem;color:#64748b;">IndoBERT sedang membaca ceritamu</p>
    </div>
    <div style="display:flex;gap:6px;margin-top:4px;">
        <span class="ldot"></span>
        <span class="ldot"></span>
        <span class="ldot"></span>
    </div>
</div>

<div class="max-w-2xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="font-display text-xl font-bold text-slate-900">Skrining Risiko Kecemasan</h1>
        <p class="text-sm text-slate-500 mt-0.5">Dua langkah. Kurang dari 10 menit. Data terenkripsi.</p>
    </div>

    @if($errors->any())
        <div class="mb-4 rounded-lg px-4 py-3 text-sm" style="background:#fff1f2;border:1px solid #fecdd3;color:#be123c;">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('mahasiswa.screening.store') }}" id="screeningForm" class="space-y-5">
        @csrf

        {{-- LANGKAH 1: Tulis Curhatan --}}
        <div class="card overflow-hidden">
            <div class="flex items-start gap-4 p-5 border-b border-slate-100">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm font-bold flex-shrink-0" style="background:#0284c7;">1</div>
                <div class="flex-1">
                    <h2 class="font-display text-sm font-semibold text-slate-900">Tulis Curhatanmu</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Gunakan bahasa sehari-hari. Minimal 20 karakter. Teks dienkripsi — hanya AI yang menganalisis.</p>
                </div>
                <img src="{{ asset('images/analisis_curhat.png') }}" alt="" class="w-14 h-14 object-contain flex-shrink-0 hidden sm:block" style="mix-blend-mode:multiply;">
            </div>
            <div class="p-5">
                <textarea id="narrativeInput" name="narrative" rows="5" required minlength="20" maxlength="1000"
                          placeholder="Ceritakan apa yang paling membebani pikiran atau perasaanmu akhir-akhir ini..."
                          class="input-field resize-none" style="line-height:1.6;">{{ old('narrative') }}</textarea>
                <div class="flex justify-between items-center mt-1.5">
                    <span id="charHint" class="text-xs text-slate-400"></span>
                    <span id="charCount" class="text-xs text-slate-400">{{ strlen(old('narrative','')) }} / 1000 karakter</span>
                </div>
                @error('narrative') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- LANGKAH 2: HARS --}}
        <div class="card overflow-hidden">
            <div class="flex items-center gap-4 p-5 border-b border-slate-100">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm font-bold flex-shrink-0" style="background:#0284c7;">2</div>
                <div class="flex-1">
                    <h2 class="font-display text-sm font-semibold text-slate-900">Kuesioner HARS (14 pertanyaan)</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Jawab sesuai kondisimu <b>dalam 1 minggu terakhir</b>.</p>
                </div>
            </div>

            @if($canFillHars)
                <!-- Progress bar -->
                <div class="px-5 pt-4 pb-2">
                    <div class="flex justify-between text-xs text-slate-400 mb-1.5">
                        <span>Progres pengisian</span>
                        <span>Terisi <b id="answeredCount" class="text-primary-700">0</b> dari 14</span>
                    </div>
                    <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div id="progressBar" class="h-full rounded-full transition-all duration-300" style="background:#0284c7;width:0%"></div>
                    </div>
                </div>

                <!-- Scale legend -->
                <div class="mx-5 mb-4 bg-slate-50 border border-slate-100 rounded-lg px-3 py-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">
                    @foreach(['Tidak ada','Ringan','Sedang','Berat','Sangat berat'] as $idx => $label)
                        <span><b class="text-slate-700">{{ $idx }}</b> {{ $label }}</span>
                    @endforeach
                </div>

                <div class="px-5 pb-5 space-y-5">
                    @foreach($harsItems as $i => $item)
                        <div class="{{ !$loop->last ? 'border-b border-slate-100 pb-5' : '' }}">
                            <p class="text-sm font-semibold text-slate-800">{{ $i+1 }}. {{ $item['nama'] }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $item['gejala'] }}</p>
                            <p class="text-xs text-primary-600 mt-1.5 flex items-start gap-1.5">
                                <svg class="w-3.5 h-3.5 mt-px flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $item['contoh'] }}
                            </p>
                            <div class="flex gap-2 mt-2.5" data-hars-group="{{ $item['id'] }}">
                                @for($s = 0; $s <= 4; $s++)
                                    @php $old = old('hars.'.$item['id']); @endphp
                                    <!-- Hidden radio -->
                                    <input type="radio" name="hars[{{ $item['id'] }}]" value="{{ $s }}"
                                           id="hars_{{ $item['id'] }}_{{ $s }}"
                                           {{ $old !== null && (int)$old === $s ? 'checked' : '' }}
                                           class="sr-only hars-opt">
                                    <!-- Visual button -->
                                    <label for="hars_{{ $item['id'] }}_{{ $s }}"
                                           class="hars-btn {{ $old !== null && (int)$old === $s ? 'selected' : '' }}"
                                           data-val="{{ $s }}">{{ $s }}</label>
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-5">
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-sm text-amber-800">
                        Kuesioner HARS sedang dalam masa cooldown (boleh diisi ulang setiap 2 minggu).
                        Sistem akan menggunakan skor HARS terakhirmu: <b>{{ auth()->user()->screenings()->whereNotNull('hars_score')->latest()->value('hars_score') }}/56</b>.
                        @if(isset($nextHarsAt)) Bisa diisi ulang mulai {{ $nextHarsAt }}. @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" id="submitBtn" class="btn-primary w-full justify-center py-3 text-base">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Analisis Sekarang
        </button>
    </form>
</div>

@push('scripts')
<script>
// ── Character counter real-time ──
var narrative = document.getElementById('narrativeInput');
var charCount = document.getElementById('charCount');
var charHint  = document.getElementById('charHint');

function updateCounter() {
    var len = narrative.value.length;
    charCount.textContent = len + ' / 1000 karakter';
    if (len < 20) {
        charHint.textContent = 'Minimal ' + (20 - len) + ' karakter lagi';
        charHint.style.color = '#ef4444';
    } else {
        charHint.textContent = '✓ Siap dianalisis';
        charHint.style.color = '#16a34a';
    }
}
narrative.addEventListener('input', updateCounter);
updateCounter(); // init

// ── HARS radio buttons ──
var answered = 0;
var oldAnswered = document.querySelectorAll('.hars-opt:checked').length;
answered = oldAnswered;

function updateProgress() {
    document.getElementById('answeredCount').textContent = answered;
    document.getElementById('progressBar').style.width = (answered / 14 * 100) + '%';
}
updateProgress();

document.querySelectorAll('[data-hars-group]').forEach(function(group) {
    var labels = group.querySelectorAll('.hars-btn');
    var radios = group.querySelectorAll('.hars-opt');
    var wasAnswered = false;
    radios.forEach(function(r) { if (r.checked) wasAnswered = true; });

    labels.forEach(function(label, idx) {
        label.addEventListener('click', function() {
            var wasEmpty = !wasAnswered;
            // Deselect all in group
            labels.forEach(function(l) { l.classList.remove('selected'); });
            // Select clicked
            label.classList.add('selected');
            radios[idx].checked = true;
            if (wasEmpty) { answered++; wasAnswered = true; updateProgress(); }
        });
    });
});

// ── Loading overlay fullscreen ──
document.getElementById('screeningForm').addEventListener('submit', function(e) {
    document.getElementById('loadingOverlay').classList.add('show');
    // Do not disable submitBtn here as it can cancel the form submission in Safari/Chrome.
    // The overlay has z-index 9998 and covers the entire screen, preventing double clicks.
});
</script>
@endpush
@endsection
