<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Portal login STAF (/admin/login): admin teknis + psikolog.
 *
 * Keputusan desain (dokumentasikan di Bab III bagian keamanan):
 * - Staf tidak memakai tombol Google dan tidak berbagi halaman login
 *   dengan mahasiswa (portal terpisah, tanpa OAuth pihak ketiga —
 *   akun staf murni kredensial lokal + password yang di-hash Bcrypt).
 * - Login umum (/login) khusus Google mahasiswa dan MENOLAK role staf.
 */
class AdminLoginController extends Controller
{
    public function create()
    {
        return view('auth.admin-login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! auth()->attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        // Hanya staf (admin/psikolog) yang boleh lewat portal ini
        if (! in_array($request->user()->role, ['admin', 'psikolog'], true)) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Portal ini khusus staf. Mahasiswa silakan masuk dengan Google di halaman login utama.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(
            $request->user()->role === 'psikolog'
                ? route('psikolog.dashboard')
                : route('admin.dashboard')
        );
    }
}
