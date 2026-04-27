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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        Menu::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image' => $imagePath,
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Menampilkan halaman edit stok
    public function editStock(Menu $menu)
    {
        return view('seller.menus.edit-stock', compact('menu'));
    }

    // Melakukan update stok manual (Requirement 1 & 3)
    public function updateStock(Request $request, Menu $menu)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $menu->update([
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Stok berhasil diperbarui!');
    }
}
