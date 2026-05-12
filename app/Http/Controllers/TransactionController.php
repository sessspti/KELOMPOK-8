<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Menampilkan riwayat pesanan untuk konsumen.
     */
    public function history()
    {
        $userId = Auth::id();
        
        // Group orders by transaction_id untuk ditampilkan sebagai satu entri invoice
        // Hanya menampilkan order dengan status 'paid'
        $transactions = Order::where('id_user', $userId)
            ->whereNotNull('transaction_id')
            ->where('status', 'paid')
            ->select(
                'transaction_id', 
                'payment_method', 
                'status', 
                DB::raw('MAX(created_at) as date'), 
                DB::raw('SUM(quantity * (select price from menus where menus.id = orders.menu_id)) as total_price')
            )
            ->groupBy('transaction_id', 'payment_method', 'status')
            ->orderBy('date', 'desc')
            ->get();

        return view('transaction.history', compact('transactions'));
    }

    /**
     * Menampilkan invoice untuk transaksi spesifik.
     */
    public function invoice($transactionId)
    {
        $userId = Auth::id();
        
        // Mengambil semua item dalam satu transaksi
        $orders = Order::with('menu')
            ->where('id_user', $userId)
            ->where('transaction_id', $transactionId)
            ->get();

        if ($orders->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'Invoice tidak ditemukan.');
        }

        // Membuat variabel tunggal $order untuk data umum invoice (menghindari error 'Property [id] does not exist')
        $order = $orders->first();

        $transaction = (object) [
            'id' => $transactionId,
            'date' => $order->created_at,
            'payment_method' => $order->payment_method,
            'status' => $order->status,
            'customer_name' => Auth::user()->name,
            'customer_email' => Auth::user()->email,
        ];

        // Mengirimkan $orders (untuk list tabel) dan $order (untuk info header)
        return view('transaction.invoice', compact('orders', 'order', 'transaction'));
    }

    /**
     * Menyimpan transaksi baru dari checkout.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();
        $cart = $request->input('cart', []);
        $paymentMethod = $request->input('payment_method', 'Transfer Bank');
        $transactionId = 'INV-' . strtoupper(bin2hex(random_bytes(4)));

        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong.'], 400);
        }

        try {
            DB::beginTransaction();

            foreach ($cart as $item) {
                $menu = Menu::find($item['id']);
                
                if (!$menu) {
                    throw new \Exception("Menu dengan ID {$item['id']} tidak ditemukan. Silakan periksa kembali keranjang Anda.");
                }

                Order::create([
                    'id_user' => $userId,
                    'menu_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'status' => 'paid',
                    'transaction_id' => $transactionId,
                    'payment_method' => $paymentMethod,
                ]);

                // Mengurangi stok menu
                $menu->decrement('stock', $item['qty']);
            }

            // Hapus pesanan pending lainnya jika ada agar tidak menumpuk
            Order::where('id_user', $userId)->where('status', 'pending')->delete();

            DB::commit();

            return response()->json([
                'success' => true, 
                'transaction_id' => $transactionId,
                'redirect_url' => route('transaction.invoice', $transactionId)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}