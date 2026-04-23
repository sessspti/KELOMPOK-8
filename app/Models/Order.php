<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['menu_id', 'quantity', 'status'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
