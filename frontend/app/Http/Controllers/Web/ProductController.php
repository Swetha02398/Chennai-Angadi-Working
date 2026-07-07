<?php

namespace App\Http\Controllers\web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\MainCategory;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $categories = MainCategory::withCount('products')
            ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC')
            ->get();

        return view('index', compact('categories'));
    }

    /**
     * Quick View - Returns product data as JSON for modal
     */
    public function quickView($id)
    {
        try {
            $product = Product::with(['category', 'reviews', 'variants.quantity'])->find($id);

            if (!$product) {
                return response()->json([
                    'error' => true,
                    'message' => 'Product not found'
                ], 404);
            }

            // Calculate average rating
            $avgRating = $product->reviews()->where('approved', 1)->avg('rating') ?? 0;
            $reviewCount = $product->reviews()->where('approved', 1)->count();
            $avgRatingPercent = ($avgRating / 5) * 100;

            // Get first variant for pricing if available
            $firstVariant = $product->variants->first();
            $sellPrice = $firstVariant ? ($firstVariant->sell_price ?? $firstVariant->price) : ($product->sell_price ?? $product->price ?? 0);
            $mrpPrice = $firstVariant ? $firstVariant->price : ($product->price ?? 0);
            $stock = $firstVariant ? ($firstVariant->stock ?? 0) : ($product->stock ?? 0);

            // Calculate discount percentage
            $discountPercent = 0;
            if ($mrpPrice && $sellPrice && $sellPrice < $mrpPrice) {
                $discountPercent = round((($mrpPrice - $sellPrice) / $mrpPrice) * 100);
            }

            // Get image - productimage is cast as array in Product model
            $images = $product->productimage;
            $primaryImage = null;

            // Handle array of images
            if (is_array($images) && count($images) > 0) {
                $primaryImage = $images[0];
            } elseif (is_string($images) && !empty($images)) {
                $primaryImage = $images;
            }

            // Extract just the filename and fix path separators
            $imageName = '';
            if ($primaryImage) {
                $primaryImage = str_replace('\\', '/', $primaryImage);
                // Remove 'uploads/' prefix if present
                if (strpos($primaryImage, 'uploads/') === 0) {
                    $primaryImage = substr($primaryImage, 8);
                }
                $imageName = basename($primaryImage);
            }

            // Construct the full image URL using ADMIN_ASSET_URL
            $adminAssetUrl = env('ADMIN_ASSET_URL', 'http://localhost/chennaiangadi/adminpanel/public/uploads');
            $fullImageUrl = $adminAssetUrl . '/products/' . $imageName;

            // Build variants data for dropdown
            $activeOffer = $product->getActiveOffer();
            $hasProductOffer = $activeOffer !== null;
            $discountType = $hasProductOffer ? $activeOffer->discount_type : null;
            $discountValue = $hasProductOffer ? $activeOffer->discount_value : 0;

            if ($hasProductOffer) {
                $offerPrice = $product->offer_price;
                $offerMrp = $product->offer_mrp;
                $sellPrice = $offerPrice;
                $mrpPrice = $offerMrp;
            }

            $variantsData = [];
            foreach ($product->variants as $variant) {
                $variantMrp = $variant->price ?? 0;
                $variantSellPrice = $variant->sell_price ?? $variant->price;
                $variantOfferPrice = $variantSellPrice;

                if ($hasProductOffer && $variantSellPrice > 0) {
                    if ($discountType === 'percentage') {
                        $discount = ($variantSellPrice * $discountValue) / 100;
                    } else {
                        $discount = $discountValue;
                    }
                    $variantOfferPrice = max(0, round($variantSellPrice - $discount, 2));
                }

                $displayPrice = $hasProductOffer ? $variantOfferPrice : $variantSellPrice;
                $quantityLabel = $variant->quantity->label ?? $variant->quantity->name ?? '';

                $variantsData[] = [
                    'id' => $variant->id,
                    'label' => $quantityLabel,
                    'price' => $hasProductOffer ? $variantSellPrice : $variantMrp,
                    'sell_price' => $variantSellPrice,
                    'offer_price' => $hasProductOffer ? $variantOfferPrice : null,
                    'display_price' => $displayPrice,
                    'has_offer' => $hasProductOffer,
                    'stock' => $variant->stock ?? 0,
                ];
            }

            return response()->json([
                'success' => true,
                'id' => $product->id,
                'name' => $product->productname ?? 'Unknown Product',
                'price' => $sellPrice,
                'old_price' => $mrpPrice,
                'discount_percent' => $discountPercent,
                'image' => asset('uploads/products/' . $imageName),
                'admin_image' => $fullImageUrl,
                'raw_image' => $primaryImage,
                'description' => $product->description ?? $product->short_description ?? '',
                'stock' => $stock,
                'weight' => $product->weight ?? null,
                'avg_rating' => round($avgRating, 1),
                'avg_rating_percent' => $avgRatingPercent,
                'review_count' => $reviewCount,
                'variants' => $variantsData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Error loading product: ' . $e->getMessage()
            ], 500);
        }
    }


    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|digits:10',
            'message' => 'required|string',
        ]);

        try {
            \App\Models\ContactEnquiry::create([
                'name' => $request->name,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'message' => $request->message,
                'status' => 'pending',
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Your message has been sent successfully! We will get back to you soon.'
                ]);
            }

            return redirect()->back()->with('success', 'Your message has been sent successfully! We will get back to you soon.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again later. Error: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong. Please try again later. Error: ' . $e->getMessage());
        }
    }

    public function offer()
    {
        // Get active coupons that haven't expired yet (check both end_date and end_time)
        $coupons = \App\Models\Coupon::where('status', 1)
            ->where(function ($query) {
                $query->where('end_date', '>', now()->toDateString())
                    ->orWhere(function ($q) {
                        // Same day: check if end_time hasn't passed yet
                        $q->where('end_date', '=', now()->toDateString())
                            ->where(function ($timeQ) {
                            $timeQ->whereNull('end_time')
                                ->orWhere('end_time', '>=', now()->format('H:i:s'));
                        });
                    });
            })
            ->orderBy('end_date', 'asc')
            ->get();

        return view('section.offer', compact('coupons'));
    }

    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    public function termsCondition()
    {
        return view('pages.terms-condition');
    }

    public function returnRefund()
    {
        return view('pages.return-refund');
    }

    public function shippingDetails()
    {
        return view('pages.shipping-details');
    }
    public function ordertrack()
    {
        return view('pages.order-track');
    }

    /**
     * Dynamic Search - Search products by name, category, tags, and description
     * Supports partial matching and case-insensitive search
     * SQL injection safe using Laravel's query builder
     * 
     * If exact product name match found or only one product matches,
     * redirects directly to product details page instead of search results
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $categoryId = $request->input('category', '');

        // Sanitize and prepare search term
        $searchTerm = trim($query);

        // If search term is provided, first check for exact product name match
        if (!empty($searchTerm)) {
            // Check for exact match (case-insensitive)
            $exactMatch = Product::whereRaw('LOWER(productname) = ?', [strtolower($searchTerm)])->first();

            if ($exactMatch) {
                // Redirect directly to product details page
                return redirect()->route('product.details', $exactMatch->id);
            }
        }

        // Initialize products query with eager loading
        $productsQuery = Product::with(['category', 'variants.quantity', 'reviews']);

        // Apply search filters if search term is provided
        if (!empty($searchTerm)) {
            $productsQuery->where(function ($q) use ($searchTerm) {
                // Search in product name (partial, case-insensitive)
                $q->where('productname', 'LIKE', '%' . $searchTerm . '%')
                    // Search in short description
                    ->orWhere('short_description', 'LIKE', '%' . $searchTerm . '%')
                    // Search in full description
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                    // Search in SEO keywords (stored as JSON array)
                    ->orWhere('seo_keywords', 'LIKE', '%' . $searchTerm . '%')
                    // Search in SKU
                    ->orWhere('sku', 'LIKE', '%' . $searchTerm . '%')
                    // Search in category name via relationship
                    ->orWhereHas('category', function ($categoryQuery) use ($searchTerm) {
                        $categoryQuery->where('name', 'LIKE', '%' . $searchTerm . '%');
                    })
                    // Search in subcategory name via relationship
                    ->orWhereHas('subcategory', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'LIKE', '%' . $searchTerm . '%');
                    });
            });
        }

        // Filter by specific category if selected
        if (!empty($categoryId)) {
            $productsQuery->where('category_id', $categoryId);
        }

        // Clone query to check total count before pagination
        $totalCount = (clone $productsQuery)->count();

        // If only one product matches, redirect directly to product details
        if ($totalCount === 1 && !empty($searchTerm)) {
            $singleProduct = $productsQuery->first();
            return redirect()->route('product.details', $singleProduct->id);
        }

        // Get paginated results — out-of-stock last
        $products = $productsQuery
            ->orderByRaw('(SELECT MAX(stock) FROM product_variants WHERE product_variants.product_id = products.id) > 0 DESC')
            ->paginate(12);

        // Append query string to pagination links
        $products->appends(['q' => $query, 'category' => $categoryId]);

        // Get all categories for the filter dropdown
        $categories = MainCategory::orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC')
            ->get();

        return view('section.search-results', compact('products', 'query', 'categoryId', 'categories'));
    }

    /**
     * AJAX Search Suggestions - Returns JSON for live search dropdown
     */
    public function searchSuggestions(Request $request)
    {
        $query = trim($request->input('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::with('category')
            ->where(function ($q) use ($query) {
                $q->where('productname', 'LIKE', '%' . $query . '%')
                    ->orWhere('short_description', 'LIKE', '%' . $query . '%')
                    ->orWhereHas('category', function ($catQuery) use ($query) {
                        $catQuery->where('name', 'LIKE', '%' . $query . '%');
                    });
            })
            ->limit(8)
            ->get();

        $suggestions = $products->map(function ($product) {
            // Get first image
            $images = $product->productimage;
            $imageName = '';
            if (is_array($images) && count($images) > 0) {
                $imageName = basename(str_replace('\\', '/', $images[0]));
            } elseif (is_string($images) && !empty($images)) {
                $imageName = basename(str_replace('\\', '/', $images));
            }

            $adminAssetUrl = env('ADMIN_ASSET_URL', 'http://localhost/chennaiangadi/adminpanel/public/uploads');

            return [
                'id' => $product->id,
                'name' => $product->productname,
                'category' => $product->category->name ?? '',
                'image' => $adminAssetUrl . '/products/' . $imageName,
                'url' => route('product.details', $product->id),
            ];
        });

        return response()->json($suggestions);
    }

}