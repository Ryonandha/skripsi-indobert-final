<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Jadwal konseling (psikolog)
        if (! Schema::hasTable('counseling_schedules')) {
            Schema::create('counseling_schedules', function (Blueprint $table) {
                $table->id();
                $table->foreignId('psychologist_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
                $table->date('scheduled_date');
                $table->time('scheduled_time');
                $table->string('location')->nullable();
                $table->text('notes')->nullable();
                $table->enum('status', ['dijadwalkan', 'selesai', 'dibatalkan'])->default('dijadwalkan');
                $table->timestamps();
            });
        }

        // Pesan / notifikasi psikolog -> mahasiswa
        if (! Schema::hasTable('messages')) {
            Schema::create('messages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('psychologist_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('screening_id')->nullable()->constrained('screenings')->nullOnDelete();
                $table->text('body');
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('counseling_schedules');
    }
};
