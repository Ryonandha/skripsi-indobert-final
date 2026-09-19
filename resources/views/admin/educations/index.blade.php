@extends('layouts.app')
@section('title', 'Kelola Edukasi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="font-display text-2xl font-bold text-calm-900">Artikel Edukasi</h1>
        <p class="text-sm text-calm-500 mt-0.5">Kelola konten edukasi kesehatan mental untuk mahasiswa</p>
    </div>
    <a href="{{ route('admin.educations.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Artikel
    </a>
</div>

<div class="bg-white rounded-xl border border-calm-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead style="background:#f8fafc; border-bottom:1px solid #e2e8f0;">
            <tr>
                <th class="p-3 text-left text-xs font-semibold text-calm-500 uppercase tracking-wide">Judul</th>
                <th class="p-3 text-left text-xs font-semibold text-calm-500 uppercase tracking-wide">Status</th>
                <th class="p-3 text-left text-xs font-semibold text-calm-500 uppercase tracking-wide">Dibuat</th>
                <th class="p-3 text-right text-xs font-semibold text-calm-500 uppercase tracking-wide">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($educations as $edu)
                <tr class="border-t border-calm-100 hover:bg-calm-50/50">
                    <td class="p-3 font-medium text-calm-800">{{ $edu->title }}</td>
                    <td class="p-3">
                        @if($edu->is_published)
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-primary-700 bg-primary-50 px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>Terbit
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-calm-500 bg-calm-100 px-2 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-calm-400"></span>Draf
                            </span>
                        @endif
                    </td>
                    <td class="p-3 text-calm-600">{{ $edu->created_at->format('d M Y') }}</td>
                    <td class="p-3 text-right space-x-3">
                        <a href="{{ route('admin.educations.edit', $edu) }}" class="text-primary-700 hover:underline font-medium">Edit</a>
                        <form method="POST" action="{{ route('admin.educations.destroy', $edu) }}" class="inline"
                              onsubmit="return confirm('Hapus artikel ini?')">
                            @csrf @method('DELETE')
                            <button class="text-danger-600 hover:underline font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-10 text-center text-calm-400 text-sm">Belum ada artikel edukasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($educations->hasPages())
    <div class="mt-4">{{ $educations->links() }}</div>
@endif
@endsection
