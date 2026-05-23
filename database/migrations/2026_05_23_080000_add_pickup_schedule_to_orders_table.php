<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * AC 2 — Penjadwalan Self-Pickup
     * Menambahkan kolom `pickup_schedule` (string, nullable) pada tabel orders
     * untuk menyimpan jadwal pengambilan yang dipilih konsumen (misal: "15.00 - 15.30 WIB").
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Ditempatkan setelah kolom pickup_method
            $table->string('pickup_schedule')->nullable()->after('pickup_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('pickup_schedule');
        });
    }
};
