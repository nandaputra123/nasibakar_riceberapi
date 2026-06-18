<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // Field yang bisa diisi mass assignment
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    // Casting tipe data
    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relasi: Cart milik User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Cart milik Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Hitung subtotal = price * quantity
    public function subtotal()
    {
        return $this->product->price * $this->quantity;
    }
}
