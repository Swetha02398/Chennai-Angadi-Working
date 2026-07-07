<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxCalculation extends Model
{
    use HasFactory;
     // =============================
    // 💾 Table Fillable Fields
    // =============================
    protected $fillable = [
        'order_id',
        'cart_id',
        'item_id',
        'hsn_code',
        'taxable_value',
        'gst_rate',
        'cgst_amount',
        'sgst_amount',
        'igst_amount',
        'total_tax',
        'gst_type',
        'calculation_source',
    ];

    // =============================
    // 🧮 Type Casting
    // =============================
    protected $casts = [
        'taxable_value' => 'decimal:2',
        'gst_rate' => 'decimal:2',
        'cgst_amount' => 'decimal:2',
        'sgst_amount' => 'decimal:2',
        'igst_amount' => 'decimal:2',
        'total_tax' => 'decimal:2',
    ];

    // =============================
    // 🔗 RELATIONSHIPS
    // =============================

    /**
     * Link to Cart Item
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    /**
     * Link to Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Link to Product (if you want per item tracking)
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }

    // =============================
    // 💡 HELPER FUNCTIONS
    // =============================

    /**
     * Auto-calculate total tax
     */
    public function getComputedTotalTaxAttribute()
    {
        return ($this->cgst_amount ?? 0) + ($this->sgst_amount ?? 0) + ($this->igst_amount ?? 0);
    }

    /**
     * Define type label (for UI/report)
     */
    public function getGstTypeLabelAttribute()
    {
        return $this->gst_type === 'igst' ? 'Inter-State (IGST)' : 'Intra-State (CGST + SGST)';
    }
}