<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class AddtoCartController extends Controller
{
    /**
     * Add product to cart - Works for both guests and logged-in users
     */
    public function addtocart(Request $request)
    {
        try {
            // Handle both form data and JSON requests
            $productId = $request->input('product_id');
            // Accept selected_quantity (new) or quantity (legacy) - per strict quantity flow contract
            $quantity = $request->input('selected_quantity') ?? $request->input('quantity', 1);
            $variantId = $request->input('variant_id');
            $unitPrice = $request->input('unit_price'); // Resolved price from frontend
            $selectedWeight = $request->input('selected_weight'); // Weight label for display

            // If JSON content type, parse the raw input
            if ($request->isJson() || $request->wantsJson()) {
                $jsonData = json_decode($request->getContent(), true);
                if ($jsonData) {
                    $productId = $jsonData['product_id'] ?? $productId;
                    // Accept selected_quantity (new) or quantity (legacy)
                    $quantity = $jsonData['selected_quantity'] ?? $jsonData['quantity'] ?? $quantity;
                    $variantId = $jsonData['variant_id'] ?? $variantId;
                    $unitPrice = $jsonData['unit_price'] ?? $unitPrice;
                    $selectedWeight = $jsonData['selected_weight'] ?? $selectedWeight;
                }
            }

            // Validate product exists
            $product = Product::find($productId);
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found'
                ], 404);
            }

            // Get selected weight label if variant_id is provided but selected_weight is not
            if ($variantId && !$selectedWeight) {
                $variant = $product->variants()->with('quantity')->where('id', $variantId)->first();
                if ($variant && $variant->quantity) {
                    $selectedWeight = $variant->quantity->label ?? $variant->quantity->name ?? null;
                }
            }

            // PRICE RESOLUTION - Priority:
            // 1. Use frontend-provided unit_price if available (already resolved with offer logic)
            // 2. Otherwise calculate based on variant or product
            $price = 0;

            if ($unitPrice && $unitPrice > 0) {
                // Frontend sent the resolved price - use it directly
                // This is the price user saw on product page with all offer logic applied
                $price = (float) $unitPrice;
            } else {
                // Fallback: Calculate price server-side
                // If variant_id is provided, get that specific variant
                if ($variantId) {
                    $variant = $product->variants()->where('id', $variantId)->first();
                    if ($variant) {
                        // Check if product has offer - apply to variant's MRP
                        if ($product->has_offer && $product->offer_price > 0) {
                            // Calculate offer price for this variant
                            $variantMrp = $variant->price ?? 0;
                            if ($product->discount_type === 'percentage') {
                                $discount = ($variantMrp * $product->discount_value) / 100;
                            } else {
                                $discount = $product->discount_value ?? 0;
                            }
                            $price = max(0, $variantMrp - $discount);
                        } else {
                            // No offer - use variant's sell_price
                            $price = ($variant->sell_price && $variant->sell_price > 0)
                                ? $variant->sell_price
                                : ($variant->price ?? 0);
                        }
                    }
                }

                // If still no price, try first variant or product price
                if (!$price || $price <= 0) {
                    if ($product->has_offer && $product->offer_price > 0) {
                        $price = $product->offer_price;
                    } else {
                        $firstVariant = $product->variants()->first();
                        if ($firstVariant) {
                            $price = ($firstVariant->sell_price && $firstVariant->sell_price > 0)
                                ? $firstVariant->sell_price
                                : ($firstVariant->price ?? 0);
                        } else {
                            $price = ($product->sell_price && $product->sell_price > 0)
                                ? $product->sell_price
                                : ($product->price ?? 0);
                        }
                    }
                }
            }

            // Final validation - log warning if price is invalid
            if (!$price || $price <= 0) {
                \Log::warning('Add to cart: Price is 0 for product ID ' . $productId);
            }

            // Check if user is logged in
            if (auth('customer')->check()) {
                // LOGGED IN USER: Use database cart
                $customerId = auth('customer')->id();

                // Check if product + variant already exists in cart
                // IMPORTANT: Each variant is a separate cart item
                $existingCartQuery = Cart::where('customer_id', $customerId)
                    ->where('product_id', $productId);

                // If variant_id is provided, check for that specific variant
                if ($variantId) {
                    $existingCartQuery->where('variant_id', $variantId);
                } else {
                    // For simple products (no variant), check where variant_id is null
                    $existingCartQuery->whereNull('variant_id');
                }

                $existingCart = $existingCartQuery->first();

                // Calculate stock change needed and new quantity
                $newQuantity = $quantity;
                $stockChangeNeeded = 0;

                if ($existingCart) {
                    // ADD to existing cart item quantity (combine quantities)
                    $newQuantity = $existingCart->quantity + $quantity;
                    $stockChangeNeeded = $quantity; // Only deduct the newly added quantity
                } else {
                    // New cart item - deduct full quantity
                    $stockChangeNeeded = $quantity;
                }

                // Deduct stock from variant only (products don't have stock column)
                if ($stockChangeNeeded > 0) {
                    if ($variantId) {
                        // Variable product - deduct from variant stock
                        $variant = $product->variants()->where('id', $variantId)->first();
                        if ($variant) {
                            if ($variant->stock < $stockChangeNeeded) {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Insufficient stock. Only ' . $variant->stock . ' items available.'
                                ], 422);
                            }
                            $variant->stock = max(0, $variant->stock - $stockChangeNeeded);
                            $variant->save();
                        }
                    }
                    // Note: Simple products without variants don't have stock management
                }

                // Now update or create cart item
                if ($existingCart) {
                    // Add to existing quantity (combine quantities from different pages)
                    $existingCart->update([
                        'quantity' => $newQuantity,
                        'row_total' => $price * $newQuantity
                    ]);
                } else {
                    // Create new cart item for this variant
                    Cart::create([
                        'customer_id' => $customerId,
                        'product_id' => $productId,
                        'variant_id' => $variantId ?: null,
                        'selected_weight' => $selectedWeight,
                        'quantity' => $quantity,
                        'price_at_add_time' => (float) $price,
                        'row_total' => (float) $price * $quantity,
                        'status' => 1
                    ]);
                }

                // Get updated cart count
                $cartCount = Cart::where('customer_id', $customerId)->count();
            } else {
                // GUEST USER: Use session cart
                // Use product_id + variant_id as the cart key to differentiate variants
                $cart = session()->get('guest_cart', []);
                $cartKey = $variantId ? $productId . '_' . $variantId : (string) $productId;

                // Calculate stock change needed and new quantity
                $newQuantity = $quantity;
                $stockChangeNeeded = 0;

                if (isset($cart[$cartKey])) {
                    // ADD to existing cart item quantity (combine quantities)
                    $newQuantity = $cart[$cartKey]['quantity'] + $quantity;
                    $stockChangeNeeded = $quantity; // Only deduct the newly added quantity
                } else {
                    // New cart item - deduct full quantity
                    $stockChangeNeeded = $quantity;
                }

                // Deduct stock from variant only (products don't have stock column)
                if ($stockChangeNeeded > 0) {
                    if ($variantId) {
                        // Variable product - deduct from variant stock
                        $variant = $product->variants()->where('id', $variantId)->first();
                        if ($variant) {
                            if ($variant->stock < $stockChangeNeeded) {
                                return response()->json([
                                    'success' => false,
                                    'message' => 'Insufficient stock. Only ' . $variant->stock . ' items available.'
                                ], 422);
                            }
                            $variant->stock = max(0, $variant->stock - $stockChangeNeeded);
                            $variant->save();
                        }
                    }
                    // Note: Simple products without variants don't have stock management
                }

                // Now update or create cart item
                // Check if this product + variant already exists in cart
                if (isset($cart[$cartKey])) {
                    // Add to existing quantity (combine quantities from different pages)
                    $cart[$cartKey]['quantity'] = $newQuantity;
                    $cart[$cartKey]['row_total'] = $price * $newQuantity;
                } else {
                    // Add new item for this variant
                    $cart[$cartKey] = [
                        'product_id' => $productId,
                        'variant_id' => $variantId ?: null,
                        'selected_weight' => $selectedWeight,
                        'quantity' => $quantity,
                        'price_at_add_time' => (float) $price,
                        'row_total' => (float) $price * $quantity,
                        'added_at' => now()->toDateTimeString()
                    ];
                }

                // Save cart to session
                session()->put('guest_cart', $cart);

                // Get cart count
                $cartCount = count($cart);
            }

            // Get updated stock for the variant or product
            $remainingStock = 0;
            if ($variantId) {
                // Variable product - get variant stock
                $variant = $product->variants()->where('id', $variantId)->first();
                $remainingStock = $variant ? ($variant->stock ?? 0) : 0;
            } else {
                // Simple product - no stock tracking at product level
                $remainingStock = 0;
            }

            // Always return JSON for AJAX requests
            if ($request->expectsJson() || $request->isJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart!',
                    'cartCount' => $cartCount,
                    'remainingStock' => $remainingStock,
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->productname,
                        'price' => $price,
                        'image' => $product->productimage,
                        'quantity' => $quantity
                    ]
                ]);
            }

            return redirect()->back()->with('success', 'Product added to cart!');
        } catch (\Exception $e) {
            \Log::error('Add to cart error: ' . $e->getMessage());
            if ($request->expectsJson() || $request->isJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display cart page - Works for both guests and logged-in users
     */
    public function cartPage()
    {
        try {
            if (auth('customer')->check()) {
                // LOGGED IN USER: Get cart from database
                $customerId = auth('customer')->id();

                $cartItems = Cart::where('customer_id', $customerId)
                    ->where('status', 1)
                    ->with('product')
                    ->get();
            } else {
                // GUEST USER: Get cart from session
                $cart = session()->get('guest_cart', []);

                // Build a collection that matches the database cart structure
                $cartItems = collect([]);

                foreach ($cart as $cartKey => $item) {
                    // Extract product_id from the cart item (stored in the item itself)
                    $productId = $item['product_id'] ?? $cartKey;
                    $product = Product::find($productId);
                    if ($product) {
                        // Create a cart item object compatible with the view
                        $cartItem = (object) [
                            'id' => 'guest_' . $cartKey, // Unique ID for guest items (includes variant)
                            'product_id' => $productId,
                            'variant_id' => $item['variant_id'] ?? null,
                            'selected_weight' => $item['selected_weight'] ?? null,
                            'quantity' => $item['quantity'],
                            'price_at_add_time' => $item['price_at_add_time'],
                            'row_total' => $item['row_total'],
                            'product' => $product
                        ];
                        $cartItems->push($cartItem);
                    } else {
                        // Remove invalid product from session cart
                        unset($cart[$cartKey]);
                        session()->put('guest_cart', $cart);
                    }
                }
            }

            // Calculate totals
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price_at_add_time * $item->quantity;
            });

            $total = $subtotal;

            return view('section.add-cart-blade', [
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
                'total' => $total
            ]);
        } catch (\Exception $e) {
            \Log::error('Cart page error: ' . $e->getMessage());
            return redirect()->route('index')->with('error', 'Failed to load cart');
        }
    }

    /**
     * Get cart items as JSON - Works for both guests and logged-in users
     */
    public function getCartJson(Request $request)
    {
        try {
            if (auth('customer')->check()) {
                // LOGGED IN USER
                $customerId = auth('customer')->id();

                $cartItems = Cart::where('customer_id', $customerId)
                    ->where('status', 1)
                    ->with('product')
                    ->get();

                $cartData = $cartItems->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'customer_id' => $item->customer_id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->productname ?? '',
                        'product_slug' => $item->product->slug ?? '',
                        'quantity' => $item->quantity,
                        'price_at_add_time' => (float) $item->price_at_add_time,
                        'subtotal' => (float) ($item->price_at_add_time * $item->quantity),
                    ];
                });
            } else {
                // GUEST USER
                $cart = session()->get('guest_cart', []);

                $cartData = collect([]);
                foreach ($cart as $productId => $item) {
                    $product = Product::find($productId);
                    if ($product) {
                        $cartData->push([
                            'id' => 'guest_' . $productId,
                            'product_id' => $productId,
                            'product_name' => $product->productname ?? '',
                            'product_slug' => $product->slug ?? '',
                            'quantity' => $item['quantity'],
                            'price_at_add_time' => (float) $item['price_at_add_time'],
                            'subtotal' => (float) ($item['price_at_add_time'] * $item['quantity']),
                        ]);
                    }
                }
            }

            $subtotal = $cartData->sum('subtotal');

            return response()->json([
                'success' => true,
                'cart_count' => $cartData->count(),
                'items' => $cartData,
                'subtotal' => $subtotal,
                'total' => $subtotal
            ]);
        } catch (\Exception $e) {
            \Log::error('Get cart JSON error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve cart'
            ], 422);
        }
    }

    /**
     * Remove item from cart - Works for both guests and logged-in users
     */
    public function removeFromCart(Request $request)
    {
        try {
            $cartId = $request->cart_id;

            if (auth('customer')->check()) {
                // LOGGED IN USER
                $cartItem = Cart::where('id', $cartId)
                    ->where('customer_id', auth('customer')->id())
                    ->first();

                if (!$cartItem) {
                    return response()->json(['success' => false, 'message' => 'Item not found']);
                }

                // Restore stock before deleting cart item (variant stock only)
                $product = Product::find($cartItem->product_id);
                if ($product && $cartItem->variant_id) {
                    // Variable product - restore to variant stock
                    $variant = $product->variants()->where('id', $cartItem->variant_id)->first();
                    if ($variant) {
                        $variant->stock = $variant->stock + $cartItem->quantity;
                        $variant->save();
                    }
                }
                // Note: Simple products without variants don't have stock management

                $cartItem->delete();

                $cartCount = Cart::where('customer_id', auth('customer')->id())->count();

                $cartItems = Cart::where('customer_id', auth('customer')->id())->get();
                $subtotal = $cartItems->sum(function ($item) {
                    return $item->price_at_add_time * $item->quantity;
                });
            } else {
                // GUEST USER - cart_id format is 'guest_CARTKEY' where CARTKEY is productId or productId_variantId
                $cartKey = str_replace('guest_', '', $cartId);
                $cart = session()->get('guest_cart', []);

                if (!isset($cart[$cartKey])) {
                    return response()->json(['success' => false, 'message' => 'Item not found']);
                }

                // Restore stock before removing from cart (variant stock only)
                $cartItem = $cart[$cartKey];
                $product = Product::find($cartItem['product_id']);
                if ($product && isset($cartItem['variant_id']) && $cartItem['variant_id']) {
                    // Variable product - restore to variant stock
                    $variant = $product->variants()->where('id', $cartItem['variant_id'])->first();
                    if ($variant) {
                        $variant->stock = $variant->stock + $cartItem['quantity'];
                        $variant->save();
                    }
                }
                // Note: Simple products without variants don't have stock management

                unset($cart[$cartKey]);
                session()->put('guest_cart', $cart);

                $cartCount = count($cart);
                $subtotal = collect($cart)->sum('row_total');
            }

            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,
                'subtotal' => $subtotal,
                'total' => $subtotal
            ]);
        } catch (\Exception $e) {
            \Log::error('Remove from cart error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Clear entire cart - Works for both guests and logged-in users
     */
    public function clearCart()
    {
        try {
            if (auth('customer')->check()) {
                Cart::where('customer_id', auth('customer')->id())->delete();
            } else {
                session()->forget('guest_cart');
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('Clear cart error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Update cart quantity - Works for both guests and logged-in users
     */
    public function updateQty(Request $request)
    {
        try {
            $cartId = $request->cart_id;
            $quantity = (int) $request->quantity;

            if ($quantity < 1) {
                return response()->json(['success' => false, 'message' => 'Quantity must be at least 1'], 422);
            }

            if (auth('customer')->check()) {
                // LOGGED IN USER
                $cartItem = Cart::where('id', $cartId)
                    ->where('customer_id', auth('customer')->id())
                    ->first();

                if (!$cartItem) {
                    return response()->json(['success' => false, 'message' => 'Item not found'], 404);
                }

                $cartItem->update([
                    'quantity' => $quantity,
                    'row_total' => $cartItem->price_at_add_time * $quantity
                ]);

                $rowTotal = $cartItem->price_at_add_time * $quantity;

                $cartItems = Cart::where('customer_id', auth('customer')->id())->get();
                $subtotal = $cartItems->sum(function ($item) {
                    return $item->price_at_add_time * $item->quantity;
                });
            } else {
                // GUEST USER - cart_id format is 'guest_CARTKEY' where CARTKEY is productId or productId_variantId
                $cartKey = str_replace('guest_', '', $cartId);
                $cart = session()->get('guest_cart', []);

                if (!isset($cart[$cartKey])) {
                    return response()->json(['success' => false, 'message' => 'Item not found'], 404);
                }

                $cart[$cartKey]['quantity'] = $quantity;
                $cart[$cartKey]['row_total'] = $cart[$cartKey]['price_at_add_time'] * $quantity;

                session()->put('guest_cart', $cart);

                $rowTotal = $cart[$cartKey]['row_total'];
                $subtotal = collect($cart)->sum('row_total');
            }

            return response()->json([
                'success' => true,
                'row_total' => $rowTotal,
                'subtotal' => $subtotal,
                'total' => $subtotal
            ]);
        } catch (\Exception $e) {
            \Log::error('Update quantity error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Update cart quantity with increment/decrement - Works for both guests and logged-in users
     * Handles stock management and auto-removes item if quantity reaches 0
     */
    public function updateCartQuantity(Request $request)
    {
        try {
            $cartId = $request->cart_id;
            $action = $request->action; // 'increase' or 'decrease'

            if (auth('customer')->check()) {
                // LOGGED IN USER
                $cartItem = Cart::where('id', $cartId)
                    ->where('customer_id', auth('customer')->id())
                    ->first();

                if (!$cartItem) {
                    return response()->json(['success' => false, 'message' => 'Item not found'], 404);
                }

                $product = Product::find($cartItem->product_id);
                if (!$product) {
                    return response()->json(['success' => false, 'message' => 'Product not found'], 404);
                }

                $currentQuantity = $cartItem->quantity;
                $newQuantity = $action === 'increase' ? $currentQuantity + 1 : $currentQuantity - 1;

                // If quantity becomes 0, remove the item
                if ($newQuantity <= 0) {
                    // Restore stock (variant stock only)
                    if ($cartItem->variant_id) {
                        $variant = $product->variants()->where('id', $cartItem->variant_id)->first();
                        if ($variant) {
                            $variant->stock = $variant->stock + $cartItem->quantity;
                            $variant->save();
                        }
                    }
                    // Note: Simple products without variants don't have stock management

                    $cartItem->delete();

                    $cartCount = Cart::where('customer_id', auth('customer')->id())->count();
                    $cartItems = Cart::where('customer_id', auth('customer')->id())->get();
                    $subtotal = $cartItems->sum(function ($item) {
                        return $item->price_at_add_time * $item->quantity;
                    });

                    return response()->json([
                        'success' => true,
                        'removed' => true,
                        'cartCount' => $cartCount,
                        'subtotal' => $subtotal,
                        'total' => $subtotal,
                        'message' => 'Item removed from cart'
                    ]);
                }

                // Check stock availability for increase (variant stock only)
                if ($action === 'increase') {
                    if ($cartItem->variant_id) {
                        $variant = $product->variants()->where('id', $cartItem->variant_id)->first();
                        if ($variant && $variant->stock < 1) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Insufficient stock available'
                            ], 422);
                        }
                        // Deduct stock
                        if ($variant) {
                            $variant->stock = max(0, $variant->stock - 1);
                            $variant->save();
                        }
                    }
                    // Note: Simple products without variants don't have stock management
                } else {
                    // Restore stock for decrease (variant stock only)
                    if ($cartItem->variant_id) {
                        $variant = $product->variants()->where('id', $cartItem->variant_id)->first();
                        if ($variant) {
                            $variant->stock = $variant->stock + 1;
                            $variant->save();
                        }
                    }
                    // Note: Simple products without variants don't have stock management
                }

                // Update cart item
                $cartItem->update([
                    'quantity' => $newQuantity,
                    'row_total' => $cartItem->price_at_add_time * $newQuantity
                ]);

                $rowTotal = $cartItem->price_at_add_time * $newQuantity;

                $cartItems = Cart::where('customer_id', auth('customer')->id())->get();
                $subtotal = $cartItems->sum(function ($item) {
                    return $item->price_at_add_time * $item->quantity;
                });

                return response()->json([
                    'success' => true,
                    'quantity' => $newQuantity,
                    'row_total' => $rowTotal,
                    'subtotal' => $subtotal,
                    'total' => $subtotal
                ]);
            } else {
                // GUEST USER
                $cartKey = str_replace('guest_', '', $cartId);
                $cart = session()->get('guest_cart', []);

                if (!isset($cart[$cartKey])) {
                    return response()->json(['success' => false, 'message' => 'Item not found'], 404);
                }

                $cartItem = $cart[$cartKey];
                $product = Product::find($cartItem['product_id']);
                if (!$product) {
                    return response()->json(['success' => false, 'message' => 'Product not found'], 404);
                }

                $currentQuantity = $cartItem['quantity'];
                $newQuantity = $action === 'increase' ? $currentQuantity + 1 : $currentQuantity - 1;

                // If quantity becomes 0, remove the item
                if ($newQuantity <= 0) {
                    // Restore stock (variant stock only)
                    if (isset($cartItem['variant_id']) && $cartItem['variant_id']) {
                        $variant = $product->variants()->where('id', $cartItem['variant_id'])->first();
                        if ($variant) {
                            $variant->stock = $variant->stock + $cartItem['quantity'];
                            $variant->save();
                        }
                    }
                    // Note: Simple products without variants don't have stock management

                    unset($cart[$cartKey]);
                    session()->put('guest_cart', $cart);

                    $cartCount = count($cart);
                    $subtotal = collect($cart)->sum('row_total');

                    return response()->json([
                        'success' => true,
                        'removed' => true,
                        'cartCount' => $cartCount,
                        'subtotal' => $subtotal,
                        'total' => $subtotal,
                        'message' => 'Item removed from cart'
                    ]);
                }

                // Check stock availability for increase (variant stock only)
                if ($action === 'increase') {
                    if (isset($cartItem['variant_id']) && $cartItem['variant_id']) {
                        $variant = $product->variants()->where('id', $cartItem['variant_id'])->first();
                        if ($variant && $variant->stock < 1) {
                            return response()->json([
                                'success' => false,
                                'message' => 'Insufficient stock available'
                            ], 422);
                        }
                        if ($variant) {
                            $variant->stock = max(0, $variant->stock - 1);
                            $variant->save();
                        }
                    }
                    // Note: Simple products without variants don't have stock management
                } else {
                    // Restore stock for decrease (variant stock only)
                    if (isset($cartItem['variant_id']) && $cartItem['variant_id']) {
                        $variant = $product->variants()->where('id', $cartItem['variant_id'])->first();
                        if ($variant) {
                            $variant->stock = $variant->stock + 1;
                            $variant->save();
                        }
                    }
                    // Note: Simple products without variants don't have stock management
                }

                // Update cart item
                $cart[$cartKey]['quantity'] = $newQuantity;
                $cart[$cartKey]['row_total'] = $cart[$cartKey]['price_at_add_time'] * $newQuantity;

                session()->put('guest_cart', $cart);

                $rowTotal = $cart[$cartKey]['row_total'];
                $subtotal = collect($cart)->sum('row_total');

                return response()->json([
                    'success' => true,
                    'quantity' => $newQuantity,
                    'row_total' => $rowTotal,
                    'subtotal' => $subtotal,
                    'total' => $subtotal
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('Update cart quantity error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Get cart count for header - Works for both guests and logged-in users
     */
    public function getCartCount()
    {
        if (auth('customer')->check()) {
            $cartCount = Cart::where('customer_id', auth('customer')->id())->count();
        } else {
            $cart = session()->get('guest_cart', []);
            $cartCount = count($cart);
        }

        return response()->json(['cartCount' => $cartCount]);
    }

    /**
     * Store coupon in session for checkout
     */
    public function storeCouponInSession(Request $request)
    {
        try {
            $couponCode = $request->input('coupon_code');
            $couponDiscount = $request->input('coupon_discount');

            session()->put('cart_coupon_code', $couponCode);
            session()->put('cart_coupon_discount', $couponDiscount);

            return response()->json([
                'success' => true,
                'message' => 'Coupon stored in session'
            ]);
        } catch (\Exception $e) {
            \Log::error('Store coupon in session error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Clear coupon from session
     */
    public function clearCouponFromSession(Request $request)
    {
        try {
            session()->forget('cart_coupon_code');
            session()->forget('cart_coupon_discount');

            return response()->json([
                'success' => true,
                'message' => 'Coupon cleared from session'
            ]);
        } catch (\Exception $e) {
            \Log::error('Clear coupon from session error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}