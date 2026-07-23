<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'razorpay_order_id',
        'razorpay_payment_id',
        'order_type',
        'order_source',
        'customer_type',
        'customer_id',
        'guest_details',
        'shipping_address',
        'billing_address',
        'billing_type',
        'payment_method',
        'payment_provider',
        'payment_status',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'shipping_amount',
        'cod_charge',
        'total_amount',
        'final_amount',
        'status',
        'placed_at',
        'delivered_at',
        'coupon_code',
        'created_by_type',
        'created_by_id',
        'notes',
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'guest_details' => 'array',
        'placed_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // Default attribute values
    protected $attributes = [
        'status' => 'hold',
    ];

    // Order belongs to a registered customer (from customers table)
    public function customer()
    {
        return $this->belongsTo(\App\Models\Customer::class, 'customer_id');
    }

    // Order has many items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Order has many history entries (tracking timeline)
    public function histories()
    {
        return $this->hasMany(OrderHistory::class)->orderBy('created_at', 'asc');
    }
}
