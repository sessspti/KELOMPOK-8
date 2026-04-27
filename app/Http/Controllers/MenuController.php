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

        return redirect()->route('seller.tambah-menu')->with('success', 'Produk berhasil ditambahkan!');
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
            $menu->image = $imagePath;
        }

        $menu->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'image' => $menu->image,
        ]);

        return redirect()->route('seller.tambah-menu')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($menu->image);
        }
        $menu->delete();

        return redirect()->route('seller.tambah-menu')->with('success', 'Menu berhasil dihapus!');
    }
}
