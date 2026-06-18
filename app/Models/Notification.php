<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    // Field yang bisa diisi mass assignment
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
    ];

    // Casting tipe data
    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Relasi: Notification milik User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
