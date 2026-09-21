<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // true = pesan dari mahasiswa ke psikolog (balasan)
            // false (default) = pesan dari psikolog ke mahasiswa
            $table->boolean('is_from_student')->default(false)->after('is_read');
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('is_from_student');
        });
    }
};
