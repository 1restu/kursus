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
        Schema::table('kursus_materi', function (Blueprint $table) {
            Schema::dropIfExists('kursus_materi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('kursus_materi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_krs')->constrained('kursus')->onDelete('restrict');
            $table->foreignId('id_mtr')->constrained('materi')->onDelete('restrict');
            $table->timestamps();
        });
    }
};
