<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DonationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- Halaman Utama & Redirect Role ---
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }

    $role = auth()->user()->role;

    return match ($role) {
        'admin'           => redirect()->route('admin.dashboard'),
        'seller'          => redirect()->route('seller.dashboard'),
        'lembaga_sosial'  => redirect()->route('sosial.dashboard'),
        default           => redirect()->route('dashboard'),
    };
});

// --- Group Route Auth ---
Route::middleware(['auth', 'verified'])->group(function () {

    // 0. Shared Routes (Konsumen & Lembaga Sosial)
    Route::get('/transaction/history', [TransactionController::class, 'history'])->middleware('role:konsumen,lembaga_sosial')->name('transaction.history');
    Route::get('/transaction/invoice/{id}', [TransactionController::class, 'invoice'])->middleware('role:konsumen,lembaga_sosial')->name('transaction.invoice');

    // 1. Dashboard Konsumen
   // 1. Dashboard Konsumen
    Route::get('/dashboard', function () {
<<<<<<<<< Temporary merge branch 1
        $orders = \App\Models\Order::where('id_user', auth()->id())
            ->with('menu.user')
            ->latest()
            ->get();
        return view('dashboard', compact('orders'));
=========
        $menus = \App\Models\Menu::with('user')->get()->map(function($menu) {
            return [
                'id' => $menu->id,
                'name' => $menu->name,
                'store' => $menu->user->name ?? 'Resto FoodSave',
                'price' => $menu->price,
                'originalPrice' => $menu->price + ($menu->discount ?? 0),
                'distance' => (rand(1, 20) / 10) . ' km',
                'urgent' => $menu->stock <= 3 ? 'Sisa ' . $menu->stock . '!' : '',
                'expired_at' => \Carbon\Carbon::now()->addDays(rand(1, 3))->format('d M Y'),
                'image' => $menu->image ? asset('storage/' . $menu->image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=500'
            ];
        });
        return view('dashboard', compact('menus'));
>>>>>>>>> Temporary merge branch 2
    })->middleware('role:konsumen')->name('dashboard');

    // UNTUK LIHAT PROFILE SELLER
    Route::get('/store/{id}', [\App\Http\Controllers\MenuController::class, 'showStore'])->middleware('role:konsumen')->name('store.show');

    // 2. Fitur Transaksi (History, Invoice, & Store)
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transaction/history', 'history')->name('transaction.history');
        Route::get('/transaction/invoice/{id}', 'invoice')->name('transaction.invoice');
        Route::post('/transaction/store', 'store')->name('transaction.store');
    });

    // 4. Notification Management
    Route::controller(NotificationController::class)->group(function () {
        Route::post('/notifications/{id}/mark-as-read', 'markAsRead')->name('notifications.markAsRead');
        Route::post('/notifications/mark-all-as-read', 'markAllAsRead')->name('notifications.markAllAsRead');
    });

    // 5. Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 4. Fitur Seller
    Route::prefix('seller')->middleware('role:seller')->group(function () {
        Route::get('/dashboard', function () {
            $menus = \App\Models\Menu::where('user_id', auth()->id())->get();
            $orders = \App\Models\Order::whereHas('menu', function ($query) {
                $query->where('user_id', auth()->id());
            })->with(['menu', 'user'])->latest()->get();
            return view('seller.dashboardSeller', compact('menus', 'orders'));
        })->name('seller.dashboard');

        // Route untuk update status pesanan (Memperbaiki error RouteNotFound)
        Route::patch('/orders/{order}/status', function (\App\Models\Order $order) {
            $status = request('status');
            $order->update(['status' => $status]);
            
            // Kirim notifikasi ke konsumen
            $icon = match($status) {
                'paid' => '✅',
                'proses' => '👨‍🍳',
                'siap_diambil' => '🥡',
                'selesai' => '✨',
                'dibatalkan' => '❌',
                default => '🔔'
            };

            $statusText = match($status) {
                'paid' => 'telah dibayar',
                'proses' => 'sedang diproses',
                'siap_diambil' => 'siap diambil',
                'selesai' => 'telah selesai',
                'dibatalkan' => 'telah dibatalkan',
                default => $status
            };

            $order->user->notify(new \App\Notifications\GeneralNotification(
                "Status Pesanan Diperbarui",
                "Pesanan Anda #{$order->transaction_id} {$statusText}.",
                $icon
            ));

            return back()->with('success', 'Status pesanan berhasil diperbarui!');
        })->name('orders.updateStatus');

        Route::get('/manage-inventory', function () {
            $query = \App\Models\Menu::where('user_id', auth()->id());
            if (request()->has('search') && request('search') != '') {
                $query->where('name', 'like', '%' . request('search') . '%');
            }
            $menus = $query->paginate(6)->withQueryString();
            return view('seller.etalase', compact('menus'));
        })->name('seller.manage');

        Route::post('/menus', [MenuController::class, 'store'])->name('seller.menus.store');
        Route::get('/menus/{menu}/edit', [MenuController::class, 'editMenu'])->name('seller.menus.editMenu');
        Route::put('/menus/{menu}/update', [MenuController::class, 'updateMenu'])->name('seller.menus.updateMenu');
        Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('seller.menus.destroy');

        Route::get('/tambah-menu', function () {
            return view('seller.tambah-menu');
        })->name('seller.tambah-menu');

        Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('seller.profile.edit');
    });

    // 5. Fitur Lembaga Sosial
    Route::prefix('sosial')->middleware('role:lembaga_sosial')->group(function () {
        Route::get('/dashboard', function () {
            $orders = \App\Models\Order::where('id_user', auth()->id())->with('menu.user')->latest()->get();
            $menus = \App\Models\Menu::with('user')->where('stock', '>', 0)->notExpired()->latest()->get();
            return view('sosial.dashboard', compact('orders', 'menus'));
        })->name('sosial.dashboard');

        Route::post('/claim', [TransactionController::class, 'claimDonation'])->name('sosial.claim');
        
        // Profil untuk Lembaga Sosial
        Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('sosial.profile.edit');
    });

    // 6. Eksplorasi & Transaksi - Hanya Konsumen
    Route::get('/checkout-summary', function () {
        return view('transaction.checkout');
    })->middleware('role:konsumen')->name('checkout.summary');

    // 7. Fitur Admin (Pusat Kendali Platform)
    Route::prefix('admin')->middleware('role:admin')->group(function () {

        
        Route::post('/checkout/{order}/pay', [CheckoutController::class, 'processPayment'])->name('checkout.pay');
        Route::post('/cart/sync', [CartController::class, 'sync'])->name('cart.sync');
    });

    // 7. Fitur Admin
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', function () {
            $orders = \App\Models\Order::with(['menu.user', 'user'])->latest()->get();
            $ordersGrouped = $orders->groupBy(fn($order) => $order->menu->user->name ?? 'Unknown Store');
            return view('admin.dashboard', compact('ordersGrouped'));
        })->name('admin.dashboard');

        Route::get('/users', fn() => view('admin.users.index'))->name('admin.users.index');
        Route::get('/verifikasi', fn() => view('admin.verifikasi'))->name('admin.verifikasi');
        Route::get('/edukasi', fn() => view('admin.edukasi.index'))->name('admin.edukasi');
    });
