<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Admin\VerificationController as AdminVerificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

<<<<<<<<< Temporary merge branch 1
// PERBAIKAN: Redirect halaman utama berdasarkan Role (Menghindari Loop)
Route::get('/', function () {
    if (!auth()->check()) {
        return redirect('/login');
    }

    $role = auth()->user()->role;

    // Arahkan ke dashboard masing-masing sesuai role
    return match ($role) {
        'admin'           => redirect()->route('admin.dashboard'),
        'seller'          => redirect()->route('seller.dashboard'),
        'lembaga_sosial'  => redirect()->route('sosial.dashboard'),
        default           => redirect()->route('dashboard'), // Role konsumen
    };
=========
// ─── ROOT: Redirect berdasarkan role ───
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'seller') {
            return redirect()->route('seller.dashboard');
        } elseif ($role === 'lembaga_sosial') {
            return redirect()->route('sosial.dashboard');
        } elseif ($role === 'konsumen') {
            return redirect()->route('dashboard');
        }
    }
    // Guest yang belum login → halaman publik
    return redirect()->route('guest.dashboard');
>>>>>>>>> Temporary merge branch 2
});

// ─── ROUTE PUBLIK: Dashboard Guest/Konsumen ───
// Dapat diakses oleh siapapun (guest maupun konsumen yang login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Alias /home → sama dengan /dashboard (friendly URL)
Route::get('/home', function () {
    return view('dashboard');
})->name('guest.dashboard');

// --- Group Route untuk User yang Sudah Login ---
Route::middleware(['auth', 'verified'])->group(function () {

<<<<<<<<< Temporary merge branch 1
    // 1. Dashboard Konsumen
    Route::get('/dashboard', function () {
        // Ambil data menu beserta data penjualnya yang belum expired
        $menus = \App\Models\Menu::with('user')->notExpired()->latest()->get();
        
        // Mapping data is_open milik user ke dalam setiap item menu
        $menus->map(function ($menu) {
            $menu->store_is_open = $menu->user ? $menu->user->is_open : 0;
            return $menu;
        });

        // Tetap ambil data orders jika dashboard membutuhkannya
        $orders = \App\Models\Order::where('id_user', auth()->id())
            ->with('menu.user')
            ->latest()
            ->get();

        return view('dashboard', compact('menus', 'orders'));
    })->middleware('role:konsumen')->name('dashboard');
    
    // 2. Profile Management Umum
=========
    // 1. Profile Management Umum (bisa diakses semua role yang login)
>>>>>>>>> Temporary merge branch 2
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

<<<<<<<<< Temporary merge branch 1
    // 3. Fitur Seller
=========
    // 2. Fitur Seller (Dibagi menjadi Home & Manajemen)
>>>>>>>>> Temporary merge branch 2
    Route::prefix('seller')->middleware('role:seller')->group(function () {
        Route::get('/dashboard', function () {
            $menus = \App\Models\Menu::where('user_id', auth()->id())->get();
            $orders = \App\Models\Order::whereHas('menu', function ($query) {
                $query->where('user_id', auth()->id());
            })->with(['menu', 'user'])->latest()->get();
            return view('seller.dashboardSeller', compact('menus', 'orders'));
        })->name('seller.dashboard');

        // Route untuk update status pesanan
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

            if ($order->user) {
                $order->user->notify(new \App\Notifications\GeneralNotification(
                    "Status Pesanan Diperbarui",
                    "Pesanan Anda #{$order->transaction_id} {$statusText}.",
                    $icon
                ));
            }

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

<<<<<<<<< Temporary merge branch 1
=========
        // D. Rute Alias untuk Profil Seller (Agar tidak error di Dashboard Bento)
>>>>>>>>> Temporary merge branch 2
        Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('seller.profile.edit');
        
        // Order Management for Seller
        Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus.alt');
        Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        
        Route::post('/toggle-status', [MenuController::class, 'toggleStatus'])->name('seller.toggle-status');
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

    // 4. Fitur Checkout/Pembayaran (Hanya Konsumen)
    Route::post('/checkout/{order}/pay', [CheckoutController::class, 'processPayment'])->middleware('role:konsumen')->name('checkout.pay');

<<<<<<<<< Temporary merge branch 1
    // 6. Eksplorasi & Transaksi - Hanya Konsumen
=========
    // 5. Eksplorasi & Transaksi (FoodSave Features) - Hanya Konsumen
>>>>>>>>> Temporary merge branch 2
    Route::get('/checkout-summary', function () {
        return view('transaction.checkout');
    })->middleware('role:konsumen')->name('checkout.summary');

<<<<<<<<< Temporary merge branch 1
    // 7. Fitur Admin (Pusat Kendali Platform)
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        
=========
    // 6. Fitur Admin (Pusat Kendali Platform)
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        
        // Dashboard Utama Admin
>>>>>>>>> Temporary merge branch 2
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::post('/verifications/{user}/approve', [AdminVerificationController::class, 'approve'])->name('admin.verifications.approve');
        Route::post('/verifications/{user}/reject', [AdminVerificationController::class, 'reject'])->name('admin.verifications.reject');
        Route::post('/users/{user}/toggle-status', [AdminVerificationController::class, 'toggleStatus'])->name('admin.users.toggle-status');
        Route::delete('/users/{user}', [AdminVerificationController::class, 'destroy'])->name('admin.users.destroy');

        Route::get('/users', fn() => view('admin.users.index'))->name('admin.users.index');
        Route::get('/verifikasi', fn() => view('admin.verifikasi'))->name('admin.verifikasi');
        Route::get('/edukasi', fn() => view('admin.edukasi.index'))->name('admin.edukasi');
    });
});

// --- Auth & Donasi ---
Route::get('/donasi', [DonationController::class, 'index'])->name('donations.index');
Route::get('/auth/google/role-password', [\App\Http\Controllers\Auth\SocialAuthController::class, 'showRoleForm'])->name('google.role.form');
Route::post('/auth/google/role-password', [\App\Http\Controllers\Auth\SocialAuthController::class, 'storeRolePassword'])->name('google.role.store');

require __DIR__ . '/auth.php'; 

// Cart Synchronization
Route::post('/cart/sync', [App\Http\Controllers\CartController::class, 'sync'])->name('cart.sync')->middleware('auth');

// Route Eksplorasi Donasi
Route::get('/donasi', [DonationController::class, 'index'])->name('donations.index');



