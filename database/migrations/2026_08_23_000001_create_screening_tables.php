<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom role & profil ke tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['mahasiswa', 'admin', 'psikolog'])->default('mahasiswa')->after('password');
            $table->string('nim')->nullable()->unique()->after('role');
            $table->string('phone')->nullable()->after('nim');
        });

        // Riwayat skrining: teks curhatan (dienkripsi), hasil AI, skor HARS, risk level, consent
        Schema::create('screenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('narrative')->comment('Teks curhatan mahasiswa (AES-256 encrypted)');
            $table->string('emotion_label')->comment('Anger/Fear/Sadness/Non-distress Emosional');
            $table->decimal('emotion_confidence', 5, 4);
            $table->json('emotion_probabilities')->nullable();
            $table->unsignedTinyInteger('hars_score')->nullable()->comment('0-56');
            $table->json('hars_answers')->nullable();
            $table->enum('risk_level', ['rendah', 'sedang', 'tinggi']);
            $table->text('recommendation')->nullable();
            $table->boolean('consent_followup')->default(false)->comment('Persetujuan rujukan konselor');
            $table->timestamp('consented_at')->nullable();

            // Penanganan oleh psikolog
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('handling_status', ['belum', 'diproses', 'selesai'])->default('belum');
            $table->text('handling_notes')->nullable();
            $table->timestamps();

            $table->index(['risk_level', 'consent_followup']);
        });

        // Artikel edukasi
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
        Schema::dropIfExists('screenings');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'nim', 'phone']);
        });
    }
};
