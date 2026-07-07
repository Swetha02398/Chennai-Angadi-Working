<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\ChildCategory;
class ProductApiController extends Controller
{
    /**
     * 1️⃣ ALL PRODUCTS
     * GET /api/products
     */
    public function allProducts(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $search = $request->query('search', '');

        $query = Product::with([
            'variants.quantity',
            'maincategory',
            'subcategory',
            'childcategory',
            'specifications'
        ])
        ->where('status', 1);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('productname', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        $products = $query->orderByRaw('CASE WHEN orderby IS NULL OR orderby = "" THEN 1 ELSE 0 END, CAST(NULLIF(orderby, "") AS UNSIGNED) ASC')
            ->orderBy('productname', 'asc')
            ->paginate($perPage)->withQueryString();

        return response()->json([
            'status' => true,
            'total'  => $products->total(),
            'products' => $products
        ], 200);
    }

    /**
     * 2️⃣ SINGLE PRODUCT BY ID
     * GET /api/products/{id}
     */
    public function singleProduct($id)
    {
        $product = Product::with([
            'variants.quantity',
            'maincategory',
            'subcategory',
            'childcategory',
            'specifications'
        ])
        ->where('status', 1)
        ->find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'product' => $product
        ], 200);
    }

    /**
     * 3️⃣ CATEGORY / SUB / CHILD FILTER
     * GET /api/products/filter?category_id=X or subcategory_id=X or childcategory_id=X
     */
    public function productsByCategory(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $query = Product::with([
            'variants.quantity',
            'maincategory',
            'subcategory',
            'childcategory',
            'specifications'
        ])->where('status', 1);

        if ($request->filled('childcategory_id')) {
            $query->where('childcategory_id', $request->childcategory_id);
        }
        elseif ($request->filled('subcategory_id')) {
            $query->where('subcategory_id', $request->subcategory_id);
        }
        elseif ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->orderByRaw('CASE WHEN orderby IS NULL OR orderby = "" THEN 1 ELSE 0 END, CAST(NULLIF(orderby, "") AS UNSIGNED) ASC')
            ->orderBy('productname', 'asc')
            ->paginate($perPage)->withQueryString();

        return response()->json([
            'status' => true,
            'total' => $products->count(),
            'products' => $products
        ]);
    }

    /**
     * 4️⃣ FEATURED PRODUCTS
     * GET /api/products/featured
     */
    public function featuredProducts(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $products = Product::with([
            'variants.quantity',
            'maincategory',
            'subcategory',
            'childcategory',
            'specifications'
        ])
        ->where('status', 1)
        ->where('featured', 1)
        ->orderByRaw('CASE WHEN orderby IS NULL OR orderby = "" THEN 1 ELSE 0 END, CAST(NULLIF(orderby, "") AS UNSIGNED) ASC')
        ->orderBy('productname', 'asc')
        ->paginate($perPage)->withQueryString();

        return response()->json([
            'status' => true,
            'total'  => $products->count(),
            'products' => $products
        ], 200);
    }

    /**
     * 5️⃣ TOP SELLING PRODUCTS
     * GET /api/products/top-selling
     */
    public function topSellingProducts()
    {
        $products = Product::with([
            'variants.quantity',
            'maincategory',
            'subcategory',
            'childcategory',
            'specifications'
        ])
        ->where('status', 1)
        ->where('top_selling', 1)
        ->orderByRaw('CASE WHEN orderby IS NULL OR orderby = "" THEN 1 ELSE 0 END, CAST(NULLIF(orderby, "") AS UNSIGNED) ASC')
        ->orderBy('productname', 'asc')
        ->limit(6)
        ->get();

        return response()->json([
            'status' => true,
            'total'  => $products->count(),
            'products' => $products
        ], 200);
    }

    /**
     * 6️⃣ TRENDING PRODUCTS
     * GET /api/products/trending
     */
    public function trendingProducts()
    {
        $products = Product::with([
            'variants.quantity',
            'maincategory',
            'subcategory',
            'childcategory',
            'specifications'
        ])
        ->where('status', 1)
        ->where('trending_product', 1)
        ->orderByRaw('CASE WHEN orderby IS NULL OR orderby = "" THEN 1 ELSE 0 END, CAST(NULLIF(orderby, "") AS UNSIGNED) ASC')
        ->orderBy('productname', 'asc')
        ->limit(6)
        ->get();

        return response()->json([
            'status' => true,
            'total'  => $products->count(),
            'products' => $products
        ], 200);
    }

    /**
     * 7️⃣ HOT DEAL PRODUCTS
     * GET /api/products/hot-deals
     */
    public function hotDealProducts()
    {
        $products = Product::with([
            'variants.quantity',
            'maincategory',
            'subcategory',
            'childcategory',
            'specifications'
        ])
        ->where('status', 1)
        ->where('hot_deal', 1)
        ->orderByRaw('CASE WHEN orderby IS NULL OR orderby = "" THEN 1 ELSE 0 END, CAST(NULLIF(orderby, "") AS UNSIGNED) ASC')
        ->orderBy('productname', 'asc')
        ->limit(6)
        ->get();

        return response()->json([
            'status' => true,
            'total'  => $products->count(),
            'products' => $products
        ], 200);
    }
}