<<<<<<<<< Temporary merge branch 1

    // 8. Order Management & Invoice
    Route::post('/orders/{order}/update-status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/{order}/invoice', [App\Http\Controllers\OrderController::class, 'invoice'])->name('orders.invoice');
=========
    // 8. Riwayat Transaksi & Invoice
    Route::middleware('role:konsumen')->group(function () {
        Route::get('/history', [\App\Http\Controllers\TransactionController::class, 'history'])->name('transaction.history');
        Route::get('/invoice/{transaction_id}', [\App\Http\Controllers\TransactionController::class, 'invoice'])->name('transaction.invoice');
        Route::post('/transaction/store', [\App\Http\Controllers\TransactionController::class, 'store'])->name('transaction.store');
    });
>>>>>>>>> Temporary merge branch 2
});

// Route untuk Pemilihan Role dan Password Google Auth
Route::get('/auth/google/role-password', [\App\Http\Controllers\Auth\SocialAuthController::class, 'showRoleForm'])->name('google.role.form');
Route::post('/auth/google/role-password', [\App\Http\Controllers\Auth\SocialAuthController::class, 'storeRolePassword'])->name('google.role.store');

require __DIR__ . '/auth.php'; 

// Cart Synchronization
Route::post('/cart/sync', [App\Http\Controllers\CartController::class, 'sync'])->name('cart.sync')->middleware('auth');

// Route Eksplorasi Donasi
Route::get('/donasi', [DonationController::class, 'index'])->name('donations.index');



