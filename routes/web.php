<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

// Redirect halaman utama ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 1. Dashboard Umum / Konsumen
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// --- Group Route untuk User yang Sudah Login ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 2. Profile Management Umum
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. Fitur Seller (Dibagi menjadi Home & Manajemen)
    Route::prefix('seller')->group(function () {
        
        // A. HOME DASHBOARD SELLER (Halaman Bento Grid)
        // Lokasi file: resources/views/seller/dashboardSeller.blade.php
        Route::get('/dashboard', function () {
            $menus = \App\Models\Menu::where('user_id', auth()->id())->get();
            return view('seller.dashboardSeller', compact('menus'));
        })->name('seller.dashboard');

        // B. MANAJEMEN PRODUK (Halaman Tabel & Form punya Dev 2)
        // Lokasi file: resources/views/seller/dashboard.blade.php
        Route::get('/manage-inventory', function () {
            $menus = \App\Models\Menu::where('user_id', auth()->id())->get();
            return view('seller.dashboard', compact('menus'));
        })->name('seller.manage');

        // C. PROSES CRUD (Tambah & Update)
        Route::post('/menus', [MenuController::class, 'store'])->name('seller.menus.store');
        Route::get('/menus/{menu}/edit-stock', [MenuController::class, 'editStock'])->name('seller.menus.editStock');
        Route::put('/menus/{menu}/update-stock', [MenuController::class, 'updateStock'])->name('seller.menus.updateStock');

        // D. PERBAIKAN: Rute Alias untuk Profil Seller (Agar tidak error di Dashboard Bento)
        Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('seller.profile.edit');
    });

    // 4. Fitur Lembaga Sosial
    // Route::get('/sosial/dashboard', function () {
    //     return view('sosial.dashboard');
    // })->name('sosial.dashboard');

    // 5. Fitur Checkout/Pembayaran
    Route::post('/checkout/{order}/pay', [CheckoutController::class, 'processPayment'])->name('checkout.pay');
});

require __DIR__ . '/auth.php';