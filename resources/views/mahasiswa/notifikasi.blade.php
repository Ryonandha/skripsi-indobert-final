@extends('layouts.app')
@section('title', 'Notifikasi')

@section('content')
<div class="animate-fade-in max-w-3xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-3xl font-bold text-calm-900">Notifikasi</h1>
            <p class="text-calm-500 mt-1">Pesan & undangan konseling dari psikolog kampus.</p>
        </div>
        @if($unreadCount > 0)
            <form method="POST" action="{{ route('mahasiswa.notifikasi.readAll') }}">
                @csrf
                <button class="px-4 py-2.5 bg-white border border-calm-200 text-calm-600 hover:bg-calm-50 rounded-xl font-medium text-sm transition-colors">
                    Tandai semua dibaca ({{ $unreadCount }})
                </button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div class="mb-4 bg-primary-50 border border-primary-200 text-primary-800 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Daftar Pesan -->
    <div class="space-y-3">
        @forelse($messages as $msg)
            <div class="bg-white rounded-2xl shadow-card border p-5 {{ $msg->is_read ? 'border-calm-100' : 'border-primary-300 ring-1 ring-primary-100' }}">
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 {{ $msg->is_read ? 'bg-calm-100' : 'bg-primary-100' }}">
                        <svg class="w-5 h-5 {{ $msg->is_read ? 'text-calm-500' : 'text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-semibold text-calm-900 text-sm">{{ $msg->psychologist->name ?? 'Psikolog' }}</span>
                            <span class="text-xs text-calm-400">Psikolog</span>
                            @unless($msg->is_read)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-primary-100 text-primary-700 text-xs font-semibold">Baru</span>
                            @endunless
                        </div>
                        <p class="text-calm-700 text-sm mt-1.5 whitespace-pre-line">{{ $msg->body }}</p>
                        <div class="flex items-center gap-3 mt-3">
                            <span class="text-xs text-calm-400">{{ $msg->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</span>
                            @if($msg->screening && $msg->screening->user_id === auth()->id())
                                <a href="{{ route('mahasiswa.screening.show', $msg->screening) }}" class="text-xs font-medium text-primary-600 hover:text-primary-700">Lihat skrining terkait →</a>
                            @endif
                            @unless($msg->is_read)
                                <form method="POST" action="{{ route('mahasiswa.notifikasi.read', $msg) }}">
                                    @csrf
                                    <button type="submit" class="text-xs font-medium text-calm-500 hover:text-primary-600">Tandai dibaca</button>
                                </form>
                            @endunless
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-card border border-calm-100 p-12 text-center">
                <div class="w-16 h-16 rounded-full bg-calm-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-calm-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="font-display text-lg font-semibold text-calm-900 mb-1">Belum ada pesan</h3>
                <p class="text-calm-500 text-sm">Pesan dari psikolog akan muncul di sini jika Anda dihubungi.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $messages->links() }}</div>
</div>
@endsection
