<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    /**
     * Registrasi mandiri DITUTUP (keputusan desain Bab III):
     * akun mahasiswa diterbitkan oleh kampus agar NIM/email tervalidasi
     * dan tidak ada akun ganda/palsu yang merusak integritas data skrining.
     * Halaman /register kini hanya mengarahkan ke login dengan penjelasan.
     */
    public function create()
    {
        return redirect()->route('login')->with('info',
            'Pendaftaran mandiri tidak dibuka. Akun mahasiswa diterbitkan oleh kampus — silakan masuk dengan email kampus.');
    }

    public function store(Request $request)
    {
        abort(404);
    }
}
