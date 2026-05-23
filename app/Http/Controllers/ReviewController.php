<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review; // Pastikan memanggil model Review kamu

class ReviewController extends Controller
{
    /**
     * Menyimpan ulasan dari konsumen setelah pesanan selesai.
     */
    public function store(Request $request)
    {
        // Mendukung fallback jika frontend mengirimkan product_id
        if ($request->has('product_id') && !$request->has('menu_id')) {
            $request->merge(['menu_id' => $request->product_id]);
        }

        // 1. Validasi data yang masuk dari form ulasan
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
            'photo'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Maksimal 2MB
        ]);

        // 2. Handle upload foto ulasan jika konsumen menyertakan foto
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('reviews', 'public');
        }

        // 3. Simpan data ulasan baru ke tabel database
        $review = Review::create([
            'user_id'    => auth()->id(), // ID Konsumen yang sedang login
            'menu_id'    => $request->menu_id,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'photo_path' => $photoPath,
        ]);

        // 4. Kirim notifikasi ke penjual (Seller)
        $menu = \App\Models\Menu::with('user')->find($request->menu_id);
        if ($menu && $menu->user) {
            $reviewerName = auth()->user()->name;
            $stars = str_repeat('⭐', $request->rating);
            $commentSnippet = $request->comment ? '"' . \Illuminate\Support\Str::limit($request->comment, 50) . '"' : 'Memberikan rating tanpa ulasan teks.';
            
            $menu->user->notify(new \App\Notifications\GeneralNotification(
                "Ulasan Baru!",
                "{$reviewerName} memberikan {$stars} untuk {$menu->name}. {$commentSnippet}",
                "⭐"
            ));
        }

        // 5. Kembalikan konsumen ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }
}