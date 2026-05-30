<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            // Konsumen yang melaporkan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Seller yang dilaporkan
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            // Isi teks keluhan
            $table->text('reason');
            // Status keluhan (pending, ditinjau, selesai)
            $table->string('status')->default('pending');
            // Tanggapan/balasan resmi dari admin platform
            $table->text('admin_reply')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }

    /**
     * Menyelesaikan error: Memproses form balasan statis dari dashboard admin
     */
    public function adminReply(Request $request, Complaint $complaint)
    {
        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        // Simpan balasan langsung ke teks chat baru agar konsumen bisa membaca di halaman chat mereka
        $complaint->messages()->create([
            'user_id'      => auth()->id(),
            'message'      => $request->admin_reply,
            'sender_role'  => 'admin',
            'is_read'      => false,
        ]);

        // Otomatis ubah status keluhan menjadi selesai setelah admin merespon dari dashboard
        $complaint->update(['status' => 'selesai']);

        return back()->with('success', 'Tanggapan keluhan berhasil dikirim dan status diperbarui menjadi selesai!');
    }
};