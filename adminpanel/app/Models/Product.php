<?php
namespace App\Models;
use App\Models\MainCategory;   // ✅ Correct
use App\Models\SubCategory;    // ✅ Correct
use App\Models\ChildCategory;  // ✅ Correct
use App\Models\User;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;

class Product extends Model
{
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
        // 'price' => 'float',
        'gst' => 'float',
        'sgst' => 'float',
        'igst' => 'float',
    ];

    protected $appends = [
        'has_offer',
        'offer_price',
        'offer_mrp',
        'offer_name',
        'sell_price',
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function latestStockUpdate()
    {
        return $this->hasOne(ProductVariant::class)->latestOfMany('stock_updated_at');
    }


    // ============================
    // 🔗 RELATIONSHIPS
    // ============================

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

    public function getFirstImageAttribute()
    {
        if (is_array($this->productimage) && count($this->productimage) > 0) {
            return $this->productimage[array_key_first($this->productimage)];
        }

        return null;
    }

    public function getSellPriceAttribute()
    {
        if ($this->variants && count($this->variants) > 0) {
            return $this->variants[0]->sell_price ?? 0;
        }

        return 0;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

    // App\Models\Product.php
    public static function lowStockCount()
    {
        return self::where('stock', '<', 10)->count();
    }

    /**
     * Get active offer for this product (if any)
     */
    public function getActiveOffer()
    {
        return Offer::active()
            ->get()
            ->first(function ($offer) {
                $productIds = $offer->product_ids;

                if (!is_array($productIds) || empty($productIds)) {
                    return false;
                }

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