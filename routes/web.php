<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

    // 1. Profile Management Umum (bisa diakses semua role yang login)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Fitur Seller (Dibagi menjadi Home & Manajemen)
    Route::prefix('seller')->middleware('role:seller')->group(function () {
        
        // A. HOME DASHBOARD SELLER (Halaman Bento Grid)
        // Lokasi file: resources/views/seller/dashboardSeller.blade.php
        Route::get('/dashboard', function () {
            $menus = \App\Models\Menu::where('user_id', auth()->id())->get();
            return view('seller.dashboardSeller', compact('menus'));
        })->name('seller.dashboard');

        // Alias: agar URL /seller/dashboardSeller juga bisa diakses langsung
        Route::get('/dashboardSeller', function () {
            return redirect()->route('seller.dashboard');
        });

        // B. ETALASE MENU (Daftar menu + tombol tambah/edit/hapus)
        // Lokasi file: resources/views/seller/etalase.blade.php
        Route::get('/manage-inventory', function () {
            $menus = \App\Models\Menu::where('user_id', auth()->id())->get();
            return view('seller.etalase', compact('menus'));
        })->name('seller.manage');

        // C. PROSES CRUD (Tambah, Edit, Update, Hapus)
        Route::post('/menus', [MenuController::class, 'store'])->name('seller.menus.store');
        Route::get('/menus/{menu}/edit', [MenuController::class, 'editMenu'])->name('seller.menus.editMenu');
        Route::put('/menus/{menu}/update', [MenuController::class, 'updateMenu'])->name('seller.menus.updateMenu');
        Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('seller.menus.destroy');

        // Alias nama route agar redirect di controller bisa menemukan seller.tambah-menu
        Route::get('/tambah-menu', function () {
            $menus = \App\Models\Menu::where('user_id', auth()->id())->get();
            return view('seller.tambah-menu', compact('menus'));
        })->name('seller.tambah-menu');

        // D. Rute Alias untuk Profil Seller (Agar tidak error di Dashboard Bento)
        Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('seller.profile.edit');
    });

    // 3. Fitur Lembaga Sosial
    Route::prefix('sosial')->middleware('role:lembaga_sosial')->group(function () {
        Route::get('/dashboard', function () {
            return view('sosial.dashboard');
        })->name('sosial.dashboard');

        // Profil untuk Lembaga Sosial
        Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('sosial.profile.edit');
    });

    // 4. Fitur Checkout/Pembayaran (Hanya Konsumen)
    Route::post('/checkout/{order}/pay', [CheckoutController::class, 'processPayment'])->middleware('role:konsumen')->name('checkout.pay');

    // 5. Eksplorasi & Transaksi (FoodSave Features) - Hanya Konsumen
    Route::get('/checkout-summary', function () {
        return view('transaction.checkout');
    })->middleware('role:konsumen')->name('checkout.summary');

    // 6. Fitur Admin (Pusat Kendali Platform)
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        
        // Dashboard Utama Admin
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Manajemen User (PBI-007)
        Route::get('/users', function () {
            return view('admin.users.index'); 
        })->name('admin.users.index');

        // Validasi Merchant & Lembaga
        Route::get('/verifikasi', function () {
            return view('admin.verifikasi');
        })->name('admin.verifikasi');

        // Manajemen Konten/Artikel Edukasi
        Route::get('/edukasi', function () {
            return view('admin.edukasi.index');
        })->name('admin.edukasi');
    });
});


// Route untuk Pemilihan Role dan Password Google Auth
Route::get('/auth/google/role-password', [\App\Http\Controllers\Auth\SocialAuthController::class, 'showRoleForm'])->name('google.role.form');
Route::post('/auth/google/role-password', [\App\Http\Controllers\Auth\SocialAuthController::class, 'storeRolePassword'])->name('google.role.store');

require __DIR__ . '/auth.php';