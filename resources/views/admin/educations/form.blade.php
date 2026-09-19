@extends('layouts.app')
@section('title', $education->exists ? 'Edit Artikel' : 'Tambah Artikel')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="font-display text-2xl font-bold text-calm-900">{{ $education->exists ? 'Edit' : 'Tambah' }} Artikel Edukasi</h1>
        <p class="text-sm text-calm-500 mt-0.5">
            <a href="{{ route('admin.educations') }}" class="text-primary-700 hover:underline">← Kembali ke daftar artikel</a>
        </p>
    </div>

    <div class="bg-white rounded-xl border border-calm-200 p-6">
        <form method="POST" action="{{ $education->exists ? route('admin.educations.update', $education) : route('admin.educations.store') }}">
            @csrf
            @if($education->exists) @method('PUT') @endif

            <div class="mb-5">
                <label class="block text-sm font-medium text-calm-700 mb-1">Judul <span class="text-danger-500">*</span></label>
                <input type="text" name="title" value="{{ old('title', $education->title) }}" required
                       class="input-field">
                @error('title') <p class="text-danger-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-calm-700 mb-1">Isi Artikel <span class="text-danger-500">*</span></label>
                <textarea name="content" rows="12" required
                          class="input-field resize-y">{{ old('content', $education->content) }}</textarea>
                @error('content') <p class="text-danger-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            @if($education->exists)
            <div class="mb-5">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $education->is_published) ? 'checked' : '' }}
                           class="w-4 h-4 text-primary-600 rounded">
                    <span class="text-sm text-calm-700">Terbitkan artikel (tampil di landing page)</span>
                </label>
            </div>
            @endif

            <div class="flex items-center gap-3">
                <button type="submit" class="btn-primary">Simpan Artikel</button>
                <a href="{{ route('admin.educations') }}" class="text-calm-500 hover:text-calm-700 text-sm">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
