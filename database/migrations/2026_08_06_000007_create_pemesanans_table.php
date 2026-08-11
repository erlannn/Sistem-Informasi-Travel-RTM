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
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id('id_pemesanan');
            $table->foreignId('id_penumpang')->constrained('penumpangs', 'id_penumpang')->cascadeOnDelete();
            $table->foreignId('id_jadwal')->constrained('jadwals', 'id_jadwal')->cascadeOnDelete();
            $table->foreignId('id_kursi')->nullable()->constrained('kursis', 'id_kursi')->nullOnDelete();
            $table->date('tanggal_pesan');
            $table->integer('jumlah_penumpang')->default(1);
            $table->decimal('total_bayar', 12, 2)->default(0.00);
            $table->string('metode_pembayaran', 50)->default('Cash');
            $table->enum('status_pembayaran', ['Belum Bayar', 'Lunas'])->default('Belum Bayar');
            $table->enum('status_perjalanan', ['Pending', 'Naik', 'Selesai', 'Batal'])->default('Pending');
            $table->timestamp('waktu_bayar')->nullable();
            $table->boolean('is_setor_admin')->default(false);
            $table->timestamp('tanggal_setor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
