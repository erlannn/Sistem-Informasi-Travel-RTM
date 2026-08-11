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
        if (Schema::hasColumn('sopirs', 'gaji')) {
            Schema::table('sopirs', function (Blueprint $table) {
                $table->dropColumn('gaji');
            });
        }

        if (!Schema::hasColumn('jadwals', 'bagi_hasil_sopir')) {
            Schema::table('jadwals', function (Blueprint $table) {
                $table->decimal('bagi_hasil_sopir', 12, 2)->default(0.00)->after('harga');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('sopirs', 'gaji')) {
            Schema::table('sopirs', function (Blueprint $table) {
                $table->decimal('gaji', 12, 2)->default(0.00);
            });
        }

        if (Schema::hasColumn('jadwals', 'bagi_hasil_sopir')) {
            Schema::table('jadwals', function (Blueprint $table) {
                $table->dropColumn('bagi_hasil_sopir');
            });
        }
    }
};
