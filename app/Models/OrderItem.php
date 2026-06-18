<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // Field yang bisa diisi mass assignment
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'product_name',
    ];

    // Casting tipe data
    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
    ];

    // Relasi: OrderItem milik Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi: OrderItem milik Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Hitung subtotal item
    public function subtotal()
    {
        return $this->price * $this->quantity;
    }
}
