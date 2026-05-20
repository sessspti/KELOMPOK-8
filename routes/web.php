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

// ─── ROOT: Redirect berdasarkan role ───
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        return match ($role) {
            'admin'           => redirect()->route('admin.dashboard'),
            'seller'          => redirect()->route('seller.dashboard'),
            'lembaga_sosial'  => redirect()->route('sosial.dashboard'),
            default           => redirect()->route('dashboard'), // Role konsumen
        };
    }
    // Guest yang belum login → halaman publik
    return redirect()->route('guest.dashboard');
});

// ─── ROUTE PUBLIK: Dashboard Guest/Konsumen ───
// Alias /home → sama dengan /dashboard (friendly URL)
Route::get('/home', function () {
    // 1. Ambil data menu agar Guest tetap bisa melihat produk/makanan yang tersedia
    $menus = \App\Models\Menu::with('user')->notExpired()->latest()->get();
    
    // Mapping data is_open milik user ke dalam setiap item menu
    $menus->map(function ($menu) {
        $menu->store_is_open = $menu->user ? $menu->user->is_open : 0;
        return $menu;
    });

    // 2. Karena guest belum login, buatlah $orders kosong (menggunakan collect())
    // Ini penting agar file Blade tidak memunculkan error "Undefined variable $orders" nantinya
    $orders = collect(); 

    return view('dashboard', compact('menus', 'orders'));
})->name('guest.dashboard');

// --- Group Route untuk User yang Sudah Login ---
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Dashboard Konsumen
    Route::get('/dashboard', function () {
        // Ambil data menu beserta data penjualnya yang belum expired
        $menus = \App\Models\Menu::with('user')->notExpired()->latest()->get();

        // Mapping data is_open milik user ke dalam setiap item menu
        $menus->map(function ($menu) {
            $menu->store_is_open = $menu->user ? $menu->user->is_open : 0;
            return $menu;
        });

        // Ambil data orders milik user
        $orders = \App\Models\Order::where('id_user', auth()->id())
            ->with('menu.user')
            ->latest()
            ->get();

        return view('dashboard', compact('menus', 'orders'));
    })->middleware('role:konsumen')->name('dashboard');

    // Store / Seller Profile
    Route::get('/store/{id}', [MenuController::class, 'showStore'])->name('store.show');

    // 2. Verification System (KTP, NIB, dll)
    Route::controller(VerificationController::class)->group(function () {
        Route::get('/verify/notice', 'notice')->name('verification.notice');
        Route::post('/verify/store', 'upload')->name('verification.upload');
    });

    // 3. Transaction Management
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
    
    // 5. Profile Management Umum (bisa diakses semua role yang login)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 6. Fitur Seller (Dibagi menjadi Home & Manajemen)
    Route::prefix('seller')->middleware(['role:seller', 'approved'])->group(function () {
        Route::get('/dashboard', function () {
            $menus = \App\Models\Menu::where('user_id', auth()->id())->get();
            $orders = \App\Models\Order::whereHas('menu', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->whereNotNull('transaction_id')
            ->where('status', '!=', 'pending')
            ->with(['menu', 'user'])
            ->latest()
            ->get();

            // Hitung data menu aktif & stok menipis secara dinamis
            $activeMenusCount = $menus->filter(function ($menu) {
                return $menu->stock > 0 && ($menu->expiry_date === null || $menu->expiry_date >= now()->toDateString());
            })->count();

            $lowStockMenusCount = $menus->filter(function ($menu) {
                return $menu->stock > 0 && $menu->stock < 5 && ($menu->expiry_date === null || $menu->expiry_date >= now()->toDateString());
            })->count();

            $totalClaimsCount = $orders->count();

            return view('seller.dashboardSeller', compact('menus', 'orders', 'activeMenusCount', 'lowStockMenusCount', 'totalClaimsCount'));
        })->name('seller.dashboard');

        // Route untuk update status pesanan
        Route::patch('/orders/{order}/status', function (\App\Models\Order $order) {
            $status = request('status');
            $order->update(['status' => $status]);

            // Kirim notifikasi ke konsumen
            $icon = match($status) {
                'paid'         => '✅',
                'proses'       => '👨‍🍳',
                'siap_diambil' => '🥡',
                'selesai'      => '✨',
                'dibatalkan'   => '❌',
                default        => '🔔'
            };

            $statusText = match($status) {
                'paid'         => 'telah dibayar',
                'proses'       => 'sedang diproses',
                'siap_diambil' => 'siap diambil',
                'selesai'      => 'telah selesai',
                'dibatalkan'   => 'telah dibatalkan',
                default        => $status
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

        // D. Rute Alias untuk Profil Seller (Agar tidak error di Dashboard Bento)
        Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('seller.profile.edit');

        // Order Management for Seller
        Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus.alt');
        Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

        Route::post('/toggle-status', [MenuController::class, 'toggleStatus'])->name('seller.toggle-status');
    });

    // 7. Fitur Lembaga Sosial
    Route::prefix('sosial')->middleware(['role:lembaga_sosial', 'approved'])->group(function () {
        Route::get('/dashboard', function () {
            $orders = \App\Models\Order::where('id_user', auth()->id())->with('menu.user')->latest()->get();
            $menus  = \App\Models\Menu::with('user')->where('stock', '>', 0)->notExpired()->latest()->get();
            return view('sosial.dashboard', compact('orders', 'menus'));
        })->name('sosial.dashboard');

        Route::post('/claim', [TransactionController::class, 'claimDonation'])->name('sosial.claim');

        // Profil untuk Lembaga Sosial
        Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('sosial.profile.edit');
    });

    // 8. Fitur Checkout/Pembayaran (Hanya Konsumen)
    Route::post('/checkout/{order}/pay', [CheckoutController::class, 'processPayment'])->middleware('role:konsumen')->name('checkout.pay');

    // 9. Eksplorasi & Transaksi (FoodSave Features) - Hanya Konsumen
    Route::get('/checkout-summary', function () {
        return view('transaction.checkout');
    })->middleware('role:konsumen')->name('checkout.summary');

    // 10. Fitur Admin (Pusat Kendali Platform)
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        // Dashboard Utama Admin
        Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
            $orders = \App\Models\Order::with(['menu.user', 'user'])->latest()->get();
            $ordersGrouped = $orders->groupBy(fn($order) => $order->menu->user->name ?? 'Unknown Store');
            
            $pendingVerifications = \App\Models\UserVerification::with('user')->where('status', 'pending')->latest()->get();

            // Manajemen Pengguna Query
            $usersQuery = \App\Models\User::where('role', '!=', 'admin');
            
            if ($request->filled('search')) {
                $usersQuery->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            }
            
            if ($request->filled('role_filter') && $request->role_filter !== 'semua') {
                $usersQuery->where('role', $request->role_filter);
            }
            
            $usersList = $usersQuery->latest()->paginate(10)->withQueryString();

            // Realtime Statistics
            $totalUsers = \App\Models\User::count();
            $activeSellers = \App\Models\User::where('role', 'seller')
                                ->where('account_status', 'approved')
                                ->count();

            return view('admin.dashboard', compact('ordersGrouped', 'pendingVerifications', 'usersList', 'totalUsers', 'activeSellers'));
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
