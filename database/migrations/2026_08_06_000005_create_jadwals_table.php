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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('id_armada')->constrained('armadas', 'id_armada')->cascadeOnDelete();
            $table->foreignId('id_sopir')->constrained('sopirs', 'id_sopir')->cascadeOnDelete();
            $table->string('asal');
            $table->string('tujuan');
            $table->date('tanggal');
            $table->time('jam');
            $table->decimal('harga', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
