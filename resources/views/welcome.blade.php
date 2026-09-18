<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPeka — Skrining Risiko Kecemasan Mahasiswa STIKOM Yos Sudarso</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_stikom.png') }}">
    <script src="/assets/tailwind.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { 
                extend: { 
                    fontFamily: { 
                        display: ['Plus Jakarta Sans', 'sans-serif'],
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        teal: { 50: '#f0fdfa', 100: '#ccfbf1', 600: '#0d9488', 700: '#0f766e', 800: '#115e59', 900: '#134e4a' },
                        slate: { 50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 500: '#64748b', 600: '#475569', 800: '#1e293b', 900: '#0f172a' }
                    }
                } 
            }
        }
    </script>
</head>
<body class="font-sans bg-white text-slate-800 antialiased selection:bg-teal-100 selection:text-teal-900">

<!-- ===== NAVBAR ===== -->
<nav class="bg-white border-b border-slate-200">
    <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="#" class="flex items-center gap-3">
            <img src="{{ asset('images/logo_stikom.png') }}" alt="Logo STIKOM Yos Sudarso" class="w-8 h-8 object-contain">
            <span class="font-display font-semibold text-lg text-slate-900 tracking-tight">SiPeka</span>
        </a>
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-600">
            <a href="#cara-kerja" class="hover:text-teal-700 transition-colors">Cara Kerja</a>
            <a href="#keunggulan" class="hover:text-teal-700 transition-colors">Keunggulan</a>
            <a href="#edukasi" class="hover:text-teal-700 transition-colors">Edukasi</a>
        </div>
        <div class="flex items-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-teal-700 hover:bg-teal-800 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">Buka Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="bg-teal-700 hover:bg-teal-800 text-white text-sm font-medium px-5 py-2 rounded-lg transition-colors">Mulai Skrining</a>
            @endauth
        </div>
    </div>
</nav>

<!-- ===== HERO ===== -->
<header class="bg-slate-50 border-b border-slate-200">
    <div class="max-w-5xl mx-auto px-6 py-20 md:py-24 grid md:grid-cols-2 gap-16 items-center">
        <div>
            <span class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-600 rounded-full px-3 py-1 text-xs font-medium mb-6">
                <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Privat & Kerahasiaan Terjaga
            </span>
            <h1 class="font-display text-4xl md:text-5xl font-bold leading-tight text-slate-900 mb-6">
                Pahami Kondisi <span class="text-teal-700">Kecemasanmu,</span> Sejak Dini.
            </h1>
            <p class="text-slate-600 text-lg leading-relaxed mb-8">
                Skrining kesehatan mental awal untuk mahasiswa. Berbasis instrumen klinis HARS dan teknologi NLP untuk memetakan tingkat risiko kecemasan Anda secara mandiri.
            </p>
            <div class="flex flex-wrap items-center gap-4">
                @auth
                    <a href="{{ auth()->user()->isMahasiswa() ? route('mahasiswa.screening.create') : route('dashboard') }}"
                       class="bg-teal-700 hover:bg-teal-800 text-white font-medium px-6 py-3 rounded-lg transition-colors">
                        Mulai Skrining Sekarang
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-teal-700 hover:bg-teal-800 text-white font-medium px-6 py-3 rounded-lg transition-colors">
                        Mulai Skrining Sekarang
                    </a>
                @endauth
                <a href="#cara-kerja" class="bg-white border border-slate-200 text-slate-700 font-medium px-6 py-3 rounded-lg hover:bg-slate-50 transition-colors">
                    Pelajari Cara Kerja
                </a>
            </div>
            <div class="flex items-center gap-6 mt-12 text-slate-600">
                <div><p class="text-xl font-bold text-slate-900">4.401+</p><p class="text-xs mt-0.5">Data Latih AI</p></div>
                <div class="w-px h-8 bg-slate-200"></div>
                <div><p class="text-xl font-bold text-slate-900">14</p><p class="text-xs mt-0.5">Item HARS</p></div>
            </div>
        </div>

        <!-- Mock card (Clean & Flat) -->
        <div class="hidden md:block">
            <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                    <p class="text-sm font-semibold text-slate-900">Ringkasan Hasil</p>
                    <span class="text-xs bg-slate-100 text-slate-600 rounded px-2 py-1 font-medium">Contoh Laporan</span>
                </div>
                
                <div class="mb-6">
                    <p class="text-xs text-slate-500 mb-1">Skor Kecemasan (HARS)</p>
                    <div class="flex items-baseline gap-1">
                        <p class="font-display text-3xl font-bold text-slate-900">28</p>
                        <p class="text-sm text-slate-500">/ 56</p>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-xs text-slate-500 mb-1">Analisis Teks (IndoBERT)</p>
                    <p class="font-medium text-slate-900">Indikasi Fear (Ketakutan)</p>
                    <div class="mt-2 h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-teal-600 rounded-full" style="width: 95%"></div>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Tingkat Risiko</p>
                    <p class="text-lg font-bold text-slate-900">Sedang – Tinggi</p>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- ===== CARA KERJA ===== -->
