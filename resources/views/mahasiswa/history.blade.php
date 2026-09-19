@extends('layouts.app')
@section('title', 'Riwayat Skrining')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="font-display text-2xl font-bold text-calm-900">Riwayat Skrining</h1>
        <p class="text-sm text-calm-500 mt-1">Kamu dapat menghapus riwayat curhatanmu kapan saja secara permanen.</p>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-primary-50 border border-primary-200 text-primary-800 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-calm-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
                <tr>
                    <th class="p-3 text-left text-xs font-semibold text-calm-500 uppercase tracking-wide">Tanggal</th>
                    <th class="p-3 text-left text-xs font-semibold text-calm-500 uppercase tracking-wide">Emosi Dominan</th>
                    <th class="p-3 text-left text-xs font-semibold text-calm-500 uppercase tracking-wide">Skor HARS</th>
                    <th class="p-3 text-left text-xs font-semibold text-calm-500 uppercase tracking-wide">Risk Level</th>
                    <th class="p-3 text-right text-xs font-semibold text-calm-500 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($screenings as $s)
                    @php
                        $rc = ['rendah' => 'text-primary-700 bg-primary-50', 'sedang' => 'text-warm-700 bg-warm-50', 'tinggi' => 'text-danger-700 bg-danger-50'][$s->risk_level] ?? 'text-calm-700 bg-calm-50';
                    @endphp
                    <tr class="border-t border-calm-100 hover:bg-calm-50/50">
                        <td class="p-3 text-calm-700">{{ $s->created_at->format('d M Y, H:i') }}</td>
                        <td class="p-3 text-calm-800">
                            {{ $s->emotion_label }}
                            <span class="text-calm-400 text-xs ml-1">({{ number_format($s->emotion_confidence * 100, 1) }}%)</span>
                        </td>
                        <td class="p-3 text-calm-700">{{ $s->hars_score }}/56</td>
                        <td class="p-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $rc }}">{{ ucfirst($s->risk_level) }}</span>
                        </td>
                        <td class="p-3">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('mahasiswa.screening.show', $s) }}"
                                   class="text-primary-700 hover:text-primary-900 font-medium hover:underline">Detail</a>
                                <form action="{{ route('mahasiswa.screening.destroy', $s) }}" method="POST"
                                      onsubmit="return confirm('Hapus permanen riwayat skrining ini? Tindakan ini tidak bisa dibatalkan.{{ $s->consent_followup ? ' Catatan: menghapusnya tidak membatalkan proses pendampingan yang sedang berjalan.' : '' }}')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger-600 hover:text-danger-800 font-medium hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center">
                            <img src="{{ asset('images/data_tidak_ada.png') }}" alt="Data tidak ada" class="w-32 h-32 object-contain mx-auto mb-3" style="mix-blend-mode:multiply;">
                            <div class="text-calm-400 text-sm">Belum ada riwayat skrining.</div>
                            <a href="{{ route('mahasiswa.screening.create') }}" class="mt-3 inline-block text-primary-700 text-sm font-medium hover:underline">Mulai skrining pertama →</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($screenings->hasPages())
        <div class="mt-4">{{ $screenings->links() }}</div>
    @endif
</div>
@endsection
