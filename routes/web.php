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
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\Admin\ImpactDashboardController as AdminImpactController;
use App\Http\Controllers\Admin\VerificationController as AdminVerificationController;
use App\Services\ImpactCalculatorService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ─── ROOT: Redirect berdasarkan role ───
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        
        // Arahkan ke dashboard masing-masing sesuai role
        return match ($role) {
            'admin'           => redirect()->route('admin.dashboard'),
            'seller'          => redirect()->route('seller.dashboard'),
            'lembaga_sosial'  => redirect()->route('sosial.dashboard'),
            default           => redirect()->route('dashboard'), // Role konsumen
        };
    }
    // Guest yang belum login → halaman publik (dashboard/home)
    return redirect()->route('guest.dashboard');
});

// ─── ROUTE PUBLIK: Dashboard Guest ───
Route::get('/home', function () {
    // 1. Ambil data menu agar Guest tetap bisa melihat produk/makanan yang tersedia
    $menus = \App\Models\Menu::with('user')
        ->withAvg('reviews', 'rating') 
        ->withCount('reviews')        
        ->where('stock', '>', 0)
        ->whereHas('user', fn($q) => $q->where('role', 'seller'))
        ->notExpired()->latest()->get();
    
    // Mapping data is_open dan status penangguhan milik user ke dalam setiap item menu
    $menus->map(function ($menu) {
        $menu->store_is_open = ($menu->user && $menu->user->is_open && $menu->user->account_status !== 'rejected') ? 1 : 0;
        $menu->store_is_suspended = ($menu->user && $menu->user->account_status === 'rejected') ? 1 : 0;
        return $menu;
    });

    // 2. Karena guest belum login, buatlah $orders kosong (menggunakan collect())
    $orders = collect(); 

    return view('dashboard', compact('menus', 'orders'));
})->name('guest.dashboard');

// Halaman Detail Toko (Public)
Route::get('/store/{id}', [MenuController::class, 'showStore'])->name('store.show');

