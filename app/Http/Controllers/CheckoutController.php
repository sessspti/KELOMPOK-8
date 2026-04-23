<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Exception;

class CheckoutController extends Controller
{
    // Simulasi saat pesanan berhasil dibayar (Requirement 4)
    public function processPayment(Request $request, Order $order)
    {
        // Menggunakan Database Transaction (Best Practice agar data aman)
        try {
            DB::beginTransaction();

            // Pastikan pesanan masih pending dan stok masih mencukupi sebelum dibayar
            if ($order->status !== 'pending') {
                throw new Exception("Order sudah diproses sebelumnya.");
            }

            if ($order->menu->stock < $order->quantity) {
                throw new Exception("Stok tidak mencukupi untuk pesanan ini.");
            }

            // 1. Ubah status order menjadi paid
            $order->update(['status' => 'paid']);

            // 2. Kurangi stok secara otomatis dari menu
            $order->menu->decrement('stock', $order->quantity);

            DB::commit();

            return redirect()->back()->with('success', 'Pembayaran berhasil! Stok telah dikurangi otomatis.');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Pembayaran gagal: ' . $e->getMessage());
        }
    }
}
