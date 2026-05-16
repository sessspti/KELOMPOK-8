<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Menu;

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
    // Kita pastikan role pengguna tersebut memang adalah 'seller'
    $seller = \App\Models\User::where('role', 'seller')->findOrFail($id);

    // 2. Ambil SEMUA makanan dari tabel menus yang kolom 'user_id'-nya COCOK dengan ID penjual ini
    // Kita juga gunakan 'notExpired()' agar makanan yang sudah kedaluwarsa tidak ikut tampil
    $menus = \App\Models\Menu::where('user_id', $id)
                            ->notExpired()
                            ->latest()
                            ->get();

    // 3. Kirim data penjual ($seller) dan daftar makanannya ($menus) ke file tampilan baru
    return view('store.show', compact('seller', 'menus'));
}
}
