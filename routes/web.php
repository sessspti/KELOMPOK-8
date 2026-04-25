<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

// --- Group Route untuk User yang Sudah Login ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. Dashboard Umum / Konsumen
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 2. Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. Fitur Seller (Dashboard & Kontrol Stok dari Dev 2)
    Route::prefix('seller')->group(function () {
        Route::get('/dashboard', function () {
            $menus = \App\Models\Menu::where('user_id', auth()->id())->get();
            return view('seller.dashboard', compact('menus'));
        })->name('seller.dashboard');

        Route::post('/menus', [MenuController::class, 'store'])->name('seller.menus.store');

        // Route Kontrol Stok dari Dev 2
        Route::get('/menus/{menu}/edit-stock', [MenuController::class, 'editStock'])->name('seller.menus.editStock');
        Route::put('/menus/{menu}/update-stock', [MenuController::class, 'updateStock'])->name('seller.menus.updateStock');
    });

    // 4. Fitur Lembaga Sosial
    Route::get('/sosial/dashboard', function () {
        return view('sosial.dashboard');
    })->name('sosial.dashboard');

    // 5. Fitur Checkout/Pembayaran
    Route::post('/checkout/{order}/pay', [CheckoutController::class, 'processPayment'])->name('checkout.pay');
});

require __DIR__ . '/auth.php';