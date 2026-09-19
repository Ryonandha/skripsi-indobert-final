@extends('layouts.app')
@section('title', 'Jadwal Konseling')

@section('content')
<div class="animate-fade-in max-w-5xl">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="font-display text-3xl font-bold text-calm-900">Jadwal Konseling</h1>
        <p class="text-calm-500 mt-1">Kelola sesi konseling dengan mahasiswa. Mahasiswa otomatis diberi tahu saat jadwal dibuat.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-primary-50 border border-primary-200 text-primary-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Form Tambah -->
        <div class="bg-white rounded-2xl shadow-card border border-calm-100 p-6 h-fit">
            <h2 class="font-display text-lg font-semibold text-calm-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Buat Jadwal Baru
            </h2>
            <form method="POST" action="{{ route('psikolog.schedule.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-calm-700 mb-1.5">Mahasiswa</label>
                    <select name="student_id" required
                            class="w-full border border-calm-200 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none bg-white text-sm">
                        <option value="" disabled selected>— Pilih Mahasiswa —</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}">{{ $s->name }} {{ $s->nim ? "({$s->nim})" : '' }}</option>
                        @endforeach
                    </select>
                    @error('student_id') <p class="text-danger-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-calm-700 mb-1.5">Tanggal</label>
                        <input type="date" name="scheduled_date" min="{{ now()->toDateString() }}" required
                               class="w-full border border-calm-200 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none text-sm">
                        @error('scheduled_date') <p class="text-danger-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-calm-700 mb-1.5">Jam</label>
                        <input type="time" name="scheduled_time" required
                               class="w-full border border-calm-200 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none text-sm">
                        @error('scheduled_time') <p class="text-danger-600 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-calm-700 mb-1.5">Lokasi <span class="text-calm-400 font-normal">(opsional)</span></label>
                    <input type="text" name="location" placeholder="mis. Ruang Konseling Lt. 2"
                           class="w-full border border-calm-200 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none text-sm">
                    @error('location') <p class="text-danger-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-calm-700 mb-1.5">Catatan <span class="text-calm-400 font-normal">(opsional)</span></label>
                    <textarea name="notes" rows="2" placeholder="mis. bawa hasil skrining"
                              class="w-full border border-calm-200 rounded-xl px-3 py-2.5 focus:ring-2 focus:ring-primary-500 outline-none text-sm"></textarea>
                    @error('notes') <p class="text-danger-600 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit"
                        class="w-full px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-medium transition-colors shadow-soft text-sm">
                    + Simpan Jadwal & Beri Tahu Mahasiswa
                </button>
            </form>
        </div>

        <!-- Daftar Jadwal -->
        <div class="lg:col-span-2 space-y-6">
            @php $upcoming = $schedules->get('upcoming', collect()); $past = $schedules->get('past', collect()); @endphp

            {{-- Sesi Mendatang --}}
            <div class="bg-white rounded-2xl shadow-card border border-calm-100 overflow-hidden overflow-x-auto">
                <div class="p-5 border-b border-calm-100 flex items-center gap-2">
                    <h2 class="font-display text-lg font-semibold text-calm-900">Sesi Mendatang</h2>
                    <span class="px-2.5 py-0.5 rounded-full bg-primary-100 text-primary-700 text-xs font-semibold">{{ $upcoming->count() }}</span>
                </div>
                <div class="divide-y divide-calm-100">
                    @forelse($upcoming as $sch)
                        <div class="p-5 flex flex-col md:flex-row md:items-center gap-4 hover:bg-calm-50/50 transition-colors">
                            <div class="flex items-center gap-4 md:w-44 flex-shrink-0">
                                <div class="text-center bg-primary-50 border border-primary-100 rounded-xl px-3 py-2">
                                    <p class="text-xs text-primary-700 font-medium uppercase">{{ $sch->scheduled_date->format('M') }}</p>
                                    <p class="font-display text-2xl font-bold text-primary-800 leading-none">{{ $sch->scheduled_date->format('d') }}</p>
                                </div>
                                <div>
                                    <p class="font-semibold text-calm-900 text-sm">{{ $sch->scheduled_time }}</p>
                                    @if($sch->location)<p class="text-xs text-calm-500 mt-0.5">{{ $sch->location }}</p>@endif
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-calm-900 text-sm">{{ $sch->student->name }} <span class="text-calm-400 font-normal">{{ $sch->student->nim ?? '' }}</span></p>
                                @if($sch->notes)<p class="text-xs text-calm-500 mt-1 line-clamp-2">{{ $sch->notes }}</p>@endif
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <form method="POST" action="{{ route('psikolog.schedule.status', $sch) }}">
                                    @csrf
                                    <input type="hidden" name="status" value="selesai">
                                    <button title="Tandai selesai" class="p-2 rounded-lg text-calm-500 hover:bg-primary-50 hover:text-primary-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('psikolog.schedule.status', $sch) }}"
                                      onsubmit="return confirm('Batalkan sesi ini?')">
                                    @csrf
                                    <input type="hidden" name="status" value="dibatalkan">
                                    <button title="Batalkan" class="p-2 rounded-lg text-calm-500 hover:bg-danger-50 hover:text-danger-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('psikolog.schedule.destroy', $sch) }}"
                                      onsubmit="return confirm('Hapus jadwal ini dari daftar?')">
                                    @csrf
                                    @method('DELETE')
                                    <button title="Hapus" class="p-2 rounded-lg text-calm-500 hover:bg-danger-50 hover:text-danger-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center">
                            <div class="w-14 h-14 rounded-full bg-calm-100 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-calm-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <h3 class="font-display font-semibold text-calm-900 text-sm mb-1">Belum ada sesi mendatang</h3>
                            <p class="text-calm-500 text-xs">Buat jadwal baru lewat form di samping</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Riwayat --}}
            @if($past->count())
                <div class="bg-white rounded-2xl shadow-card border border-calm-100 overflow-hidden overflow-x-auto">
                    <div class="p-5 border-b border-calm-100">
                        <h2 class="font-display text-lg font-semibold text-calm-900">Riwayat Sesi</h2>
                    </div>
                    <div class="divide-y divide-calm-100 max-h-80 overflow-y-auto">
                        @foreach($past as $sch)
                            <div class="px-5 py-3 flex items-center justify-between gap-4">
                                <div class="min-w-0">
                                    <p class="text-sm text-calm-700 truncate">{{ $sch->student->name }} — {{ $sch->scheduled_date->format('d M Y') }}, {{ $sch->scheduled_time }}</p>
                                    @if($sch->notes)<p class="text-xs text-calm-400 truncate">{{ $sch->notes }}</p>@endif
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold flex-shrink-0
                                    {{ $sch->status === 'selesai' ? 'bg-primary-50 text-primary-700' : ($sch->status === 'dibatalkan' ? 'bg-danger-50 text-danger-600' : 'bg-calm-100 text-calm-600') }}">
                                    {{ ucfirst($sch->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
