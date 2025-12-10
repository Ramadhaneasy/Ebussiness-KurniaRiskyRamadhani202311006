<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'status',
        'payment_method',
        'shipping_address',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    // Relationship: Order belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Order has many OrderItems
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Generate Order Number
    public static function generateOrderNumber()
    {
        $date = date('Ymd');
        $lastOrder = self::whereDate('created_at', today())->latest()->first();
        $number = $lastOrder ? intval(substr($lastOrder->order_number, -4)) + 1 : 1;
        return 'ORD-' . $date . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}