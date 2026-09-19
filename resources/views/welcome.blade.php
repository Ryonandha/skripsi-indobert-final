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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: {
                    display: ['Plus Jakarta Sans', 'sans-serif'],
                    sans: ['Inter', 'sans-serif']
                }
            }}
        }
    </script>
    <style>
        * { box-sizing: border-box; }
        body {
            background: #0f172a;
            color: #cbd5e1;
            min-height: 100vh;
        }
        /* subtle grid bg */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
            z-index: 0;
        }
        .glow-amber {
            position: fixed;
            top: -15%;
            right: -5%;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(245,158,11,0.07) 0%, transparent 65%);
            pointer-events: none;
            z-index: 0;
        }
        .glow-blue {
            position: fixed;
            bottom: -15%;
            left: -5%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(59,130,246,0.06) 0%, transparent 65%);
            pointer-events: none;
            z-index: 0;
        }
        .glass-nav {
            background: rgba(15,23,42,0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .glass-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.09);
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        }
        .btn-amber {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #0f172a;
            font-weight: 700;
            border-radius: 0.875rem;
            padding: 0.875rem 2rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 24px rgba(245,158,11,0.3);
            font-size: 0.9375rem;
        }
        .btn-amber:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(245,158,11,0.45);
        }
        .btn-ghost {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            color: #e2e8f0;
            border-radius: 0.875rem;
            padding: 0.875rem 1.75rem;
            font-weight: 600;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
        }
        .btn-ghost:hover {
            background: rgba(255,255,255,0.12);
            border-color: rgba(245,158,11,0.3);
            color: #fff;
        }
        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .section { position: relative; z-index: 1; }
        .stat-card {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 20px;
            padding: 1.75rem;
            text-align: center;
        }
        .step-line {
            position: absolute;
            top: 24px;
            left: calc(50% + 28px);
            right: calc(-50% + 28px);
            height: 1px;
            background: linear-gradient(90deg, rgba(245,158,11,0.4), transparent);
        }
    </style>
</head>
<body class="font-sans antialiased">
<div class="glow-amber"></div>
<div class="glow-blue"></div>

<!-- NAVBAR -->
<nav class="glass-nav fixed top-0 left-0 right-0 z-50">
    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="#" class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <span class="font-display font-bold text-white text-lg">SiPeka</span>
        </a>
        <div class="hidden md:flex items-center gap-8 text-sm font-medium" style="color: #94a3b8;">
            <a href="#cara-kerja" class="hover:text-amber-400 transition-colors">Cara Kerja</a>
            <a href="#keunggulan" class="hover:text-amber-400 transition-colors">Keunggulan</a>
            <a href="#edukasi" class="hover:text-amber-400 transition-colors">Edukasi</a>
        </div>
        <div class="flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-amber text-sm px-5 py-2.5">
                    Buka Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-amber text-sm px-5 py-2.5">
                    Mulai Skrining
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="section pt-32 pb-24 px-6">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-16 items-center">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full px-3.5 py-1.5 text-xs font-semibold mb-6" style="background: rgba(245,158,11,0.12); border: 1px solid rgba(245,158,11,0.25); color: #fbbf24;">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Privat & Terenkripsi AES-256
            </div>
            <h1 class="font-display font-bold text-white leading-tight" style="font-size: clamp(2rem, 5vw, 3.25rem);">
                Skrining Kecemasan<br>
                <span style="background: linear-gradient(135deg, #f59e0b, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Berbasis AI</span><br>
                untuk Mahasiswa
            </h1>
            <p class="mt-5 text-base leading-relaxed" style="color: #64748b;">
                SiPeka menganalisis kondisi emosionalmu menggunakan <strong style="color: #94a3b8;">IndoBERT NLP</strong> dan instrumen klinis <strong style="color: #94a3b8;">HARS</strong> untuk deteksi dini risiko kecemasan mahasiswa STIKOM Yos Sudarso.
            </p>
            <div class="flex flex-wrap gap-3 mt-8">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-amber">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Mulai Skrining
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-amber">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Mulai Skrining Gratis
                    </a>
                    <a href="#cara-kerja" class="btn-ghost">Pelajari Lebih</a>
                @endauth
            </div>
            <div class="flex items-center gap-6 mt-8">
                <div class="flex -space-x-2">
                    @foreach(['M','A','R','I'] as $l)
                    <div class="w-8 h-8 rounded-full border-2 flex items-center justify-center text-xs font-bold text-slate-900" style="border-color: #0f172a; background: linear-gradient(135deg, #f59e0b, #d97706);">{{ $l }}</div>
                    @endforeach
                </div>
                <p class="text-xs" style="color: #64748b;">Digunakan mahasiswa aktif STIKOM Yos Sudarso</p>
            </div>
        </div>

        <!-- Hero Card Mockup -->
        <div class="relative hidden md:block">
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider mb-1" style="color: #f59e0b;">Hasil Skrining</p>
                        <p class="font-display font-bold text-white text-lg">Risiko Sedang</p>
                    </div>
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center" style="background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.25);">
                        <svg class="w-7 h-7" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                </div>
                <div class="space-y-3">
                    @foreach([['Skor HARS','22 / 56','#f59e0b'],['Sentimen AI','Cemas (68%)','#60a5fa'],['Rekomendasi','Konsultasi','#4ade80']] as [$label,$val,$color])
                    <div class="flex items-center justify-between rounded-xl px-4 py-3" style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.07);">
                        <span class="text-sm" style="color: #94a3b8;">{{ $label }}</span>
                        <span class="text-sm font-semibold" style="color: {{ $color }};">{{ $val }}</span>
                    </div>
                    @endforeach
                </div>
                <div class="mt-4 rounded-xl px-4 py-3 flex items-center gap-2" style="background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2);">
                    <svg class="w-4 h-4 flex-shrink-0" style="color: #fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span class="text-xs" style="color: #fbbf24;">Konselor akan menghubungi Anda</span>
                </div>
            </div>
            <!-- Decorative card behind -->
            <div class="absolute -z-10 -bottom-4 -right-4 w-full h-full rounded-2xl" style="background: rgba(245,158,11,0.06); border: 1px solid rgba(245,158,11,0.1);"></div>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="section pb-20 px-6">
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach([['14','Indikator HARS','Standar klinis WHO'],['3','Tingkat Risiko','Rendah · Sedang · Tinggi'],['AES-256','Enkripsi Data','Kerahasiaan terjamin'],['24/7','Akses Sistem','Kapan saja, dimana saja']] as [$val,$label,$desc])
        <div class="stat-card">
            <p class="font-display font-bold text-2xl text-white mb-1">{{ $val }}</p>
            <p class="text-sm font-semibold" style="color: #f59e0b;">{{ $label }}</p>
            <p class="text-xs mt-1" style="color: #475569;">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</section>

