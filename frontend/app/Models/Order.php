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
        'razorpay_signature',
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
        'coupon_code',
        'tax_amount',
        'shipping_amount',
        'cod_charge',
        'total_amount',
        'final_amount',
        'status',
        'placed_at',
        'delivered_at',
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

    // Order belongs to a registered customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Order has many items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}