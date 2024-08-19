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
        Schema::create('tugas', function(Blueprint $table) {
            $table->id();
            $table->foreignId('id_mtr')->constrained('materi')->onDelete('restrict')->onUpdate('cascade');
            $table->string('nama_tgs')->unique();
            $table->string('main_task')->unique();
            $table->date('deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
