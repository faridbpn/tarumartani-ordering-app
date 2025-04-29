<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'table_number',
        'subtotal',
        'tax',
        'service',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'service' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'items' => 'array',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id')->with('menuItem');
    }    
}