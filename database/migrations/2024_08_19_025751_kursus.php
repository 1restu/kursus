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
        Schema::create('kursus', function(Blueprint $table) {
            $table->id();
            $table->string('nama_krs')->unique();
            $table->text('deskripsi');
            $table->foreignId('id_ktg')->constrained('ktg_materi')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('id_mtr')->constrained('materi')->onDelete('restrict')->onUpdate('cascade');
            $table->decimal('biaya_krs');
            $table->string('durasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kursus');
    }
};
