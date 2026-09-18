<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Kebijakan retensi data (Bab III skripsi): hapus riwayat skrining (teks
// curhatan & skor HARS) yang lebih lama dari 1 semester akademik.
// Lihat App\Console\Commands\PruneScreeningHistory & config/screening.php.
// Catatan: scheduler ini hanya jalan bila cron server memanggil
// `php artisan schedule:run` setiap menit (lihat dokumentasi deployment).
Schedule::command('screenings:prune')->dailyAt('02:00');
