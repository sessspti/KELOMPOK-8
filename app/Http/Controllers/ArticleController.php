<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Menampilkan daftar semua artikel edukasi (Public)
     */
    public function indexPublic()
    {
        // Ambil semua artikel dengan status published dan paginasi 12 item
        $articles = Article::where('status', 'published')
            ->latest()
            ->paginate(12);

        return view('articles.index', compact('articles'));
    }
}
