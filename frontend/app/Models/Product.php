<?php

namespace App\Models;
use App\Models\MainCategory;   // ✅ Correct
use App\Models\SubCategory;    // ✅ Correct
use App\Models\ChildCategory;  // ✅ Correct
use App\Models\User;
use App\Models\ProductVariant;
use App\Models\Offer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory;

    /**
     * Boot the model — apply global orderby sorting scope
     * Products with numeric orderby show first (ASC), nulls/zeros at the end
     * Secondary sort by id ASC for stable ordering
     */
    protected static function booted()
    {
        static::addGlobalScope('orderby-sort', function (Builder $builder) {
            $builder->orderByRaw('CASE WHEN orderby IS NULL OR orderby = 0 THEN 1 ELSE 0 END ASC, orderby ASC, id ASC');
        });

        static::addGlobalScope('active-status', function (Builder $builder) {
            $builder->where('status', 1);
        });
    }

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'childcategory_id',
        'productname',
        'slug',
        'sku',
        'hsn',
        'gst',
        'sgst',
        'igst',
        'short_description',
        'description',
        'featured',
        'status',
        'productimage',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'orderby',
        'top_selling',
        'trending_product',
        'hot_deal'
    ];

    protected $casts = [
        'productimage' => 'array',
        'seo_keywords' => 'array',
        'gst' => 'float',
        'sgst' => 'float',
        'igst' => 'float',
    ];

    // ============================
    // 🔗 RELATIONSHIPS
    // ============================

    // Admin (User)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Main Category
    public function maincategory()
    {
        return $this->belongsTo(MainCategory::class, 'category_id');
    }

    // Sub Category relationship
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    // Child Category relationship
    public function childcategory()
    {
        return $this->belongsTo(ChildCategory::class, 'childcategory_id');
    }
    // ============================
    // 📸 IMAGE PATH ACCESSOR
    // ============================

    public function getImageUrlAttribute()
    {
        if ($this->productimage) {
            return asset('uploads/products/' . $this->productimage);
        }

        return asset('default/no-image.png');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(MainCategory::class, 'category_id');
    }

    public function sizes()
    {
        return $this->hasMany(Product::class, 'product_id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get all variants (weight/price combinations) for this product
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    /**
     * Check if this product has variants (is a variable product)
     */
    public function isVariableProduct()
    {
        return $this->variants()->exists();
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

    /**
     * Check if this product is simple (no variants)
     */
    public function isSimpleProduct()
    {
        return !$this->isVariableProduct();
    }

    /**
     * Get the default variant (first one) for variable products
     */
    public function getDefaultVariant()
    {
        return $this->variants()->with('quantity')->first();
    }

    /**
     * Get all variants with their quantities loaded
     */
    public function getVariantsWithQuantities()
    {
        return $this->variants()->with('quantity')->orderBy('price', 'asc')->get();
    }

    /**
     * Get active offer for this product (if any)
     */
    public function getActiveOffer()
    {
        return Offer::active()
            ->get()
            ->first(function ($offer) {
                // product_ids is already cast to array by Offer model
                $productIds = $offer->product_ids;

                if (!is_array($productIds) || empty($productIds)) {
                    return false;
                }

                // Check if this product's ID is in the offer's product_ids
                // Use loose comparison since DB might store as strings
                return in_array($this->id, $productIds) || in_array((string) $this->id, $productIds);
            });
    }

    public function getOfferPriceAttribute()
    {
        $offer = $this->getActiveOffer();
        if (!$offer)
            return null;

        // Get Selling Price (sell_price) from first variant - this is the base for discount calculation
        $firstVariant = $this->variants->first();
        $sellPrice = $firstVariant 
            ? ($firstVariant->sell_price ?? $firstVariant->price ?? 0)
            : ($this->sell_price ?? $this->price ?? 0);

        if ($offer->discount_type === 'percentage') {
            $discount = ($sellPrice * $offer->discount_value) / 100;
        } else { // fixed
            $discount = $offer->discount_value;
        }

        return max(0, round($sellPrice - $discount, 2));
    }

    /**
     * Get MRP (original price) for products with offers - used for strike-through
     * Returns null if no active offer
     */
    public function getOfferMrpAttribute()
    {
        $offer = $this->getActiveOffer();
        if (!$offer)
            return null;

        // Get Selling Price (sell_price) from first variant - this is crossed out when offer is active
        $firstVariant = $this->variants->first();
        return $firstVariant 
            ? ($firstVariant->sell_price ?? $firstVariant->price ?? 0)
            : ($this->sell_price ?? $this->price ?? 0);
    }

    /**
     * Get offer name/title for display
     * Returns null if no active offer
     */
    public function getOfferNameAttribute()
    {
        $offer = $this->getActiveOffer();
        return $offer ? $offer->title : null;
    }

    /**
     * Check if product has an active offer
     */
    public function getHasOfferAttribute()
    {
        return $this->getActiveOffer() !== null;
    }

}
