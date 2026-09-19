<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Screening;
use App\Services\CrisisKeywordService;
use App\Services\IndoBERTService;
use App\Services\RiskFusionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScreeningController extends Controller
{
    /** Cooldown HARS: 14 hari (sesuai desain agar hasil tidak bias) */
    public const HARS_COOLDOWN_DAYS = 14;

    /**
     * 14 item HARS (Hamilton Anxiety Rating Scale) — ADAPTASI SELF-RAPOR.
     * Catatan metodologis (dokumentasikan di Bab III): HARS asli adalah
     * instrumen clinician-rated; versi ini mengubah sudut pandang menjadi
     * pengalaman yang dilaporkan sendiri oleh responden, termasuk item 14
     * (aslinya observasi perilaku saat wawancara) yang direframe sebagai
     * perilaku yang DIRASAKAN responden ketika berbicara di depan orang.
     * Setiap item dinilai 0-4 oleh responden.
     */
    public const HARS_ITEMS = [
        ['id' => 1,  'nama' => 'Perasaan cemas & khawatir',   'gejala' => 'Merasa khawatir berlebihan, mudah tersinggung, atau takut pada pikiran sendiri',
         'contoh' => 'Misal: ada rasa tidak enak terus, padahal tidak ada masalah berarti'],
        ['id' => 2,  'nama' => 'Ketegangan & gelisah',        'gejala' => 'Badan terasa tegang, lesu, mudah kaget, gemetar, atau sulit diam',
         'contoh' => 'Misal: bahu kaku, gampang kaget suara kecil, sulit santai'],
        ['id' => 3,  'nama' => 'Rasa takut',                  'gejala' => 'Takut pada tempat gelap, orang asing, keramaian, atau hal tertentu',
         'contoh' => 'Misal: takut keluar sendiri, takut keramaian, takut ditunjuk bicara'],
        ['id' => 4,  'nama' => 'Gangguan tidur',              'gejala' => 'Sulit mulai tidur, sering terbangun malam, atau mimpi buruk',
         'contoh' => 'Misal: berguling 1–2 jam baru bisa tidur, atau bangun jam 3 pagi'],
        ['id' => 5,  'nama' => 'Sulit konsentrasi & ingat','gejala' => 'Daya ingat menurun, susah fokus pada pembelajaran atau pekerjaan',
         'contoh' => 'Misal: membaca materi berkali-kali tetapi tidak masuk, sering lupa'],
        ['id' => 6,  'nama' => 'Suasana hati murung',         'gejala' => 'Kehilangan minat, mudah sedih, suasana hati naik-turun',
         'contoh' => 'Misal: hilang semangat untuk hobi, menangis tanpa sebab yang jelas'],
        ['id' => 7,  'nama' => 'Nyeri atau kaku otot',        'gejala' => 'Otot nyeri, terasa kaku, berkedut, atau suara bergetar',
         'contoh' => 'Misal: bahu dan punggung pegal terus, kelopak mata berkedut'],
        ['id' => 8,  'nama' => 'Indra terganggu',             'gejala' => 'Telinga berdengung, pandangan kabur, atau badan terasa lemas',
         'contoh' => 'Misal: kuping berbunyi “niiiing”, mata buram sesaat, kaki lemas'],
        ['id' => 9,  'nama' => 'Jantung berdebar',            'gejala' => 'Detak jantung cepat, dada berdebar, atau nyeri dada',
         'contoh' => 'Misal: deg-degan padahal tidak berolahraga'],
        ['id' => 10, 'nama' => 'Sesak napas',                 'gejala' => 'Dada terasa tertekan, seperti tersedak, atau napas pendek',
         'contoh' => 'Misal: napas pendek-pendek saat cemas, seperti kehabisan udara'],
        ['id' => 11, 'nama' => 'Gangguan lambung',            'gejala' => 'Sulit menelan, mual, perut melilit, atau kembung',
         'contoh' => 'Misal: mual setiap mau berangkat kuliah, perut bunyi saat stres'],
        ['id' => 12, 'nama' => 'Ke toilet lebih sering',      'gejala' => 'Buang air kecil lebih sering; bagi perempuan, siklus haid ikut terpengaruh',
         'contoh' => 'Misal: ke toilet terus-menerus padahal minum seperti biasa'],
        ['id' => 13, 'nama' => 'Reaksi tubuh otomatis',       'gejala' => 'Mulut kering, keringat berlebihan, pusing, atau merinding',
         'contoh' => 'Misal: tangan dingin berkeringat, kepala pusing sesaat'],
        ['id' => 14, 'nama' => 'Dirimu saat bicara di depan orang', 'gejala' => 'Saat berbicara/diwawancarai: gelisah, tidak tenang, wajah tegang, jari gemetar',
         'contoh' => 'Ingat saat presentasi/interview terakhir: apakah tangan gemetar, suara getar, sulit duduk tenang?'],
    ];

    public function dashboard(Request $request)
    {
        $user = $request->user();
        $latest = $user->screenings()->latest()->first();
        $canFillHars = $this->harsCooldownOver($user);

        return view('mahasiswa.dashboard', compact('latest', 'canFillHars'));
    }

    public function create()
    {
        if (!auth()->user()->hasCompleteProfile()) {
            return redirect()->route('profile.edit')
                ->with('error', 'Harap lengkapi informasi profil Anda (NIM dan Program Studi) sebelum melakukan skrining.');
        }

        $canFillHars = $this->harsCooldownOver(auth()->user());
        return view('mahasiswa.screening-form', [
            'harsItems' => self::HARS_ITEMS,
            'canFillHars' => $canFillHars,
            'nextHarsAt' => auth()->user()->screenings()->latest()->value('created_at')
                ?->addDays(self::HARS_COOLDOWN_DAYS)->format('d M Y'),
        ]);
    }

    public function store(Request $request, IndoBERTService $indobert, RiskFusionService $fusion, CrisisKeywordService $crisisService)
    {
        if (!auth()->user()->hasCompleteProfile()) {
            return redirect()->route('profile.edit')
                ->with('error', 'Harap lengkapi informasi profil Anda (NIM dan Program Studi) sebelum melakukan skrining.');
        }

        $validated = $request->validate([
            'narrative' => ['required', 'string', 'min:20', 'max:1000'],
            'hars' => ['array', 'size:14'],
            'hars.*' => ['integer', 'between:0,4'],
        ], [
            'narrative.required' => 'Curhatan wajib diisi.',
            'narrative.min' => 'Ceritakan minimal 20 karakter agar dapat dianalisis.',
            'hars.size' => 'Semua pertanyaan kuesioner wajib diisi.',
        ]);

        // ---- LANGKAH 1: Prediksi emosi dominan via IndoBERT API ----
        try {
            $ai = $indobert->predict($validated['narrative']);
        } catch (\RuntimeException $e) {
            return back()->withInput()->withErrors(['narrative' => $e->getMessage()]);
        }

        // ---- Skor HARS (0-56). Jika cooldown, gunakan skor skrining terakhir. ----
        $lastWithHars = auth()->user()->screenings()
            ->whereNotNull('hars_score')->latest()->first();

        if ($this->harsCooldownOver(auth()->user()) || ! $lastWithHars) {
            $harsScore = array_sum($validated['hars']);
            $harsAnswers = $validated['hars'];
        } else {
            $harsScore = $lastWithHars->hars_score;
            $harsAnswers = null; // pakai riwayat terakhir
        }

        // ---- LANGKAH 2: Rule-based fusion -> Risk Level ----
        $result = $fusion->compute($harsScore, $ai['emotion'], $ai['confidence']);

        // ---- LANGKAH 3: Safety net kata krisis (Bab III) ----
        // Indikator self-harm/bunuh diri memaksa risk_level = 'tinggi',
        // apa pun hasil model & skor HARS, agar segera muncul di dashboard
        // psikolog/admin dan mahasiswa langsung diberi info dukungan.
        $crisis = $crisisService->scan($validated['narrative']);
        if ($crisis['flagged']) {
            $result['risk_level'] = 'tinggi';
            $result['recommendation'] = 'Terdeteksi indikasi krisis yang membutuhkan '
                .'perhatian segera. Segera hubungi konselor kampus atau layanan '
                .'darurat. Jangan tunda — kamu tidak sendiri.';
        }

        $screening = auth()->user()->screenings()->create([
            'narrative' => $validated['narrative'],
            'emotion_label' => $ai['emotion'],
            'emotion_confidence' => $ai['confidence'],
            'emotion_probabilities' => $ai['probabilities'] ?? null,
            'hars_score' => $harsScore,
            'hars_answers' => $harsAnswers,
            'risk_level' => $result['risk_level'],
            'recommendation' => $result['recommendation'],
            'crisis_flag' => $crisis['flagged'],
            'crisis_matched' => $crisis['flagged'] ? $crisis['matched'] : null,
        ]);

        return redirect()->route('mahasiswa.screening.show', $screening);
    }

    public function show(Screening $screening)
    {
        $this->authorizeAccess($screening);
        return view('mahasiswa.screening-result', compact('screening'));
    }

    /** Mahasiswa memberikan consent untuk follow-up psikolog */
    public function consent(Request $request, Screening $screening)
    {
        $this->authorizeAccess($screening);

        if (! in_array($screening->risk_level, ['sedang', 'tinggi'])) {
            return back()->withErrors('Persetujuan rujukan hanya untuk risiko sedang/tinggi.');
        }

        $screening->update([
            'consent_followup' => true,
            'consented_at' => now(),
        ]);

        return back()->with('success',
            'Terima kasih. Konselor kampus akan menghubungi kamu untuk pendampingan.');
    }

    public function history(Request $request)
    {
        $screenings = $request->user()->screenings()->latest()->paginate(10);
        return view('mahasiswa.history', compact('screenings'));
    }

    /**
     * Hak mahasiswa menghapus riwayat curhatannya sendiri kapan saja secara
     * permanen (Bab III skripsi - Keamanan Data, SOP Etika & Eskalasi Risiko),
     * melengkapi kebijakan retensi otomatis di PruneScreeningHistory.
     */
    public function destroy(Screening $screening)
    {
        $this->authorizeAccess($screening);

        $screening->delete();

        return redirect()->route('mahasiswa.history')
            ->with('success', 'Riwayat skrining berhasil dihapus permanen.');
    }

    protected function harsCooldownOver($user): bool
    {
        $last = $user->screenings()->whereNotNull('hars_score')->latest()->first();

        return ! $last
            || $last->created_at->addDays(self::HARS_COOLDOWN_DAYS)->isPast();
    }

    protected function authorizeAccess(Screening $screening): void
    {
        abort_unless($screening->user_id === auth()->id(), 403);
    }
}

