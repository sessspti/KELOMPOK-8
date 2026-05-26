<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function updateStatus(Request $request, Order $order)
    {
        // TAMBAHAN AC 4: tambah 'siap_diambil' ke daftar status yang valid
        $request->validate([
            'status' => 'required|in:paid,proses,siap_diambil,selesai,dibatalkan',
        ]);

        $order->update(['status' => $request->status]);

        // TAMBAHAN AC 4: kirim notifikasi ke pembeli jika status diubah menjadi 'siap_diambil'
        if ($request->status === 'siap_diambil' && $order->user) {
            $order->user->notify(new \App\Notifications\GeneralNotification(
                "Pesanan Siap Diambil!",
                "Pesanan Anda sudah siap untuk diambil.",
                "🛍️"
            ));
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function invoice(Order $order)
    {
        $order->load(['menu.user', 'user']);

        // Pastikan user yang mengakses adalah pemilik pesanan atau seller menu tersebut
        if (auth()->id() !== $order->id_user && auth()->id() !== $order->menu->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $isDonation = $order->user && $order->user->role === 'lembaga_sosial';
        $subtotal = $isDonation ? 0 : $order->line_total;
        $serviceFee = 0;
        $grandTotal = $subtotal + $serviceFee;

        return view('transaction.invoice', compact('order', 'subtotal', 'serviceFee', 'grandTotal', 'isDonation'));
    }
}
