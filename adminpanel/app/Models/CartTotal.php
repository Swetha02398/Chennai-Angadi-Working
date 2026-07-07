<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartTotal extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'subtotal', 'tax', 'shipping',
        'discount', 'total', 'coupon_code', 'coupon_id', 'items_count', 'currency'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}
