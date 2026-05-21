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
        // Hanya menampilkan order yang bukan 'pending' (termasuk paid, proses, selesai, dll)
        $transactions = Order::where('id_user', $userId)
            ->whereNotNull('transaction_id')
            ->where('status', '!=', 'pending')
            ->select(
                'transaction_id', 
                'payment_method', 
                'status', 
                DB::raw('MAX(created_at) as date'), 
                DB::raw('SUM(quantity * (select (price - (price * discount / 100)) from menus where menus.id = orders.menu_id)) as total_price')
            )
            ->groupBy('transaction_id', 'payment_method', 'status')
            ->orderBy('date', 'desc')
            ->get();

        if (Auth::user()->role === 'lembaga_sosial') {
            $transactions->transform(function ($trx) {
                $trx->total_price = 0;
                return $trx;
            });
        }

        return view('transaction.history', compact('transactions'));
    }

    /**
     * Menampilkan invoice untuk transaksi spesifik.
     */
    public function invoice($transactionId)
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role;
        
        // Mengambil semua item dalam satu transaksi
        if ($userRole === 'seller') {
            $orders = Order::with(['menu', 'user'])
                ->where('transaction_id', $transactionId)
                ->whereHas('menu', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get();
        } else {
            $orders = Order::with(['menu', 'user'])
                ->where('id_user', $userId)
                ->where('transaction_id', $transactionId)
                ->get();
        }

        if ($orders->isEmpty()) {
            $redirectRoute = match ($userRole) {
                'seller' => 'seller.dashboard',
                'lembaga_sosial' => 'sosial.dashboard',
                default => 'dashboard',
            };
            return redirect()->route($redirectRoute)->with('error', 'Invoice tidak ditemukan.');
        }

        // Membuat variabel tunggal $order untuk data umum invoice (menghindari error 'Property [id] does not exist')
        $order = $orders->first();
        $buyer = $order->user;

        $transaction = (object) [
            'id' => $transactionId,
            'date' => $order->created_at,
            'payment_method' => $order->payment_method,
            'status' => $order->status,
            'customer_name' => $buyer ? $buyer->name : 'N/A',
            'customer_email' => $buyer ? $buyer->email : 'N/A',
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