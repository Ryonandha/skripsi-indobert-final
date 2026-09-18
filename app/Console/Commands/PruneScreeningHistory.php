<?php

namespace App\Console\Commands;

use App\Models\Screening;
use Illuminate\Console\Command;

/**
 * Kebijakan retensi data (Bab III skripsi - Keamanan Data, SOP Etika &
 * Eskalasi Risiko): riwayat teks curhatan (terenkripsi) dan skor HARS
 * mahasiswa hanya disimpan maksimal 1 semester akademik, lalu dihapus
 * permanen secara otomatis. Command ini dijadwalkan lewat routes/console.php.
 */
class PruneScreeningHistory extends Command
{
    protected $signature = 'screenings:prune
        {--months= : Override masa retensi dalam bulan (default: config screening.retention_months)}
        {--dry-run : Tampilkan jumlah data yang akan dihapus tanpa benar-benar menghapusnya}';

    protected $description = 'Hapus permanen riwayat skrining (teks curhatan & skor HARS) yang sudah melewati masa retensi data (default 1 semester akademik).';

    public function handle(): int
    {
        $months = (int) ($this->option('months') ?: config('screening.retention_months', 6));

        if ($months <= 0) {
            $this->error('Masa retensi (bulan) harus lebih dari 0.');

            return self::FAILURE;
        }

        $cutoff = now()->subMonths($months);

        $query = Screening::where('created_at', '<', $cutoff);
        $count = (clone $query)->count();

        if ($count === 0) {
            $this->info("Tidak ada riwayat skrining yang melewati masa retensi ({$months} bulan, cutoff {$cutoff->toDateString()}).");

            return self::SUCCESS;
        }

        if ($this->option('dry-run')) {
            $this->warn("[Dry-run] {$count} riwayat skrining sebelum {$cutoff->toDateString()} AKAN dihapus jika dijalankan tanpa --dry-run.");

            return self::SUCCESS;
        }

        $query->delete();

        $this->info("Berhasil menghapus {$count} riwayat skrining yang lebih lama dari {$months} bulan (kebijakan retensi 1 semester akademik).");

        return self::SUCCESS;
    }
}
