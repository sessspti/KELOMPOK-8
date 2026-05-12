<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
});

// --- Group Route untuk User yang Sudah Login ---
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. Dashboard Konsumen
    Route::get('/dashboard', function () {
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
    })->middleware('role:konsumen')->name('dashboard');
    
    // 2. Profile Management Umum
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. Fitur Seller
    Route::prefix('seller')->middleware('role:seller')->group(function () {
        
        Route::get('/dashboard', function () {
            $menus = \App\Models\Menu::where('user_id', auth()->id())->get();
            return view('seller.dashboardSeller', compact('menus'));
        })->name('seller.dashboard');

        Route::get('/dashboardSeller', function () {
            return redirect()->route('seller.dashboard');
        });

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
            $menus = \App\Models\Menu::where('user_id', auth()->id())->get();
            return view('seller.tambah-menu', compact('menus'));
        })->name('seller.tambah-menu');

        Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('seller.profile.edit');
    });

    // 4. Fitur Lembaga Sosial
    Route::get('/sosial/dashboard', function () {
        return view('sosial.dashboard');
    })->middleware('role:lembaga_sosial')->name('sosial.dashboard');

    // 5. Fitur Checkout/Pembayaran (Hanya Konsumen)
    Route::post('/checkout/{order}/pay', [CheckoutController::class, 'processPayment'])->middleware('role:konsumen')->name('checkout.pay');

    // 6. Eksplorasi & Transaksi - Hanya Konsumen
    Route::get('/checkout-summary', function () {
        return view('transaction.checkout');
    })->middleware('role:konsumen')->name('checkout.summary');

    // 7. Fitur Admin (Pusat Kendali Platform)
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/users', function () {
            return view('admin.users.index'); 
        })->name('admin.users.index');

        Route::get('/verifikasi', function () {
            return view('admin.verifikasi');
        })->name('admin.verifikasi');

        Route::get('/edukasi', function () {
            return view('admin.edukasi.index');
        })->name('admin.edukasi');
    });
    // 8. Riwayat Transaksi & Invoice
    Route::middleware('role:konsumen')->group(function () {
        Route::get('/history', [\App\Http\Controllers\TransactionController::class, 'history'])->name('transaction.history');
        Route::get('/invoice/{transaction_id}', [\App\Http\Controllers\TransactionController::class, 'invoice'])->name('transaction.invoice');
        Route::post('/transaction/store', [\App\Http\Controllers\TransactionController::class, 'store'])->name('transaction.store');
    });
});

// Route untuk Pemilihan Role dan Password Google Auth
Route::get('/auth/google/role-password', [\App\Http\Controllers\Auth\SocialAuthController::class, 'showRoleForm'])->name('google.role.form');
Route::post('/auth/google/role-password', [\App\Http\Controllers\Auth\SocialAuthController::class, 'storeRolePassword'])->name('google.role.store');

require __DIR__ . '/auth.php';

// Cart Synchronization
Route::post('/cart/sync', [App\Http\Controllers\CartController::class, 'sync'])->name('cart.sync')->middleware('auth');