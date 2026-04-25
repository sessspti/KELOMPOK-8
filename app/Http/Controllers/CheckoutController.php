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
        try {
            DB::transaction(function () use ($order) {
                // Lock row menu spesifik ini agar tidak bisa dibaca/diupdate transaksi lain
                $menu = \App\Models\Menu::where('id', $order->menu_id)->lockForUpdate()->first();

                // Pastikan pesanan masih pending dan stok masih mencukupi sebelum dibayar
                if ($order->status !== 'pending') {
                    throw new Exception("Order sudah diproses sebelumnya.");
                }

                if ($menu->stock < $order->quantity) {
                    throw new Exception("Maaf, stok menu {$menu->name} tidak mencukupi atau sudah habis.");
                }

                // 1. Update status pesanan menjadi lunas
                $order->update(['status' => 'paid']);

                // 2. Kurangi stok menu secara otomatis
                $menu->decrement('stock', $order->quantity);
            });

            return redirect()->back()->with('success', 'Pembayaran berhasil! Stok telah dikurangi otomatis.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Pembayaran gagal: ' . $e->getMessage());
        }
    }
}
