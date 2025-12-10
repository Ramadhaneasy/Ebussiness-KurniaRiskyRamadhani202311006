<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relationship: Cart belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Cart belongs to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper: Get subtotal
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->product->price;
    }
}