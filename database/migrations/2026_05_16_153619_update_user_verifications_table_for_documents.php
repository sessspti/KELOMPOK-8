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
        Schema::table('user_verifications', function (Blueprint $table) {
            $table->string('ktp_path')->nullable()->after('user_id');
            $table->string('nib_path')->nullable()->after('ktp_path');
            $table->string('surat_izin_path')->nullable()->after('nib_path');
            $table->string('profil_seller_path')->nullable()->after('surat_izin_path');
            
            // Kolom lama bisa dibuat nullable agar data lama tidak crash, 
            // atau jika belum ada data production, bisa di-drop.
            // Kita drop karena ini baru dibuat di fitur sebelumnya.
            $table->dropColumn('document_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_verifications', function (Blueprint $table) {
            $table->dropColumn(['ktp_path', 'nib_path', 'surat_izin_path', 'profil_seller_path']);
            $table->string('document_path')->nullable()->after('user_id');
        });
    }
};
