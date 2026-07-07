<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'user_type',
        'product_id',
        'quantity',
        'price_at_add_time',
        'taxable',
        'tax_rate',
        'tax_amount',
        'row_total',
        'status',
    ];

    /**
     * Type casting (for booleans & decimals)
     */
    protected $casts = [
        'user_type'   => 'boolean',
        'taxable'     => 'boolean',
        'price_at_add_time' => 'decimal:2',
        'tax_rate'    => 'decimal:2',
        'tax_amount'  => 'decimal:2',
        'row_total'   => 'decimal:2',
    ];

    // ============================
    // 🔗 RELATIONSHIPS
    // ============================

    /**
     * Customer relationship
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Product relationship
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // ============================
    // 💡 ACCESSORS / HELPERS
    // ============================

    /**
     * Calculate tax automatically when taxable
     */
    public function getCalculatedTaxAttribute()
    {
        if ($this->taxable && $this->tax_rate) {
            return ($this->price_at_add_time * $this->quantity * $this->tax_rate) / 100;
        }
        return 0;
    }

    /**
     * Get full row total including tax
     */
    public function getFullRowTotalAttribute()
    {
        return ($this->price_at_add_time * $this->quantity) + $this->calculated_tax;
    }
}
