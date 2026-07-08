<?php
namespace App\Http\Controllers\Web\Product;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\ProductVariant;
use App\Models\Quantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Helpers\NotificationHelper;
use App\Models\Order;
use App\Models\ProductSpecification;
use Illuminate\Validation\Rule;
class ProductController extends Controller
{
    public function index()
    {
        // Fetch real statistics (Count BOTH billing and frontend orders for today)
        $todayOrderCount = Order::whereIn('order_type', ['billing', 'frontend'])
            ->whereDate('created_at', now()->toDateString())
            ->count();
            
        $totalProductCount = Product::count();

        // Total ALL orders (for accurate count display on dashboard)
        $totalOrderCount = Order::whereIn('order_type', ['billing', 'frontend'])->count();

        // Fetch recent orders (BOTH billing and frontend)
        $recentOrders = Order::whereIn('order_type', ['billing', 'frontend'])
            ->with(['customer'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Fetch main categories for filter dropdown
        $mainCategories = MainCategory::where('status', 'active')->get();

        return view('index', compact('recentOrders', 'mainCategories', 'todayOrderCount', 'totalProductCount', 'totalOrderCount'));
    }

    /**
     * AJAX method to filter dashboard orders
     */
    public function filterOrders(Request $request)
    {
        $query = Order::whereIn('order_type', ['billing', 'frontend'])
            ->with(['customer', 'items.product']);

        // Category filter - filter by products in the order that belong to this category
        if ($request->filled('category_id')) {
            $categoryId = $request->category_id;
            $query->whereHas('items.product', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        // Date filter
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Status filter (payment status - Paid/COD/Not Paid)
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'cod') {
                $query->whereIn('payment_method', ['cash_on_delivery', 'cod']);
            } elseif ($status === 'paid') {
                $query->where('payment_status', 'paid')
                      ->whereNotIn('payment_method', ['cash_on_delivery', 'cod']);
            } elseif ($status === 'not_paid') {
                $query->where('payment_status', '!=', 'paid')
                      ->whereNotIn('payment_method', ['cash_on_delivery', 'cod']);
            }
        }

        // Return more results for the dashboard filter (20 instead of 10)
        $orders = $query->orderBy('created_at', 'desc')->limit(20)->get();

        // Return HTML for the table body
        $html = '';
        if ($orders->isEmpty()) {
            $html = '<tr><td colspan="8" class="text-center text-muted py-4">No orders found matching filters</td></tr>';
        } else {
            foreach ($orders as $index => $order) {
                $billingName = 'N/A';
                if ($order->customer_type === 'registered' && $order->customer) {
                    $billingName = $order->customer->username;
                } elseif ($order->customer_type === 'guest' && $order->guest_details) {
                    $billingName = $order->guest_details['first_name'] ?? $order->guest_details['name'] ?? 'Guest';
                }

                if (in_array($order->payment_method, ['cash_on_delivery', 'cod'])) {
                    $paymentBadge = '<button type="button" class="btn btn-sm d-inline-flex justify-content-center align-items-center" style="background-color:#ffc107;color:#000;border-radius:50px;width:80px;height:24px;font-size:12px;border:none;padding:0;">COD</button>';
                } elseif ($order->payment_status === 'paid') {
                    $paymentBadge = '<button type="button" class="btn btn-sm d-inline-flex justify-content-center align-items-center" style="background-color:#28a745;color:#fff;border-radius:50px;width:80px;height:24px;font-size:12px;border:none;padding:0;">Paid</button>';
                } else {
                    $paymentBadge = '<button type="button" class="btn btn-sm d-inline-flex justify-content-center align-items-center" style="background-color:#dc3545;color:#fff;border-radius:50px;width:80px;height:24px;font-size:12px;border:none;padding:0;">Not Paid</button>';
                }

                // Determine method label
                $method = $order->payment_method ?? 'cash';
                $methodLabel = match(strtolower($method)) {
                    'online_gateway', 'online', 'razorpay', 'stripe', 'paytm' => 'Online',
                    'cash_on_delivery', 'cod' => 'Cash',
                    'cash' => 'Cash',
                    default => ucwords(str_replace('_', ' ', $method))
                };

                // Determine view URL based on order type
                $viewUrl = ($order->order_type === 'billing') 
                    ? route('admin.billing.invoice', $order->id)
                    : route('orders.view', $order->id);

                $html .= '<tr>
                    <td>' . ($index + 1) . '</td>
                    <td><a href="' . $viewUrl . '" class="fw-bold">#' . $order->order_number . '</a></td>
                    <td>' . $billingName . '</td>
                    <td>' . $order->created_at->format('d M, Y') . '</td>
                    <td>₹' . number_format($order->final_amount, 2) . '</td>
                    <td class="text-center">' . $paymentBadge . '</td>
                    <td><div class="d-flex align-items-center"><i class="material-icons md-payment font-xxl text-muted me-2"></i> <span>' . $methodLabel . '</span></div></td>
                    <td><button type="button" class="btn btn-xs btn-primary view-invoice-btn" data-order-id="' . $order->id . '"> View details</button></td>
                </tr>';
            }
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $orders->count()
        ]);
    }
    /* =========================
       1️⃣ LIST / VIEW
    ==========================*/
    public function table(Request $request)
    {
        $search = $request->input('search', '');
        $status = $request->input('status', '');

        $query = Product::with(['variants.quantity', 'latestStockUpdate.stockUpdater']);

        if (!empty($search)) {
            $query->where('productname', 'like', '%' . $search . '%')
                ->orWhere('sku', 'like', '%' . $search . '%');
        }

        if ($status !== '' && $status !== null) {
            $query->where('status', (int) $status);
        }

        // Order by category, subcategory, then 'orderby' field first (nulls last), then by id
        $query->orderBy('category_id', 'asc')
              ->orderBy('subcategory_id', 'asc')
              ->orderByRaw('orderby IS NULL OR orderby = 0')
              ->orderBy('orderby', 'asc')
              ->orderBy('id', 'asc');

        $products = $query->paginate(10);
        $quantities = Quantity::where('status', 1)->get(['id', 'label', 'name']);

        return view('product.product-table', compact('products', 'search', 'status', 'quantities'));
    }

    /* =========================
       2️⃣ CREATE FORM
    ==========================*/
    public function create()
    {
        $quantities = Quantity::where('status', 1)->get();
        $categories = MainCategory::where('status', 'active')->get();
        $subcategories = SubCategory::where('status', 'active')->get();
        $childcategories = ChildCategory::where('status', 'active')->get();


        return view('product.product-create', compact('quantities', 'categories', 'subcategories', 'childcategories'));
    }

    /* =========================
       3️⃣ STORE
    ==========================*/
    public function store(Request $request)
    {
        $request->validate([
            'productname' => 'required',
            'sku' => 'required|unique:products,sku',
            'status' => 'nullable|in:0,1',
            'orderby' => [
                'nullable',
                'numeric',
                Rule::unique('products', 'orderby')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id)
                                 ->where('subcategory_id', $request->subcategory_id);
                })
            ],
            'productimage' => 'nullable|array|max:5',
            'productimage.*' => 'image|max:2048',

            'variants' => 'required|array|min:1',
            'variants.*.quantity_id' => 'required|exists:quantities,id',
            'variants.*.price' => 'required|numeric',
            'variants.*.sell_price' => 'required|numeric',
            'variants.*.stock' => 'required|integer|min:0',
        ], [
            'orderby.unique' => 'This display order number is already taken in the selected sub-category.',
            'orderby.numeric' => 'Display order must be a number.',
        ]);

        // Prevent duplicate weight
        $weights = array_column($request->variants, 'quantity_id');
        if (count($weights) !== count(array_unique($weights))) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['errors' => ['variants' => ['Duplicate weight not allowed']]], 422);
            }
            return back()->withErrors(['variants' => 'Duplicate weight not allowed'])->withInput();
        }

        DB::beginTransaction();

        try {
            /* Ensure uploads directory exists */
            File::ensureDirectoryExists(public_path('uploads/products'));

            /* Images */
            $images = [];
            if ($request->hasFile('productimage')) {
                $images = [];
                $i = 0;
                foreach ($request->file('productimage') as $file) {
                    if ($i >= 5)
                        break;
                    $filename = time() . '_' . ($i + 1) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/products'), $filename);
                    $images[$i] = 'uploads/products/' . $filename;
                    $i++;
                }
            }

            /* Product */
            $product = Product::create([
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'childcategory_id' => $request->childcategory_id,
                'productname' => $request->productname,
                'slug' => Str::slug($request->productname),
                'sku' => $request->sku,
                // 'price' => $request->price,
                'hsn' => $request->hsn,
                'gst' => $request->gst,
                'sgst' => $request->sgst,
                'igst' => $request->igst,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'featured' => $request->featured ?? 0,
                'status' => $request->status ?? 1,
                'top_selling' => $request->top_selling ?? 0,
                'trending_product' => $request->trending_product ?? 0,
                'hot_deal' => $request->hot_deal ?? 0,
                'productimage' => $images,
                'seo_title' => $request->seo_title,
                'seo_description' => $request->seo_description,
                'seo_keywords' => $request->seo_keywords,
                'orderby' => $request->orderby,
            ]);

            /* Specifications */
            if ($request->has('specifications')) {
                foreach ($request->specifications as $spec) {
                    if (!empty($spec['key']) && !empty($spec['value'])) {
                        ProductSpecification::create([
                            'product_id' => $product->id,
                            'spec_key' => $spec['key'],
                            'spec_value' => $spec['value'],
                        ]);
                    }
                }
            }

            /* Variants */
            foreach ($request->variants as $variant) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'quantity_id' => $variant['quantity_id'],
                    'price' => $variant['price'],
                    'sell_price' => $variant['sell_price'],
                    'stock' => $variant['stock'],
                    'stock_status' => $variant['stock'] > 0 ? 'in_stock' : 'out_of_stock',
                    'stock_updated_by' => auth()->id(),
                    'stock_updated_at' => now(),
                ]);
            }
            DB::commit();

            try {
                NotificationHelper::sendToAll(
                    'New Product Added',
                    'Product "' . $product->productname . '" has been added successfully.',
                    'high',
                    'admin'
                );
            } catch (\Exception $e) {
                // Don't let notification errors break product creation
                \Log::warning('Product notification failed: ' . $e->getMessage());
            }

            if ($request->ajax() || $request->wantsJson()) {
                $request->session()->flash('success', 'Product created successfully');
                return response()->json(['success' => true, 'message' => 'Product created successfully', 'redirect' => route('product.table')]);
            }
            return redirect()->route('product.table')->with('success', 'Product created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /* =========================
       4️⃣ EDIT FORM
    ==========================*/
    public function edit($id)
    {
        $product = Product::with(['variants', 'specifications'])->findOrFail($id);
        $quantities = Quantity::where('status', 1)->get();
        $categories = MainCategory::orderBy('name')->get();         // ALL categories (active + inactive)
        $subcategories = SubCategory::orderBy('name')->get();       // ALL subcategories
        $childcategories = ChildCategory::orderBy('name')->get();   // ALL child categories


        return view('product.product-edit', compact('product', 'quantities', 'categories', 'subcategories', 'childcategories'));
    }

    /* =========================
       5️⃣ UPDATE
    ==========================*/
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'productname' => 'required',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'status' => 'nullable|in:0,1',
            'orderby' => [
                'nullable',
                'numeric',
                Rule::unique('products', 'orderby')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id)
                                 ->where('subcategory_id', $request->subcategory_id);
                })->ignore($product->id)
            ],
            'productimage' => 'nullable|array|max:5',
            'productimage.*' => 'image|max:2048',
            'replace_image.*' => 'nullable|image|max:2048',
            'variants' => 'required|array|min:1',
            'variants.*.quantity_id' => 'required|exists:quantities,id',
            'variants.*.price' => 'required|numeric',
            'variants.*.sell_price' => 'required|numeric',
            'variants.*.stock' => 'required|integer|min:0',
        ], [
            'orderby.unique' => 'This display order number is already taken in the selected sub-category.',
            'orderby.numeric' => 'Display order must be a number.',
        ]);

        $existingCount = $product->productimage ? count($product->productimage) : 0;
        $imagesToRemove = $request->input('remove_images', []);
        $existingCount = max(0, $existingCount - count($imagesToRemove));
        $newCount = $request->hasFile('productimage') ? count($request->file('productimage')) : 0;
        if (($existingCount + $newCount) > 5) {
            return back()->withErrors(['productimage' => 'Total number of images cannot exceed 5. Please delete some existing images first.'])->withInput();
        }

        DB::beginTransaction();

        try {
            /* Ensure uploads directory exists */
            File::ensureDirectoryExists(public_path('uploads/products'));

            /* Handle Images */
            $images = $product->productimage ?? [];

            // Remove images that user checked for removal
            $imagesToRemove = $request->input('remove_images', []);
            if (!empty($imagesToRemove)) {
                foreach ($imagesToRemove as $imageToRemove) {
                    $imagePath = public_path($imageToRemove);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                    $images = array_diff($images, [$imageToRemove]);
                }
                $images = array_values($images);
            }

            // Replace individual images if uploaded
            if ($request->hasFile('replace_image')) {
                foreach ($request->file('replace_image') as $index => $file) {
                    if (isset($images[$index])) {
                        // Delete old image file
                        $oldImagePath = public_path($images[$index]);
                        if (File::exists($oldImagePath)) {
                            File::delete($oldImagePath);
                        }
                    }
                    // Upload new replacement image
                    $filename = time() . '_replace_' . ($index + 1) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/products'), $filename);
                    $images[$index] = 'uploads/products/' . $filename;
                }
            }

            // Add new images if uploaded
            if ($request->hasFile('productimage')) {
                $uploadCount = count($images);

                foreach ($request->file('productimage') as $file) {
                    if ($uploadCount >= 5)
                        break; // max 5 images

                    // Create unique filename
                    $filename = time() . '_' . ($uploadCount + 1) . '.' . $file->getClientOriginalExtension();

                    // Move file to public/uploads/products
                    $file->move(public_path('uploads/products'), $filename);

                    // Save path in images array
                    $images[$uploadCount] = 'uploads/products/' . $filename;

                    $uploadCount++;
                }
            }

            /* Update product */
            $product->update([
                'category_id' => $request->category_id,
                'subcategory_id' => $request->subcategory_id,
                'childcategory_id' => $request->childcategory_id,
                'productname' => $request->productname,
                'slug' => Str::slug($request->productname),
                'sku' => $request->sku,
                // 'price' => $request->price,
                'hsn' => $request->hsn,
                'gst' => $request->gst,
                'sgst' => $request->sgst,
                'igst' => $request->igst,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'featured' => $request->featured ?? 0,
                'status' => $request->status ?? 1,
                'top_selling' => $request->top_selling ?? 0,
                'trending_product' => $request->trending_product ?? 0,
                'hot_deal' => $request->hot_deal ?? 0,
                'productimage' => $images,
                'seo_title' => $request->seo_title,
                'seo_description' => $request->seo_description,
                'seo_keywords' => $request->seo_keywords,
                'orderby' => $request->orderby,
            ]);

            /* Handle specifications surgically */
            ProductSpecification::where('product_id', $product->id)->delete();
            if ($request->has('specifications')) {
                foreach ($request->specifications as $spec) {
                    if (!empty($spec['key']) && !empty($spec['value'])) {
                        ProductSpecification::create([
                            'product_id' => $product->id,
                            'spec_key' => $spec['key'],
                            'spec_value' => $spec['value'],
                        ]);
                    }
                }
            }

            /* Handle variants surgically */
            $existingVariantIds = ProductVariant::where('product_id', $product->id)->pluck('id')->toArray();
            $newVariantIds = [];

            foreach ($request->variants as $variantData) {
                // Find existing variant for this product with the same quantity (weight)
                $variant = ProductVariant::where('product_id', $product->id)
                    ->where('quantity_id', $variantData['quantity_id'])
                    ->first();

                $stockChanged = false;
                if ($variant) {
                    $stockChanged = (int)$variant->stock !== (int)$variantData['stock'];
                    
                    $updateData = [
                        'price' => $variantData['price'],
                        'sell_price' => $variantData['sell_price'],
                        'stock' => $variantData['stock'],
                        'stock_status' => $variantData['stock'] > 0 ? 'in_stock' : 'out_of_stock',
                    ];

                    if ($stockChanged) {
                        $updateData['stock_updated_by'] = auth()->id();
                        $updateData['stock_updated_at'] = now();
                    }

                    $variant->update($updateData);
                    $newVariantIds[] = $variant->id;
                } else {
                    // Create new variant
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'quantity_id' => $variantData['quantity_id'],
                        'price' => $variantData['price'],
                        'sell_price' => $variantData['sell_price'],
                        'stock' => $variantData['stock'],
                        'stock_status' => $variantData['stock'] > 0 ? 'in_stock' : 'out_of_stock',
                        'stock_updated_by' => auth()->id(),
                        'stock_updated_at' => now(),
                    ]);
                    $newVariantIds[] = $variant->id;
                    $stockChanged = true;
                }

                // Send low stock notification if stock is below 10 and it's a new update or change
                if ($stockChanged && $variant->stock < 10) {
                    NotificationHelper::sendToRole(
                        'admin',
                        'Low Stock Alert',
                        'SKU ' . $product->sku . ' stock is below 10. Current stock: ' . $variant->stock,
                        'admin',
                        'admin'
                    );
                }
            }

            // Remove variants that are no longer in the request
            ProductVariant::where('product_id', $product->id)
                ->whereNotIn('id', $newVariantIds)
                ->delete();

            DB::commit();
            return redirect()->route('product.table')->with('success', 'Product updated');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /* =========================
       x️⃣ DELETE IMAGE
    ==========================*/
    public function deleteImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $imagePath = $request->input('image_path');
        
        $images = $product->productimage ?? [];
        
        // Find the relative path without the leading slash if necessary
        $imagePath = ltrim($imagePath, '/');
        
        if (in_array($imagePath, $images) || in_array('/' . $imagePath, $images)) {
            $actualImagePath = in_array($imagePath, $images) ? $imagePath : '/' . $imagePath;
            $fullPath = public_path($actualImagePath);
            
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
            
            $images = array_diff($images, [$actualImagePath]);
            $product->productimage = array_values($images);
            $product->save();
            
            return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
        }
        
        return response()->json(['success' => false, 'message' => 'Image not found'], 404);
    }

    /* =========================
       x️⃣ DELETE MULTIPLE IMAGES (Bulk)
    ==========================*/
    public function deleteImages(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $imagePaths = $request->input('image_paths', []);

        if (empty($imagePaths)) {
            return response()->json(['success' => false, 'message' => 'No images selected'], 422);
        }

        $images = $product->productimage ?? [];
        $deleted = 0;

        foreach ($imagePaths as $imagePath) {
            $imagePath = ltrim($imagePath, '/');
            $actualImagePath = in_array($imagePath, $images) ? $imagePath : '/' . $imagePath;

            if (in_array($actualImagePath, $images) || in_array($imagePath, $images)) {
                $key = in_array($imagePath, $images) ? $imagePath : $actualImagePath;
                $fullPath = public_path($key);
                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                }
                $images = array_diff($images, [$key]);
                $deleted++;
            }
        }

        $product->productimage = array_values($images);
        $product->save();

        return response()->json([
            'success' => true,
            'deleted' => $deleted,
            'message' => $deleted . ' image(s) deleted successfully'
        ]);
    }

    /* =========================
       6️⃣ DELETE
    ==========================*/
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            DB::beginTransaction();

            // Delete product images from storage
            if ($product->productimage && is_array($product->productimage)) {
                foreach ($product->productimage as $image) {
                    $imagePath = public_path($image);
                    if (File::exists($imagePath)) {
                        File::delete($imagePath);
                    }
                }
            }

            // Delete variants first
            ProductVariant::where('product_id', $product->id)->delete();

            // Delete the product
            $product->delete();

            DB::commit();

            return redirect()->route('product.table')->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('product.table')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function view($id)
    {
        $product = Product::with([
            'variants.quantity', 'specifications'
        ])->findOrFail($id);

        return view('product.product-view', compact('product'));
    }

    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);

        $product->status = $product->status == 1 ? 0 : 1;
        $product->save();

        return redirect()->back()->with('success', 'Product status updated');
    }

    public function storeVariant(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $data = $request->validate([
            'quantity_id' => 'required|exists:quantities,id',
            'price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $exists = ProductVariant::where('product_id', $product->id)
            ->where('quantity_id', $data['quantity_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This weight already exists for the product.',
            ], 422);
        }

        $variant = ProductVariant::create([
            'product_id' => $product->id,
            'quantity_id' => $data['quantity_id'],
            'price' => $data['price'],
            'sell_price' => $data['sell_price'],
            'stock' => $data['stock'],
            'stock_status' => $data['stock'] > 0 ? 'in_stock' : 'out_of_stock',
            'stock_updated_by' => auth()->id(),
            'stock_updated_at' => now(),
        ]);

        $variant->load('quantity');

        return response()->json([
            'success' => true,
            'variant' => $variant,
        ]);
    }

    public function deleteVariant(Request $request, $id)
    {
        $variant = ProductVariant::with('quantity')->findOrFail($id);

        if ($request->filled('product_id') && (int) $variant->product_id !== (int) $request->product_id) {
            return response()->json([
                'success' => false,
                'message' => 'Variant does not belong to this product.',
            ], 404);
        }

        $variant->delete();

        return response()->json([
            'success' => true,
            'message' => 'Variant deleted',
        ]);
    }

    public function units($id)
    {
        try {
            $variants = ProductVariant::with('quantity')
                ->where('product_id', $id)
                ->get()
                ->each(function ($variant) {
                    // Strip offer-related appended attributes to avoid N+1 Offer queries
                    $variant->makeHidden(['has_offer', 'offer_price', 'offer_mrp']);
                });

            return response()->json($variants, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateVariantStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        try {
            $variant = ProductVariant::with('product')->findOrFail($id);
            $oldStock = $variant->stock;
            $newStock = $request->stock;

            $variant->stock = $newStock;
            $variant->stock_status = $newStock > 0 ? 'in_stock' : 'out_of_stock';
            $variant->stock_updated_by = auth()->id();
            $variant->stock_updated_at = now();
            $variant->save();

            /** 🔥 LOW STOCK ALERT (ADMIN ONLY) */
            if ($oldStock >= 10 && $newStock < 10) {
                NotificationHelper::sendToRole(
                    'admin',
                    'Low Stock Alert',
                    'SKU ' . $variant->product->sku . ' is low. Current stock: ' . $newStock,
                    'admin',
                    'admin'
                );
            }

            $variant->load('stockUpdater');

            return response()->json([
                'success' => true,
                'stock' => $variant->stock,
                'updater' => $variant->stockUpdater->username ?? $variant->stockUpdater->name ?? 'Admin',
                'updated_at' => \Carbon\Carbon::parse($variant->stock_updated_at)->format('d M, h:i A'),
                'message' => 'Stock updated successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update stock',
            ], 500);
        }
    }
    // ProductController.php
    public function inventoryTable(Request $request)
    {
        $search = $request->input('search', '');
        $status = $request->input('status', '');

        $query = ProductVariant::with('product', 'quantity')
            ->where('stock', '<', 10);

        // Search by product name
        if ($search) {
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('productname', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        // Filter by status (low/ok based on stock level)
        if ($status === 'low') {
            $query->where('stock', '<', 5);
        } elseif ($status === 'max') {
            $query->whereBetween('stock', [5, 9]);
        } elseif ($status === 'high') {
            $query->where('stock', '>=', 10);
        }


        $variants = $query->latest()->paginate(10);

        return view('product.inventory-table', compact('variants', 'search', 'status'));
    }
    public function updateStock(Request $request)
    {
        foreach ($request->stocks as $item) {
            $stock = (int) $item['stock'];
            ProductVariant::where('id', $item['id'])
                ->update([
                    'stock' => $stock,
                    'stock_status' => $stock > 0 ? 'in_stock' : 'out_of_stock',
                    'stock_updated_by' => auth()->id(),
                    'stock_updated_at' => now(),
                ]);
        }

        return response()->json(['status' => true]);
    }

}
