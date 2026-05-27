<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('dampak_lingkungan')) {
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

        if (Schema::hasTable('environmental_impacts') && Schema::hasTable('dampak_lingkungan')) {
            DB::statement('
                INSERT INTO dampak_lingkungan (id, user_id, food_saved_kg, co2_reduced_kg, money_saved, total_rescues, created_at, updated_at)
                SELECT e.id, e.user_id, e.food_saved_kg, e.co2_reduced_kg, e.money_saved, e.total_rescues, e.created_at, e.updated_at
                FROM environmental_impacts e
                LEFT JOIN dampak_lingkungan d ON d.user_id = e.user_id
                WHERE d.user_id IS NULL
            ');
        }
    }

    public function down(): void
    {
        // no-op: keep table/data safe
    }
};
