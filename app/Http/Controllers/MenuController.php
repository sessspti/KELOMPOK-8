<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Complaint; // 💡 TAMBAHAN AMAN: Meng-import model Complaint agar bisa digunakan
use App\Services\ProductVisibilityService;

class MenuController extends Controller
{
    /**
     * Menyimpan produk (menu) baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'discount' => 'required|integer|min:0|max:100',
            'stock'    => 'required|integer|min:1',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'expiry_date' => 'nullable|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        Menu::create([
            'user_id'  => auth()->id(),
            'name'     => $validated['name'],
            'price'    => $validated['price'],
            'discount' => $validated['discount'],
            'stock'    => $validated['stock'],
            'image'    => $imagePath,
            'expiry_date' => $request->expiry_date,
        ]);

        return redirect()->route('seller.manage')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan halaman edit menu
    public function editMenu(Menu $menu)
    {
        return view('seller.menus.edit-menu', compact('menu'));
    }

    // Melakukan update menu
    public function updateMenu(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'discount' => 'required|integer|min:0|max:100',
            'stock'    => 'required|integer|min:0',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'expiry_date' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
            $menu->image = $imagePath;
        }

        $menu->update([
            'name'     => $validated['name'],
            'price'    => $validated['price'],
            'discount' => $validated['discount'],
            'stock'    => $validated['stock'],
            'image'    => $menu->image,
            'expiry_date' => $request->expiry_date,
        ]);

        return redirect()->route('seller.manage')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->image);
        }
        $menu->delete();

        return redirect()->route('seller.manage')->with('success', 'Menu berhasil dihapus!');
    }

    public function showStore($id)
    {
        // 1. Ambil data profil penjual berdasarkan ID yang diklik
        $seller = \App\Models\User::where('role', 'seller')->findOrFail($id);

        // 2. Ambil SEMUA makanan dari tabel menus yang kolom 'user_id'-nya COCOK dengan ID penjual ini
        $menus = \App\Models\Menu::with('reviews.user')
                                ->where('user_id', $id)
                                ->withAvg('reviews', 'rating')
                                ->withCount('reviews')
                                ->notExpired()
                                ->latest()
                                ->get();

    // 3. Tambahkan informasi store status ke setiap menu
    $menus = $menus->map(function ($menu) use ($seller) {
        $menu->store_is_open = ($seller->is_open && $seller->account_status !== 'rejected') ? 1 : 0;
        $menu->store_is_suspended = ($seller->account_status === 'rejected') ? 1 : 0;
        // Pastikan properties ini selalu diset untuk dikonsumsi Alpine.js
        $menu->reviews_count = $menu->reviews_count ?? 0;
        $menu->reviews_avg_rating = $menu->reviews_avg_rating ?? 0.0;
        return $menu;
    });
        // 3. Tambahkan informasi store status ke setiap menu
        $menus = $menus->map(function ($menu) use ($seller) {
            $menu->store_is_open = $seller->is_open ? 1 : 0;
            $menu->reviews_count = $menu->reviews_count ?? 0;
            $menu->reviews_avg_rating = $menu->reviews_avg_rating ?? 0.0;
            return $menu;
        });

        // 4. Data Follow
        $followersCount = \App\Models\Follow::where('followed_id', $id)->count();
        $isFollowed = auth()->check() ? \App\Models\Follow::where('follower_id', auth()->id())->where('followed_id', $id)->exists() : false;

        // ──💡 DI SINI PERUBAHANNYA: Ambil keluhan aktif milik pengguna terhadap toko ini ──
        $activeComplaint = null;
        if (auth()->check()) {
            $activeComplaint = Complaint::where('user_id', auth()->id())
                ->where('seller_id', $id)
                ->whereIn('status', ['pending', 'ditinjau']) // Mengunci tombol jika laporan belum berstatus selesai/ditolak
                ->first();
        }

        // 5. Kirim data penjual ($seller), daftar makanan ($menus), dan $activeComplaint ke file tampilan
        return view('store.show', compact('seller', 'menus', 'followersCount', 'isFollowed', 'activeComplaint'));
    }

    public function toggleStatus()
    {
        // 1. Ambil data seller yang sedang login
        $user = auth()->user();

        // 2. Balikkan statusnya: jika 1 (buka) jadi 0 (tutup), jika 0 jadi 1
        $user->is_open = !$user->is_open;
        
        // 3. Simpan perubahan ke database
        $user->save();

        // 4. Kembalikan ke halaman dashboard dengan pesan sukses
        return back()->with('success', 'Status toko berhasil diperbarui!');
    }

    /**
     * Display consumer dashboard with visible products only.
     */
    public function consumerDashboard(ProductVisibilityService $visibilityService)
    {
        $menus = $visibilityService->getVisibleProductsForConsumer();

        //(Karena data dari Service, gunakan loadAvg & loadCount & load)
        $menus->loadAvg('reviews', 'rating')->loadCount('reviews')->load('reviews.user');
        
        // Add store_is_open information to each menu
        $menus = $menus->map(function ($menu) {
            $menu->store_is_open = ($menu->user && $menu->user->is_open && $menu->user->account_status !== 'rejected') ? 1 : 0;
            $menu->store_is_suspended = ($menu->user && $menu->user->account_status === 'rejected') ? 1 : 0;
            return $menu;
        });
        
        // Get orders for authenticated user
        $orders = \App\Models\Order::where('id_user', auth()->id())
            ->with('menu.user')
            ->latest()
            ->get();

        // ── Dampak Lingkungan: hitung dari riwayat pembelian konsumen ──
        $completedOrders = $orders->whereIn('status', ['selesai', 'siap_diambil', 'paid', 'proses']);
        $totalPortionsBought = $completedOrders->sum('quantity');
        // Konversi: 1 porsi ≈ 0.3 kg makanan diselamatkan
        $foodSavedKg = round($totalPortionsBought * 0.3, 1);
        // Konversi: 1 kg makanan diselamatkan ≈ 2.5 kg CO₂ dikurangi
        $co2ReducedKg = round($foodSavedKg * 2.5, 1);

        $impact = [
            'total_portions' => $totalPortionsBought,
            'food_saved_kg'  => $foodSavedKg,
            'co2_reduced_kg' => $co2ReducedKg,
        ];

        return view('dashboard', compact('menus', 'orders', 'impact'));
    }

