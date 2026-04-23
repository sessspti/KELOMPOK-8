<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;

// Route untuk Dashboard F&B (Penjual)
Route::prefix('seller')->group(function () {
    Route::get('/menus/{menu}/edit-stock', [MenuController::class, 'editStock'])->name('seller.menus.editStock');
    Route::put('/menus/{menu}/update-stock', [MenuController::class, 'updateStock'])->name('seller.menus.updateStock');
});

// Route untuk simulasi pembayaran Pembeli
Route::post('/checkout/{order}/pay', [CheckoutController::class, 'processPayment'])->name('checkout.pay');
