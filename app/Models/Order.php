<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    // Anda bisa menambahkan properti fillable, casts, atau relationships di sini.
    // Contoh untuk mempermudah:
    protected $fillable = [
        'user_id',
        'total_price',
        'status', // pending, completed, cancelled
    ];

    // Jika Anda ingin mendefinisikan relasi ke User:
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}