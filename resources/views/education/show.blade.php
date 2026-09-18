@extends('layouts.app')
@section('title', $education->title)

@section('content')
<div class="max-w-3xl mx-auto animate-fade-in">
    <!-- Back Button -->
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-calm-500 hover:text-calm-700 text-sm font-medium mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Dashboard
    </a>

    <!-- Article Card -->
    <article class="bg-white rounded-2xl shadow-card border border-calm-100 overflow-hidden">
        <div class="bg-gradient-to-r from-primary-50 to-primary-100 border-b border-primary-200 px-6 py-6 md:px-8 md:py-8">
            <div class="flex items-center gap-2 text-primary-700 text-sm font-medium mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                Artikel Edukasi
            </div>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-calm-900 mt-2">{{ $education->title }}</h1>
            <p class="text-primary-600 text-sm mt-2">Diterbitkan: {{ $education->created_at->format('d F Y') }}</p>
        </div>

        <div class="p-6 md:p-8 prose prose-calm max-w-none">
            {!! nl2br(e($education->content)) !!}
        </div>

        <!-- Share & Action -->
        <div class="border-t border-calm-100 px-6 py-4 md:px-8 flex flex-col sm:flex-row gap-3 justify-between items-start sm:items-center">
            <div class="flex items-center gap-3">
                <button onclick="navigator.clipboard.writeText(window.location.href)"
                        class="flex items-center gap-2 px-3 py-2 bg-calm-100 hover:bg-calm-200 text-calm-700 rounded-xl text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 012-2h10a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2 2 2 0 012-2h10a2 2 0 002-2V5a2 2 0 01-2-2H6a2 2 0 01-2 2z"/></svg>
                    Salin Link
                </button>
                <button class="flex items-center gap-2 px-3 py-2 bg-calm-100 hover:bg-calm-200 text-calm-700 rounded-xl text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.116-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                    Bagikan
                </button>
            </div>
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-medium transition-colors">
                Kembali ke Dashboard
            </a>
        </div>
    </article>

    <!-- Related Articles -->
    @php $related = \App\Models\Education::where('is_published', true)->where('id', '!=', $education->id)->latest()->take(3)->get(); @endphp
    @if($related->count())
    <section class="mt-8">
        <h2 class="font-display text-xl font-semibold text-calm-900 mb-4">Artikel Terkait</h2>
        <div class="grid gap-4">
            @foreach($related as $rel)
                <a href="{{ route('education.show', $rel->slug) }}"
                   class="bg-white rounded-xl shadow-card border border-calm-100 p-5 hover:shadow-card-hover transition-all duration-300 group">
                    <h3 class="font-semibold text-calm-900 group-hover:text-primary-600 transition-colors">{{ $rel->title }}</h3>
                    <p class="text-sm text-calm-500 mt-2 line-clamp-2">{{ Str::limit(strip_tags($rel->content), 120) }}</p>
                    <span class="inline-flex items-center gap-1 text-xs text-primary-600 mt-3 group-hover:gap-2 transition-all">
                        Baca
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                </a>
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection