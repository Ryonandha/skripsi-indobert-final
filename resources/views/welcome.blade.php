<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiPeka — Skrining Risiko Kecemasan Mahasiswa STIKOM Yos Sudarso</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_stikom.png') }}">
    <script src="/assets/tailwind.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #f8fafc; color: #334155; font-family: 'Inter', system-ui, sans-serif; line-height: 1.6; }

        /* ── Navbar ── */
        .navbar {
            position: sticky; top: 0; z-index: 50;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
        }
        .navbar-inner {
            max-width: 1100px; margin: 0 auto;
            display: flex; align-items: center; justify-content: space-between;
            height: 60px; padding: 0 24px;
        }
        .logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .logo-icon { width: 32px; height: 32px; border-radius: 8px; background: #0284c7; display: flex; align-items: center; justify-content: center; }
        .logo-text { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 1.05rem; color: #0f172a; }
        .nav-links { display: flex; align-items: center; gap: 28px; }
        .nav-links a { font-size: 0.875rem; font-weight: 500; color: #64748b; text-decoration: none; transition: color 0.15s; }
        .nav-links a:hover { color: #0f172a; }
        .btn { display: inline-flex; align-items: center; gap: 6px; font-weight: 600; font-size: 0.875rem; border-radius: 8px; padding: 8px 18px; text-decoration: none; transition: all 0.15s ease; cursor: pointer; border: none; }
        .btn-primary { background: #0284c7; color: #fff; }
        .btn-primary:hover { background: #0369a1; }
        .btn-outline { background: #fff; color: #334155; border: 1px solid #e2e8f0; }
        .btn-outline:hover { background: #f8fafc; border-color: #cbd5e1; }

        /* ── Sections ── */
        .section { max-width: 1100px; margin: 0 auto; padding: 80px 24px; }
        .section-sm { max-width: 1100px; margin: 0 auto; padding: 60px 24px; }

        /* ── Hero ── */
        .hero { background: #fff; border-bottom: 1px solid #e2e8f0; }
        .hero-inner { max-width: 1100px; margin: 0 auto; padding: 80px 24px 88px; display: grid; grid-template-columns: 1fr 1fr; gap: 64px; align-items: center; }
        @media(max-width: 768px) {
            .hero-inner { grid-template-columns: 1fr; gap: 40px; padding: 48px 24px 56px; }
            .hero-visual { display: none; }
            .nav-links { display: none; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .features-grid { grid-template-columns: 1fr; }
        }
        .hero-badge { display: inline-flex; align-items: center; gap: 6px; background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; border-radius: 999px; padding: 4px 12px; font-size: 0.75rem; font-weight: 600; margin-bottom: 20px; }
        .hero-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: clamp(1.875rem, 4vw, 2.75rem); color: #0f172a; line-height: 1.2; margin-bottom: 16px; }
        .hero-title span { color: #0284c7; }
        .hero-desc { font-size: 1rem; color: #64748b; line-height: 1.7; margin-bottom: 28px; }
        .hero-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .hero-note { margin-top: 20px; font-size: 0.8125rem; color: #94a3b8; display: flex; align-items: center; gap: 6px; }

        /* ── Hero visual card ── */
        .result-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.07); padding: 24px; }
        .result-card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
        .result-card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 0.9375rem; color: #0f172a; }
        .result-metric { background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 8px; padding: 14px 16px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .result-metric-label { font-size: 0.8125rem; color: #64748b; }
        .result-metric-value { font-weight: 700; font-size: 0.875rem; color: #0f172a; }
        .badge { display: inline-flex; align-items: center; border-radius: 999px; padding: 3px 10px; font-size: 0.75rem; font-weight: 600; }
        .badge-med { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
        .badge-high { background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; }
        .badge-low { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-blue { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

        /* ── Stats ── */
        .stats-section { background: #0284c7; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 0; }
        .stat-item { padding: 36px 24px; text-align: center; border-right: 1px solid rgba(255,255,255,0.15); }
        .stat-item:last-child { border-right: none; }
        .stat-num { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 2rem; color: #fff; line-height: 1; margin-bottom: 6px; }
        .stat-label { font-size: 0.875rem; font-weight: 600; color: rgba(255,255,255,0.85); }
        .stat-desc { font-size: 0.75rem; color: rgba(255,255,255,0.55); margin-top: 3px; }

        /* ── Steps ── */
        .steps-section { background: #fff; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; }
        .steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
        .step-card { position: relative; }
        .step-num { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 0.75rem; color: #0284c7; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 12px; }
        .step-icon { width: 44px; height: 44px; border-radius: 10px; border: 1px solid #e2e8f0; background: #f8fafc; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; }
        .step-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 1rem; color: #0f172a; margin-bottom: 8px; }
        .step-desc { font-size: 0.875rem; color: #64748b; line-height: 1.6; }
        .step-connector { position: absolute; top: 22px; left: calc(100% + 8px); right: calc(-100% + 8px - 24px); height: 1px; background: #e2e8f0; display: none; }
        @media(min-width: 769px) { .step-connector { display: block; } .step-card:last-child .step-connector { display: none; } }

        /* ── Features ── */
        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .feature-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 22px; transition: all 0.15s ease; }
        .feature-card:hover { border-color: #bae6fd; box-shadow: 0 4px 16px rgba(2,132,199,0.08); transform: translateY(-2px); }
        .feature-icon { width: 40px; height: 40px; border-radius: 9px; background: #eff6ff; border: 1px solid #bae6fd; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
        .feature-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 0.9375rem; color: #0f172a; margin-bottom: 6px; }
        .feature-desc { font-size: 0.8125rem; color: #64748b; line-height: 1.6; }

        /* ── Articles ── */
        .articles-section { background: #f8fafc; border-top: 1px solid #e2e8f0; }
        .articles-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 40px; }
        .article-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 22px; text-decoration: none; display: block; transition: all 0.15s ease; }
        .article-card:hover { border-color: #bae6fd; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
        .article-tag { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; color: #0284c7; margin-bottom: 10px; }
        .article-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 0.9375rem; color: #0f172a; margin-bottom: 8px; line-height: 1.4; }
        .article-excerpt { font-size: 0.8125rem; color: #64748b; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .article-more { font-size: 0.8125rem; font-weight: 600; color: #0284c7; margin-top: 12px; display: flex; align-items: center; gap: 4px; }

        /* ── CTA ── */
        .cta-section { background: #0f172a; }
        .cta-inner { max-width: 680px; margin: 0 auto; text-align: center; padding: 88px 24px; }
        .cta-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: clamp(1.625rem, 3vw, 2.25rem); color: #fff; margin-bottom: 14px; line-height: 1.25; }
        .cta-desc { font-size: 1rem; color: #94a3b8; margin-bottom: 32px; }
        .cta-btn { display: inline-flex; align-items: center; gap: 8px; background: #0284c7; color: #fff; font-weight: 700; font-size: 0.9375rem; padding: 13px 28px; border-radius: 9px; text-decoration: none; transition: background 0.15s; }
        .cta-btn:hover { background: #0369a1; }
        .cta-note { font-size: 0.8125rem; color: #475569; margin-top: 14px; }

        /* ── Footer ── */
        .footer { background: #0f172a; border-top: 1px solid rgba(255,255,255,0.07); }
        .footer-inner { max-width: 1100px; margin: 0 auto; padding: 28px 24px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
        .footer-text { font-size: 0.8125rem; color: #475569; }
        .footer-link { font-size: 0.8125rem; color: #475569; text-decoration: none; transition: color 0.15s; }
        .footer-link:hover { color: #94a3b8; }

        .section-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #0284c7; margin-bottom: 10px; }
        .section-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: clamp(1.5rem, 3vw, 2rem); color: #0f172a; margin-bottom: 12px; }
        .section-desc { font-size: 0.9375rem; color: #64748b; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="navbar-inner">
        <a href="#" class="logo">
            <img src="{{ asset('images/logo_stikom.png') }}" alt="Logo STIKOM Yos Sudarso" style="width:36px; height:36px; object-fit:contain; flex-shrink:0;">
            <div>
                <div class="logo-text">SiPeka</div>
                <div style="font-size: 0.65rem; color: #94a3b8; line-height: 1; margin-top: 1px;">STIKOM Yos Sudarso</div>
            </div>
        </a>
        <div class="nav-links">
            <a href="#cara-kerja">Cara Kerja</a>
            <a href="#keunggulan">Keunggulan</a>
            <a href="#edukasi">Edukasi</a>
        </div>
        @auth
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Buka Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Mulai Skrining</a>
        @endauth
    </div>
</nav>

<!-- HERO -->
<div class="hero">
    <div class="hero-inner">
        <div>
            <div class="hero-badge">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                Data terenkripsi &amp; terjaga privasi
            </div>
            <h1 class="hero-title">
                Deteksi Dini Risiko<br>
                Kecemasan Mahasiswa<br>
                <span>dengan Kecerdasan AI</span>
            </h1>
            <p class="hero-desc">
                SiPeka menggabungkan instrumen klinis <strong>HARS</strong> dan model AI <strong>IndoBERT</strong> berbahasa Indonesia untuk mengidentifikasi risiko kecemasan mahasiswa secara akurat, cepat, dan terjaga kerahasiaannya.
            </p>
            <div class="hero-actions">
                @auth
                    <a href="{{ route('mahasiswa.screening.create') }}" class="btn btn-primary" style="padding: 11px 22px; font-size: 0.9375rem;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Mulai Skrining
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary" style="padding: 11px 22px; font-size: 0.9375rem;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        Mulai Skrining Gratis
                    </a>
                    <a href="#cara-kerja" class="btn btn-outline" style="padding: 11px 22px; font-size: 0.9375rem;">Pelajari cara kerjanya</a>
                @endauth
            </div>
            <p class="hero-note">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Khusus mahasiswa aktif STIKOM Yos Sudarso Purwokerto
            </p>
        </div>

        <!-- Visual -->
        <div class="hero-visual">
            <div class="result-card">
                <div class="result-card-header">
                    <div>
                        <div style="font-size:0.75rem; color:#94a3b8; margin-bottom:4px;">Hasil Skrining Terbaru</div>
                        <div class="result-card-title">Laporan Risiko Kecemasan</div>
                    </div>
                    <span class="badge badge-med">Risiko Sedang</span>
                </div>
                <div class="result-metric">
                    <span class="result-metric-label">Skor HARS</span>
                    <span class="result-metric-value" style="color: #b45309;">22 / 56</span>
                </div>
                <div class="result-metric">
                    <span class="result-metric-label">Sentimen AI (IndoBERT)</span>
                    <span class="result-metric-value" style="color: #0284c7;">Fear · 68%</span>
                </div>
                <div class="result-metric">
                    <span class="result-metric-label">Status Penanganan</span>
                    <span class="badge badge-blue">Menunggu Konselor</span>
                </div>
                <div style="margin-top: 14px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 10px 14px; font-size: 0.8125rem; color: #b45309; display: flex; align-items: flex-start; gap: 8px;">
                    <svg style="flex-shrink:0; margin-top:1px;" width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Konselor Anda akan dihubungi secara otomatis
                </div>
            </div>
        </div>
    </div>
</div>

<!-- STATS -->
<div class="stats-section">
    <div class="stats-grid" style="max-width: 1100px; margin: 0 auto;">
        @foreach([['14','Indikator Klinis','Standar HARS internasional'],['3','Tingkat Risiko','Rendah · Sedang · Tinggi'],['AES-256','Enkripsi Data','Privasi data terjamin'],['< 10 mnt','Durasi Skrining','Cepat & tidak rumit']] as [$n,$l,$d])
        <div class="stat-item">
            <div class="stat-num">{{ $n }}</div>
            <div class="stat-label">{{ $l }}</div>
            <div class="stat-desc">{{ $d }}</div>
        </div>
        @endforeach
    </div>
</div>

<!-- CARA KERJA -->
<div class="steps-section" id="cara-kerja">
    <div class="section">
        <div style="margin-bottom: 44px;">
            <div class="section-label">Cara Kerja</div>
            <div class="section-title">Tiga Langkah yang Mudah</div>
            <div class="section-desc">Proses skrining tervalidasi yang bisa diselesaikan kurang dari 10 menit</div>
        </div>
        <div class="steps-grid">
            @foreach([
                ['Langkah 01','Tulis Curhatan','Ceritakan apa yang kamu rasakan dalam bahasa Indonesia. Model AI IndoBERT akan menganalisis sentimen dan emosi dari teks tulisanmu secara otomatis.','M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                ['Langkah 02','Isi Kuesioner HARS','Jawab 14 pertanyaan Hamilton Anxiety Rating Scale yang sudah divalidasi klinis untuk mengukur tingkat kecemasan secara objektif dan terstandar.','M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                ['Langkah 03','Dapatkan Laporan','Lihat hasil analisis risiko secara instan. Jika terdeteksi risiko tinggi, psikolog kampus otomatis mendapat notifikasi untuk menindaklanjuti.','M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ] as [$num,$title,$desc,$icon])
            <div class="step-card">
                <div class="step-num">{{ $num }}</div>
                <div class="step-icon">
                    <svg width="20" height="20" fill="none" stroke="#0284c7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                </div>
                <div class="step-title">{{ $title }}</div>
                <div class="step-desc">{{ $desc }}</div>
                <div class="step-connector"></div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- KEUNGGULAN -->
<div id="keunggulan" style="background: #f8fafc; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;">
    <div class="section">
        <div style="margin-bottom: 40px;">
            <div class="section-label">Keunggulan</div>
            <div class="section-title">Mengapa Memilih SiPeka?</div>
            <div class="section-desc">Dibangun dengan standar klinis dan teknologi AI untuk mahasiswa STIKOM Yos Sudarso</div>
        </div>
        <div class="features-grid">
            @foreach([
                ['IndoBERT NLP','Model AI terlatih khusus Bahasa Indonesia. Memahami konteks dan nuansa emosi dalam tulisan curhatan mahasiswa secara akurat.','M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
                ['Standar Klinis HARS','14 indikator kecemasan mengacu pada Hamilton Anxiety Rating Scale yang diakui internasional dan divalidasi oleh psikolog klinis.','M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['Enkripsi AES-256','Narasi curhatan dienkripsi penuh menggunakan AES-256. Admin dan psikolog hanya melihat skor — teks asli tidak dapat dibaca siapapun.','M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'],
                ['Login Kampus (OAuth)','Hanya mahasiswa aktif dengan akun Google kampus @student.stikomyos.ac.id yang dapat mengakses sistem. Tidak perlu daftar manual.','M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207'],
                ['Notifikasi Psikolog','Saat terdeteksi risiko tinggi, psikolog kampus langsung menerima notifikasi dan email otomatis untuk segera menindaklanjuti.','M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9'],
                ['Cooldown 14 Hari','Jeda wajib 14 hari antar sesi skrining HARS mencegah bias dan menjaga akurasi pengukuran dari waktu ke waktu.','M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ] as [$t,$d,$icon])
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="18" height="18" fill="none" stroke="#0284c7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
                </div>
                <div class="feature-title">{{ $t }}</div>
                <div class="feature-desc">{{ $d }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- MENGENAL SIPEKA -->
<div style="background: #fff; border-bottom: 1px solid #e2e8f0;">
    <div class="section">
        <div style="margin-bottom: 48px; text-align: center;">
            <div class="section-label">Mengenal SiPeka</div>
            <div class="section-title">Filosofi Maskot &amp; Logo</div>
            <div class="section-desc">Identitas visual yang mewakili visi perlindungan dan dukungan emosional</div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 48px; align-items: center; margin-bottom: 72px;">
            <div style="text-align: center; background: #f8fafc; padding: 24px; border-radius: 20px; border: 1px solid #e2e8f0;">
                <img src="{{ asset('images/awal_menyambut.png') }}" alt="Maskot SiPeka" style="max-width: 100%; height: auto; max-height: 280px; mix-blend-mode: multiply; margin: 0 auto;">
            </div>
            <div>
                <h3 style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 1.25rem; color: #0f172a; margin-bottom: 16px;">Makna Burung Hantu sebagai Maskot</h3>
                <p style="font-size: 0.9375rem; color: #475569; line-height: 1.75; margin-bottom: 16px;">
                    Burung hantu dipilih sebagai maskot SiPeka karena secara simbolis merepresentasikan kepekaan dan perhatian. Karakteristik tersebut relevan dengan fungsi SiPeka yang melakukan skrining awal terhadap risiko kecemasan mahasiswa dengan memperhatikan dua sumber informasi, yaitu respons HARS dan narasi yang dianalisis menggunakan IndoBERT.
                </p>
                <p style="font-size: 0.9375rem; color: #475569; line-height: 1.75;">
                    Desain burung hantu kemudian dibuat dengan ekspresi yang tenang dan bersahabat untuk merepresentasikan SiPeka sebagai pendamping dalam proses skrining, bukan sebagai pengganti tenaga profesional atau alat diagnosis.
                </p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 48px; align-items: center;">
            <div style="text-align: center; background: #f8fafc; padding: 24px; border-radius: 20px; border: 1px solid #e2e8f0;" class="md-order-2">
                <img src="{{ asset('images/makna_logo.png') }}" alt="Logo SiPeka" style="max-width: 100%; height: auto; max-height: 320px; mix-blend-mode: multiply; margin: 0 auto;">
            </div>
            <div class="md-order-1">
                <h3 style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 1.25rem; color: #0f172a; margin-bottom: 16px;">Filosofi Logo SiPeka</h3>
                <p style="font-size: 0.9375rem; color: #475569; line-height: 1.75; margin-bottom: 16px;">
                    Logo SiPeka merupakan perpaduan antara burung hantu, bentuk huruf "S", dan elemen visual yang menyerupai pelukan atau perisai. Burung hantu merepresentasikan kepekaan, pengamatan, dan kesadaran terhadap kondisi diri, sementara mata yang besar menggambarkan kemampuan untuk mengenali tanda-tanda kecemasan sejak dini.
                </p>
                <p style="font-size: 0.9375rem; color: #475569; line-height: 1.75;">
                    Bentuk "S" yang mengelilingi burung hantu memberikan makna perlindungan, dukungan, dan ruang yang aman bagi mahasiswa. Dominasi warna biru merepresentasikan ketenangan, rasa aman, dan kepercayaan, sedangkan aksen kuning memberikan kesan kehangatan dan harapan. Keseluruhan identitas dirancang dengan pendekatan yang ramah dan modern agar SiPeka tidak terasa seperti sistem klinis yang kaku, tetapi sebagai teman digital yang membantu mahasiswa mengenali, memahami, dan merespons kondisi dirinya dengan lebih baik.
                </p>
            </div>
        </div>
    </div>
</div>
<style>
    @media(min-width: 768px) {
        .md-order-1 { order: -1; }
        .md-order-2 { order: 2; }
    }
</style>

<!-- EDUKASI -->
@php $educations = \App\Models\Education::where('is_published', true)->latest()->take(3)->get(); @endphp
@if($educations->count())
<div class="articles-section" id="edukasi">
    <div class="section-sm">
        <div class="section-label">Edukasi</div>
        <div class="section-title">Bacaan untuk Mahasiswa</div>
        <div class="section-desc">Artikel kesehatan mental pilihan untuk mendukung kesejahteraan kamu</div>
        <div class="articles-grid">
            @foreach($educations as $edu)
            <a href="{{ route('education.show', $edu->slug) }}" class="article-card">
                <div class="article-tag">Artikel Edukasi</div>
                <div class="article-title">{{ $edu->title }}</div>
                <div class="article-excerpt">{{ strip_tags($edu->content) }}</div>
                <div class="article-more">
                    Baca selengkapnya
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- CTA -->
<div class="cta-section">
    <div class="cta-inner">
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 52px; height: 52px; border-radius: 12px; background: #0284c7; margin-bottom: 24px;">
            <svg width="24" height="24" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <h2 class="cta-title">Mulai Peduli Diri Sendiri Sekarang</h2>
        <p class="cta-desc">Deteksi dini adalah langkah pertama. Gratis, aman, dan selesai dalam kurang dari 10 menit.</p>
        @auth
            <a href="{{ route('mahasiswa.screening.create') }}" class="cta-btn">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Mulai Skrining Sekarang
            </a>
        @else
            <a href="{{ route('login') }}" class="cta-btn">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Mulai Skrining Sekarang
            </a>
        @endauth
        <p class="cta-note">Khusus mahasiswa aktif dengan akun Google kampus</p>
    </div>
</div>

<!-- FOOTER -->
<div class="footer">
    <div class="footer-inner">
        <div style="display: flex; align-items: center; gap: 10px;">
            <img src="{{ asset('images/logo_stikom.png') }}" alt="Logo STIKOM" style="width:22px; height:22px; object-fit:contain; opacity:0.4;">
            <span class="footer-text">&copy; {{ date('Y') }} SiPeka · STIKOM Yos Sudarso Purwokerto</span>
        </div>
        <div class="footer-text">Dikembangkan dengan IndoBERT + HARS</div>
    </div>
</div>

</body>
</html>
