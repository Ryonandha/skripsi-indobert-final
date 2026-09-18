<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0; padding:0; background-color:#f1f5f9; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9; padding:32px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background-color:#ffffff; border-radius:16px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.1);">

                    {{-- Header --}}
                    <tr>
                        <td style="background-color: #ffffff; border-top: 4px solid #0d9488; border-bottom: 1px solid #e2e8f0; padding:28px 32px; text-align:center;">
                            <h1 style="margin:0; color:#0f172a; font-size:20px; font-weight:700;">
                                ✉️ Pesan dari Konselor Kampus
                            </h1>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 8px; color:#64748b; font-size:14px;">Halo,</p>
                            <h2 style="margin:0 0 20px; color:#0f172a; font-size:18px; font-weight:600;">
                                {{ $student->name }}
                            </h2>

                            <p style="margin:0 0 16px; color:#334155; font-size:14px; line-height:1.6;">
                                Kamu menerima pesan dari konselor kampus <strong>{{ $psychologist->name }}</strong>:
                            </p>

                            {{-- Message Box --}}
                            <div style="background-color:#f0fdfa; border-left:4px solid #0d9488; padding:16px 20px; border-radius:0 12px 12px 0; margin-bottom:24px;">
                                <p style="margin:0; color:#134e4a; font-size:14px; line-height:1.7; white-space:pre-line;">{{ $message->body }}</p>
                            </div>

                            {{-- CTA Button --}}
                            <table cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                <tr>
                                    <td style="background-color:#0d9488; border-radius:12px;">
                                        <a href="{{ route('mahasiswa.notifikasi.index') }}"
                                           style="display:inline-block; padding:12px 28px; color:#ffffff; text-decoration:none; font-size:14px; font-weight:600;">
                                            Lihat di Aplikasi →
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:20px 32px; background-color:#f8fafc; border-top:1px solid #e2e8f0; text-align:center;">
                            <p style="margin:0; color:#94a3b8; font-size:12px; line-height:1.5;">
                                Email ini dikirim otomatis oleh {{ config('app.name') }}.<br>
                                Jangan balas email ini — gunakan aplikasi untuk merespons.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
