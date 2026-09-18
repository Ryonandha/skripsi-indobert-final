@extends('layouts.app')
@section('title', 'Riwayat Skrining')

@section('content')
<h1 class="text-2xl font-bold text-teal-800 mb-2">Riwayat Skrining</h1>
<p class="text-sm text-slate-500 mb-6">Kamu dapat menghapus riwayat curhatanmu kapan saja secara permanen.</p>

@if(session('success'))
    <div class="mb-4 bg-primary-50 border border-primary-200 text-primary-800 px-4 py-3 rounded-xl text-sm">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-100 text-left">
            <tr>
                <th class="p-3">Tanggal</th>
                <th class="p-3">Emosi Dominan</th>
                <th class="p-3">Skor HARS</th>
                <th class="p-3">Risk Level</th>
                <th class="p-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($screenings as $s)
                <?php $rc = ['rendah'=>'text-green-700','sedang'=>'text-amber-600','tinggi'=>'text-red-600'][$s->risk_level]; ?>
                <tr class="border-t">
                    <td class="p-3">{{ $s->created_at->format('d M Y H:i') }}</td>
                    <td class="p-3">{{ $s->emotion_label }} <span class="text-slate-400">({{ number_format($s->emotion_confidence*100,1) }}%)</span></td>
                    <td class="p-3">{{ $s->hars_score }}/56</td>
                    <td class="p-3 font-bold {{ $rc }}">{{ ucfirst($s->risk_level) }}</td>
                    <td class="p-3">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('mahasiswa.screening.show', $s) }}" class="text-teal-700 hover:underline">Detail</a>
                            <form action="{{ route('mahasiswa.screening.destroy', $s) }}" method="POST"
                                  onsubmit="return confirm('Hapus permanen riwayat skrining ini? Tindakan ini tidak bisa dibatalkan.{{ $s->consent_followup ? ' Catatan: kamu sudah menyetujui pendampingan konselor untuk riwayat ini — menghapusnya tidak membatalkan proses pendampingan yang sedang berjalan.' : '' }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="p-6 text-center text-slate-400">Belum ada riwayat skrining.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $screenings->links() }}
@endsection
