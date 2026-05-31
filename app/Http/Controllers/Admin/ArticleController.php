<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of articles.
     * Menampilkan daftar artikel terbaru untuk admin dashboard.
     */
    public function index()
    {
        // Ambil data artikel terbaru, urutkan dari yang paling baru
        $articles = Article::latest()->get();

        // Kirim data ke view admin dashboard
        return view('admin.dashboard', compact('articles'));
    }

    /**
     * Store a newly created article in storage.
     * Menyimpan artikel baru ke database dengan validasi dan upload foto.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255'
            ],
            'category' => [
                'required',
                'string',
                'max:100'
            ],
            'content' => [
                'required',
                'string'
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048' // Maksimal 2MB
            ],
            'status' => [
                'required',
                'in:published,draft'
            ],
        ], [
            // Pesan error dalam Bahasa Indonesia
            'title.required' => 'Judul artikel wajib diisi.',
            'title.max' => 'Judul artikel maksimal 255 karakter.',
            'category.required' => 'Kategori artikel wajib diisi.',
            'category.max' => 'Kategori artikel maksimal 100 karakter.',
            'content.required' => 'Konten artikel wajib diisi.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'status.required' => 'Status artikel wajib dipilih.',
            'status.in' => 'Status artikel tidak valid.',
        ]);

        // Handle upload foto jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Upload ke storage public dengan folder 'articles'
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        // Simpan artikel ke database
        Article::create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'content' => $validated['content'],
            'image' => $imagePath,
            'status' => $validated['status'],
            // slug akan otomatis terisi melalui boot event di Model
        ]);

        // Redirect kembali dengan flash message success
        return redirect()
            ->back()
            ->with('success', 'Artikel berhasil ditambahkan!');
    }

    /**
     * Update the specified article in storage.
     * Mengupdate artikel dengan validasi dan upload foto baru.
     */
    public function update(Request $request, Article $article)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255'
            ],
            'category' => [
                'required',
                'string',
                'max:100'
            ],
            'content' => [
                'required',
                'string'
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048' // Maksimal 2MB
            ],
            'status' => [
                'required',
                'in:published,draft'
            ],
        ], [
            // Pesan error dalam Bahasa Indonesia
            'title.required' => 'Judul artikel wajib diisi.',
            'title.max' => 'Judul artikel maksimal 255 karakter.',
            'category.required' => 'Kategori artikel wajib diisi.',
            'category.max' => 'Kategori artikel maksimal 100 karakter.',
            'content.required' => 'Konten artikel wajib diisi.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'status.required' => 'Status artikel wajib dipilih.',
            'status.in' => 'Status artikel tidak valid.',
        ]);

        // Handle upload foto baru jika ada
        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($article->image && Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }
            
            // Upload foto baru
            $validated['image'] = $request->file('image')->store('articles', 'public');
        }

        // Update artikel
        $article->update($validated);

        // Redirect kembali dengan flash message success
        return redirect()
            ->back()
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified article from storage.
     * Menghapus artikel dan file foto terkait dari storage.
     */
    public function destroy(Article $article)
    {
        // Hapus foto dari storage jika ada
        if ($article->image && Storage::disk('public')->exists($article->image)) {
            Storage::disk('public')->delete($article->image);
        }

        // Hapus artikel dari database
        $article->delete();

        // Redirect kembali dengan flash message success
        return redirect()
            ->back()
            ->with('success', 'Artikel berhasil dihapus!');
    }
}
