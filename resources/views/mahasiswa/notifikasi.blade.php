@extends('layouts.app')
@section('title', 'Notifikasi & Pesan')

@section('content')
<div class="animate-fade-in max-w-3xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="font-display text-3xl font-bold text-calm-900">Notifikasi & Pesan</h1>
            <p class="text-calm-500 mt-1">Pesan, undangan konseling, dan komunikasi dengan konselor kampus.</p>
        </div>
        @if($unreadCount > 0)
            <form method="POST" action="{{ route('mahasiswa.notifikasi.readAll') }}">
                @csrf
                <button class="px-4 py-2.5 bg-white border border-calm-200 text-calm-600 hover:bg-calm-50 rounded-xl font-medium text-sm transition-colors shadow-sm">
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
    <div class="space-y-4">
        @forelse($messages as $msg)
            @if($msg->is_from_student)
                {{-- Balasan dari Mahasiswa --}}
                <div class="bg-primary-50/40 rounded-2xl border border-primary-200/70 p-5 ml-4 sm:ml-10">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-primary-600 text-white flex items-center justify-center flex-shrink-0 text-xs font-bold shadow-sm">
                            Saya
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 flex-wrap">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-calm-900 text-sm">Balasan Anda</span>
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-primary-100 text-primary-700 font-medium">Terkirim</span>
                                </div>
                                <span class="text-xs text-calm-400">{{ $msg->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</span>
                            </div>
                            <p class="text-calm-800 text-sm mt-2 whitespace-pre-line leading-relaxed">{{ $msg->body }}</p>
                            <p class="text-xs text-calm-400 mt-2 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                                Dikirim ke: {{ $msg->psychologist->name ?? 'Konselor Kampus' }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
                {{-- Pesan dari Psikolog --}}
                <div x-data="{ showReply: false }" class="bg-white rounded-2xl shadow-card border p-5 {{ $msg->is_read ? 'border-calm-100' : 'border-primary-300 ring-2 ring-primary-100' }}">
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 {{ $msg->is_read ? 'bg-calm-100' : 'bg-primary-100' }}">
                            <svg class="w-5 h-5 {{ $msg->is_read ? 'text-calm-500' : 'text-primary-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-semibold text-calm-900 text-sm">{{ $msg->psychologist->name ?? 'Psikolog' }}</span>
                                <span class="text-xs text-calm-400">Konselor Kampus</span>
                                @unless($msg->is_read)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-primary-100 text-primary-700 text-xs font-semibold">Baru</span>
                                @endunless
                            </div>
                            <p class="text-calm-700 text-sm mt-1.5 whitespace-pre-line leading-relaxed">{{ $msg->body }}</p>
                            
                            <div class="flex items-center gap-3 mt-3 flex-wrap">
                                <span class="text-xs text-calm-400">{{ $msg->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</span>
                                
                                @if($msg->screening && $msg->screening->user_id === auth()->id())
                                    <a href="{{ route('mahasiswa.screening.show', $msg->screening) }}" class="text-xs font-medium text-primary-600 hover:text-primary-700">Lihat skrining terkait →</a>
                                @endif

                                {{-- Tombol Balas Pesan --}}
                                <button type="button" @click="showReply = !showReply" class="inline-flex items-center gap-1 text-xs font-semibold text-primary-600 hover:text-primary-700 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                    <span x-text="showReply ? 'Tutup Form' : 'Balas Pesan'"></span>
                                </button>

                                @unless($msg->is_read)
                                    <form method="POST" action="{{ route('mahasiswa.notifikasi.read', $msg) }}">
                                        @csrf
                                        <button type="submit" class="text-xs font-medium text-calm-500 hover:text-primary-600">Tandai dibaca</button>
                                    </form>
                                @endunless
                            </div>

                            {{-- Form Balas (Inline) --}}
                            <div x-show="showReply" x-cloak class="mt-4 pt-4 border-t border-calm-100">
                                <form method="POST" action="{{ route('mahasiswa.notifikasi.reply', $msg) }}" class="space-y-3">
                                    @csrf
                                    <div>
                                        <label class="block text-xs font-medium text-calm-700 mb-1">
                                            Ketik balasan untuk {{ $msg->psychologist->name ?? 'Konselor' }}:
                                        </label>
                                        <textarea name="body" rows="3" required placeholder="Contoh: Halo Bu Nilam, saya bisa bertemu hari Rabu pukul 10:00. Terima kasih."
                                                  class="w-full px-3.5 py-2.5 text-sm border border-calm-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none resize-none"></textarea>
                                    </div>
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" @click="showReply = false" class="px-3.5 py-1.5 text-xs text-calm-600 hover:bg-calm-100 rounded-lg transition-colors">Batal</button>
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-primary-600 hover:bg-primary-700 text-white text-xs font-medium rounded-lg shadow-sm transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                            Kirim Balasan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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

    <div class="mt-6">{{ $messages->links() }}</div>
</div>
@endsection
