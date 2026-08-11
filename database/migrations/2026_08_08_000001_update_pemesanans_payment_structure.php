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
        Schema::table('pemesanans', function (Blueprint $table) {
            if (Schema::hasColumn('pemesanans', 'status')) {
                $table->dropColumn('status');
            }

            if (!Schema::hasColumn('pemesanans', 'total_bayar')) {
                $table->decimal('total_bayar', 12, 2)->default(0.00)->after('jumlah_penumpang');
            }
            if (!Schema::hasColumn('pemesanans', 'metode_pembayaran')) {
                $table->string('metode_pembayaran', 50)->default('Cash')->after('total_bayar');
            }
            if (!Schema::hasColumn('pemesanans', 'status_pembayaran')) {
                $table->enum('status_pembayaran', ['Belum Bayar', 'Lunas'])->default('Belum Bayar')->after('metode_pembayaran');
            }
            if (!Schema::hasColumn('pemesanans', 'status_perjalanan')) {
                $table->enum('status_perjalanan', ['Pending', 'Naik', 'Selesai', 'Batal'])->default('Pending')->after('status_pembayaran');
            }
            if (!Schema::hasColumn('pemesanans', 'waktu_bayar')) {
                $table->timestamp('waktu_bayar')->nullable()->after('status_perjalanan');
            }
            if (!Schema::hasColumn('pemesanans', 'is_setor_admin')) {
                $table->boolean('is_setor_admin')->default(false)->after('waktu_bayar');
            }
            if (!Schema::hasColumn('pemesanans', 'tanggal_setor')) {
                $table->timestamp('tanggal_setor')->nullable()->after('is_setor_admin');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            if (!Schema::hasColumn('pemesanans', 'status')) {
                $table->string('status')->default('Pending')->after('jumlah_penumpang');
            }

            $table->dropColumn([
                'total_bayar',
                'metode_pembayaran',
                'status_pembayaran',
                'status_perjalanan',
                'waktu_bayar',
                'is_setor_admin',
                'tanggal_setor',
            ]);
        });
    }
};
