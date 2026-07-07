<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Mdels\customer;

class CategoryController extends Controller
{
    public function ajaxList()
    {
        // Category name + image + product count fetch pannrom
        $categories = MainCategory::withCount('products')
            ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC')
            ->get();

        // Section view ku pass pannrom
        return view('section.Category', compact('categories'));
    }


    // index category
    public function byCategory($id)
    {
        $category = MainCategory::findOrFail($id);

        // Assuming product table has category_id
        $products = Product::with('variants.quantity')->where('category_id', $id)->get();

        return view('category.category-show', compact('category', 'products'));
    }
    // category products
    public function products($id)
    {
        $category = MainCategory::with('subcategories')->findOrFail($id);

        $categories = MainCategory::withCount('products')
            ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC')
            ->get();

        // Build query with rating average
        $query = Product::with('variants.quantity')->withAvg([
            'reviews' => function ($q) {
                $q->where('approved', 1);
            }
        ], 'rating')->where('category_id', $category->id);

        // Handle sorting based on query parameter
        switch (request('sort')) {
            case 'low':
                $query->reorder()->orderBy(
                    \App\Models\ProductVariant::select('sell_price')
                        ->whereColumn('product_id', 'products.id')
                        ->orderBy('sell_price', 'asc')
                        ->limit(1),
                    'asc'
                );
                break;
            case 'high':
                $query->reorder()->orderBy(
                    \App\Models\ProductVariant::select('sell_price')
                        ->whereColumn('product_id', 'products.id')
                        ->orderBy('sell_price', 'desc')
                        ->limit(1),
                    'desc'
                );
                break;
            case 'featured':
            default:
                // Global scope handles orderby sorting
                break;
        }

        // Paginate and preserve query parameters — out-of-stock last
        if (!request('sort') || request('sort') === 'featured') {
            $query->orderByRaw('(SELECT MAX(stock) FROM product_variants WHERE product_variants.product_id = products.id) > 0 DESC');
        }
        $products = $query->paginate(12)->appends(request()->query());

        $wishlistProductIds = [];
        if (Auth::guard('customer')->check()) {
            $wishlistProductIds = Wishlist::where('customer_id', Auth::guard('customer')->id())
                ->pluck('product_id')
                ->toArray();
        } else {
            // Guest user - get from session
            $wishlistProductIds = session()->get('guest_wishlist', []);
        }
        return view('category.category-show', compact('category', 'products', 'categories', 'wishlistProductIds'));
    }

    public function categoryProducts($id)
    {
        $category = Category::with('subcategories')->findOrFail($id);


        $categories = MainCategory::withCount('products')
            ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC')
            ->get();

        // 1) How many products per page?
        $perPage = request('per_page') ?? 50; // default 50

        // 2) Base query
        $query = Product::with('variants.quantity')->withAvg([
            'reviews' => function ($q) {
                $q->where('approved', 1);
            }
        ], 'rating')->where('category_id', $id);


        // 3) Sorting logic
        switch (request('sort')) {
            case 'low_high':
                $query->reorder()->orderBy(
                    \App\Models\ProductVariant::select('sell_price')
                        ->whereColumn('product_id', 'products.id')
                        ->orderBy('sell_price', 'asc')
                        ->limit(1),
                    'asc'
                );
                break;

            case 'high_low':
                $query->reorder()->orderBy(
                    \App\Models\ProductVariant::select('sell_price')
                        ->whereColumn('product_id', 'products.id')
                        ->orderBy('sell_price', 'desc')
                        ->limit(1),
                    'desc'
                );
                break;

            case 'rating':
                $query->reorder()->orderBy('reviews_avg_rating', 'desc');
                break;

            case 'featured':
            default:
                // Global scope handles orderby sorting
                break;
        }

        // 4) Pagination or all
        if ($perPage == 'all') {
            $products = $query->get();
        } else {
            $products = $query->paginate($perPage)->appends(request()->query());
        }

        return view('category.category-show', compact('category', 'products'));
    }

