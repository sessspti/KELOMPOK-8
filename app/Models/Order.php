<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['id_user', 'menu_id', 'quantity', 'status'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
