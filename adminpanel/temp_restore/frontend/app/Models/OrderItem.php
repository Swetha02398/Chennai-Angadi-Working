<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'product_productname',
        'variant_name',
        'price',
        'qty',
        'total',
    ];

    // belongs to order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // belongs to product
    public function product()
    {
        return $this->belongsTo(Product::class)->withoutGlobalScope('active-status');
    }

    // belongs to variant
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
} 