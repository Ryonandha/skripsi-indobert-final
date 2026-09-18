<?php

namespace App\Http\Controllers\Psikolog;

use App\Http\Controllers\Controller;
use App\Mail\CounselingScheduledMail;
use App\Mail\PsychologistMessageMail;
use App\Models\Screening;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

/**
 * PSIKOLOG/KONSELOR: Mengelola follow-up mahasiswa.
 * Fitur:
 * - Dashboard: ringkasan kasus
 * - Daftar Pasien: semua mahasiswa (bisa filter), bisa hubungi proaktif
 * - Jadwal: kelola sesi konseling
 * - Catatan: catatan progres per mahasiswa
 * - Hubungi Mahasiswa: kirim undangan konseling (proaktif, tanpa consent)
 */
class PsikologController extends Controller
{
    /**
     * Dashboard: ringkasan statistik kasus hari ini.
     */
    public function dashboard(Request $request)
    {
        $today = now()->startOfDay();

        $stats = [
            'total_butuh_dampingan' => Screening::where('consent_followup', true)
                ->whereIn('risk_level', ['sedang', 'tinggi'])
                ->count(),
            'belum_ditangani' => Screening::where('consent_followup', true)
                ->whereIn('risk_level', ['sedang', 'tinggi'])
                ->where('handling_status', 'belum')
                ->count(),
            'sedang_diproses' => Screening::where('handling_status', 'diproses')->count(),
            'selesai_bulan_ini' => Screening::where('handling_status', 'selesai')
                ->where('updated_at', '>=', now()->startOfMonth())
                ->count(),
            'risiko_tinggi_tanpa_consent' => Screening::where('risk_level', 'tinggi')
                ->where('consent_followup', false)
                ->count(),
        ];

        // Kasus terbaru butuh perhatian
        $urgentCases = Screening::where('consent_followup', true)
            ->whereIn('risk_level', ['sedang', 'tinggi'])
            ->where('handling_status', 'belum')
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('psikolog.dashboard', compact('stats', 'urgentCases'));
    }

