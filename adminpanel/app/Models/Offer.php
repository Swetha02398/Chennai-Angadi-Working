<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

     protected $fillable = [
        'title',
        'description',
        'banner_image',
        'product_ids',
        'category_ids',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'priority',
        'status'
    ];

    protected $casts = [
        'product_ids' => 'array',
        'category_ids' => 'array',
        'status' => 'boolean',
    ];

    // ============================
    // 🔗 RELATIONSHIPS (Optional)
    // ============================

    // Category (main category)
    public function categories()
    {
        // since we store multiple category IDs, relationship handled manually in controller
        return $this->belongsTo(MainCategory::class, 'category_ids');
    }

    // Product relationship (manual link via product_ids)
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_ids');
    }

    // Scope for active offers
    public function scopeActive($query)
    {
        return $query->where('status', 1)
                     ->whereDate('start_date', '<=', now())
                     ->whereDate('end_date', '>=', now());
    }
}
