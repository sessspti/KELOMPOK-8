<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    // ✅ UBAH product_id menjadi menu_id di sini
    protected $fillable = [
        'user_id', 'menu_id', 'rating', 'comment', 'photo_path', 'merchant_reply'
    ];

    // ✅ UBAH nama fungsinya menjadi menu() dan modelnya Menu::class
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}