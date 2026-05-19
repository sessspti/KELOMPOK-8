<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'ktp_path', 'nib_path', 'surat_izin_path', 'profil_seller_path', 'status', 'rejection_reason'])]
class UserVerification extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