<!-- CARA KERJA -->
<section id="cara-kerja" class="section pb-24 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-14">
            <p class="text-xs font-semibold uppercase tracking-widest mb-3" style="color: #f59e0b;">Cara Kerja</p>
            <h2 class="font-display font-bold text-white text-3xl">Tiga Langkah Sederhana</h2>
            <p class="mt-3 text-sm" style="color: #64748b;">Proses skrining yang cepat, aman, dan tervalidasi klinis</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach([
                ['01','Tulis Curhatan','Ceritakan apa yang kamu rasakan dalam bahasa Indonesia. AI akan menganalisis sentimen emosionalmu secara otomatis.','rgba(245,158,11,0.15)','rgba(245,158,11,0.25)','#f59e0b','M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                ['02','Isi Kuesioner HARS','Jawab 14 pertanyaan standar Hamilton Anxiety Rating Scale untuk mengukur tingkat kecemasan secara klinis.','rgba(96,165,250,0.12)','rgba(96,165,250,0.2)','#60a5fa','M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                ['03','Terima Hasil & Saran','Dapatkan laporan risiko instan. Jika berisiko tinggi, psikolog kampus akan otomatis dinotifikasi untuk menghubungi kamu.','rgba(74,222,128,0.12)','rgba(74,222,128,0.2)','#4ade80','M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ] as [$num,$title,$desc,$bg,$border,$color,$icon])
            <div class="glass-card rounded-2xl p-7">
                <div class="feature-icon mb-5" style="background: {{ $bg }}; border: 1px solid {{ $border }};">
                    <svg class="w-6 h-6" style="color: {{ $color }};" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                </div>
                <div class="text-xs font-bold mb-2" style="color: {{ $color }};">LANGKAH {{ $num }}</div>
                <h3 class="font-display font-bold text-white mb-2">{{ $title }}</h3>
                <p class="text-sm leading-relaxed" style="color: #64748b;">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- KEUNGGULAN -->
<section id="keunggulan" class="section pb-24 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-14">
            <p class="text-xs font-semibold uppercase tracking-widest mb-3" style="color: #f59e0b;">Keunggulan</p>
            <h2 class="font-display font-bold text-white text-3xl">Mengapa Memilih SiPeka?</h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach([
                ['IndoBERT NLP','Model AI yang dilatih khusus untuk bahasa Indonesia, memahami nuansa emosi dalam curhatan.','rgba(245,158,11,0.15)','#f59e0b','M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
                ['Validasi Klinis HARS','14 indikator kecemasan berbasis standar Hamilton Anxiety Rating Scale yang diakui secara internasional.','rgba(96,165,250,0.12)','#60a5fa','M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['Enkripsi AES-256','Curhatanmu dienkripsi secara kriptografis. Bahkan admin sistem tidak bisa membacanya.','rgba(74,222,128,0.12)','#4ade80','M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                ['Login Google Kampus','Hanya mahasiswa aktif dengan email @student.stikomyos.ac.id yang dapat mengakses sistem.','rgba(245,158,11,0.15)','#f59e0b','M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207'],
                ['Notifikasi Real-time','Psikolog langsung menerima notifikasi dan email saat terdeteksi mahasiswa berisiko tinggi.','rgba(96,165,250,0.12)','#60a5fa','M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                ['Cooldown 14 Hari','Sistem menerapkan jeda 14 hari antar skrining HARS untuk menjaga validitas dan akurasi data.','rgba(74,222,128,0.12)','#4ade80','M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ] as [$title,$desc,$bg,$color,$icon])
            <div class="glass-card rounded-2xl p-6 transition-all duration-200" style="cursor: default;"
                 onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='rgba(255,255,255,0.16)'"
                 onmouseout="this.style.transform=''; this.style.borderColor=''">
                <div class="feature-icon mb-4" style="background: {{ $bg }}; border: 1px solid {{ $color }}22;">
                    <svg class="w-5 h-5" style="color: {{ $color }};" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                </div>
                <h3 class="font-display font-semibold text-white mb-2">{{ $title }}</h3>
                <p class="text-sm leading-relaxed" style="color: #64748b;">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- EDUCATIONAL ARTICLES -->
@php $educations = \App\Models\Education::where('is_published', true)->latest()->take(3)->get(); @endphp
@if($educations->count())
<section id="edukasi" class="section pb-24 px-6">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <p class="text-xs font-semibold uppercase tracking-widest mb-3" style="color: #f59e0b;">Edukasi</p>
            <h2 class="font-display font-bold text-white text-3xl">Bacaan untuk Kamu</h2>
            <p class="mt-3 text-sm" style="color: #64748b;">Artikel kesehatan mental pilihan untuk mendukung kesejahteraan mahasiswa</p>
        </div>
        <div class="grid md:grid-cols-3 gap-5">
            @foreach($educations as $edu)
            <a href="{{ route('education.show', $edu->slug) }}" class="glass-card rounded-2xl p-6 block transition-all duration-200"
               onmouseover="this.style.transform='translateY(-3px)'; this.style.borderColor='rgba(245,158,11,0.2)'"
               onmouseout="this.style.transform=''; this.style.borderColor=''">
                <div class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold mb-4" style="background: rgba(245,158,11,0.12); color: #fbbf24; border: 1px solid rgba(245,158,11,0.2);">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Artikel
                </div>
                <h3 class="font-display font-semibold text-white mb-2 leading-snug">{{ $edu->title }}</h3>
                <p class="text-sm leading-relaxed line-clamp-3" style="color: #64748b;">{{ Str::limit(strip_tags($edu->content), 120) }}</p>
                <div class="flex items-center gap-1 mt-4 text-xs font-medium" style="color: #f59e0b;">
                    Baca selengkapnya
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA -->
<section class="section pb-28 px-6">
    <div class="max-w-3xl mx-auto text-center glass-card rounded-3xl p-12" style="background: linear-gradient(135deg, rgba(245,158,11,0.08), rgba(15,23,42,0.5)); border-color: rgba(245,158,11,0.2);">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-6" style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 8px 30px rgba(245,158,11,0.3);">
            <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <h2 class="font-display font-bold text-white text-3xl mb-3">Mulai Peduli Diri Sendiri</h2>
        <p class="text-base mb-8" style="color: #64748b;">Deteksi dini adalah langkah pertama menuju kesehatan mental yang lebih baik. Skrining gratis, aman, dan butuh waktu kurang dari 10 menit.</p>
        @auth
            <a href="{{ route('mahasiswa.screening.create') }}" class="btn-amber">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Mulai Skrining Sekarang
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-amber">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Mulai Skrining Sekarang
            </a>
        @endauth
    </div>
</section>

<!-- FOOTER -->
<footer class="section pb-10 px-6" style="border-top: 1px solid rgba(255,255,255,0.06);">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4 pt-8">
        <div class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg flex items-center justify-center" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <svg class="w-4 h-4 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <span class="font-display font-bold text-white">SiPeka</span>
        </div>
        <p class="text-xs text-center" style="color: #334155;">© {{ date('Y') }} SiPeka · STIKOM Yos Sudarso Purwokerto · Dikembangkan dengan IndoBERT + HARS</p>
        <a href="{{ route('admin.login') }}" class="text-xs transition-colors" style="color: #334155;" onmouseover="this.style.color='#64748b'" onmouseout="this.style.color='#334155'">Login Staf →</a>
    </div>
</footer>
</body>
</html>
