@extends('layouts.app')
@section('title', $education->exists ? 'Edit Artikel' : 'Tambah Artikel')

@section('content')
<h1 class="text-2xl font-bold text-teal-800 mb-6">{{ $education->exists ? 'Edit' : 'Tambah' }} Artikel Edukasi</h1>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <form method="POST" action="{{ $education->exists ? route('admin.educations.update', $education) : route('admin.educations.store') }}">
        @csrf
        @if($education->exists) @method('PUT') @endif

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Judul</label>
            <input type="text" name="title" value="{{ old('title', $education->title) }}" required
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 outline-none">
            @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Isi</label>
            <textarea name="content" rows="10" required
                      class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 outline-none">{{ old('content', $education->content) }}</textarea>
            @error('content') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button class="bg-teal-700 hover:bg-teal-600 text-white rounded-lg px-5 py-2 font-semibold">Simpan</button>
        <a href="{{ route('admin.educations') }}" class="ml-2 text-slate-500 hover:underline text-sm">Batal</a>
    </form>
</div>
@endsection
