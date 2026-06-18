<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Field yang bisa diisi mass assignment
    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'rating',
        'comment',
    ];

    // Casting tipe data
    protected $casts = [
        'rating' => 'integer',
    ];

    // Relasi: Review milik User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Review milik Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi: Review milik Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
