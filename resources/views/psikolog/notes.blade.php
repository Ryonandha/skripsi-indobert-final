@extends('layouts.app')
@section('title', 'Catatan Progres')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">
    <div class="mb-6">
        <h1 class="font-display text-3xl font-bold text-calm-900">Catatan Progres Konseling</h1>
        <p class="text-calm-500 mt-1">Riwayat catatan dari semua sesi konseling yang telah ditangani</p>
    </div>

    <div class="bg-white rounded-2xl shadow-card border border-calm-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-calm-50">
                    <tr>
                        <th class="py-3 px-4 text-left font-medium text-calm-700 text-sm border-b border-calm-200">Mahasiswa</th>
                        <th class="py-3 px-4 text-left font-medium text-calm-700 text-sm border-b border-calm-200">Screening</th>
                        <th class="py-3 px-4 text-left font-medium text-calm-700 text-sm border-b border-calm-200">Status</th>
                        <th class="py-3 px-4 text-left font-medium text-calm-700 text-sm border-b border-calm-200">Catatan Terakhir</th>
                        <th class="py-3 px-4 text-left font-medium text-calm-700 text-sm border-b border-calm-200">Konselor</th>
                        <th class="py-3 px-4 text-left font-medium text-calm-700 text-sm border-b border-calm-200">Diperbarui</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-calm-100">
                    @forelse($screenings as $s)
                        <tr class="hover:bg-calm-50 transition-colors">
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center">
                                        <span class="font-display font-semibold text-primary-700 text-xs">{{ strtoupper($s->user->name[0]) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-calm-900">{{ $s->user->name }}</p>
                                        <p class="text-xs text-calm-500">{{ $s->user->nim }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                @php
                                    $rc = ['rendah'=>'bg-primary-50 text-primary-700','sedang'=>'bg-warm-50 text-warm-700','tinggi'=>'bg-danger-50 text-danger-700'][$s->risk_level] ?? 'text-calm-700 bg-calm-50';
                                @endphp
                                <div class="flex flex-col gap-1">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $rc }} capitalize">
                                        Risiko {{ $s->risk_level }}
                                    </span>
                                    <span class="text-xs text-calm-500">HARS: {{ $s->hars_score }}/56 • {{ $s->emotion_label }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                @php
                                    $hsColors = ['belum'=>'bg-calm-100 text-calm-600','diproses'=>'bg-warm-50 text-warm-700','selesai'=>'bg-primary-50 text-primary-700'];
                                    $hsColor = $hsColors[$s->handling_status] ?? 'bg-calm-100 text-calm-600';
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ $hsColor }} capitalize">
                                    {{ $s->handling_status }}
                                </span>
                            </td>
                            <td class="py-4 px-4">
                                <div class="max-w-xs">
                                    @if($s->handling_notes)
                                        <p class="text-sm text-calm-700 line-clamp-2">{{ $s->handling_notes }}</p>
                                    @else
                                        <p class="text-sm text-calm-400 italic">Belum ada catatan</p>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <p class="text-sm text-calm-900">{{ $s->handler->name ?? '—' }}</p>
                            </td>
                            <td class="py-4 px-4">
                                <p class="text-sm text-calm-500">{{ $s->updated_at->format('d M Y H:i') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="w-16 h-16 rounded-full bg-calm-100 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-calm-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </div>
                                <h3 class="font-display text-lg font-semibold text-calm-900 mb-1">Belum ada catatan progres</h3>
                                <p class="text-calm-500 text-sm">Catatan akan muncul setelah konselor mengupdate penanganan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($screenings->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $screenings->links() }}
        </div>
    @endif
</div>
@endsection