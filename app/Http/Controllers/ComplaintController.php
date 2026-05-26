<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\ComplaintMessage;
use App\Models\User;

class ComplaintController extends Controller
{
    /**
     * Konsumen/Lembaga mengirim laporan baru ke Admin.
     * Alur diperbarui: Langsung membuat chat pertama dan masuk ke ruang chat.
     */
    public function store(Request $request, $sellerId)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
        ], [
            'reason.min' => 'Alasan keluhan minimal harus 10 karakter.',
        ]);

        // Cek jika konsumen mencoba melaporkan dirinya sendiri
        if (auth()->id() == $sellerId) {
            return back()->with('error', 'Anda tidak bisa melaporkan akun Anda sendiri.');
        }

        // 1. Simpan laporan keluhan ke database
        $complaint = Complaint::create([
            'user_id'   => auth()->id(),
            'seller_id' => $sellerId,
            'reason'    => $request->reason,
            'status'    => 'pending'
        ]);

        // 2. Otomatis jadikan isi alasan laporan sebagai PESAN PERTAMA di dalam chat room
        ComplaintMessage::create([
            'complaint_id' => $complaint->id,
            'user_id'      => auth()->id(),
            'message'      => $request->reason,
            'sender_role'  => 'user',
            'is_read'      => false,
        ]);

        // 3. 🔄 REDIRECT: Langsung lempar konsumen masuk ke ruang chat keluhan mereka
        return redirect()->route('complaints.show', $complaint->id)
            ->with('success', 'Laporan Anda berhasil dibuat! Silakan langsung hubungi Admin di ruang chat ini.');
    }

    /**
     * Tampilkan halaman detail keluhan (chat antara Pelapor & Admin).
     * Seller tidak dapat mengakses halaman ini.
     */
    public function show(Complaint $complaint)
    {
        $user = auth()->user();

        // Hanya pelapor atau admin yang boleh melihat
        if ($user->role !== 'admin' && $complaint->user_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $complaint->load(['reporter', 'seller', 'messages.sender']);

        // Tandai pesan dari sisi lawan sebagai sudah dibaca
        if ($user->role === 'admin') {
            $complaint->messages()->where('sender_role', 'user')->where('is_read', false)->update(['is_read' => true]);
        } else {
            $complaint->messages()->where('sender_role', 'admin')->where('is_read', false)->update(['is_read' => true]);
        }

        // 💡 PERBAIKAN: Diubah dari 'complain.show' menjadi 'complaints.show'
        return view('complaints.show', compact('complaint'));
    }

    /**
     * Kirim pesan/balasan dalam chat keluhan (digunakan oleh Pelapor & Admin).
     */
    public function sendMessage(Request $request, Complaint $complaint)
    {
        $user = auth()->user();

        // Hanya pelapor atau admin yang boleh mengirim pesan
        if ($user->role !== 'admin' && $complaint->user_id !== $user->id) {
            abort(403, 'Akses ditolak.');
        }

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $senderRole = $user->role === 'admin' ? 'admin' : 'user';

        ComplaintMessage::create([
            'complaint_id' => $complaint->id,
            'user_id'      => $user->id,
            'message'      => $request->message,
            'sender_role'  => $senderRole,
            'is_read'      => false,
        ]);

        // Update status menjadi 'ditinjau' jika admin yang membalas
        if ($senderRole === 'admin' && $complaint->status === 'pending') {
            $complaint->update(['status' => 'ditinjau']);
        }

        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    /**
     * Admin mengubah status keluhan melalui dropdown (pending, ditinjau, selesai, ditolak).
     */
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:pending,ditinjau,selesai,ditolak',
        ]);

        $complaint->update(['status' => $request->status]);

        return back()->with('success', 'Status keluhan berhasil diperbarui!');
    }

    /**
     * Daftar keluhan milik konsumen/lembaga yang sedang login.
     */
    public function myComplaints()
    {
        $complaints = Complaint::where('user_id', auth()->id())
            ->with(['seller', 'messages'])
            ->latest()
            ->get();

        // 💡 PERBAIKAN: Diubah dari 'complain.index' menjadi 'complaints.index'
        return view('complaints.index', compact('complaints'));
    }

    /**
     * Melayani kiriman form balasan cepat dari Dashboard Admin utama Anda.
     */
    public function adminReply(Request $request, Complaint $complaint)
    {
        $request->validate([
            'admin_reply' => 'required|string',
        ]);

        // 1. Simpan ke sistem Chat Dua Arah (agar rekam jejak obrolan tetap ada)
        $complaint->messages()->create([
            'user_id'      => auth()->id(),
            'message'      => $request->admin_reply,
            'sender_role'  => 'admin',
            'is_read'      => false,
        ]);

        // 2. Simpan juga ke kolom 'admin_reply' lama agar UI Dashboard tetap memunculkan teksnya
        $complaint->update([
            'admin_reply' => $request->admin_reply,
            'status'      => 'ditinjau' // 💡 DISARANKAN: Diubah ke 'ditinjau' agar ruang chat tetap terbuka dan bisa dibalas konsumen
        ]);

        return back()->with('success', 'Tanggapan berhasil dikirim, tercatat di ruang chat, dan status diperbarui!');
    }
}