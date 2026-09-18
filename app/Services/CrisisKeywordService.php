<?php

namespace App\Services;

/**
 * Deteksi kata-kata indikasi krisis (self-harm / bunuh diri) pada teks
 * curhatan mahasiswa.
 *
 * DESAIN (dokumentasikan di Bab III):
 * - Ini adalah "safety net" deterministik yang BERDIRI DI ATAS hasil model:
 *   IndoBERT memprediksi emosi dominan, tetapi keputusan risiko TINGGI untuk
 *   kasus krisis tidak boleh bergantung pada probabilitas model semata.
 *   Jika ditemukan frasa krisis, risk_level DIPAKSA menjadi 'tinggi'
 *     => muncul di dashboard psikolog & admin sebagai peringatan segera,
 *        terlepas dari skor HARS atau label emosi.
 * - Kata disusun dari frasa dulu -> kata tunggal, dipisah per batas kata
 *   (\b), sehingga "bunuh diri" dan "mengakhiri hidup" tertangkap utuh dan
 *   kata umum seperti "mati" (mis. "mati listrik") tetap lolos filter
 *   negasi sederhana ("tidak", "enggak", "nggak", "jangan") pada jendela
 *   25 karakter sebelum kata.
 * - Keterbatasan (jujur di Bab III): pendekatan leksikal bisa false
 *   positive/negative; fungsinya fail-safe, bukan diagnosis.
 */
class CrisisKeywordService
{
    /** Frasa multi-kata dicek lebih dulu (paling spesifik). */
    protected const PHRASES = [
        'bunuh diri', 'bunuhdiri', 'mengakhiri hidup', 'akhir hidupku',
        'akhiri hidup', 'ingin mati', 'mau mati', 'pengen mati',
        'lebih baik mati', 'tidak ada harapan lagi', 'ga ada harapan lagi',
        'gak ada harapan lagi', 'nggak ada harapan lagi', 'capek hidup',
        'capeknya hidup', 'pengen hilang saja', 'pengen menghilang',
        'menyakiti diri sendiri', 'melukai diri sendiri', 'sakitkan diri',
        'menabrakkan', 'jatuh dari lantai', 'minum obat sekotak',
    ];

    /** Kata tunggal berisiko — hanya dicocokkan utuh (\b). */
    protected const WORDS = [
        'bundir', 'bunuh', 'gori', 'melukai', 'talikur', 'overdosis',
        'overdose', 'putus asa',
    ];

    /** Kata "mati" dicek dengan pengecualian konteks non-diri. */
    protected const CONTEXT_WORDS = ['mati', 'bunuhi'];

    /** Penanda negasi sederhana pada jendela sebelum kata. */
    protected const NEGATIONS = [
        'tidak ', 'tak ', 'enggak ', 'nggak ', 'gak ', 'ga ', 'jangan ',
        'biar ', 'sampai ', 'hampir ',
    ];

    /**
     * @return array{flagged: bool, matched: string[]} frasa yang cocok (maks 5).
     */
    public function scan(string $text): array
    {
        $t = mb_strtolower(trim($text));
        if ($t === '') {
            return ['flagged' => false, 'matched' => []];
        }

        $matched = [];

        foreach (self::PHRASES as $phrase) {
            if (mb_strpos($t, $phrase) !== false) {
                $matched[] = $phrase;
            }
        }

        $words = implode('|', array_map('preg_quote', self::WORDS));
        if ($words !== '' && preg_match_all('/\b(?:'.$words.')\b/u', $t, $m)) {
            foreach (array_unique($m[0]) as $w) {
                $matched[] = $w;
            }
        }

        $ctx = implode('|', array_map('preg_quote', self::CONTEXT_WORDS));
        if (preg_match_all('/\b(?:'.$ctx.')\b/u', $t, $m, PREG_OFFSET_CAPTURE)) {
            foreach ($m[1] as [$word, $offset]) {
                if (! $this->isNegated($t, $offset)) {
                    $matched[] = $word;
                }
            }
        }

        return [
            'flagged' => $matched !== [],
            'matched' => array_slice(array_unique($matched), 0, 5),
        ];
    }

    /** True jika ada penanda negasi dalam jendela 25 char sebelum offset. */
    protected function isNegated(string $text, int $offset): bool
    {
        $windowStart = max(0, $offset - 25);
        $window = mb_substr($text, $windowStart, $offset - $windowStart + 1);

        foreach (self::NEGATIONS as $neg) {
            if (mb_strpos($window, $neg) !== false) {
                return true;
            }
        }

        return false;
    }

    /** Pesan aman untuk mahasiswa di halaman hasil skrining. */
    public static function supportMessage(): string
    {
        return 'Kami melihat kamu sedang membawa beban yang sangat berat. '
            .'Kamu tidak sendiri, dan perasaan ini bisa ditolong. '
           .'Tim konselor kampus siap mendampingimu hari ini juga.';
    }
}
