@extends('layouts.app')
@section('title', 'Skrining Baru')

@section('content')
<div class="max-w-2xl mx-auto">

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="font-display text-xl font-bold text-slate-900">Skrining Risiko Kecemasan</h1>
        <p class="text-sm text-slate-500 mt-0.5">Dua langkah. Kurang dari 10 menit. Data terenkripsi — hanya AI yang membaca.</p>
    </div>

    @if($errors->any())
        <div class="mb-4 rounded-lg px-4 py-3 text-sm" style="background:#fff1f2; border:1px solid #fecdd3; color:#be123c;">
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
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm font-bold flex-shrink-0" style="background: #0284c7;">1</div>
                <div class="flex-1">
                    <h2 class="font-display text-sm font-semibold text-slate-900">Tulis Curhatanmu</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Gunakan bahasa sehari-hari. Minimal 20 karakter. Teks ini dienkripsi — tidak dibaca siapa pun, hanya dianalisis AI.</p>
                </div>
                <img src="{{ asset('images/analisis_curhat.png') }}" alt="" class="w-16 h-16 object-contain flex-shrink-0 hidden sm:block" style="mix-blend-mode: multiply;">
            </div>
            <div class="p-5">
                <textarea name="narrative" rows="5" required minlength="20" maxlength="1000"
                          placeholder="Ceritakan apa yang paling membebani pikiran atau perasaanmu akhir-akhir ini..."
                          class="input-field resize-none" style="line-height: 1.6;">{{ old('narrative') }}</textarea>
                <p class="text-xs text-slate-400 mt-1.5 text-right" x-data="{ len: {{ strlen(old('narrative','')) }} }" x-text="len + ' / 1000 karakter'" @input.debounce="len = $event.target.value.length" x-init="$nextTick(() => len = document.querySelector('[name=narrative]').value.length)"></p>
                @error('narrative') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- LANGKAH 2: HARS --}}
        <div class="card overflow-hidden"
             x-data="{ answered: 0 }"
             @change="answered = document.querySelectorAll('.hars-opt:checked').length">
            <div class="flex items-center gap-4 p-5 border-b border-slate-100">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-sm font-bold flex-shrink-0" style="background: #0284c7;">2</div>
                <div class="flex-1">
                    <h2 class="font-display text-sm font-semibold text-slate-900">Kuesioner HARS (14 pertanyaan)</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Jawab sesuai kondisimu <b>dalam 1 minggu terakhir</b>. Tidak ada benar/salah.</p>
                </div>
            </div>

            @if($canFillHars)
                <!-- Progress bar -->
                <div class="px-5 pt-4 pb-2">
                    <div class="flex justify-between text-xs text-slate-400 mb-1.5">
                        <span>Progres pengisian</span>
                        <span>Terisi <b class="text-primary-700" x-text="answered"></b> dari 14</span>
                    </div>
                    <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-300" style="background:#0284c7;" :style="'width:' + (answered / 14 * 100) + '%'"></div>
                    </div>
                </div>

                <!-- Scale legend -->
                <div class="mx-5 mb-4 bg-slate-50 border border-slate-100 rounded-lg px-3 py-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">
                    @foreach(['Tidak ada', 'Ringan', 'Sedang', 'Berat', 'Sangat berat'] as $idx => $label)
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
                            <div class="flex gap-2 mt-2.5">
                                @for($s = 0; $s <= 4; $s++)
                                    @php $scaleName = ['Tidak ada', 'Ringan', 'Sedang', 'Berat', 'Sangat berat'][$s]; @endphp
                                    <label class="cursor-pointer" title="{{ $scaleName }}">
                                        <input type="radio" name="hars[{{ $item['id'] }}]" value="{{ $s }}"
                                               {{ old('hars.'.$item['id']) === (string) $s ? 'checked' : '' }} class="peer sr-only hars-opt">
                                        <span class="block w-10 h-10 rounded-lg border border-slate-200 text-center leading-10 text-sm text-slate-600 peer-checked:border-transparent peer-checked:font-bold hover:bg-primary-50 hover:border-primary-200 transition-colors peer-checked:text-white" style="peer-checked:background:#0284c7" :class="''" @class(['bg-primary-600 text-white border-transparent font-bold' => old('hars.'.$item['id']) === (string) $s])">{{ $s }}</span>
                                    </label>
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-5">
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-sm text-amber-800">
                        Kuesioner HARS sedang dalam masa cooldown (boleh diisi ulang setiap 2 minggu agar hasil tetap valid).
                        Sistem akan menggunakan skor HARS terakhirmu: <b>{{ auth()->user()->screenings()->whereNotNull('hars_score')->latest()->value('hars_score') }}/56</b>.
                        @if(isset($nextHarsAt)) Bisa diisi ulang mulai {{ $nextHarsAt }}. @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Submit button with loading -->
        <div x-data="{ loading: false }">
            <button type="submit" @click="loading = true; $nextTick(() => document.getElementById('screeningForm').submit())"
                    :disabled="loading"
                    class="btn-primary w-full justify-center py-3 text-base"
                    :class="loading ? 'opacity-75 cursor-not-allowed' : ''">
                <span x-show="!loading" class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Analisis Sekarang
                </span>
                <span x-show="loading" class="flex items-center gap-3">
                    <img src="{{ asset('images/loding.png') }}" alt="Loading..." class="w-6 h-6 object-contain animate-spin" style="mix-blend-mode: multiply;">
                    Sedang menganalisis...
                </span>
            </button>
        </div>

    </form>
</div>
@endsection
