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
        Schema::create('pd_kursus', function(Blueprint $table) {
            $table->id();
            $table->foreignId('id_krs')->constrained('kursus')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('id_mrd')->constrained('murid')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('biaya')->constrained('kursus')->onDelete('restrict')->onUpdate('restrict');
            $table->string('status');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pd_kursus');
    }
};
