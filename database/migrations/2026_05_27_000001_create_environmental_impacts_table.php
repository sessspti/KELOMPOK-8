<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dampak_lingkungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->decimal('food_saved_kg', 10, 2)->default(0);
            $table->decimal('co2_reduced_kg', 10, 2)->default(0);
            $table->decimal('money_saved', 14, 2)->default(0);
            $table->unsignedInteger('total_rescues')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dampak_lingkungan');
    }
};
