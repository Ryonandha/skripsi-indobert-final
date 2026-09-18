<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // /login kini khusus Google mahasiswa — password hanya untuk psikolog
        // (fallback teknis); admin & mahasiswa diarahkan ke jalurnya.
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! auth()->attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        $role = $request->user()->role;

        // Admin wajib lewat portal staf; mahasiswa wajib lewat Google.
        if ($role === 'admin' || $role === 'mahasiswa') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($role === 'admin') {
                return redirect()->route('admin.login')->with('info',
                    'Akun staf wajib masuk lewat Portal Staf.');
            }

            throw ValidationException::withMessages([
                'email' => 'Mahasiswa wajib masuk dengan Google. Gunakan tombol "Masuk dengan Google".',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
