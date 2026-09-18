<?php

namespace App\Services;

/**
 * Rule-Based Fusion: Emosi Dominan (IndoBERT) + Skor HARS -> Risk Level
 *
 * Logika stratifikasi (dipublikasikan di Bab III skripsi):
 *
 * 1. Kategori HARS (instrumen klinis utama):
 *    - skor < 14  : tidak cemas
 *    - skor 14-20 : ringan
 *    - skor 21-27 : sedang
 *    - skor >= 28 : berat/panik
 *
 * 2. Emosi distress (Anger/Fear/Sadness) menaikkan satu level jika
 *    skor HARS masih di bawah ambang kategori berikutnya.
 *    Emosi Non-distress tidak mengubah level.
 *
 * 3. Risiko TINGGI otomatis jika HARS >= 28, ATAU HARS sedang (21-27)
 *    dengan emosi distress ber-confidence tinggi (>= 0.70).
 */
class RiskFusionService
{
    public const DISTRESS = ['Anger', 'Fear', 'Sadness'];

    public function compute(int $harsScore, string $emotionLabel, float $confidence): array
    {
        // ---- Level dasar dari HARS (instrumen klinis) ----
        if ($harsScore < 14) {
            $level = 'rendah';
        } elseif ($harsScore < 21) {
            $level = 'rendah';      // ringan -> belum naik level
        } elseif ($harsScore < 28) {
            $level = 'sedang';
        } else {
            $level = 'tinggi';
        }

        $isDistress = in_array($emotionLabel, self::DISTRESS, true);

        // ---- Modifikasi oleh emosi dominan ----
        if ($isDistress && $confidence >= 0.70) {
            if ($harsScore >= 14 && $harsScore < 21) {
                $level = 'sedang';          // ringan + distress kuat -> sedang
            } elseif ($harsScore >= 21 && $harsScore < 28) {
                $level = 'tinggi';          // sedang + distress kuat -> tinggi
            }
        }

        return [
            'risk_level' => $level,
            'recommendation' => $this->recommendation($level),
        ];
    }

    protected function recommendation(string $level): string
    {
        return match ($level) {
            'rendah' => 'Kondisi kamu tergolong stabil. Pertahankan pola istirahat yang cukup, '
                      . 'aktif bergerak, dan baca artikel edukasi di sistem ini agar tetap sehat secara emosional.',
            'sedang' => 'Terdapat indikasi tekanan emosional yang perlu diperhatikan. '
                      . 'Coba teknik pernapasan, kurangi beban sementara, dan pertimbangkan berbagi cerita '
                      . 'dengan orang terpercaya atau konselor kampus.',
            'tinggi' => 'Hasil skrining menunjukkan risiko kecemasan tinggi. '
                      . 'Sangat disarankan untuk berkonsultasi dengan psikolog/konselor kampus. '
                      . 'Kamu tidak sendiri - bantuan tersedia.',
            default => '',
        };
    }
}
