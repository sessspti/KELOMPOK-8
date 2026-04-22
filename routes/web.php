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

// Route untuk Konsumen (Default Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk Seller FoodSave
Route::get('/seller/dashboard', function () {
    return view('seller.dashboard'); // Pastikan nanti buat file resources/views/seller/dashboard.blade.php
})->middleware(['auth'])->name('seller.dashboard');

// Route untuk Lembaga Sosial
Route::get('/sosial/dashboard', function () {
    return view('sosial.dashboard'); // Pastikan nanti buat file resources/views/sosial/dashboard.blade.php
})->middleware(['auth'])->name('sosial.dashboard');

require __DIR__ . '/auth.php';