    // category subcategory products
    public function subcategoryProducts($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $category = $subcategory->mainCategory;

        $categories = MainCategory::withCount('products')
            ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC')
            ->get();

        $perPage = request('per_page') ?? 50;

        $query = Product::with('variants.quantity')->withAvg([
            'reviews' => function ($q) {
                $q->where('approved', 1);
            }
        ], 'rating')->where('subcategory_id', $id);


        switch (request('sort')) {
            case 'low_high':
                $query->reorder()->orderBy(
                    \App\Models\ProductVariant::select('sell_price')
                        ->whereColumn('product_id', 'products.id')
                        ->orderBy('sell_price', 'asc')
                        ->limit(1),
                    'asc'
                );
                break;
            case 'high_low':
                $query->reorder()->orderBy(
                    \App\Models\ProductVariant::select('sell_price')
                        ->whereColumn('product_id', 'products.id')
                        ->orderBy('sell_price', 'desc')
                        ->limit(1),
                    'desc'
                );
                break;
            case 'rating':
                $query->reorder()->orderBy('reviews_avg_rating', 'desc');
                break;

            default:
                // Global scope handles orderby sorting
                break;
        }

        if (!request('sort')) {
            $query->orderByRaw('(SELECT MAX(stock) FROM product_variants WHERE product_variants.product_id = products.id) > 0 DESC');
        }
        $products = ($perPage == 'all') ? $query->get() : $query->paginate($perPage)->appends(request()->query());

        $wishlistProductIds = [];
        if (Auth::guard('customer')->check()) {
            $wishlistProductIds = Wishlist::where('customer_id', Auth::guard('customer')->id())
                ->pluck('product_id')
                ->toArray();
        } else {
            // Guest user - get from session
            $wishlistProductIds = session()->get('guest_wishlist', []);
        }

        return view('category.category-show', compact('category', 'subcategory', 'products', 'categories', 'wishlistProductIds'));
    }


    // child category products
    public function childcategoryProducts($id)
    {
        $childcategory = ChildCategory::findOrFail($id);
        $subcategory = $childcategory->subCategory;
        $category = $subcategory->mainCategory;

        $categories = MainCategory::withCount('products')
            ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC')
            ->get();

        $perPage = request('per_page') ?? 50;

        $query = Product::with('variants.quantity')->withAvg([
            'reviews' => function ($q) {
                $q->where('approved', 1);
            }
        ], 'rating')->where('childcategory_id', $id);

        switch (request('sort')) {
            case 'low_high':
                $query->reorder()->orderBy(
                    \App\Models\ProductVariant::select('sell_price')
                        ->whereColumn('product_id', 'products.id')
                        ->orderBy('sell_price', 'asc')
                        ->limit(1),
                    'asc'
                );
                break;
            case 'high_low':
                $query->reorder()->orderBy(
                    \App\Models\ProductVariant::select('sell_price')
                        ->whereColumn('product_id', 'products.id')
                        ->orderBy('sell_price', 'desc')
                        ->limit(1),
                    'desc'
                );
                break;
            case 'rating':
                $query->reorder()->orderBy('reviews_avg_rating', 'desc');
                break;
            default:
                break;
        }

        if (!request('sort')) {
            $query->orderByRaw('(SELECT MAX(stock) FROM product_variants WHERE product_variants.product_id = products.id) > 0 DESC');
        }
        $products = ($perPage == 'all') ? $query->get() : $query->paginate($perPage)->appends(request()->query());

        $wishlistProductIds = [];
        if (Auth::guard('customer')->check()) {
            $wishlistProductIds = Wishlist::where('customer_id', Auth::guard('customer')->id())
                ->pluck('product_id')
                ->toArray();
        } else {
            $wishlistProductIds = session()->get('guest_wishlist', []);
        }

        return view('category.category-show', compact('category', 'subcategory', 'products', 'categories', 'wishlistProductIds'));
    }

}
