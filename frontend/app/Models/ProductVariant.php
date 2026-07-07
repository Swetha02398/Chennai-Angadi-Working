<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'quantity_id',
        'price',
        'sell_price',
        'mrp_price',
        'stock',
        'status',
    ];

    protected $casts = [
        'price' => 'float',
        'sell_price' => 'float',
        'mrp_price' => 'float',
        'stock' => 'integer',
    ];

    /**
     * Get the product that owns this variant
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the quantity (weight) for this variant
     */
    public function quantity()
    {
        return $this->belongsTo(Quantity::class, 'quantity_id');
    }
}
