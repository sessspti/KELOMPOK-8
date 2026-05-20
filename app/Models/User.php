<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// TAMBAHKAN 'role', 'provider', dan 'provider_id' di sini
#[Fillable(['name', 'email', 'password', 'role', 'provider', 'provider_id', 'avatar', 'phone_number', 'address', 'account_status', 'is_open', 'suspension_reason'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            // Dapatkan semua ID menu milik user/seller ini
            $menuIds = \App\Models\Menu::where('user_id', $user->id)->pluck('id');
            if ($menuIds->isNotEmpty()) {
                // Hapus semua order yang merujuk ke menu-menu ini
                \App\Models\Order::whereIn('menu_id', $menuIds)->delete();
                // Hapus semua menu ini agar database cascade tidak bentrok
                \App\Models\Menu::whereIn('id', $menuIds)->delete();
            }
        });
    }

    public function verification()
    {
        return $this->hasOne(UserVerification::class);
    }
}