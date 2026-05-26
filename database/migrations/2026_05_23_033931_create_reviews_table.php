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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            
            // Sambungkan ke tabel users
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // ✅ UBAH DI SINI: Gunakan menu_id agar Laravel menyambungkannya ke tabel 'menus'
            $table->foreignId('menu_id')->constrained()->cascadeOnDelete(); 
            
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->string('photo_path')->nullable();
            $table->text('merchant_reply')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
