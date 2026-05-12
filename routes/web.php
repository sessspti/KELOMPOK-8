<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CartController;
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

    // 1. Dashboard Konsumen
    Route::get('/dashboard', function () {
        $menus = \App\Models\Menu::with('user')->latest()->get();
        return view('dashboard', compact('menus'));
    })->middleware('role:konsumen')->name('dashboard');

    // 2. Fitur Transaksi (History, Invoice, & Store)
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/transaction/history', 'history')->name('transaction.history');
        Route::get('/transaction/invoice/{id}', 'invoice')->name('transaction.invoice');
        Route::post('/transaction/store', 'store')->name('transaction.store');
    });

    // 3. Profile Management
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
            $order->update(['status' => request('status')]);
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
    });

    // 5. Fitur Lembaga Sosial
    Route::prefix('sosial')->middleware('role:lembaga_sosial')->group(function () {
        Route::get('/dashboard', function () {
            $orders = \App\Models\Order::where('id_user', auth()->id())->with('menu.user')->latest()->get();
            return view('sosial.dashboard', compact('orders'));
        })->name('sosial.dashboard');

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
});

// --- Auth & Donasi ---
Route::get('/donasi', [DonationController::class, 'index'])->name('donations.index');
Route::get('/auth/google/role-password', [\App\Http\Controllers\Auth\SocialAuthController::class, 'showRoleForm'])->name('google.role.form');
Route::post('/auth/google/role-password', [\App\Http\Controllers\Auth\SocialAuthController::class, 'storeRolePassword'])->name('google.role.store');

require __DIR__ . '/auth.php';