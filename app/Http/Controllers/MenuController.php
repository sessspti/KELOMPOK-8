<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Complaint; // 💡 TAMBAHAN AMAN: Meng-import model Complaint agar bisa digunakan
use App\Models\Article; // Import model Article untuk edukasi
use App\Services\ImpactCalculatorService;
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

        // 5. Calculate impact data for the seller
        $impact = app(ImpactCalculatorService::class)->syncForUser($id);

        // 6. Kirim data penjual ($seller), daftar makanan ($menus), $activeComplaint, dan $impact ke file tampilan
        return view('store.show', compact('seller', 'menus', 'followersCount', 'isFollowed', 'activeComplaint', 'impact'));
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
        $kota = request('kota');
        $menus = $visibilityService->getVisibleProductsForConsumer();

        //(Karena data dari Service, gunakan loadAvg & loadCount & load)
        $menus->loadAvg('reviews', 'rating')->loadCount('reviews')->load('reviews.user');
        
        // Terapkan filter kota secara case-insensitive
        if ($kota) {
            $menus = $menus->filter(function ($menu) use ($kota) {
                return $menu->user && strtolower($menu->user->city ?? '') === strtolower($kota);
            })->values();
        }
        
        // Add store_is_open information to each menu
        $menus = $menus->map(function ($menu) {
            $menu->store_is_open = ($menu->user && $menu->user->is_open && $menu->user->account_status !== 'rejected') ? 1 : 0;
            $menu->store_is_suspended = ($menu->user && $menu->user->account_status === 'rejected') ? 1 : 0;
            return $menu;
        });
        
        $orders = \App\Models\Order::where('id_user', auth()->id())
            ->with('menu.user')
            ->latest()
            ->get();

        $impact = app(ImpactCalculatorService::class)->syncForUser(auth()->id());

        // Ambil artikel edukasi yang berstatus published (maksimal 4 artikel terbaru)
        $articles = Article::where('status', 'published')->latest()->take(4)->get();

        return view('dashboard', compact('menus', 'orders', 'impact', 'articles'));
    }

    public function institutionDashboard(ProductVisibilityService $visibilityService)
    {
        $kota = request('kota');
        $menus = $visibilityService->getVisibleProductsForInstitution();
        
        // Load reviews data sama seperti konsumen
        $menus->loadAvg('reviews', 'rating')->loadCount('reviews')->load('reviews.user');

        // Terapkan filter kota secara case-insensitive
        if ($kota) {
            $menus = $menus->filter(function ($menu) use ($kota) {
                return $menu->user && strtolower($menu->user->city ?? '') === strtolower($kota);
            })->values();
        }
        
        // Add store_is_open information to each menu
        $menus = $menus->map(function ($menu) {
            $menu->store_is_open = ($menu->user && $menu->user->is_open && $menu->user->account_status !== 'rejected') ? 1 : 0;
            $menu->store_is_suspended = ($menu->user && $menu->user->account_status === 'rejected') ? 1 : 0;
            return $menu;
        });
        
        $orders = \App\Models\Order::where('id_user', auth()->id())
            ->with('menu.user')
            ->latest()
            ->get();

        $contribution = app(ImpactCalculatorService::class)->syncForUser(auth()->id());
        $articles = Article::where('status', 'published')->latest()->take(4)->get();

        return view('sosial.dashboard', compact('menus', 'orders', 'contribution', 'articles'));
    }
}