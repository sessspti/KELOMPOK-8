<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnvironmentalImpact extends Model
{
    protected $table = 'dampak_lingkungan';

    protected $fillable = [
        'user_id',
        'food_saved_kg',
        'co2_reduced_kg',
        'money_saved',
        'total_rescues',
    ];

    protected $casts = [
        'food_saved_kg' => 'float',
        'co2_reduced_kg' => 'float',
        'money_saved' => 'float',
        'total_rescues' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
