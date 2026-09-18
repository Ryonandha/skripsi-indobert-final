@extends('layouts.app')
@section('title', 'Kelola Edukasi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-teal-800">Artikel Edukasi</h1>
    <a href="{{ route('admin.educations.create') }}" class="bg-teal-700 hover:bg-teal-600 text-white rounded-lg px-4 py-2 text-sm font-semibold">+ Tambah Artikel</a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-100 text-left">
            <tr><th class="p-3">Judul</th><th class="p-3">Status</th><th class="p-3">Dibuat</th><th class="p-3"></th></tr>
        </thead>
        <tbody>
            @forelse($educations as $edu)
                <tr class="border-t">
                    <td class="p-3 font-medium">{{ $edu->title }}</td>
                    <td class="p-3">@if($edu->is_published)<span class="inline-flex items-center gap-1.5 text-xs font-medium text-green-700"><span class="w-2 h-2 rounded-full bg-green-500"></span>Terbit</span>@else<span class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500"><span class="w-2 h-2 rounded-full bg-slate-300"></span>Draf</span>@endif</td>
                    <td class="p-3">{{ $edu->created_at->format('d M Y') }}</td>
                    <td class="p-3 text-right space-x-2">
                        <a href="{{ route('admin.educations.edit', $edu) }}" class="text-teal-700 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('admin.educations.destroy', $edu) }}" class="inline"
                              onsubmit="return confirm('Hapus artikel ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-6 text-center text-slate-400">Belum ada artikel.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $educations->links() }}
@endsection
