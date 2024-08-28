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
        Schema::table('murid', function (Blueprint $table) {
            $table->string('no_tlp')->change();
            $table->text('alamat')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('murid', function (Blueprint $table) {
            $table->Integer('no_tlp')->unique();
            $table->string('alamat');
        });
    }
};
