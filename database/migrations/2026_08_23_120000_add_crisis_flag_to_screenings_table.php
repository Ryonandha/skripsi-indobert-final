<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('screenings', function (Blueprint $table) {
            // Safety net krisis: true jika teks curhatan memuat indikator
            // self-harm/bunuh diri -> risk_level dipaksa 'tinggi'.
            $table->boolean('crisis_flag')->default(false)->after('risk_level');
            $table->json('crisis_matched')->nullable()->after('crisis_flag');
        });
    }

    public function down(): void
    {
        Schema::table('screenings', function (Blueprint $table) {
            $table->dropColumn(['crisis_flag', 'crisis_matched']);
        });
    }
};
