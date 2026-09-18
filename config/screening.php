<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Masa Retensi Riwayat Skrining
    |--------------------------------------------------------------------------
    |
    | Sesuai kebijakan keamanan data pada skripsi (Bab III - "Keamanan Data,
    | SOP Etika & Eskalasi Risiko"): riwayat teks curhatan (terenkripsi) dan
    | skor HARS mahasiswa hanya disimpan maksimal 1 semester akademik,
    | setelah itu dihapus permanen secara otomatis.
    |
    | 1 semester akademik didekati dengan 6 bulan. Ubah lewat env
    | SCREENING_RETENTION_MONTHS bila kampus punya definisi lain.
    |
    */

    'retention_months' => env('SCREENING_RETENTION_MONTHS', 6),

];