// ==============================================================================
// ─── GROUP ROUTE KHUSUS USER YANG LOGGED IN ───
// ==============================================================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/impact/me', function (ImpactCalculatorService $calculator) {
        $impact = $calculator->syncForUser(auth()->id());

        return response()->json([
            'food_saved_kg' => (float) $impact->food_saved_kg,
            'co2_reduced_kg' => (float) $impact->co2_reduced_kg,
            'money_saved' => (float) $impact->money_saved,
            'total_rescues' => (int) $impact->total_rescues,
        ]);
    })->name('impact.me');

    // 1. Dashboard Konsumen
    Route::get('/dashboard', [MenuController::class, 'consumerDashboard'])
        ->middleware('role:konsumen')
        ->name('dashboard');

    // 2. Profile Management Umum (bisa diakses semua role yang login)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. Notifikasi
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // 4. Verifikasi Akun/Dokumen (KTP, NIB, dll)
    Route::get('/verify/notice', [VerificationController::class, 'notice'])->name('verification.notice');
    Route::post('/verify/store', [VerificationController::class, 'upload'])->name('verification.upload');
    Route::get('/verify/notice/messages', [VerificationController::class, 'getMessages'])->name('verification.messages.get');
    Route::post('/verify/notice/messages', [VerificationController::class, 'sendMessage'])->name('verification.messages.send');

    // 5. Riwayat Transaksi & Invoice
    Route::get('/transaction/history', [TransactionController::class, 'history'])->name('transaction.history');
    Route::get('/transaction/invoice/{transactionId}', [TransactionController::class, 'invoice'])->name('transaction.invoice');
    Route::post('/transaction/store', [TransactionController::class, 'store'])->name('transaction.store');

    // 5b. Follow & Chat Umum
    Route::post('/store/{id}/follow', [\App\Http\Controllers\FollowController::class, 'toggle'])->name('store.follow');
    
    Route::prefix('chat')->group(function () {
        Route::get('/', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
        Route::get('/{userId}', [\App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
        Route::post('/{userId}', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.store');
    });

    // 6. Fitur Seller (Dibagi menjadi Home & Manajemen)
    Route::prefix('seller')->middleware(['role:seller', 'approved'])->group(function () {
        Route::get('/dashboard', function (ImpactCalculatorService $impactCalculator) {
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

            // ── Performa Bulan Ini ──
            $thisMonthOrders = $orders->filter(function ($order) {
                return $order->created_at->month === now()->month
                    && $order->created_at->year === now()->year;
            });

            $soldThisMonth = $thisMonthOrders->filter(function ($order) {
                return $order->user && $order->user->role === 'konsumen';
            })->sum('quantity');

            $claimedThisMonth = $thisMonthOrders->filter(function ($order) {
                return $order->user && $order->user->role === 'lembaga_sosial';
            })->sum('quantity');

            $totalPortionsThisMonth = $soldThisMonth + $claimedThisMonth;
            $foodSavedKg = round($totalPortionsThisMonth * 0.3, 1);

            $performance = [
                'sold'       => $soldThisMonth,
                'claimed'    => $claimedThisMonth,
                'total'      => $totalPortionsThisMonth,
                'food_saved' => $foodSavedKg,
            ];

            // ── Rating Toko ──
            $avgRating = \App\Models\Review::whereHas('menu', function ($query) {
                $query->where('user_id', auth()->id());
            })->avg('rating');
            
            $avgRating = $avgRating ? number_format($avgRating, 1) : '0.0';

            // ── Semua Ulasan ──
            $allReviews = \App\Models\Review::whereHas('menu', function ($query) {
                $query->where('user_id', auth()->id());
            })->with(['menu', 'user'])->latest()->get();

            // ── Pesan/Chat ──
            $userId = auth()->id();
            $messages = \App\Models\Message::where('sender_id', $userId)
                ->orWhere('receiver_id', $userId)
                ->with(['sender', 'receiver'])
                ->latest()
                ->get();

            $contacts = collect();
            foreach ($messages as $msg) {
                $otherUser = $msg->sender_id == $userId ? $msg->receiver : $msg->sender;
                if (!$contacts->has($otherUser->id)) {
                    $unreadCount = \App\Models\Message::where('sender_id', $otherUser->id)
                                          ->where('receiver_id', $userId)
                                          ->where('is_read', false)
                                          ->count();
                    $contacts->put($otherUser->id, (object)[
                        'user' => $otherUser,
                        'last_message' => $msg,
                        'unread_count' => $unreadCount
                    ]);
                }
            }

            $impact = $impactCalculator->syncForUser(auth()->id());

            return view('seller.dashboardSeller', compact('menus', 'orders', 'activeMenusCount', 'lowStockMenusCount', 'totalClaimsCount', 'performance', 'avgRating', 'allReviews', 'contacts', 'impact'));
        })->name('seller.dashboard');

        // Route untuk update status pesanan
        Route::patch('/orders/{order}/status', function (\App\Models\Order $order) {
            $status = request('status');

            // AC 5 — Log Pengambilan: catat waktu penyerahan self-pickup
            $updateData = ['status' => $status];
            if ($status === 'selesai' && $order->pickup_method === 'self-pickup' && is_null($order->picked_up_at)) {
                $updateData['picked_up_at'] = now();
            }

            $order->update($updateData);

            $previousStatus = $order->status;
            $order->update(['status' => $status]);

            if ($status === 'selesai' && $previousStatus !== 'selesai') {
                app(ImpactCalculatorService::class)->calculateFromOrder($order->fresh(['menu', 'user']));
            }

            // Kirim notifikasi ke konsumen
            $updateData = ['status' => $status];
            if ($status === 'selesai' && $order->pickup_method === 'self-pickup' && is_null($order->picked_up_at)) {
                $updateData['picked_up_at'] = now();
            }
            $order->update($updateData);

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

        Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('seller.profile.edit');
        Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus.alt');
        Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
        Route::post('/toggle-status', [MenuController::class, 'toggleStatus'])->name('seller.toggle-status');
        Route::post('/reviews/{review}/reply', [\App\Http\Controllers\ReviewController::class, 'reply'])->name('seller.reviews.reply');
    });

    // 7. Fitur Lembaga Sosial
    Route::prefix('sosial')->middleware(['role:lembaga_sosial', 'approved'])->group(function () {
        Route::get('/dashboard', [MenuController::class, 'institutionDashboard'])->name('sosial.dashboard');
        Route::post('/claim', [TransactionController::class, 'claimDonation'])->name('sosial.claim');
        Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('sosial.profile.edit');
    });

    // 8. Fitur Checkout/Pembayaran (Hanya Konsumen)
    Route::post('/checkout/{order}/pay', [CheckoutController::class, 'processPayment'])->middleware('role:konsumen')->name('checkout.pay');

    // 9. Fitur Summary - Hanya Konsumen
    Route::get('/checkout-summary', function () {
        return view('transaction.checkout');
    })->middleware('role:konsumen')->name('checkout.summary');

    // 9b. Fitur Ulasan / Review Makanan (Konsumen dan Lembaga Sosial)
    Route::post('/reviews/store', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

    // ==============================================================================
    // 9c. Fitur Keluhan Pengguna (SISI KONSUMEN & LEMBAGA SOSIAL) - AMAN SINKRON
    // ==============================================================================
    Route::post('/complaints/store/{sellerId}', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints', [ComplaintController::class, 'myComplaints'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [ComplaintController::class, 'show'])->name('complaints.show');
    
    // 💡 DIUBAH: disesuaikan dengan 'complaints.sendMessage' bawaan Controller kamu
    Route::post('/complaints/{complaint}/send', [ComplaintController::class, 'sendMessage'])->name('complaints.sendMessage');


    // ==============================================================================
    // 10. Fitur Admin (Pusat Kendali Platform)
    // ==============================================================================
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        
        Route::get('/dashboard', function (\Illuminate\Http\Request $request, ImpactCalculatorService $impactCalculator) {
            $impactCalculator->recalculateAll();

            $orders = \App\Models\Order::with(['menu.user', 'user'])->latest()->get();
            $ordersGrouped = $orders->groupBy(fn($order) => $order->menu->user->name ?? 'Unknown Store');
            $pendingVerifications = \App\Models\UserVerification::with('user')->where('status', 'pending')->latest()->get();

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

            $totalUsers = \App\Models\User::count();
            $activeSellers = \App\Models\User::where('role', 'seller')->where('account_status', 'approved')->count();

            // Hitung global impact dari semua transaksi selesai
            $completedOrders = \App\Models\Order::where('status', 'selesai')->get();
            
            $globalFoodSaved = 0;
            $globalTransactions = $completedOrders->count();
            
            // Hitung total makanan diselamatkan (asumsi 0.5kg per item)
            foreach ($completedOrders as $order) {
                $averageWeight = 0.5; // 500 gram per item makanan
                $globalFoodSaved += $order->quantity * $averageWeight;
            }
            
            // Tambahkan donasi yang sudah diterima jika ada
            $completedDonations = \App\Models\Donation::count(); // Hitung total donasi sebagai transaksi
            $globalTransactions += $completedDonations;
            
            // Buat object global impact
            $globalImpact = (object) [
                'food_saved_kg' => $globalFoodSaved,
                'total_rescues' => $globalTransactions
            ];

            $complaintsList = \App\Models\Complaint::with(['reporter', 'seller'])->latest()->get();
            $totalComplaints = \App\Models\Complaint::where('status', 'pending')->count();

            return view('admin.dashboard', compact('ordersGrouped', 'pendingVerifications', 'usersList', 'totalUsers', 'activeSellers', 'complaintsList', 'totalComplaints', 'globalImpact'));
        })->name('admin.dashboard');

        Route::post('/verifications/{user}/approve', [AdminVerificationController::class, 'approve'])->name('admin.verifications.approve');
        Route::post('/verifications/{user}/reject', [AdminVerificationController::class, 'reject'])->name('admin.verifications.reject');
        Route::post('/users/{user}/toggle-status', [AdminVerificationController::class, 'toggleStatus'])->name('admin.users.toggle-status');
        Route::delete('/users/{user}', [AdminVerificationController::class, 'destroy'])->name('admin.users.destroy');
        Route::get('/users/{user}/messages', [AdminVerificationController::class, 'getMessages'])->name('admin.users.messages.get');
        Route::post('/users/{user}/messages', [AdminVerificationController::class, 'sendMessage'])->name('admin.users.messages.send');

        Route::get('/users', fn() => view('admin.users.index'))->name('admin.users.index');
        Route::get('/verifikasi', fn() => view('admin.verifikasi'))->name('admin.verifikasi');
        Route::get('/edukasi', fn() => view('admin.edukasi.index'))->name('admin.edukasi');
        Route::get('/impact/stats', [AdminImpactController::class, 'globalStats'])->name('admin.impact.stats');

        // Jalur Khusus Admin untuk melihat & merespon Tiket Keluhan
        Route::get('/complaints/{complaint}', [ComplaintController::class, 'adminShow'])->name('admin.complaints.show');
        Route::post('/complaints/{complaint}/reply', [ComplaintController::class, 'adminReply'])->name('admin.complaints.reply');
        Route::post('/admin/complaints/{complaint}/status', [ComplaintController::class, 'updateStatus'])->name('admin.complaints.status');
    });

}); // <─── PENUTUP MIDDLEWARE GLOBAL LOGIN YANG BENAR

// --- Auth & Donasi (Akses Publik / Tanpa Batasan) ---
Route::get('/donasi', [DonationController::class, 'index'])->name('donations.index');
Route::get('/auth/google/role-password', [\App\Http\Controllers\Auth\SocialAuthController::class, 'showRoleForm'])->name('google.role.form');
Route::post('/auth/google/role-password', [\App\Http\Controllers\Auth\SocialAuthController::class, 'storeRolePassword'])->name('google.role.store');

require __DIR__ . '/auth.php'; 

// Cart Synchronization
Route::post('/cart/sync', [App\Http\Controllers\CartController::class, 'sync'])->name('cart.sync')->middleware('auth');