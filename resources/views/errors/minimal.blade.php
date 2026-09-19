<!DOCTYPE html>
<html lang="id">
<head>
    @php $code = $exception->getStatusCode(); @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $code }} — {{ $code === 403 ? 'Akses Ditolak' : ($code === 404 ? 'Halaman Tidak Ditemukan' : 'Terjadi Kesalahan') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_web.png') }}">
    <script src="/assets/tailwind.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { background: #f8fafc; font-family: 'Inter', system-ui, sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">

        <!-- Mascot image based on error type -->
        @if($code >= 500)
            <img src="{{ asset('images/errorr.png') }}" alt="Error" class="w-40 h-40 object-contain mx-auto mb-4" style="mix-blend-mode: multiply;">
        @elseif($code === 503)
            <img src="{{ asset('images/maintenance.png') }}" alt="Maintenance" class="w-40 h-40 object-contain mx-auto mb-4" style="mix-blend-mode: multiply;">
        @else
            <img src="{{ asset('images/errorr.png') }}" alt="Error" class="w-36 h-36 object-contain mx-auto mb-4" style="mix-blend-mode: multiply;">
        @endif

        <!-- Logo -->
        <div class="flex items-center justify-center gap-2 mb-6">
            <img src="{{ asset('images/logo_web.png') }}" alt="SiPeka" class="w-7 h-7 object-contain">
            <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; color: #0f172a; font-size: 1rem;">SiPeka</span>
        </div>

        <!-- Error code -->
        <div style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 4rem; color: #e2e8f0; line-height: 1; margin-bottom: 8px;">{{ $code }}</div>

        <h1 style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 1.375rem; color: #0f172a; margin-bottom: 10px;">
            @if($code === 403) Akses Ditolak
            @elseif($code === 404) Halaman Tidak Ditemukan
            @elseif($code === 419) Sesi Berakhir
            @elseif($code === 429) Terlalu Banyak Permintaan
            @elseif($code === 503) Sedang Dalam Pemeliharaan
            @elseif($code >= 500) Kesalahan Server
            @else Terjadi Kesalahan
            @endif
        </h1>

        <p style="font-size: 0.9rem; color: #64748b; line-height: 1.6; margin-bottom: 28px; max-width: 360px; margin-left: auto; margin-right: auto;">
            @if($code === 403)
                Maaf, Anda tidak memiliki hak akses ke halaman ini. Pastikan Anda sudah masuk dengan akun yang tepat.
            @elseif($code === 404)
                Halaman yang Anda cari tidak ada atau sudah dipindahkan. Periksa kembali alamat URL-nya.
            @elseif($code === 419)
                Sesi Anda telah berakhir karena terlalu lama tidak aktif. Silakan coba lagi dari halaman sebelumnya.
            @elseif($code === 429)
                Terlalu banyak percobaan dalam waktu singkat. Tunggu sebentar lalu coba kembali.
            @elseif($code === 503)
                Sistem sedang dalam pemeliharaan untuk peningkatan layanan. Silakan coba beberapa saat lagi.
            @elseif($code >= 500)
                Terjadi kesalahan pada server kami. Tim teknis telah diberi tahu. Silakan coba beberapa saat lagi.
            @else
                Terjadi kesalahan yang tidak terduga. Silakan coba kembali.
            @endif
        </p>

        <div class="flex items-center justify-center gap-3">
            <a href="javascript:history.back()"
               style="padding: 10px 20px; background: #fff; border: 1px solid #e2e8f0; color: #475569; border-radius: 8px; font-weight: 600; font-size: 0.875rem; text-decoration: none; transition: all 0.15s;"
               onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">
                ← Kembali
            </a>
            <a href="/"
               style="padding: 10px 20px; background: #0284c7; color: #fff; border-radius: 8px; font-weight: 600; font-size: 0.875rem; text-decoration: none; transition: background 0.15s;"
               onmouseover="this.style.background='#0369a1'" onmouseout="this.style.background='#0284c7'">
                Ke Halaman Utama
            </a>
        </div>

        <p style="margin-top: 32px; font-size: 0.75rem; color: #cbd5e1;">
            SiPeka — Sistem Skrining Kecemasan Mahasiswa STIKOM Yos Sudarso
        </p>
    </div>
</body>
</html>
