<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryApiController extends Controller
{

    // ✅ Get all main categories
    public function getMainCategory(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $mainCategory = MainCategory::where('status', 'active')
            ->select('id', 'name', 'slug', 'image', 'orderby')
            ->orderByRaw('CASE WHEN orderby IS NULL OR orderby = "" THEN 1 ELSE 0 END, CAST(NULLIF(orderby, "") AS UNSIGNED) ASC')
            ->orderBy('name', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        return response()->json($mainCategory);
    }


    // ✅ Get subcategories by main category id
    public function getSubCategory(Request $request, $main_id)
    {
        $perPage = $request->query('per_page', 10);
        $subCategory = SubCategory::where('main_category_id', $main_id)
            ->where('status', 'active')
            ->select('id', 'name', 'slug', 'main_category_id', 'subimage', 'orderby')
            ->orderByRaw('CASE WHEN orderby IS NULL OR orderby = "" THEN 1 ELSE 0 END, CAST(NULLIF(orderby, "") AS UNSIGNED) ASC')
            ->orderBy('name', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        return response()->json($subCategory);
    }

    // ✅ Get child categories filtered by both main_id and sub_id
    public function getChildCategory(Request $request, $main_id, $sub_id)
    {
        $perPage = $request->query('per_page', 10);
        $childCategory = ChildCategory::where('sub_category_id', $sub_id)
            ->whereHas('subCategory', function ($q) use ($main_id) {
                $q->where('main_category_id', $main_id);
            })
            ->where('status', 'active')
            ->select('id', 'name', 'slug', 'sub_category_id', 'childimage', 'orderby')
            ->orderByRaw('CASE WHEN orderby IS NULL OR orderby = "" THEN 1 ELSE 0 END, CAST(NULLIF(orderby, "") AS UNSIGNED) ASC')
            ->orderBy('name', 'asc')
            ->paginate($perPage)
            ->appends($request->query());

        return response()->json($childCategory);
    }

    public function getCategoryProducts(Request $request)
    {
         $perPage = $request->query('per_page', 10);
        // 1️⃣ CHILD CATEGORY FILTER
        if ($request->has('child_category_id') && $request->child_category_id != '') {

            $products = Product::with(['variants.quantity', 'maincategory', 'subcategory', 'childcategory', 'specifications'])
                ->where('childcategory_id', $request->child_category_id)
                ->orderByRaw('CASE WHEN orderby IS NULL OR orderby = "" THEN 1 ELSE 0 END, CAST(NULLIF(orderby, "") AS UNSIGNED) ASC')
                ->orderBy('productname', 'asc')
                ->paginate($perPage)->appends($request->query());

            return response()->json([
                'status' => true,
                'filter' => 'child_category',
                'total'  => $products->total(),
                'products' => $products
            ]);
        }

        // 2️⃣ SUB CATEGORY FILTER
        if ($request->has('subcategory_id') && $request->subcategory_id != '') {

            $products = Product::with(['variants.quantity', 'maincategory', 'subcategory', 'childcategory', 'specifications'])
                ->where('subcategory_id', $request->subcategory_id)
                ->orderByRaw('CASE WHEN orderby IS NULL OR orderby = "" THEN 1 ELSE 0 END, CAST(NULLIF(orderby, "") AS UNSIGNED) ASC')
                ->orderBy('productname', 'asc')
                ->paginate($perPage)->appends($request->query());

            return response()->json([
                'status' => true,
                'filter' => 'subcategory',
                'total'  => $products->total(),
                'products' => $products
            ]);
        }

        // 3️⃣ MAIN CATEGORY FILTER
        if ($request->has('main_category_id') && $request->main_category_id != '') {

            $products = Product::with(['variants.quantity', 'maincategory', 'subcategory', 'childcategory', 'specifications'])
                ->where('category_id', $request->main_category_id)
                ->orderByRaw('CASE WHEN orderby IS NULL OR orderby = "" THEN 1 ELSE 0 END, CAST(NULLIF(orderby, "") AS UNSIGNED) ASC')
                ->orderBy('productname', 'asc')
                ->paginate($perPage)->appends($request->query());
            return response()->json([
                'status' => true,
                'filter' => 'main_category',
                'total'  => $products->total(),
                'products' => $products
            ]);
        }

        // 4️⃣ No filter → error response
        return response()->json([
            'status' => false,
            'message' => 'Send main_category_id OR subcategory_id OR child_category_id'
        ]);
    }

}
