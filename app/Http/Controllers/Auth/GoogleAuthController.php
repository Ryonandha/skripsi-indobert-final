<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

/**
 * Login Google (OAuth) KHUSUS mahasiswa (@student.stikomyos.ac.id).
 *
 * Keputusan desain (dokumentasikan di Bab III):
 * - Registrasi mandiri (self-signup) tetap TIDAK dibuka ke publik: satu-
 *   satunya jalur masuk mahasiswa adalah akun Google Workspace institusi.
 * - Akun mahasiswa TIDAK dibuat manual oleh admin. Begitu mahasiswa
 *   berhasil login dengan akun Google berdomain kampus, sistem melakukan
 *   auto-provisioning (membuat baris `users` baru dengan role=mahasiswa)
 *   karena kepemilikan email @student.stikomyos.ac.id itu sendiri sudah
 *   menjadi bukti keabsahan sebagai mahasiswa aktif (domain dikelola oleh
 *   kampus). Admin hanya bertugas melengkapi data (NIM/Prodi) lewat menu
 *   Edit setelah akun terbentuk.
 * - Admin & psikolog TETAP login email + password (tidak lewat Google) dan
 *   akunnya tetap dibuat manual oleh admin.
 * - Domain @student.stikomyos.ac.id ditegakkan di server (bukan hanya di
 *   pemilih akun Google) agar tidak bisa dipalsukan dari sisi klien.
 */
class GoogleAuthController extends Controller
{
    public function redirect()
    {
        // 'hd' = hint agar pemilih akun Google default ke domain kampus.
        // Penegakan sesungguhnya tetap di callback() di bawah.
        return Socialite::driver('google')
            ->with(['hd' => config('services.google.allowed_domain')])
            ->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google OAuth error: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            return redirect()->route('login')->withErrors(
                ['email' => 'Login Google gagal: ' . $e->getMessage()]
            );
        }

        $email = strtolower($googleUser->getEmail() ?? '');
        $domain = config('services.google.allowed_domain', 'student.stikomyos.ac.id');

        // 1. Tolak email di luar domain kampus
        if (! str_ends_with($email, '@'.$domain)) {
            return redirect()->route('login')->withErrors(
                ['email' => 'Gunakan akun Google kampus (@'.$domain.').']
            );
        }

        // 2. Akun staf (admin/psikolog) tetap wajib login dengan password,
        //    tidak boleh masuk lewat jalur Google meskipun kebetulan
        //    memakai domain kampus.
        $user = User::where('email', $email)->first();
        if ($user && $user->role !== 'mahasiswa') {
            return redirect()->route('login')->withErrors(
                ['email' => 'Akun admin/psikolog wajib login dengan email + password.']
            );
        }

        // 3. Auto-provisioning: akun mahasiswa dibuat otomatis pada login
        //    Google pertama dengan domain kampus tervalidasi. NIM/Prodi
        //    dilengkapi kemudian oleh admin lewat menu Edit Pengguna.
        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName() ?: strstr($email, '@', true),
                'email' => $email,
                'google_id' => $googleUser->getId(),
                'role' => 'mahasiswa',
                'password' => Hash::make(Str::random(40)),
                'email_verified_at' => now(),
            ]);
        } elseif (! $user->google_id) {
            // Tautkan google_id bila akun lama (migrasi) belum pernah login Google.
            $user->update([
                'google_id' => $googleUser->getId(),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();
        $request->session()->flash('login_success', true);

        return redirect()->intended(route('dashboard'));
    }
}
