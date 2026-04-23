<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Menu;

class MenuController extends Controller
{
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
