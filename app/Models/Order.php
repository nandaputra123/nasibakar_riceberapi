<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Field yang bisa diisi mass assignment
    protected $fillable = [
        'user_id',
        'order_code',
        'status',
        'total_price',
        'shipping_address',
        'phone',
        'note',
    ];

    // Casting tipe data
    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    // Relasi: Order milik User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Order punya banyak OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi: Order punya satu Payment
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // Relasi: Order punya banyak Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
