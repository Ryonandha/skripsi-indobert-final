<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — SiPeka</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo_stikom.png') }}">
    <script src="/assets/tailwind.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background: #f8fafc; font-family: 'Inter', system-ui, sans-serif; }
        .card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
        .btn-google { display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 11px 16px; border: 1px solid #e2e8f0; border-radius: 8px; background: #fff; color: #334155; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.15s ease; }
        .btn-google:hover { background: #f8fafc; border-color: #cbd5e1; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <!-- Logo -->
        <div class="text-center mb-8">
            @if($errors->any())
                <img src="{{ asset('images/login_gagal.png') }}" alt="Login Gagal" style="width:120px; height:120px; object-fit:contain; margin: 0 auto 16px; mix-blend-mode: multiply;">
            @elseif(session('info') || session('success'))
                <img src="{{ asset('images/login_berhasil.png') }}" alt="Login Berhasil" style="width:120px; height:120px; object-fit:contain; margin: 0 auto 16px; mix-blend-mode: multiply;">
            @else
                <img src="{{ asset('images/awal_menyambut.png') }}" alt="Halo!" style="width:100px; height:100px; object-fit:contain; margin: 0 auto 16px; mix-blend-mode: multiply;">
            @endif
            <div class="inline-flex items-center gap-2.5">
                <img src="{{ asset('images/logo_web.png') }}" alt="SiPeka" class="w-10 h-10 object-contain">
                <div class="text-left">
                    <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 1.125rem; color: #0f172a; line-height: 1.2;">SiPeka</p>
                    <p style="font-size: 0.7rem; color: #94a3b8; line-height: 1;">STIKOM Yos Sudarso</p>
                </div>
            </div>
        </div>

        <!-- Card -->
        <div class="card p-7">
            <h1 style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 1.125rem; color: #0f172a; margin-bottom: 4px;">Masuk ke Akun</h1>
            <p style="font-size: 0.8125rem; color: #64748b; margin-bottom: 20px;">Gunakan email Google kampus Anda</p>

            @if(session('info'))
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; border-radius: 8px; padding: 10px 14px; font-size: 13px; margin-bottom: 14px;">
                    {{ session('info') }}
                </div>
            @endif
            @error('email')
                <div style="background: #fff1f2; border: 1px solid #fecdd3; color: #be123c; border-radius: 8px; padding: 10px 14px; font-size: 13px; margin-bottom: 14px;">
                    {{ $message }}
                </div>
            @enderror

            <a href="{{ route('google.redirect') }}" class="btn-google" style="text-decoration: none; color: #334155;">
                <svg width="18" height="18" viewBox="0 0 24 24">
                    <path fill="#EA4335" d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115Z"/>
                    <path fill="#34A853" d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.777L1.24 17.35C3.198 21.302 7.27 24 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987Z"/>
                    <path fill="#4A90E2" d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9 0-.71-.109-1.473-.272-2.182H12v4.637h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21Z"/>
                    <path fill="#FBBC05" d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067Z"/>
                </svg>
                Lanjutkan dengan Google
            </a>

            <p style="font-size: 0.75rem; color: #94a3b8; text-align: center; margin-top: 14px; line-height: 1.5;">
                Wajib email <strong style="color: #475569;">@student.stikomyos.ac.id</strong>
            </p>

            <div style="border-top: 1px solid #f1f5f9; margin-top: 20px; padding-top: 16px;">
                <a href="{{ route('admin.login') }}" style="display: flex; align-items: center; justify-content: center; gap: 6px; font-size: 12px; color: #94a3b8; text-decoration: none; padding: 8px; border-radius: 6px; transition: color 0.15s;" onmouseover="this.style.color='#64748b'; this.style.background='#f8fafc'" onmouseout="this.style.color='#94a3b8'; this.style.background=''">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Masuk sebagai Admin / Psikolog
                </a>
            </div>
        </div>

        <p style="text-align: center; font-size: 11px; color: #cbd5e1; margin-top: 20px;">&copy; {{ date('Y') }} STIKOM Yos Sudarso Purwokerto</p>
    </div>

    @if(session('logout_success'))
    <div id="logoutSplash" style="position:fixed;inset:0;z-index:9999;background:rgba(255,255,255,0.95);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;transition:opacity 0.5s ease;backdrop-filter:blur(4px);">
        <img src="{{ asset('images/logout_berhasil.png') }}" alt="Logout Berhasil"
             style="width:200px;height:200px;object-fit:contain;mix-blend-mode:multiply;animation:bounceIn 0.6s ease;">
        <div style="text-align:center;">
            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:1.5rem;color:#0f172a;margin-bottom:6px;">Berhasil Keluar</p>
            <p style="font-size:0.95rem;color:#64748b;max-width:300px;line-height:1.5;">Kamu telah keluar dari sistem dengan aman.</p>
        </div>
        <div style="display:flex;gap:6px;margin-top:8px;">
            <span style="width:8px;height:8px;border-radius:50%;background:#0284c7;animation:dot 1.2s 0s infinite;"></span>
            <span style="width:8px;height:8px;border-radius:50%;background:#0284c7;animation:dot 1.2s 0.2s infinite;"></span>
            <span style="width:8px;height:8px;border-radius:50%;background:#0284c7;animation:dot 1.2s 0.4s infinite;"></span>
        </div>
    </div>
    <style>
        @keyframes bounceIn { 0% { transform: scale(0.5); opacity: 0; } 70% { transform: scale(1.1); opacity: 1; } 100% { transform: scale(1); } }
        @keyframes dot { 0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; } 40% { transform: scale(1); opacity: 1; } }
    </style>
    <script>
        setTimeout(function() {
            var splash = document.getElementById('logoutSplash');
            if (splash) { splash.style.opacity = '0'; setTimeout(function(){ splash.remove(); }, 500); }
        }, 2000);
    </script>
    @endif
</body>
</html>
