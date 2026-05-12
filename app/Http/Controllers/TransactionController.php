<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Display the order history for the consumer.
     */
    public function history()
    {
        $userId = Auth::id();
        
        // Group orders by transaction_id to show as a single invoice entry
        // We only show 'paid' orders in history
        $transactions = Order::where('id_user', $userId)
            ->whereNotNull('transaction_id')
            ->where('status', 'paid')
            ->select('transaction_id', 'payment_method', 'status', DB::raw('MAX(created_at) as date'), DB::raw('SUM(quantity * (select price from menus where menus.id = orders.menu_id)) as total_price'))
            ->groupBy('transaction_id', 'payment_method', 'status')
            ->orderBy('date', 'desc')
            ->get();

        return view('transaction.history', compact('transactions'));
    }

    /**
     * Display the invoice for a specific transaction.
     */
    public function invoice($transactionId)
    {
        $userId = Auth::id();
        
        $orders = Order::with('menu')
            ->where('id_user', $userId)
            ->where('transaction_id', $transactionId)
            ->get();

        if ($orders->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'Invoice tidak ditemukan.');
        }

        $transaction = (object) [
            'id' => $transactionId,
            'date' => $orders->first()->created_at,
            'payment_method' => $orders->first()->payment_method,
            'status' => $orders->first()->status,
            'customer_name' => Auth::user()->name,
            'customer_email' => Auth::user()->email,
        ];

        return view('transaction.invoice', compact('orders', 'transaction'));
    }

    /**
     * Store a new transaction from the checkout.
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
                $menu = \App\Models\Menu::find($item['id']);
                
                if (!$menu) {
                    throw new \Exception("Menu dengan ID {$item['id']} tidak ditemukan di database. Silakan hapus item ini dari keranjang.");
                }

                Order::create([
                    'id_user' => $userId,
                    'menu_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'status' => 'paid',
                    'transaction_id' => $transactionId,
                    'payment_method' => $paymentMethod,
                ]);

                $menu->decrement('stock', $item['qty']);
            }

            // Clean up other pending orders if any
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