    /**
     * Display institution dashboard with visible products only.
     */
    public function institutionDashboard(ProductVisibilityService $visibilityService)
    {
        $menus = $visibilityService->getVisibleProductsForInstitution();
        
        $menus->loadAvg('reviews', 'rating')->loadCount('reviews')->load('reviews.user');
        // Add store_is_open information to each menu
        $menus = $menus->map(function ($menu) {
            $menu->store_is_open = ($menu->user && $menu->user->is_open && $menu->user->account_status !== 'rejected') ? 1 : 0;
            $menu->store_is_suspended = ($menu->user && $menu->user->account_status === 'rejected') ? 1 : 0;
            return $menu;
        });
        
        // Get orders for authenticated user (klaim donasi)
        $orders = \App\Models\Order::where('id_user', auth()->id())
            ->with('menu.user')
            ->latest()
            ->get();

        // ── Kontribusi Sosial & Lingkungan: hitung dari klaim donasi ──
        $claimedOrders = $orders->whereIn('status', ['selesai', 'siap_diambil', 'paid', 'proses']);
        $totalClaimedPortions = $claimedOrders->sum('quantity');
        // Konversi: 1 porsi ≈ 0.3 kg makanan tersalurkan
        $foodDistributedKg = round($totalClaimedPortions * 0.3, 1);
        // Konversi: 1 kg makanan diselamatkan ≈ 2.5 kg CO₂ dikurangi
        $co2ReducedKg = round($foodDistributedKg * 2.5, 1);

        $contribution = [
            'total_claims'       => $claimedOrders->count(),
            'total_portions'     => $totalClaimedPortions,
            'food_distributed_kg'=> $foodDistributedKg,
            'co2_reduced_kg'     => $co2ReducedKg,
        ];

        return view('sosial.dashboard', compact('menus', 'orders', 'contribution'));
    }
}