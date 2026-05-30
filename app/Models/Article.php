<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'category',
        'content',
        'image',
        'status',
    ];

    /**
     * Boot method untuk auto-generate slug dari title.
     */
    protected static function boot()
    {
        parent::boot();

        // Event: Sebelum membuat artikel baru
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
                
                // Pastikan slug unik dengan menambahkan suffix jika duplikat
                $originalSlug = $article->slug;
                $count = 1;
                
                while (static::where('slug', $article->slug)->exists()) {
                    $article->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });

        // Event: Sebelum update artikel
        static::updating(function ($article) {
            if ($article->isDirty('title')) {
                $article->slug = Str::slug($article->title);
                
                // Pastikan slug unik (kecuali untuk artikel itu sendiri)
                $originalSlug = $article->slug;
                $count = 1;
                
                while (static::where('slug', $article->slug)
                    ->where('id', '!=', $article->id)
                    ->exists()) {
                    $article->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }
}
