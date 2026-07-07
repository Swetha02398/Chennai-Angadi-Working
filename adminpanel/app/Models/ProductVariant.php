<?php
namespace App\Models;
use App\Models\Product;
use App\Models\Quantity;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ProductVariant extends Model
{
    protected $fillable = [
        'product_id','quantity_id','price','sell_price','stock','stock_status',
        'stock_updated_by', 'stock_updated_at'
    ];

    protected $appends = [
        'has_offer',
        'offer_price',
        'offer_mrp',
    ];

    public function quantity()
    {
        return $this->belongsTo(Quantity::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stockUpdater()
    {
        return $this->belongsTo(User::class, 'stock_updated_by');
    }

    public function getActiveOffer()
    {
        // Avoid accessing $this->product directly to prevent infinite JSON serialization loop
        $productId = $this->product_id;
        if (!$productId) {
            return null;
        }

        return Offer::active()
            ->get()
            ->first(function ($offer) use ($productId) {
                $productIds = $offer->product_ids;

                if (!is_array($productIds) || empty($productIds)) {
                    return false;
                }

                return in_array($productId, $productIds) || in_array((string) $productId, $productIds);
            });
    }

    public function getHasOfferAttribute()
    {
        return $this->getActiveOffer() !== null;
    }

    public function getOfferPriceAttribute()
    {
        $offer = $this->getActiveOffer();
        if (!$offer) {
            return null;
        }

        $sellPrice = $this->sell_price ?? $this->price ?? 0;

        if ($offer->discount_type === 'percentage') {
            $discount = ($sellPrice * $offer->discount_value) / 100;
        } else {
            $discount = $offer->discount_value;
        }

        return max(0, round($sellPrice - $discount, 2));
    }

    public function getOfferMrpAttribute()
    {
        $offer = $this->getActiveOffer();
        if (!$offer) {
            return null;
        }

        return $this->sell_price ?? $this->price ?? 0;
    }
}
