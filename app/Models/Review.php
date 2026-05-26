<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'menu_id', 'rating', 'comment', 'photo_path', 'merchant_reply'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}