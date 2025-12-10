<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'stock',
        'description',
        'image'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    // Relationship: Product has many Carts
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // Relationship: Product has many OrderItems
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}