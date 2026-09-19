<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — SiPeka</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_stikom.png') }}">
    <script src="/assets/tailwind.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: {
                    sans: ['Inter', 'system-ui', 'sans-serif'],
                    display: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'],
                }
            }}
        }
    </script>
    <style>
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f172a 100%);
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed;
            top: -20%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(245,158,11,0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -20%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(59,130,246,0.07) 0%, transparent 70%);
            pointer-events: none;
        }
        .glass-card {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.10);
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
        }
        .btn-google {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            color: #e2e8f0;
            transition: all 0.2s ease;
        }
        .btn-google:hover {
            background: rgba(255,255,255,0.12);
            border-color: rgba(245,158,11,0.4);
            color: #f1f5f9;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm relative z-10">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4" style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 8px 30px rgba(245,158,11,0.35);">
                <svg class="w-9 h-9 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <h1 class="font-display text-2xl font-bold text-white">SiPeka</h1>
            <p class="text-sm mt-1" style="color: #64748b;">Sistem Skrining Kecemasan Mahasiswa</p>
        </div>

        <!-- Card -->
        <div class="glass-card rounded-2xl p-7">
            <h2 class="font-display font-bold text-white text-lg mb-1">Masuk ke Akun</h2>
            <p class="text-sm mb-6" style="color: #64748b;">Gunakan akun Google kampus Anda</p>

            @if(session('info'))
                <div class="mb-4 rounded-xl px-4 py-3 text-sm" style="background: rgba(96,165,250,0.12); border: 1px solid rgba(96,165,250,0.2); color: #93c5fd;">
                    {{ session('info') }}
                </div>
            @endif
            @error('email')
                <div class="mb-4 rounded-xl px-4 py-3 text-sm" style="background: rgba(239,68,68,0.12); border: 1px solid rgba(239,68,68,0.2); color: #fca5a5;">
                    {{ $message }}
                </div>
            @enderror

            <a href="{{ route('google.redirect') }}"
               class="btn-google w-full flex items-center justify-center gap-3 rounded-xl py-3 font-semibold text-sm">
                <!-- Google Icon -->
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#EA4335" d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115Z"/>
                    <path fill="#34A853" d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.777L1.24 17.35C3.198 21.302 7.27 24 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987Z"/>
                    <path fill="#4A90E2" d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9 0-.71-.109-1.473-.272-2.182H12v4.637h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21Z"/>
                    <path fill="#FBBC05" d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067Z"/>
                </svg>
                Masuk dengan Google
            </a>

            <p class="text-center text-xs mt-4 leading-relaxed" style="color: #475569;">
                Wajib akun <span class="font-medium" style="color: #f59e0b;">@student.stikomyos.ac.id</span><br>
                Belum terdaftar? Hubungi bagian kemahasiswaan.
            </p>

            <div class="mt-6 pt-5" style="border-top: 1px solid rgba(255,255,255,0.07);">
                <a href="{{ route('admin.login') }}" class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl text-xs font-medium transition-all" style="color: #64748b; border: 1px solid rgba(255,255,255,0.07);" onmouseover="this.style.background='rgba(255,255,255,0.05)'; this.style.color='#94a3b8'" onmouseout="this.style.background=''; this.style.color='#64748b'">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Login Admin / Psikolog
                </a>
            </div>
        </div>

        <p class="text-center text-xs mt-6" style="color: #334155;">© {{ date('Y') }} STIKOM Yos Sudarso Purwokerto</p>
    </div>
</body>
</html>
