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
        Schema::table('armadas', function (Blueprint $table) {
            if (!Schema::hasColumn('armadas', 'kursi')) {
                $table->integer('kursi')->default(5)->after('warna');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('armadas', function (Blueprint $table) {
            if (Schema::hasColumn('armadas', 'kursi')) {
                $table->dropColumn('kursi');
            }
        });
    }
};
