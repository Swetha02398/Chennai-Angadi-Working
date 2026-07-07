<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
    ];

    // 🔗 Relationship: Wishlist → Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // 🔗 Relationship: Wishlist → Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
