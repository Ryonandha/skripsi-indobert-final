<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Screening;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * ADMIN TEKNIS: mengelola edukasi + CRUD pengguna (mahasiswa & psikolog).
 * Catatan etika: admin TIDAK melihat isi teks curhatan (hanya agregat).
 */
class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_mahasiswa' => User::where('role', 'mahasiswa')->count(),
            'total_psikolog' => User::where('role', 'psikolog')->count(),
            'total_screening' => Screening::count(),
            'risk_rendah' => Screening::where('risk_level', 'rendah')->count(),
            'risk_sedang' => Screening::where('risk_level', 'sedang')->count(),
            'risk_tinggi' => Screening::where('risk_level', 'tinggi')->count(),
            'consent_count' => Screening::where('consent_followup', true)->count(),
        ];

        // Distribusi emosi dominan (agregat)
        $emotionStats = Screening::selectRaw('emotion_label, COUNT(*) as total')
            ->groupBy('emotion_label')
            ->pluck('total', 'emotion_label');

        return view('admin.dashboard', compact('stats', 'emotionStats'));
    }

    public function educations()
    {
        $educations = Education::latest()->paginate(10);
        return view('admin.educations.index', compact('educations'));
    }

    public function createEducation()
    {
        return view('admin.educations.form', ['education' => new Education()]);
    }

    public function storeEducation(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        Education::create($validated + ['slug' => Str::slug($validated['title'])]);

        return redirect()->route('admin.educations')->with('success', 'Artikel edukasi ditambahkan.');
    }

    public function editEducation(Education $education)
    {
        return view('admin.educations.form', compact('education'));
    }

    public function updateEducation(Request $request, Education $education)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $education->update($validated + ['slug' => Str::slug($validated['title'])]);

        return redirect()->route('admin.educations')->with('success', 'Artikel diperbarui.');
    }

    public function destroyEducation(Education $education)
    {
        $education->delete();
        return back()->with('success', 'Artikel dihapus.');
    }

    // ================= CRUD PENGGUNA =================

    public function users(Request $request)
    {
        $role = $request->get('role', 'mahasiswa');
        abort_unless(in_array($role, ['mahasiswa', 'psikolog']), 404);

        $users = User::where('role', $role)
            ->when($request->q, fn ($q, $s) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$s}%")
                ->orWhere('nim', 'like', "%{$s}%")
                ->orWhere('email', 'like', "%{$s}%")))
            ->withCount('screenings')
            ->latest()->paginate(15)->withQueryString();

        return view('admin.users', compact('users', 'role'));
    }

    /**
     * Akun mahasiswa TIDAK dibuat manual di sini (lihat GoogleAuthController):
     * akun mereka auto-provisioning saat login Google pertama dengan email
     * kampus. Form "Tambah Pengguna" khusus untuk akun staf (Psikolog/
     * Konselor) yang memang login dengan email + password lokal.
     */
    public function createUser()
    {
        return view('admin.users-form', ['user' => new User(), 'role' => 'psikolog']);
    }

    public function storeUser(Request $request)
    {
        $validated = $this->validateUser($request, role: 'psikolog');

        User::create($validated + [
            'role' => 'psikolog',
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.users', ['role' => 'psikolog'])
            ->with('success', 'Akun psikolog baru berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        return view('admin.users-form', ['user' => $user, 'role' => $user->role]);
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $this->validateUser($request, role: $user->role, ignoreId: $user->id, isUpdate: true);

        // Password hanya relevan untuk staf (psikolog); mahasiswa login via
        // Google sehingga field password tidak pernah divalidasi/disimpan.
        if ($user->role === 'psikolog' && ! empty($validated['password'])) {
            $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }
        unset($validated['password']);

        $user->update($validated);

        return redirect()->route('admin.users', ['role' => $user->role])
            ->with('success', 'Data pengguna diperbarui.');
    }

    public function destroyUser(User $user)
    {
        abort_if($user->id === auth()->id(), 403, 'Tidak bisa menghapus akun sendiri.');

        $role = $user->role;
        $user->delete();

        return redirect()->route('admin.users', ['role' => $role])
            ->with('success', 'Pengguna dihapus.');
    }

    private function validateUser(Request $request, string $role, ?int $ignoreId = null, bool $isUpdate = false): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ];

        if (!$isUpdate) {
            $rules['email'] = ['required', 'email', 'max:255', Rule::unique('users')];
        }

        if ($role === 'mahasiswa') {
            // Mahasiswa hanya bisa diedit (bukan dibuat di sini) dan login
            // lewat Google, sehingga tidak ada field password untuk role ini.
            $rules['prodi'] = ['nullable', 'string', 'max:100'];
            $rules['nim'] = ['nullable', 'string', 'digits:7', Rule::unique('users')->ignore($ignoreId)];

            return $request->validate($rules);
        }

        // Psikolog tetap pakai password lokal (wajib saat dibuat, opsional saat edit).
        $rules['password'] = $isUpdate ? ['nullable', 'string', 'min:8'] : ['required', 'string', 'min:8'];

        return $request->validate($rules);
    }
}
