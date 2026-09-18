<!DOCTYPE html>
<html lang="id">
<head>
    @php $code = $exception->getStatusCode(); @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $code }} — {{ $code === 403 ? 'Akses Ditolak' : 'Terjadi Kesalahan' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_stikom.png') }}">
    <script src="/assets/tailwind.js"></script>
    <style>
        .hero-gradient { background: linear-gradient(135deg, #0f766e 0%, #0d9488 45%, #14b8a6 100%); }
    </style>
</head>
<body class="font-sans bg-calm-50 text-slate-800 antialiased min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <div class="w-20 h-20 rounded-2xl hero-gradient flex items-center justify-center mx-auto mb-6 shadow-lg shadow-teal-200">
            @if($code === 403)
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            @elseif($code === 404)
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @else
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            @endif
        </div>

        <h1 class="font-display text-6xl font-extrabold text-calm-900 mb-2">{{ $code }}</h1>
        <h2 class="font-display text-xl font-bold text-calm-700 mb-3">
            @if($code === 403)
                Akses Ditolak
            @elseif($code === 404)
                Halaman Tidak Ditemukan
            @elseif($code === 419)
                Sesi Berakhir
            @elseif($code === 429)
                Terlalu Banyak Permintaan
            @elseif($code >= 500)
                Kesalahan Server
            @else
                Terjadi Kesalahan
            @endif
        </h2>
        <p class="text-calm-500 text-sm mb-8 leading-relaxed">
            @if($code === 403)
                Maaf, Anda tidak memiliki hak akses ke halaman ini. Halaman tersebut hanya dapat diakses oleh peran tertentu (mahasiswa / psikolog / admin).
            @elseif($code === 404)
                Halaman yang Anda cari tidak ada atau sudah dipindahkan.
            @elseif($code === 419)
                Sesi Anda telah berakhir karena terlalu lama tidak aktif. Silakan coba lagi.
            @elseif($code === 429)
                Terlalu banyak percobaan. Tunggu sebentar lalu coba lagi.
            @elseif($code >= 500)
                Terjadi kesalahan pada server. Tim teknis telah diberi tahu. Silakan coba beberapa saat lagi.
            @else
                Terjadi kesalahan yang tidak terduga. Silakan coba lagi.
            @endif
        </p>

        <div class="flex items-center justify-center gap-3">
            <a href="javascript:history.back()"
               class="px-5 py-2.5 bg-white border border-calm-200 text-calm-600 hover:bg-calm-100 rounded-xl font-medium text-sm transition-colors">
                Kembali
            </a>
            <a href="/"
               class="px-5 py-2.5 hero-gradient text-white rounded-xl font-medium text-sm transition-opacity hover:opacity-90">
                Ke Halaman Utama
            </a>
        </div>

        <p class="mt-8 text-xs text-calm-400">SiPeka — Sistem Skrining Kecemasan Mahasiswa STIKOM Yos Sudarso</p>
    </div>
</body>
</html>
