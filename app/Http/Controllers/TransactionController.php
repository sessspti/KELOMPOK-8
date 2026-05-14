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

                // Notifikasi stok menipis ke seller
                if ($menu->fresh()->stock < 5) {
                    $menu->user->notify(new \App\Notifications\GeneralNotification(
                        "Stok Menipis!",
                        "Produk {$menu->name} tinggal {$menu->stock} porsi. Segera restock!",
                        "⚠️"
                    ));
                }
            }

            // Hapus pesanan pending lainnya jika ada agar tidak menumpuk
            Order::where('id_user', $userId)->where('status', 'pending')->delete();

            DB::commit();

            // Kirim notifikasi ke konsumen
            Auth::user()->notify(new \App\Notifications\GeneralNotification(
                "Pembayaran Berhasil",
                "Pesanan #{$transactionId} telah kami terima dan akan segera diproses.",
                "💳"
            ));

            // Kirim notifikasi ke seller
            // Mengambil semua seller unik yang produknya dibeli dalam transaksi ini
            $sellerIds = Menu::whereIn('id', collect($cart)->pluck('id'))->pluck('user_id')->unique();
            foreach ($sellerIds as $sellerId) {
                $seller = \App\Models\User::find($sellerId);
                if ($seller) {
                    $isSosial = Auth::user()->role === 'lembaga_sosial';
                    
                    $title = $isSosial ? "Klaim Donasi Baru!" : "Pesanan Baru Masuk!";
                    $icon = $isSosial ? "🤝" : "🛍️";
                    $message = $isSosial 
                        ? "Lembaga " . Auth::user()->name . " baru saja mengklaim produk donasi Anda."
                        : "Seseorang baru saja membeli produk Anda. Segera proses pesanan #{$transactionId}.";

                    $seller->notify(new \App\Notifications\GeneralNotification($title, $message, $icon));
                }
            }

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

    /**
     * Menyimpan klaim donasi dari lembaga sosial.
     */
    public function claimDonation(Request $request)
    {
        $userId = Auth::id();
        $items = $request->input('items', []);
        $transactionId = 'CLM-' . strtoupper(bin2hex(random_bytes(4)));

        if (empty($items)) {
            return response()->json(['success' => false, 'message' => 'Daftar pengambilan kosong.'], 400);
        }

        try {
            DB::beginTransaction();

            foreach ($items as $item) {
                $menu = Menu::find($item['id']);
                
                if (!$menu) {
                    throw new \Exception("Menu tidak ditemukan.");
                }

                $claimQty = 1; 

                Order::create([
                    'id_user' => $userId,
                    'menu_id' => $menu->id,
                    'quantity' => $claimQty,
                    'status' => 'proses',
                    'transaction_id' => $transactionId,
                    'payment_method' => 'Donasi',
                ]);

                $menu->decrement('stock', $claimQty);

                $menu->user->notify(new \App\Notifications\GeneralNotification(
                    "Klaim Donasi Baru!",
                    "Lembaga " . Auth::user()->name . " baru saja mengklaim produk donasi Anda: {$menu->name}.",
                    "🤝"
                ));
            }

            DB::commit();

            Auth::user()->notify(new \App\Notifications\GeneralNotification(
                "Pengajuan Berhasil",
                "Klaim donasi #{$transactionId} telah dikirim. Menunggu konfirmasi restoran.",
                "✅"
            ));

            return response()->json([
                'success' => true,
                'message' => 'Klaim berhasil diajukan.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}