<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Offer;

class OfferProductController extends Controller
{
    public function section()
    {
        $offers = Offer::where('status', 1)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->orderBy('priority', 'asc')
            ->get();

        $offerProducts = [];

        foreach ($offers as $offer) {

            $offerProducts[$offer->id] = collect();

            if ($offer->product_ids) {

                // Decode JSON safely
                $productIds = is_string($offer->product_ids)
                    ? json_decode($offer->product_ids, true)
                    : $offer->product_ids;

                if (is_array($productIds) && count($productIds) > 0) {

                    $products = Product::with('variants.quantity')->withAvg([
                        'reviews' => function ($q) {
                            $q->where('approved', 1);
                        }
                    ], 'rating')->whereIn('id', $productIds)->get();


                    foreach ($products as $product) {

                        // Get MRP (price) from first variant - this is the strike-through price
                        $firstVariant = $product->variants->first();
                        if ($firstVariant && $firstVariant->price) {
                            // Use variant's price (MRP) as base for offer calculation
                            $mrpPrice = $firstVariant->price;
                        } else {
                            // Fallback to product-level price
                            $mrpPrice = $product->price ?: 0;
                        }

                        // Discount calculation based on MRP (price)
                        if ($offer->discount_type === 'percentage') {
                            $discountAmount = ($mrpPrice * $offer->discount_value) / 100;
                        } elseif ($offer->discount_type === 'fixed') {
                            $discountAmount = $offer->discount_value;
                        } else {
                            $discountAmount = 0;
                        }

                        // Final price = MRP - discount (should never go below zero)
                        $finalPrice = max(0, $mrpPrice - $discountAmount);

                        // Attach dynamic values
                        // original_price = MRP (price from variant) - to be struck through
                        // final_price = calculated offer price - main display price
                        $product->original_price = $mrpPrice;
                        $product->discountAmount = round($discountAmount, 2);
                        $product->final_price = round($finalPrice, 2);

                        $offerProducts[$offer->id][] = $product;
                    }
                }
            }
        }


        $wishlistProductIds = [];
        if (Auth::guard('customer')->check()) {
            $wishlistProductIds = Wishlist::where('customer_id', Auth::guard('customer')->id())
                ->pluck('product_id')
                ->toArray();
        } else {
            // Guest user - get from session
            $wishlistProductIds = session()->get('guest_wishlist', []);
        }

        // Return only the section view (AJAX)
        return view('section.offered-products', compact('offers', 'offerProducts', 'wishlistProductIds'));
    }
}