<section id="cara-kerja" class="py-24 bg-white">
    <div class="max-w-5xl mx-auto px-6">
        <div class="mb-16 max-w-2xl">
            <h2 class="font-display text-3xl font-bold text-slate-900 mb-4">Proses Skrining</h2>
            <p class="text-slate-600 text-lg">Tiga tahapan sederhana yang dapat diselesaikan dalam waktu kurang dari 5 menit.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach([
                ['Tulis Keluhan', 'Ceritakan apa yang membebani pikiran Anda secara naratif. Data teks akan diproses secara anonim.'],
                ['Isi Kuesioner', 'Jawab 14 pertanyaan pilihan ganda berbasis instrumen klinis Hamilton Anxiety Rating Scale (HARS).'],
                ['Terima Hasil', 'Sistem memproses data dan langsung menampilkan metrik tingkat risiko kecemasan Anda.'],
            ] as $i => $step)
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-8">
                    <div class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center text-slate-900 font-bold mb-6">
                        {{ $i+1 }}
                    </div>
                    <h3 class="font-bold text-lg text-slate-900 mb-2">{{ $step[0] }}</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">{{ $step[1] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== KEUNGGULAN ===== -->
<section id="keunggulan" class="py-24 bg-slate-50 border-t border-slate-200">
    <div class="max-w-5xl mx-auto px-6">
        <div class="mb-16">
            <h2 class="font-display text-3xl font-bold text-slate-900">Keunggulan Sistem</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-6">
            @foreach([
                ['Privasi Terjamin', 'Data naratif dienkripsi dengan standar AES-256. Tidak ada staf atau konselor yang dapat membaca teks curhatan asli Anda.'],
                ['Validasi Klinis', 'Menggunakan instrumen HARS yang terstandarisasi untuk mengukur derajat kecemasan secara objektif.'],
                ['Analisis Berbasis AI', 'Mengimplementasikan model bahasa IndoBERT untuk memahami konteks emosi dalam Bahasa Indonesia.'],
                ['Tindak Lanjut', 'Menyediakan jalur langsung untuk meminta pendampingan psikolog kampus jika terindikasi memiliki risiko tinggi.'],
            ] as $f)
                <div class="bg-white rounded-2xl p-8 border border-slate-200">
                    <h3 class="font-bold text-slate-900 mb-2">{{ $f[0] }}</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">{{ $f[1] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ===== EDUKASI ===== -->
@php $educations = \App\Models\Education::where('is_published', true)->latest()->take(3)->get(); @endphp
@if($educations->count())
<section id="edukasi" class="py-24 bg-white border-t border-slate-200">
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex items-end justify-between mb-12">
            <h2 class="font-display text-3xl font-bold text-slate-900">Artikel Edukasi</h2>
            <a href="#" class="text-teal-700 text-sm font-medium hover:text-teal-800">Lihat semua &rarr;</a>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($educations as $edu)
                <a href="{{ route('education.show', $edu) }}" class="group bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-slate-300 transition-colors block">
                    <div class="p-6">
                        <h3 class="font-bold text-slate-900 mb-3 group-hover:text-teal-700 transition-colors">{{ $edu->title }}</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-4">{{ \Illuminate\Support\Str::limit(strip_tags($edu->content), 100) }}</p>
                        <span class="text-sm font-medium text-slate-900">Baca artikel</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- ===== CTA ===== -->
<section class="py-24 bg-slate-900 text-center">
    <div class="max-w-3xl mx-auto px-6 text-center">
        <h2 class="font-display text-3xl font-bold text-white mb-4">Evaluasi Kesehatan Mental Anda</h2>
        <p class="text-slate-400 mb-8 max-w-xl mx-auto">Sistem kami siap membantu Anda memahami kondisi emosional saat ini. Identifikasi dini adalah langkah pertama yang tepat.</p>
        @auth
            @if(auth()->user()->isMahasiswa())
                <a href="{{ route('mahasiswa.screening.create') }}" class="inline-block bg-white text-slate-900 font-medium px-8 py-3 rounded-lg hover:bg-slate-100 transition-colors">Mulai Skrining Sekarang</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="inline-block bg-white text-slate-900 font-medium px-8 py-3 rounded-lg hover:bg-slate-100 transition-colors">Masuk dengan Akun Kampus</a>
        @endauth
    </div>
</section>

<!-- ===== FOOTER ===== -->
<footer class="bg-white border-t border-slate-200 py-12">
    <div class="max-w-5xl mx-auto px-6 grid md:grid-cols-3 gap-8 text-sm text-slate-600">
        <div>
            <p class="font-display font-bold text-slate-900 text-lg mb-2 flex items-center gap-2">SiPeka</p>
            <p class="leading-relaxed">Sistem Skrining Risiko Kecemasan Mahasiswa STIKOM Yos Sudarso.</p>
        </div>
        <div>
            <p class="font-semibold text-slate-900 mb-3">Layanan Darurat</p>
            <ul class="space-y-2">
                <li>Konseling Kampus STIKOM</li>
                <li>Layanan PSJK Kemenkes: <b>119 ext. 8</b></li>
            </ul>
        </div>
        <div>
            <p class="font-semibold text-slate-900 mb-3">Disclaimer Medis</p>
            <p class="leading-relaxed text-xs text-slate-500">Sistem ini berfungsi sebagai alat skrining awal dan tidak menggantikan diagnosis medis profesional. Segera hubungi tenaga profesional medis jika Anda berada dalam kondisi krisis.</p>
        </div>
    </div>
    <div class="max-w-5xl mx-auto px-6 mt-12 pt-8 border-t border-slate-100 text-xs text-slate-400 text-center">
        &copy; {{ date('Y') }} STIKOM Yos Sudarso Purwokerto. All rights reserved.
    </div>
</footer>

</body>
</html>
