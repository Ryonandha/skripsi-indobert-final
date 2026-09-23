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
    /**
     * Bangun callback URL dari host yang sedang diakses user.
     * Ini memastikan URL cocok apakah user akses via sipekacare.my.id
     * maupun langsung via URL Azure — keduanya terdaftar di Google Console.
     */
    private function buildCallbackUrl(): string
    {
        // Dengan trustProxies yang sudah dikonfigurasi (termasuk X-Forwarded-Host),
        // request()->getSchemeAndHttpHost() akan mengembalikan host asli
        // (sipekacare.my.id) bukan host internal Azure (127.0.0.1).
        $host = request()->getSchemeAndHttpHost();

        // Jika karena alasan tertentu host masih HTTP (lokal/testing), biarkan.
        // Di produksi (Azure + custom domain) pasti HTTPS.
        return rtrim($host, '/') . '/auth/google/callback';
    }

    public function redirect()
    {
        $callbackUrl = $this->buildCallbackUrl();

        \Illuminate\Support\Facades\Log::info('Google OAuth redirect', [
            'callback_url' => $callbackUrl,
            'request_host' => request()->getSchemeAndHttpHost(),
        ]);

        return Socialite::driver('google')
            ->with(['hd' => config('services.google.allowed_domain')])
            ->redirectUrl($callbackUrl)
            ->redirect();
    }

    public function callback(Request $request)
    {
        $callbackUrl = $this->buildCallbackUrl();

        \Illuminate\Support\Facades\Log::info('Google OAuth callback', [
            'callback_url' => $callbackUrl,
            'request_host' => $request->getSchemeAndHttpHost(),
        ]);

        try {
            $googleUser = Socialite::driver('google')
                ->redirectUrl($callbackUrl)
                ->user();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google OAuth error', [
                'message'      => $e->getMessage(),
                'callback_url' => $callbackUrl,
                'request_url'  => $request->fullUrl(),
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
