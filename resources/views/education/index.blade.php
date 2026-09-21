@extends('layouts.app')
@section('title', 'Artikel Edukasi Kesehatan Mental')

@section('content')
<div class="max-w-5xl mx-auto animate-fade-in">
    <!-- Header -->
    <div class="mb-8 text-center sm:text-left flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl font-bold text-calm-900">Edukasi Kesehatan Mental</h1>
            <p class="text-calm-500 mt-2">Kumpulan artikel dan panduan untuk mendukung kesejahteraan psikologismu.</p>
        </div>
        <a href="{{ route('home') }}" class="inline-flex justify-center items-center gap-2 px-4 py-2 bg-white border border-calm-200 hover:bg-calm-50 text-calm-700 rounded-xl font-medium transition-colors shadow-sm w-full sm:w-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3m10-11v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Halaman Utama
        </a>
    </div>

    <!-- Grid Artikel -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse( as )
            <a href="{{ route('education.show', ->slug) }}" class="group bg-white rounded-2xl shadow-card border border-calm-100 hover:shadow-card-hover hover:border-primary-200 transition-all duration-300 overflow-hidden flex flex-col">
                <div class="bg-gradient-to-br from-primary-50 to-calm-50 p-6 border-b border-calm-100">
                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-white border border-primary-100 text-primary-700 text-xs font-semibold mb-4 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Artikel
                    </div>
                    <h2 class="font-display text-lg font-bold text-calm-900 group-hover:text-primary-700 transition-colors line-clamp-2 leading-snug">
                        {{ ->title }}
                    </h2>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <p class="text-sm text-calm-600 line-clamp-3 mb-4 leading-relaxed">
                        {{ Str::limit(strip_tags(->content), 150) }}
                    </p>
                    <div class="mt-auto flex items-center justify-between">
                        <span class="text-xs font-medium text-calm-400">
                            {{ ->created_at->format('d M Y') }}
                        </span>
                        <span class="inline-flex items-center gap-1 text-sm font-semibold text-primary-600 group-hover:gap-2 transition-all">
                            Baca <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full bg-white rounded-2xl shadow-card border border-calm-100 p-12 text-center">
                <img src="{{ asset('images/data_tidak_ada.png') }}" alt="Kosong" class="w-32 h-32 object-contain mx-auto mb-4 opacity-75">
                <h3 class="text-lg font-semibold text-calm-900">Belum Ada Artikel Edukasi</h3>
                <p class="text-calm-500 mt-1">Nantikan artikel-artikel kesehatan mental yang akan datang.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(->hasPages())
        <div class="mt-10">
            {{ ->links() }}
        </div>
    @endif
</div>
@endsection
