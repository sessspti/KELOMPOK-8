<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'provider',
        'provider_id',
        'avatar',
        'phone_number',
        'address',
        'city',
        'account_status',
        'is_open',
        'suspension_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public function suspensionMessages()
    {
        return $this->hasMany(SuspensionMessage::class);
    }

    public function verifications()
    {
        return $this->hasMany(UserVerification::class);
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'followed_id');
    }

    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    /**
     * Get the readable store status.
     *
     * @return string
     */
    public function getStoreStatusDisplayAttribute(): string
    {
        return $this->store_status === 'Buka' ? 'Buka' : 'Tutup';
    }

    /**
     * Check whether the store is open.
     *
     * @return bool
     */
    public function getIsStoreOpenAttribute(): bool
    {
        return $this->store_status === 'Buka';
    }
}