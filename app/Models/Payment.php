<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Field yang bisa diisi mass assignment
    protected $fillable = [
        'order_id',
        'method',
        'status',
        'amount',
        'note',
        'confirmed_at',
        'proof_of_transfer',
    ];

    // Casting tipe data
    protected $casts = [
        'amount' => 'decimal:2',
        'confirmed_at' => 'datetime',
    ];

    // Relasi: Payment milik Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
