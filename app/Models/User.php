<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Field yang bisa diisi mass assignment
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * Field yang disembunyikan saat serialization
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data field
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

    // Relasi: User punya banyak Cart
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Relasi: User punya banyak Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi: User punya banyak Notification
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Relasi: User punya banyak Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
