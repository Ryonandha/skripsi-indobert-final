@extends('layouts.app')
@section('title', 'Skrining Baru')

@section('content')
<h1 class="text-2xl font-bold text-teal-800 mb-1">Skrining Risiko Kecemasan</h1>
<p class="text-slate-500 text-sm mb-6">Dua langkah: tulis curhatan, lalu isi kuesioner HARS. Semua data dijaga kerahasiaannya.</p>

<form method="POST" action="{{ route('mahasiswa.screening.store') }}" class="space-y-8">
    @csrf

    {{-- LANGKAH 1 --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="font-bold mb-1"><span class="bg-teal-700 text-white rounded-full px-2 py-0.5 text-sm mr-2">1</span> Tulis Curhatanmu</h2>
        <p class="text-xs text-slate-400 mb-3">Gunakan bahasa sehari-hari. Minimal 20 karakter. Teks ini dienkripsi dan tidak akan dibaca oleh siapa pun — hanya dianalisis oleh model AI untuk mengenali emosi dominan.</p>
        <textarea name="narrative" rows="5" required minlength="20" maxlength="1000"
                  placeholder="Ceritakan apa yang paling membebani pikiran atau perasaanmu akhir-akhir ini..."
                  class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-teal-500 outline-none">{{ old('narrative') }}</textarea>
        @error('narrative') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- LANGKAH 2 --}}
    <div class="bg-white rounded-xl shadow p-6"
         x-data="{ answered: document.querySelectorAll('.hars-opt:checked').length }"
         @change="answered = document.querySelectorAll('.hars-opt:checked').length">
        <h2 class="font-bold mb-1"><span class="bg-teal-700 text-white rounded-full px-2 py-0.5 text-sm mr-2">2</span> Kuesioner HARS (14 pertanyaan)</h2>

        @if($canFillHars)
            <p class="text-xs text-slate-400 mt-1">Jawab sesuai kondisimu <b>dalam 1 minggu terakhir</b>. Tidak ada jawaban benar/salah — yang paling menggambarkan dirimu itulah yang tepat.</p>
            <div class="mt-3 mb-5 bg-slate-50 border border-slate-100 rounded-lg px-3 py-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500">
                <span><b class="text-slate-700">0</b> Tidak ada</span>
                <span><b class="text-slate-700">1</b> Ringan</span>
                <span><b class="text-slate-700">2</b> Sedang</span>
                <span><b class="text-slate-700">3</b> Berat</span>
                <span><b class="text-slate-700">4</b> Sangat berat</span>
            </div>

            <!-- Progres pengisian -->
            <div class="mb-5">
                <div class="flex justify-between text-xs text-slate-400 mb-1">
                    <span>Progres pengisian</span>
                    <span>Terisi <b class="text-teal-700" x-text="answered"></b> dari 14</span>
                </div>
                <div class="h-1.5 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full bg-teal-600 rounded-full transition-all duration-300" :style="'width:' + (answered / 14 * 100) + '%'"></div>
                </div>
            </div>

            <div class="space-y-5">
                @foreach($harsItems as $i => $item)
                    <div class="border-b border-slate-100 pb-5 last:border-0 last:pb-0">
                        <p class="text-sm font-medium text-slate-800">{{ $i+1 }}. {{ $item['nama'] }}</p>
                        <p class="text-sm text-slate-500 mt-0.5">{{ $item['gejala'] }}</p>
                        <p class="text-xs text-teal-700/80 mt-1.5 flex items-start gap-1.5">
                            <svg class="w-3.5 h-3.5 mt-px flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $item['contoh'] }}
                        </p>
                        <div class="flex gap-2 mt-2.5">
                            @for($s = 0; $s <= 4; $s++)
                                @php $scaleName = ['Tidak ada', 'Ringan', 'Sedang', 'Berat', 'Sangat berat'][$s]; @endphp
                                <label class="cursor-pointer" title="{{ $scaleName }}">
                                    <input type="radio" name="hars[{{ $item['id'] }}]" value="{{ $s }}"
                                           {{ old('hars.'.$item['id']) === (string) $s ? 'checked' : '' }} class="peer sr-only hars-opt">
                                    <span class="block w-10 h-10 rounded-lg border text-center leading-10 text-slate-600 peer-checked:bg-teal-700 peer-checked:text-white peer-checked:border-teal-700 peer-checked:font-semibold hover:bg-teal-50 transition-colors">{{ $s }}</span>
                                </label>
                            @endfor
                            <span class="self-end ml-2 text-[11px] text-slate-400 hidden sm:block">0 tidak ada → 4 sangat berat</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 text-sm text-amber-800">
                Kuesioner HARS sedang dalam masa cooldown (boleh diisi ulang setiap 2 minggu agar hasil tetap valid).
                Sistem akan menggunakan skor HARS terakhirmu: <b>{{ auth()->user()->screenings()->whereNotNull('hars_score')->latest()->value('hars_score') }}/56</b>.
                @if(isset($nextHarsAt)) Bisa diisi ulang mulai {{ $nextHarsAt }}. @endif
            </div>
        @endif
    </div>

    <button type="submit" class="w-full bg-teal-700 hover:bg-teal-600 text-white rounded-lg py-3 font-semibold text-lg">
        Analisis Sekarang
    </button>
</form>
@endsection
