<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->foreignId('kursus_id')
                  ->nullable() // Nullable dulu
                  ->after('id') // Tentukan posisinya
                  ->constrained('kursus') // Baru foreign constraint
                  ->onDelete('restrict'); // Atur apa yang terjadi pada penghapusan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materi', function (Blueprint $table) {
            $table->dropColumn('kursus_id');
        });
    }
};
