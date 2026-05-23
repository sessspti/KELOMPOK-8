<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * AC 5 — Log Pengambilan
     * Menambahkan kolom `picked_up_at` (timestamp, nullable) pada tabel orders
     * untuk mencatat waktu penyerahan pesanan self-pickup ke pembeli.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Ditempatkan setelah kolom pickup_method
            $table->timestamp('picked_up_at')->nullable()->after('pickup_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('picked_up_at');
        });
    }
};
