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

    // Verification Routes
    Route::get('/verification/notice', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::post('/verification/upload', [VerificationController::class, 'upload'])->name('verification.upload');

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

    // UNTUK LIHAT PROFILE SELLER
    Route::get('/store/{id}', [MenuController::class, 'showStore'])->middleware('role:konsumen')->name('store.show');

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
    Route::prefix('seller')->middleware(['role:seller', 'approved'])->group(function () {
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

        Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('seller.profile.edit');
        
        // Order Management for Seller
        Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus.alt');
        Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        
        Route::post('/toggle-status', [MenuController::class, 'toggleStatus'])->name('seller.toggle-status');
    });

    // 5. Fitur Lembaga Sosial
    Route::prefix('sosial')->middleware(['role:lembaga_sosial', 'approved'])->group(function () {
        Route::get('/dashboard', function () {
            $orders = \App\Models\Order::where('id_user', auth()->id())->with('menu.user')->latest()->get();
            $menus = \App\Models\Menu::with('user')->where('stock', '>', 0)->notExpired()->latest()->get();
            return view('sosial.dashboard', compact('orders', 'menus'));
        })->name('sosial.dashboard');

        Route::post('/claim', [TransactionController::class, 'claimDonation'])->name('sosial.claim');
        
        // Profil untuk Lembaga Sosial
        Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('sosial.profile.edit');
    });

    // 6. Fitur Checkout & Cart (Hanya Konsumen)
    Route::middleware('role:konsumen')->group(function () {
        Route::get('/checkout-summary', function () {
            return view('transaction.checkout');
        })->name('checkout.summary');
        
        Route::post('/checkout/{order}/pay', [CheckoutController::class, 'processPayment'])->name('checkout.pay');
        Route::post('/cart/sync', [CartController::class, 'sync'])->name('cart.sync');
    });

    // 7. Fitur Admin
    Route::prefix('admin')->middleware('role:admin')->group(function () {
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
