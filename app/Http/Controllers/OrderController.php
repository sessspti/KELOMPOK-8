<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Proses,Selesai',
        ]);

        $order->update(['status' => $request->status]);

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
