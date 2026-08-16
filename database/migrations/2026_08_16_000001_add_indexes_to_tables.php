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
        Schema::table('jadwals', function (Blueprint $table) {
            $table->index(['tanggal'], 'idx_jadwals_tanggal');
            $table->index(['asal', 'tujuan', 'tanggal'], 'idx_jadwals_route_tanggal');
            $table->index(['id_sopir', 'tanggal'], 'idx_jadwals_sopir_tanggal');
        });

        Schema::table('pemesanans', function (Blueprint $table) {
            $table->index(['id_jadwal', 'status_perjalanan'], 'idx_pemesanans_jadwal_status');
            $table->index(['status_perjalanan'], 'idx_pemesanans_status_perjalanan');
            $table->index(['status_pembayaran', 'is_setor_admin'], 'idx_pemesanans_bayar_setor');
            $table->index(['tanggal_pesan'], 'idx_pemesanans_tanggal_pesan');
        });

        Schema::table('kursis', function (Blueprint $table) {
            $table->index(['id_jadwal', 'status'], 'idx_kursis_jadwal_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwals', function (Blueprint $table) {
            $table->dropIndex('idx_jadwals_tanggal');
            $table->dropIndex('idx_jadwals_route_tanggal');
            $table->dropIndex('idx_jadwals_sopir_tanggal');
        });

        Schema::table('pemesanans', function (Blueprint $table) {
            $table->dropIndex('idx_pemesanans_jadwal_status');
            $table->dropIndex('idx_pemesanans_status_perjalanan');
            $table->dropIndex('idx_pemesanans_bayar_setor');
            $table->dropIndex('idx_pemesanans_tanggal_pesan');
        });

        Schema::table('kursis', function (Blueprint $table) {
            $table->dropIndex('idx_kursis_jadwal_status');
        });
    }
};