    /**
     * Daftar Semua Mahasiswa (Pasien Potensial).
     * Psikolog bisa lihat semua mahasiswa, filter berdasarkan risk level,
     * dan mengirim undangan konseling secara proaktif.
     */
    public function patients(Request $request)
    {
        $query = User::where('role', 'mahasiswa')
            ->withCount(['screenings' => function ($q) {
                $q->whereIn('risk_level', ['sedang', 'tinggi']);
            }])
            ->with(['screenings' => function ($q) {
                $q->whereIn('risk_level', ['sedang', 'tinggi'])->latest()->limit(1);
            }])
            ->when($request->risk, function ($q, $risk) {
                $q->whereHas('screenings', function ($sq) use ($risk) {
                    $sq->where('risk_level', $risk);
                });
            })
            ->when($request->search, function ($q, $search) {
                $q->where(function ($w) use ($search) {
                    $w->where('name', 'like', "%{$search}%")
                      ->orWhere('nim', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($request->consent_only, function ($q) {
                $q->whereHas('screenings', function ($sq) {
                    $sq->where('consent_followup', true);
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('psikolog.patients', compact('query'));
    }

    /**
     * Detail mahasiswa + riwayat skrining + form kirim undangan.
     */
    public function patientDetail(User $student)
    {
        abort_unless($student->role === 'mahasiswa', 403);

        $screenings = $student->screenings()
            ->with('handler')
            ->latest()
            ->get();

        $latestScreening = $screenings->first();

        $latestConsent = $student->screenings()
            ->where('consent_followup', true)
            ->latest()
            ->first();

        return view('psikolog.patient-detail', compact('student', 'screenings', 'latestConsent', 'latestScreening'));
    }

    /**
     * Detail hasil skrining milik pasien — versi psikolog.
     * Privasi: teks curhatan TIDAK ditampilkan (enkripsi AES-256 tetap
     * berlaku; psikolog hanya melihat metrik emosi, skor HARS, risiko,
     * dan rekomendasi sistem — sesuai desain Bab III).
     */
    public function screeningDetail(Screening $screening)
    {
        abort_unless($screening->user->role === 'mahasiswa', 403);

        return view('psikolog.screening-detail', [
            'screening' => $screening,
            'student' => $screening->user,
        ]);
    }

    /**
     * Kirim undangan konseling ke mahasiswa (proaktif).
     * Bisa dipakai untuk risiko tinggi yang belum consent.
     * Pesan TERSIMPAN ke tabel messages agar mahasiswa bisa membacanya.
     */
    public function contactStudent(Request $request, Screening $screening)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        // Simpan pesan agar terlihat oleh mahasiswa (halaman Notifikasi)
        $msg = \App\Models\Message::create([
            'psychologist_id' => auth()->id(),
            'student_id' => $screening->user_id,
            'screening_id' => $screening->id,
            'body' => $request->message,
        ]);

        // Kirim notifikasi email ke mahasiswa
        $student = $screening->user;
        try {
            Mail::to($student->email)->send(
                new PsychologistMessageMail($msg, auth()->user(), $student)
            );
        } catch (\Exception $e) {
            Log::warning('Gagal kirim email notifikasi ke mahasiswa', [
                'student_email' => $student->email,
                'error' => $e->getMessage(),
            ]);
        }

        // Log aktivitas kontak
        Log::channel('psikolog')->info('Konselor menghubungi mahasiswa', [
            'psikolog_id' => auth()->id(),
            'mahasiswa_id' => $screening->user_id,
            'screening_id' => $screening->id,
            'message' => $request->message,
        ]);

        // Update screening: catat sudah dihubungi
        $screening->update([
            'handling_status' => 'diproses',
            'handled_by' => auth()->id(),
            'handling_notes' => ($screening->handling_notes ? $screening->handling_notes . "\n---\n" : '')
                . "[" . now()->format('d M Y H:i') . "] Konselor menghubungi: " . $request->message,
        ]);

        return back()->with('success', 'Undangan konseling terkirim ke mahasiswa (+ email).');
    }

    /**
     * Jadwal Konseling — daftar + tambah sesi (CRUD sederhana).
     */
    public function schedule(Request $request)
    {
        $schedules = \App\Models\CounselingSchedule::where('psychologist_id', auth()->id())
            ->with('student')
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->get()
            ->groupBy(fn ($s) => $s->status === 'dijadwalkan' && $s->scheduled_date->isFuture() ? 'upcoming' : 'past');

        $students = User::where('role', 'mahasiswa')->orderBy('name')->get();

        return view('psikolog.schedule', compact('schedules', 'students'));
    }

    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', Rule::exists('users', 'id')->where('role', 'mahasiswa')],
            'scheduled_date' => ['required', 'date', 'after_or_equal:today'],
            'scheduled_time' => ['required', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $schedule = \App\Models\CounselingSchedule::create($validated + ['psychologist_id' => auth()->id()]);

        // Beri tahu mahasiswa lewat pesan otomatis
        \App\Models\Message::create([
            'psychologist_id' => auth()->id(),
            'student_id' => $validated['student_id'],
            'body' => 'Anda memiliki jadwal konseling pada '
                . \Carbon\Carbon::parse($validated['scheduled_date'])->format('d M Y')
                . ' pukul ' . $validated['scheduled_time']
                . ($validated['location'] ? ' di ' . $validated['location'] : '')
                . '. Mohon hadir tepat waktu. Terima kasih.',
        ]);

        // Kirim notifikasi email ke mahasiswa
        $student = User::find($validated['student_id']);
        try {
            Mail::to($student->email)->send(
                new CounselingScheduledMail($schedule, auth()->user(), $student)
            );
        } catch (\Exception $e) {
            Log::warning('Gagal kirim email jadwal konseling', [
                'student_email' => $student->email,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('psikolog.schedule')
            ->with('success', 'Jadwal konseling berhasil ditambahkan & mahasiswa telah diberi tahu (+ email).');
    }

    public function updateScheduleStatus(Request $request, \App\Models\CounselingSchedule $schedule)
    {
        abort_unless($schedule->psychologist_id === auth()->id(), 403);

        $validated = $request->validate([
            'status' => ['required', Rule::in(['dijadwalkan', 'selesai', 'dibatalkan'])],
        ]);

        $schedule->update($validated);

        return back()->with('success', 'Status jadwal diperbarui.');
    }

    public function destroySchedule(\App\Models\CounselingSchedule $schedule)
    {
        abort_unless($schedule->psychologist_id === auth()->id(), 403);

        $schedule->delete();

        return back()->with('success', 'Jadwal dihapus.');
    }

    /**
     * Catatan Progres per Mahasiswa.
     */
    public function notes(Request $request)
    {
        $screenings = Screening::where('handling_status', '!=', 'belum')
            ->whereNotNull('handled_by')
            ->with(['user', 'handler'])
            ->latest()
            ->paginate(20);

        return view('psikolog.notes', compact('screenings'));
    }

    /**
     * Update status penanganan (existing).
     */
    public function updateHandling(Request $request, Screening $screening)
    {
        $validated = $request->validate([
            'handling_status' => ['required', 'in:belum,diproses,selesai'],
            'handling_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $screening->update($validated + ['handled_by' => auth()->id()]);

        return back()->with('success', 'Status penanganan diperbarui.');
    }
}