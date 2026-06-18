<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Field yang bisa diisi mass assignment
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category',
        'is_active',
    ];

    // Casting tipe data
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relasi: Product punya banyak Cart
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Relasi: Product punya banyak OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi: Product punya banyak Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Hitung rata-rata rating produk
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    // Hitung jumlah review produk
    public function reviewCount()
    {
        return $this->reviews()->count();
    }
}
