<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class OurProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = MainCategory::withCount('products')
            ->where('status', 'active')
            ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC')
            ->get();

        // MAIN LIST
        $products = Product::with(['category', 'variants.quantity'])
            ->withAvg([
                'reviews' => function ($q) {
                    $q->where('approved', true);
                }
            ], 'rating')
            ->where('status', 1)
            ->orderByRaw('(SELECT MAX(stock) FROM product_variants WHERE product_variants.product_id = products.id) > 0 DESC')
            ->paginate(20);

        if ($request->ajax()) {
            return view('section.products', compact('products'))->render();
        }

        // TOP SELLING PRODUCTS (where top_selling = 1)
        $topSellingProducts = Product::with(['category', 'variants.quantity'])
            ->withAvg([
                'reviews' => function ($q) {
                    $q->where('approved', true);
                }
            ], 'rating')
            ->where('status', 1)
            ->where('top_selling', 1)
            ->take(3)
            ->get();

        // TRENDING PRODUCTS (where trending_product = 1)
        $trendingProducts = Product::with(['category', 'variants.quantity'])
            ->withAvg([
                'reviews' => function ($q) {
                    $q->where('approved', true);
                }
            ], 'rating')
            ->where('status', 1)
            ->where('trending_product', 1)
            ->take(3)
            ->get();

        // RECENTLY ADDED PRODUCTS (latest created)
        $recentlyAddedProducts = Product::with(['category', 'variants.quantity'])
            ->withAvg([
                'reviews' => function ($q) {
                    $q->where('approved', true);
                }
            ], 'rating')
            ->where('status', 1)
            ->latest()
            ->take(3)
            ->get();

        // HOT DEAL PRODUCTS (where hot_deal = 1)
        $hotDealProducts = Product::with(['category', 'variants.quantity'])
            ->withAvg([
                'reviews' => function ($q) {
                    $q->where('approved', true);
                }
            ], 'rating')
            ->where('status', 1)
            ->where('hot_deal', 1)
            ->take(10)
            ->get();


        // FETCH DYNAMIC SLIDERS
        $topSliders = \App\Models\Slider::where('slider_position', 'top')
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->get();

        $middleSliders = \App\Models\Slider::where('slider_position', 'middle')
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->take(3)
            ->get();

        $bottomSlider = \App\Models\Slider::where('slider_position', 'bottom')
            ->where('status', 1)
            ->first();

        return response()
            ->view('index', compact(
                'categories', 
                'products', 
                'topSellingProducts', 
                'trendingProducts', 
                'recentlyAddedProducts', 
                'hotDealProducts',
                'topSliders',
                'middleSliders',
                'bottomSlider'
            ))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }




    public function categoryFilterAjax($categorySlug = null)
    {
        try {

            $query = Product::with(['category', 'variants.quantity'])
                ->withCount([
                    'reviews' => function ($q) {
                        $q->where('approved', true);
                    }
                ])
                ->withAvg([
                    'reviews' => function ($q) {
                        $q->where('approved', true);
                    }
                ], 'rating')
                ->where('status', 1);

            // Category filter
            if (!empty($categorySlug) && $categorySlug !== 'all') {

                $category = MainCategory::where('slug', $categorySlug)
                    ->where('status', 'active')
                    ->first();

                if (!$category) {
                    return view('section.products', ['products' => collect()])->render();
                }

                $query->where('category_id', $category->id);
            }

            // Sort by rating, then out-of-stock last
            $products = $query
                ->orderByRaw('(SELECT MAX(stock) FROM product_variants WHERE product_variants.product_id = products.id) > 0 DESC')
                ->orderByRaw("COALESCE(reviews_avg_rating, 0) DESC")
                ->paginate(20);

            return view('section.products', compact('products'))->render();

        } catch (\Exception $e) {
            \Log::error('Filter products error: ' . $e->getMessage());
            return view('section.products', ['products' => collect()])->render();
        }
    }




    public function view($id)
    {
        $product = Product::with(['category', 'variants.quantity', 'specifications'])->findOrFail($id);

        $categories = MainCategory::withCount('products')
            ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC')
            ->get();

        $relatedProducts = Product::with(['reviews', 'variants.quantity'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 1)
            ->orderByRaw('(SELECT MAX(stock) FROM product_variants WHERE product_variants.product_id = products.id) > 0 DESC')
            ->take(8)
            ->get();

        // Approved reviews only
        $reviews = Review::where('product_id', $product->id)
            ->where('approved', true)
            ->orderBy('created_at', 'DESC')
            ->get();

        // Review count
        $reviewCount = $product->reviews()
            ->where('approved', true)
            ->count();

        // Total reviews
        $totalReviews = $reviews->count();

        // Average rating
        $avgRating = $totalReviews ? round($reviews->avg('rating'), 1) : 0;
        $avgRatingPercent = ($avgRating / 5) * 100;

        // Star breakdown
        $starCounts = [];
        for ($i = 1; $i <= 5; $i++) {
            $starCounts[$i] = $totalReviews
                ? ($reviews->where('rating', $i)->count() / $totalReviews) * 100
                : 0;
        }

        // ========================================
        // PRODUCT VARIANTS (Weight/Price Options)
        // ========================================
        $productVariants = $product->getVariantsWithQuantities();
        $isVariableProduct = $productVariants->count() > 0;

        // Determine base price (sell_price = current price, price = MRP)
        if ($isVariableProduct) {
            $defaultVariant = $productVariants->first();
            $basePrice = $defaultVariant->sell_price ?? $defaultVariant->price ?? $product->price;
            $baseMrpPrice = $defaultVariant->price ?? null; // price is MRP in database
        } else {
            $basePrice = $product->sell_price ?? $product->price;
            $baseMrpPrice = $product->price;
        }

        // ========================================
        // CHECK FOR ACTIVE OFFER
        // ========================================
        $activeOffer = $product->getActiveOffer();
        $offerPrice = $product->offer_price;
        if ($offerPrice !== null) {
            // Product has an offer - show offer price as main, MRP as strike-through
            $displayPrice = $offerPrice;
            $displayMrpPrice = $product->offer_mrp;
        } else {
            // No offer - show sell_price as main, mrp_price as strike-through (if higher)
            $displayPrice = $basePrice;
            $displayMrpPrice = ($baseMrpPrice && $baseMrpPrice > $basePrice) ? $baseMrpPrice : null;
        }

        return view('section.productdetails', compact(
            'product',
            'categories',
            'relatedProducts',
            'reviews',
            'reviewCount',
            'totalReviews',
            'avgRating',
            'starCounts',
            'productVariants',
            'isVariableProduct',
            'displayPrice',
            'displayMrpPrice',
            'activeOffer'
        ));
    }




    public function shop(Request $request)
    {
        $sort = $request->sort;

        $query = Product::with(['category', 'variants.quantity'])
            ->withAvg([
                'reviews' => function ($q) {
                    $q->where('approved', true);
                }
            ], 'rating')
            ->where('status', 1);

        // Sorting logic
        if ($sort === 'featured') {
            $query->where('featured', 1);
        }

        if ($sort === 'low') {
            $query->orderByRaw(
                '(SELECT MIN(sell_price) FROM product_variants WHERE product_variants.product_id = products.id) ASC'
            );
        }

        if ($sort === 'high') {
            $query->orderByRaw(
                '(SELECT MIN(sell_price) FROM product_variants WHERE product_variants.product_id = products.id) DESC'
            );
        }

        // Fetch products — out-of-stock last
        $products = $query
            ->orderByRaw('(SELECT MAX(stock) FROM product_variants WHERE product_variants.product_id = products.id) > 0 DESC')
            ->paginate(50)->withQueryString();

        // Count total
        $totalProducts = Product::where('status', 1)->count();

        return view('section.shop', compact('products', 'totalProducts'));
    }
}
