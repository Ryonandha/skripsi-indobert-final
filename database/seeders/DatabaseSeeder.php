<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun demo untuk tiap role
        User::updateOrCreate(
            ['email' => 'admin@stikom.edu'],
            ['name' => 'Admin Teknis', 'password' => bcrypt('password'), 'role' => 'admin', 'nim' => null]
        );
        User::updateOrCreate(
            ['email' => 'psikolog@stikom.edu'],
            ['name' => 'Nilam Sari, M.Psi.', 'password' => bcrypt('password'), 'role' => 'psikolog', 'nim' => null, 'phone' => '081234567890']
        );
        User::updateOrCreate(
            ['email' => 'mahasiswa@stikom.edu'],
            ['name' => 'Rian Mahasiswa', 'password' => bcrypt('password'), 'role' => 'mahasiswa', 'nim' => '202201009', 'phone' => '089876543210']
        );

        // Contoh artikel edukasi
        $educations = [
            [
                'title' => 'Mengenali Perbedaan Stres dan Kecemasan',
                'slug' => 'mengenali-perbedaan-stres-dan-kecemasan',
                'content' => "Stres biasanya muncul karena pemicu yang jelas (tugas menumpuk, deadline) dan mereda setelah pemicu itu selesai. Kecemasan bersifat lebih menghantui: rasa khawatir berlebih terhadap hal yang belum tentu terjadi.\n\nTanda kecemasan yang perlu diwaspadai: sulit tidur, jantung berdebar tanpa sebab jelas, sulit konsentrasi, dan pikiran negatif yang terus berulang. Jika gejala ini bertahan lebih dari 2 minggu dan mengganggu aktivitas, jangan ragu mencari bantuan konselor kampus.",
            ],
            [
                'title' => '5 Teknik Menenangkan Diri Saat Cemas',
                'slug' => '5-teknik-menenangkan-diri-saat-cemas',
                'content' => "1. Pernapasan 4-7-8: tarik napas 4 detik, tahan 7 detik, hembuskan 8 detik.\n2. Grounding 5-4-3-2-1: sebutkan 5 benda yang kamu lihat, 4 yang bisa disentuh, 3 suara, 2 aroma, 1 rasa.\n3. Tulis pikiranmu — menuangkan kecemasan dalam tulisan terbukti membantu otak memprosesnya.\n4. Gerakkan tubuh: jalan 15 menit saja bisa menurunkan hormon stres.\n5. Batasi kafein dan waktu layar sebelum tidur.",
            ],
            [
                'title' => 'Kapan Sebaiknya Konsultasi ke Psikolog?',
                'slug' => 'kapan-sebaiknya-konsultasi-ke-psikolog',
                'content' => "Tidak harus menunggu 'sudah parah' untuk berkonsultasi. Beberapa sinyal yang tepat untuk datang ke konselor:\n\n- Gangguan tidur atau pola makan berlangsung lebih dari 2 minggu\n- Sulit fokus kuliah karena pikiran berkecamuk\n- Menarik diri dari lingkungan sosial\n- Merasa putus asa atau tidak berharga\n\nLayanan konseling kampus gratis dan kerahasiaanmu terjamin. Meminta bantuan adalah bentuk kekuatan, bukan kelemahan.",
            ],
        ];

        foreach ($educations as $edu) {
            Education::updateOrCreate(['slug' => $edu['slug']], $edu);
        }
    }
}
