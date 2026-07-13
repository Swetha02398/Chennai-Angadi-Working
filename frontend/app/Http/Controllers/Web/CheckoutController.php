<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Customer;
use App\Models\AddressBook;
use App\Models\ShippingZone;
use App\Models\ShippingZoneRegion;
use App\Models\ShippingRule;
use App\Models\ShippingRuleSlab;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\EmailHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\AdminOrderNotification;
use App\Models\User;

class CheckoutController extends Controller
{
    /**
     * Display checkout page with cart items
     */
    public function index()
    {
        try {
            // Get cart items
            if (auth('customer')->check()) {
                // LOGGED IN USER: Get cart from database
                $customerId = auth('customer')->id();
                $customer = Customer::find($customerId);

                // Fetch saved addresses for logged-in customer
                $savedAddresses = AddressBook::where('customer_id', $customerId)
                    ->where('status', 1)
                    ->orderBy('is_default', 'desc')
                    ->get();

                $cartItems = Cart::where('customer_id', $customerId)
                    ->where('status', 1)
                    ->with('product')
                    ->get();
            } else {
                // GUEST USER: Get cart from session
                $cart = session()->get('guest_cart', []);

                if (empty($cart)) {
                    return redirect()->route('cart.page')->with('warning', 'Your cart is empty!');
                }

                // Build a collection that matches the database cart structure
                $cartItems = collect([]);

                foreach ($cart as $cartKey => $item) {
                    // Get product_id from item data (cart key can be composite like 12_5)
                    $productId = $item['product_id'] ?? $cartKey;
                    $product = Product::find($productId);
                    if ($product) {
                        // Create a cart item object compatible with the view
                        $cartItem = (object) [
                            'id' => 'guest_' . $cartKey,
                            'product_id' => $productId,
                            'variant_id' => $item['variant_id'] ?? null,
                            'selected_weight' => $item['selected_weight'] ?? null,
                            'quantity' => $item['quantity'],
                            'price_at_add_time' => $item['price_at_add_time'],
                            'row_total' => $item['row_total'],
                            'product' => $product
                        ];
                        $cartItems->push($cartItem);
                    }
                }

                $customer = null;
            }

            // Check if cart is empty
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.page')->with('warning', 'Your cart is empty!');
            }

            // Filter out any cart items where the product no longer exists
            $cartItems = $cartItems->filter(function ($item) {
                return $item->product !== null;
            });

            // Check again after filtering
            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.page')->with('warning', 'Your cart contains products that are no longer available!');
            }

            // Calculate totals
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price_at_add_time * $item->quantity;
            });

            $shipping = 0; // Default shipping cost
            $total = $subtotal + $shipping;

            return view('section.checkout', [
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'customer' => $customer ?? null,
                'savedAddresses' => $savedAddresses ?? collect([]),
                'sessionCouponCode' => session('cart_coupon_code', null),
                'sessionCouponDiscount' => session('cart_coupon_discount', 0)
            ]);
        } catch (\Exception $e) {
            \Log::error('Checkout page error: ' . $e->getMessage());
            return redirect()->route('cart.page')->with('error', 'Failed to load checkout page');
        }
    }

    /**
     * Handle guest continue - store email in session and redirect to billing page
     */
    public function guestContinue(Request $request)
    {
        try {
            $request->validate([
                'guest_email' => 'required|email'
            ]);

            // Store guest email in session
            session(['guest_checkout_email' => $request->guest_email]);

            // Mutual exclusion: Logout registered customer if any
            if (auth('customer')->check()) {
                auth('customer')->logout();
            }

            return response()->json([
                'success' => true,
                'redirect_url' => route('checkout.billing-information')
            ]);
        } catch (\Exception $e) {
            \Log::error('Guest continue error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Invalid email address'
            ], 422);
        }
    }

    /**
     * Clear guest session via AJAX
     */
    public function abandonGuestSession(Request $request)
    {
        session()->forget('guest_checkout_email');
        session()->forget('checkout_billing_data');
        session()->forget('active_checkout_order_id');
        
        return response()->json(['success' => true, 'message' => 'Guest session cleared']);
    }

    /**
     * Display billing information page (Step 2 of checkout)
     */
    public function billingInformation()
    {
        try {
            // Check if user is logged in or has a guest email
            if (!auth('customer')->check() && !session('guest_checkout_email')) {
                return redirect()->route('checkout')->with('warning', 'Please enter your email to continue');
            }

            // Get cart items
            if (auth('customer')->check()) {
                $customerId = auth('customer')->id();
                $customer = Customer::find($customerId);
                $savedAddresses = AddressBook::where('customer_id', $customerId)
                    ->where('status', 1)
                    ->orderBy('is_default', 'desc')
                    ->get();

                $cartItems = Cart::where('customer_id', $customerId)
                    ->where('status', 1)
                    ->with('product')
                    ->get();
            } else {
                $cart = session()->get('guest_cart', []);

                if (empty($cart)) {
                    return redirect()->route('cart.page')->with('warning', 'Your cart is empty!');
                }

                $cartItems = collect([]);
                foreach ($cart as $cartKey => $item) {
                    $productId = $item['product_id'] ?? $cartKey;
                    $product = Product::find($productId);
                    if ($product) {
                        $cartItem = (object) [
                            'id' => 'guest_' . $cartKey,
                            'product_id' => $productId,
                            'variant_id' => $item['variant_id'] ?? null,
                            'selected_weight' => $item['selected_weight'] ?? null,
                            'quantity' => $item['quantity'],
                            'price_at_add_time' => $item['price_at_add_time'],
                            'row_total' => $item['row_total'],
                            'product' => $product
                        ];
                        $cartItems->push($cartItem);
                    }
                }

                $customer = null;
                $savedAddresses = collect([]);
            }

            // Filter out any cart items where the product no longer exists
            $cartItems = $cartItems->filter(function ($item) {
                return $item->product !== null;
            });

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.page')->with('warning', 'Your cart is empty!');
            }

            // Calculate totals
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price_at_add_time * $item->quantity;
            });

            $shipping = 0;
            $total = $subtotal + $shipping;

            return view('section.billing-information', [
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'customer' => $customer ?? null,
                'savedAddresses' => $savedAddresses ?? collect([]),
                'guestEmail' => session('guest_checkout_email'),
                'sessionCouponCode' => session('cart_coupon_code', null),
                'sessionCouponDiscount' => session('cart_coupon_discount', 0)
            ]);
        } catch (\Exception $e) {
            \Log::error('Billing information page error: ' . $e->getMessage());
            return redirect()->route('checkout')->with('error', 'Failed to load billing page');
        }
    }

    /**
     * Save billing information to session and redirect to payment mode
     */
    public function saveBilling(Request $request)
    {
        try {
            $request->validate([
                'billing_name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'billing_address' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'zipcode' => 'required|string',
                'shipping_name' => 'required|string',
                'shipping_address' => 'required|string',
                'shipping_city' => 'required|string',
                'shipping_state' => 'required|string',
                'shipping_pincode' => 'required|string',
                'shipping_phone' => 'required|string',
            ]);

            // Store billing data in session
            session([
                'checkout_billing_data' => [
                    'billing_name' => $request->billing_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'billing_address' => $request->billing_address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zipcode' => $request->zipcode,
                    'billing_landmark' => $request->billing_landmark,
                    'shipping_name' => $request->shipping_name,
                    'shipping_address' => $request->shipping_address,
                    'shipping_city' => $request->shipping_city,
                    'shipping_state' => $request->shipping_state,
                    'shipping_pincode' => $request->shipping_pincode,
                    'shipping_phone' => $request->shipping_phone,
                    'shipping_landmark' => $request->shipping_landmark,
                ]
            ]);

            return response()->json([
                'success' => true,
                'redirect_url' => route('checkout.order-review')
            ]);
        } catch (\Exception $e) {
            \Log::error('Save billing error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save billing information: ' . $e->getMessage()
            ], 422);
        }
    }

    /**
     * Display order review page (Step 3 of checkout)
     */
    public function orderReview()
    {
        try {
            // Check if billing data exists in session
            $billingData = session('checkout_billing_data');
            if (!$billingData) {
                return redirect()->route('checkout.billing-information')->with('warning', 'Please fill in billing information first');
            }

            // Get cart items
            if (auth('customer')->check()) {
                $customerId = auth('customer')->id();
                $cartItems = Cart::where('customer_id', $customerId)
                    ->where('status', 1)
                    ->with('product')
                    ->get();
            } else {
                $cart = session()->get('guest_cart', []);
                if (empty($cart)) {
                    return redirect()->route('cart.page')->with('warning', 'Your cart is empty!');
                }

                $cartItems = collect([]);
                foreach ($cart as $cartKey => $item) {
                    $productId = $item['product_id'] ?? $cartKey;
                    $product = Product::find($productId);
                    if ($product) {
                        $cartItem = (object) [
                            'id' => 'guest_' . $cartKey,
                            'product_id' => $productId,
                            'variant_id' => $item['variant_id'] ?? null,
                            'selected_weight' => $item['selected_weight'] ?? null,
                            'quantity' => $item['quantity'],
                            'price_at_add_time' => $item['price_at_add_time'],
                            'row_total' => $item['row_total'],
                            'product' => $product
                        ];
                        $cartItems->push($cartItem);
                    }
                }
            }

            // Filter and calculate totals
            $cartItems = $cartItems->filter(function ($item) {
                return $item->product !== null;
            });

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.page')->with('warning', 'Your cart is empty!');
            }

            $subtotal = $cartItems->sum(function ($item) {
                return $item->price_at_add_time * $item->quantity;
            });

            // Calculate shipping based on shipping state
            $shipping = $this->getShippingCharge(
                $billingData['shipping_state'],
                $subtotal,
                $cartItems,
                session('cart_coupon_discount', 0)
            );
            $total = $subtotal + $shipping;

            return view('section.order-review', [
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'billingData' => $billingData,
                'sessionCouponCode' => session('cart_coupon_code', null),
                'sessionCouponDiscount' => session('cart_coupon_discount', 0)
            ]);
        } catch (\Exception $e) {
            \Log::error('Order review page error: ' . $e->getMessage());
            return redirect()->route('checkout.billing-information')->with('error', 'Failed to load order review page');
        }
    }

    /**
     * Display single-page checkout order page
     */
    public function checkoutOrder()
    {
        try {
            // Get cart items
            if (auth('customer')->check()) {
                $customerId = auth('customer')->id();
                $customer = Customer::find($customerId);
                $savedAddresses = AddressBook::where('customer_id', $customerId)
                    ->where('status', 1)
                    ->orderBy('is_default', 'desc')
                    ->get();

                $cartItems = Cart::where('customer_id', $customerId)
                    ->where('status', 1)
                    ->with('product')
                    ->get();
            } else {
                $cart = session()->get('guest_cart', []);

                if (empty($cart)) {
                    return redirect()->route('index')->with('warning', 'Your cart is empty!');
                }

                $cartItems = collect([]);
                foreach ($cart as $cartKey => $item) {
                    $productId = $item['product_id'] ?? $cartKey;
                    $product = Product::find($productId);
                    if ($product) {
                        $cartItem = (object) [
                            'id' => 'guest_' . $cartKey,
                            'product_id' => $productId,
                            'variant_id' => $item['variant_id'] ?? null,
                            'selected_weight' => $item['selected_weight'] ?? null,
                            'quantity' => $item['quantity'],
                            'price_at_add_time' => $item['price_at_add_time'],
                            'row_total' => $item['row_total'],
                            'product' => $product
                        ];
                        $cartItems->push($cartItem);
                    }
                }

                $customer = null;
                $savedAddresses = collect([]);
            }

            // Filter out any cart items where the product no longer exists
            // Also auto-delete stale cart entries from DB/session
            $originalCount = $cartItems->count();
            $staleCartIds = [];
            $staleGuestKeys = [];

            foreach ($cartItems as $item) {
                if ($item->product === null) {
                    if (auth('customer')->check() && is_numeric($item->id)) {
                        $staleCartIds[] = $item->id;
                    } elseif (!auth('customer')->check()) {
                        // Extract guest cart key (remove 'guest_' prefix)
                        $guestKey = str_replace('guest_', '', $item->id);
                        $staleGuestKeys[] = $guestKey;
                    }
                }
            }

            // Delete stale cart items from database
            if (!empty($staleCartIds)) {
                Cart::whereIn('id', $staleCartIds)->delete();
                \Log::info('Auto-deleted stale cart items: ' . implode(', ', $staleCartIds));
            }

            // Remove stale items from guest session cart
            if (!empty($staleGuestKeys)) {
                $guestCart = session()->get('guest_cart', []);
                foreach ($staleGuestKeys as $key) {
                    unset($guestCart[$key]);
                }
                session()->put('guest_cart', $guestCart);
                \Log::info('Auto-removed stale guest cart items: ' . implode(', ', $staleGuestKeys));
            }

            $cartItems = $cartItems->filter(function ($item) {
                return $item->product !== null;
            });

            if ($cartItems->isEmpty()) {
                return redirect()->route('index')->with('warning', 'Your cart is empty!');
            }

            // Calculate totals
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price_at_add_time * $item->quantity;
            });

            $shipping = 0;
            $total = $subtotal + $shipping;

            // Get active states from shipping zone regions
            $shippingStates = ShippingZoneRegion::where('is_active', 1)
                ->distinct()
                ->orderBy('state')
                ->pluck('state');

            return view('checkout.checkout-order', [
                'cartItems' => $cartItems,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'total' => $total,
                'customer' => $customer ?? null,
                'savedAddresses' => $savedAddresses ?? collect([]),
                'guestEmail' => session('guest_checkout_email'),
                'sessionCouponCode' => session('cart_coupon_code', null),
                'sessionCouponDiscount' => session('cart_coupon_discount', 0),
                'shippingStates' => $shippingStates
            ]);
        } catch (\Exception $e) {
            \Log::error('Checkout order page error: ' . $e->getMessage());
            return redirect()->route('index')->with('error', 'Failed to load checkout page');
        }
    }

    /**
     * Place order
     */
    public function placeOrder(Request $request)
    {
        \Log::info('=== PLACE ORDER STARTED ===');
        \Log::info('Request data: ' . json_encode($request->all()));

        try {
            try {
                $request->validate([
                    'billing_name' => 'required|string',
                    'email' => 'required|email',
                    'phone' => 'required|string',
                    'billing_address' => 'required|string',
                    'city' => 'required|string',
                    'state' => 'required|string',
                    'zipcode' => 'required|string',
                    'billing_landmark' => 'nullable|string',
                    'payment_option' => 'required|in:bank_transfer,cash_on_delivery,online_gateway',
                    'ship_to_different' => 'sometimes|boolean',
                    // Shipping fields
                    'shipping_name' => 'required|string',
                    'shipping_address' => 'required|string',
                    'shipping_city' => 'required|string',
                    'shipping_state' => 'required|string',
                    'shipping_pincode' => 'required|string',
                    'shipping_phone' => 'required|string',
                    'shipping_landmark' => 'nullable|string',
                ]);
            } catch (\Illuminate\Validation\ValidationException $ve) {
                \Log::error('Validation Failed: ' . json_encode($ve->errors()));
                throw $ve;
            }

            // Build billing address
            $billingData = [
                'name' => $request->billing_name,
                'address' => $request->billing_address,
                'address2' => $request->input('billing_address2', ''),
                'landmark' => $request->input('billing_landmark', ''),
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->zipcode,
                'phone' => $request->phone,
                'email' => $request->email,
            ];

            // Determine shipping address
            $shipToDifferent = $request->input('ship_to_different', 0);

            if ($shipToDifferent) {
                $shippingData = [
                    'name' => $request->shipping_name,
                    'address' => $request->shipping_address,
                    'landmark' => $request->input('shipping_landmark', ''),
                    'city' => $request->shipping_city,
                    'state' => $request->shipping_state,
                    'pincode' => $request->shipping_pincode,
                    'phone' => $request->shipping_phone,
                    'email' => $request->email,
                ];
            } else {
                $shippingData = $billingData;
            }

            // Get cart items
            if (auth('customer')->check()) {
                $customerId = auth('customer')->id();
                $cartItems = Cart::where('customer_id', $customerId)
                    ->where('status', 1)
                    ->with('product')
                    ->get();
                $customerType = 'registered';
                $customerTypeInt = 1; // For address_books table (1=registered, 0=guest)
            } else {
                $cart = session()->get('guest_cart', []);
                if (empty($cart)) {
                    return response()->json(['success' => false, 'message' => 'Your cart is empty'], 422);
                }

                // Build cart items from session
                $cartItems = collect([]);
                foreach ($cart as $cartKey => $item) {
                    // Get product_id from item data (cart key can be composite like 12_5)
                    $productId = $item['product_id'] ?? $cartKey;
                    $product = Product::find($productId);
                    if ($product) {
                        $cartItem = (object) [
                            'id' => 'guest_' . $cartKey,
                            'product_id' => $productId,
                            'variant_id' => $item['variant_id'] ?? null,
                            'selected_weight' => $item['selected_weight'] ?? null,
                            'quantity' => $item['quantity'],
                            'price_at_add_time' => $item['price_at_add_time'],
                            'product' => $product
                        ];
                        $cartItems->push($cartItem);
                    }
                }
                $customerId = null;
                $customerType = 'guest';
                $customerTypeInt = 0; // For address_books table (0=guest)
            }

            // Filter out any cart items where the product no longer exists
            $cartItems = $cartItems->filter(function ($item) {
                return $item->product !== null;
            });

            // Check if cart is empty after filtering
            if ($cartItems->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Your cart contains products that are no longer available'], 422);
            }

            // Calculate subtotal
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price_at_add_time * $item->quantity;
            });

            // Get coupon discount first to use in shipping calculation (for Tamil Nadu)
            $couponCode = $request->input('coupon_code', null);
            $couponDiscount = $request->input('coupon_discount', 0);

            // Calculate shipping based on shipping state and cart items (weight-based for non-Tamil Nadu)
            $shippingCharge = $this->getShippingCharge($shippingData['state'], $subtotal, $cartItems, $couponDiscount);

            // Get COD charge from frontend (â‚¹50 if price after coupon < â‚¹600 and COD selected)
            $codCharge = $request->input('cod_charge', 0);

            // Calculate final amounts
            $totalAmount = $subtotal + $shippingCharge + $codCharge;
            $finalAmount = $totalAmount - $couponDiscount;

            $orderId = session('active_checkout_order_id');
            $order = null;
            if ($orderId) {
                $order = Order::find($orderId);
            }

            if ($order) {
                $orderNumber = $order->order_number;
            } else {
                // Generate sequential order number (CA + 5 digits)
                $latestOrder = Order::where('order_number', 'LIKE', 'CA%')
                    ->whereRaw('LENGTH(order_number) = 7')
                    ->orderBy('id', 'desc')
                    ->first();

                $nextId = 60001;
                if ($latestOrder) {
                    // Extract number from CAxxxxx (remove first 2 chars)
                    $lastNumber = (int) substr($latestOrder->order_number, 2);
                    $nextId = max(60001, $lastNumber + 1);
                }

                $orderNumber = 'CA' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

                // Create the order
                $order = Order::create([
                    'order_number' => $orderNumber,
                    'order_type' => 'frontend',
                    'order_source' => 'web',
                    'customer_id' => $customerId,
                    'customer_type' => $customerType,
                    'shipping_address' => [],
                    'billing_address' => [],
                    'payment_method' => $request->payment_option ?? 'online_gateway',
                ]);
            }

            // Sync/Update the order details
            $order->update([
                'guest_details' => $customerType === 'guest' ? [
                    'name' => $billingData['name'],
                    'email' => $request->email,
                    'phone' => $request->phone,
                ] : null,
                'shipping_address' => $shippingData,
                'billing_address' => $billingData,
                'billing_type' => $shipToDifferent ? 'different' : 'same',
                'payment_method' => $request->payment_option,
                'payment_status' => ($request->payment_option === 'cash_on_delivery') ? 'cod' : 'not_paid',
                'subtotal' => $subtotal,
                'discount_amount' => $couponDiscount,
                'coupon_code' => $couponCode,
                'tax_amount' => 0,
                'shipping_amount' => $shippingCharge,
                'cod_charge' => $codCharge,
                'total_amount' => $totalAmount,
                'final_amount' => $finalAmount,
                'status' => 'processing',
                'placed_at' => now(),
                'notes' => $request->input('notes', null),
                'created_by_type' => 'customer',
                'created_by_id' => $customerId,
            ]);

            // Clear the draft order ID from session
            session()->forget('active_checkout_order_id');

            \Log::info('ORDER PROCESSED with ID: ' . $order->id . ', Order Number: ' . $order->order_number);

            // Re-sync order items (delete and recreate to ensure they match current cart)
            $order->items()->delete();
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->variant_id ?? null,
                    'product_productname' => $item->product->productname,
                    'variant_name' => $item->selected_weight ?? null,
                    'price' => $item->price_at_add_time,
                    'qty' => $item->quantity,
                    'total' => $item->price_at_add_time * $item->quantity,
                ]);
                \Log::info('Order item created for product: ' . $item->product->productname);

                // Stock is already deducted when items are added to cart
                // No need to deduct again at checkout to prevent double-deduction
            }

            \Log::info('All order items created successfully. Total items: ' . $cartItems->count());

            // Save shipping address to address_book for registered customers (avoid duplicates)
            if ($customerType === 'registered' && $customerId) {
                // Check if an identical address already exists for this customer
                $existingAddress = AddressBook::where('customer_id', $customerId)
                    ->where('address', $shippingData['address'])
                    ->where('city', $shippingData['city'])
                    ->where('state', $shippingData['state'])
                    ->where('pincode', $shippingData['pincode'])
                    ->first();

                // Only save if address doesn't already exist (uses 'title' field, not 'name')
                if (!$existingAddress) {
                    AddressBook::create([
                        'customer_id' => $customerId,
                        'customer_type' => $customerTypeInt, // 1 = registered customer, 0 = guest
                        'title' => $shippingData['title'] ?? 'Shipping Address',
                        'phone' => $shippingData['phone'],
                        'email' => $shippingData['email'] ?? null,
                        'address' => $shippingData['address'],
                        'city' => $shippingData['city'],
                        'state' => $shippingData['state'],
                        'pincode' => $shippingData['pincode'],
                        'country' => 'India',
                        'is_default' => 0,
                        'status' => 1,
                    ]);
                }
            }

            // Clear the cart
            if (auth('customer')->check()) {
                Cart::where('customer_id', $customerId)
                    ->where('status', 1)
                    ->delete();
            } else {
                session()->forget('guest_cart');
                
            }

            // Track coupon usage: increment global count & record per-user usage
            if ($couponCode) {
                $usedCoupon = \App\Models\Coupon::where('code', $couponCode)->first();
                if ($usedCoupon) {
                    // Increment global used_count
                    $usedCoupon->increment('used_count');

                    // Record per-user usage for registered customers
                    if ($customerId) {
                        \DB::table('coupon_user')->insert([
                            'coupon_id'  => $usedCoupon->id,
                            'user_id'    => $customerId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // Send order confirmation email
            $emailSubject = 'Order Confirmation - #' . $order->order_number;
            try {
                \Mail::to($request->email)->send(new \App\Mail\OrderPlaced($order));
                \Log::info('Order confirmation email sent successfully', [
                    'order_number' => $order->order_number,
                    'email' => $request->email
                ]);

                // Log to EmailHistory table
                EmailHistory::create([
                    'order_id' => $order->id,
                    'email_type' => 'order_confirmation',
                    'recipient_email' => $request->email,
                    'recipient_name' => $request->billing_name,
                    'subject' => $emailSubject,
                    'order_number' => $order->order_number,
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            } catch (\Exception $emailError) {
                \Log::error('Order email failed: ' . $emailError->getMessage(), [
                    'order_number' => $order->order_number,
                    'email' => $request->email,
                    'trace' => $emailError->getTraceAsString()
                ]);

                // Log failed email to history
                EmailHistory::create([
                    'order_id' => $order->id,
                    'email_type' => 'order_confirmation',
                    'recipient_email' => $request->email,
                    'recipient_name' => $request->billing_name,
                    'subject' => $emailSubject,
                    'order_number' => $order->order_number,
                    'status' => 'failed',
                    'error_message' => $emailError->getMessage(),
                    'sent_at' => now(),
                ]);
                // Don't fail the order if email fails
            }

            // Send admin notification email
            try {
                $adminEmail = config('app.admin_email') 
                    ?? User::where('role', 'superadmin')->value('email') 
                    ?? User::where('role', 'admin')->value('email')
                    ?? 'care@chennaiangadi.com';
                    
                \Mail::to($adminEmail)->send(new AdminOrderNotification($order));
                \Log::info('Admin order notification email sent successfully', [
                    'order_number' => $order->order_number,
                    'admin_email' => $adminEmail
                ]);
            } catch (\Exception $adminEmailError) {
                \Log::error('Admin order notification email failed: ' . $adminEmailError->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_id' => $orderNumber,
                'order_number' => $orderNumber,
                'order_total' => $finalAmount,
                'shipping_charge' => $shippingCharge,
                'shipping_address' => $shippingData
            ]);
        } catch (\Exception $e) {
            \Log::error('Place order error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * AJAX Login for checkout page
     * Supports email, mobile number, or username
     */
    public function checkoutLogin(Request $request)
    {
        try {
            $request->validate([
                'login_id' => 'required',
                'password' => 'required'
            ]);

            $login_id = $request->login_id;

            // Determine type: email / mobile / username
            $fieldType = filter_var($login_id, FILTER_VALIDATE_EMAIL) ? 'email'
                : (is_numeric($login_id) ? 'mobilenumber' : 'username');

            // Find customer
            $customer = Customer::where($fieldType, $login_id)->first();

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid login credentials'
                ], 401);
            }

            // Check password
            if (!Hash::check($request->password, $customer->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password is incorrect'
                ], 401);
            }

            // Login the customer
            Auth::guard('customer')->login($customer);

            // Mutual exclusion: Clear guest checkout session on registered login
            

            // Merge guest cart to customer cart if needed
            $guestCart = session()->get('guest_cart', []);
            if (!empty($guestCart)) {
                foreach ($guestCart as $cartKey => $item) {
                    // Extract actual product_id from item data (cart key can be composite like "18_65")
                    $actualProductId = $item['product_id'] ?? null;
                    $variantId = $item['variant_id'] ?? null;
                    $selectedWeight = $item['selected_weight'] ?? null;

                    // Skip if no valid product_id
                    if (!$actualProductId) {
                        continue;
                    }

                    // Check for existing cart item with same product_id AND variant_id
                    $existingCartQuery = Cart::where('customer_id', $customer->id)
                        ->where('product_id', $actualProductId)
                        ->where('status', 1);

                    // Match by variant_id if present
                    if ($variantId) {
                        $existingCartQuery->where('variant_id', $variantId);
                    } else {
                        $existingCartQuery->whereNull('variant_id');
                    }

                    $existingCartItem = $existingCartQuery->first();

                    if ($existingCartItem) {
                        // Update quantity and row_total
                        $existingCartItem->quantity += $item['quantity'];
                        $existingCartItem->row_total = $existingCartItem->price_at_add_time * $existingCartItem->quantity;
                        $existingCartItem->save();
                    } else {
                        // Create new cart item with separate columns for each value
                        Cart::create([
                            'customer_id' => $customer->id,
                            'product_id' => (int) $actualProductId,
                            'variant_id' => $variantId ? (int) $variantId : null,
                            'selected_weight' => $selectedWeight,
                            'quantity' => $item['quantity'],
                            'price_at_add_time' => $item['price_at_add_time'],
                            'row_total' => $item['row_total'],
                            'status' => 1
                        ]);
                    }
                }
                session()->forget('guest_cart');
            }

            // Fetch customer addresses
            $addresses = AddressBook::where('customer_id', $customer->id)
                ->where('status', 1)
                ->get();

            // Return customer data for auto-populate
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'customer' => [
                    'id' => $customer->id,
                    'username' => $customer->username,
                    'email' => $customer->email,
                    'phone' => $customer->mobilenumber,
                    'address' => $customer->address,
                    'city' => $customer->city,
                    'state' => $customer->state,
                    'pincode' => $customer->pin,
                    'country' => $customer->country,
                ],
                'addresses' => $addresses
            ]);

        } catch (\Exception $e) {
            \Log::error('Checkout login error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Login failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate shipping charges based on state, subtotal, and cart weight
     */
    public function calculateShipping(Request $request)
    {
        try {
            $request->validate([
                'state' => 'required|string',
                'subtotal' => 'required|numeric|min:0'
            ]);

            $state = $request->state;
            $subtotal = $request->subtotal;
            $discount = $request->input('coupon_discount', 0);

            // Get cart items for weight calculation
            $cartItems = $this->getCartItems();

            $shippingCharge = $this->getShippingCharge($state, $subtotal, $cartItems, $discount);

            return response()->json([
                'success' => true,
                'shipping_charge' => $shippingCharge,
                'state' => $state
            ]);

        } catch (\Exception $e) {
            \Log::error('Calculate shipping error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate shipping',
                'shipping_charge' => 0
            ], 500);
        }
    }

    /**
     * Helper: Get cart items for the current user (logged in or guest)
     */
    private function getCartItems()
    {
        if (auth('customer')->check()) {
            $customerId = auth('customer')->id();
            $cartItems = Cart::where('customer_id', $customerId)
                ->where('status', 1)
                ->with('product')
                ->get();

            // Filter out items with null products
            return $cartItems->filter(function ($item) {
                return $item->product !== null;
            });
        } else {
            // Guest cart from session
            $cart = session()->get('guest_cart', []);
            $cartItems = collect([]);

            foreach ($cart as $cartKey => $item) {
                $productId = $item['product_id'] ?? $cartKey;
                $product = Product::find($productId);
                if ($product) {
                    $cartItem = (object) [
                        'id' => 'guest_' . $cartKey,
                        'product_id' => $productId,
                        'variant_id' => $item['variant_id'] ?? null,
                        'selected_weight' => $item['selected_weight'] ?? null,
                        'quantity' => $item['quantity'],
                        'price_at_add_time' => $item['price_at_add_time'],
                        'product' => $product
                    ];
                    $cartItems->push($cartItem);
                }
            }

            return $cartItems;
        }
    }

    /**
     * Helper: Get shipping charge based on state, subtotal, and cart items
     * Tamil Nadu: Uses price-based slab calculation
     * Other States: Uses weight-based slab calculation
     */
    private function getShippingCharge($state, $subtotal, $cartItems = null, $discount = 0)
    {
        \Log::info("=== Shipping Calculation Started ===");
        \Log::info("State: {$state}, Subtotal: {$subtotal}");

        // Find shipping zone for the state
        $region = ShippingZoneRegion::where('state', $state)
            ->where('is_active', 1)
            ->first();

        if (!$region) {
            \Log::info("No shipping region found for state: {$state}");
            return 0;
        }
        \Log::info("Found region: {$region->id}, Zone ID: {$region->shipping_zone_id}");

        $zone = ShippingZone::where('id', $region->shipping_zone_id)
            ->where('is_active', 1)
            ->first();

        if (!$zone) {
            \Log::info("No active shipping zone found for zone_id: {$region->shipping_zone_id}");
            return 0;
        }
        \Log::info("Found zone: {$zone->name} (ID: {$zone->id})");

        // Find shipping rule for this zone that applies to this state
        $rule = ShippingRule::where('shipping_zone_id', $zone->id)
            ->where('is_active', 1)
            ->whereJsonContains('states', $state)
            ->first();

        // If no state-specific rule found, try to get a generic rule for the zone
        if (!$rule) {
            \Log::info("No state-specific rule found, trying generic rule");
            $rule = ShippingRule::where('shipping_zone_id', $zone->id)
                ->where('is_active', 1)
                ->whereNull('states')
                ->first();
        }

        if (!$rule) {
            \Log::info("No shipping rule found for zone {$zone->id} and state {$state}");
            return 0;
        }
        \Log::info("Found rule ID: {$rule->id}, Condition Type: {$rule->condition_type}, States: " . json_encode($rule->states));

        // Determine calculation method based on rule's condition_type
        // 'weight' = weight-based slabs (in grams)
        // 'final_amount' or other = price-based slabs (in â‚¹)
        $conditionType = strtolower(trim($rule->condition_type ?? ''));
        $useWeightCalculation = ($conditionType === 'weight');

        // Weight-based calculation (slabs are in grams)
        if ($useWeightCalculation && $cartItems) {
            $totalWeight = $this->calculateTotalWeight($cartItems);

            // Find appropriate slab based on weight (in grams)
            $slab = ShippingRuleSlab::where('shipping_rule_id', $rule->id)
                ->where('min_slab', '<=', $totalWeight)
                ->where(function ($query) use ($totalWeight) {
                    $query->where('max_slab', '>=', $totalWeight)
                        ->orWhereNull('max_slab');
                })
                ->first();

            if ($slab) {
                return $slab->shipping_amount;
            }

            // If no slab matches, get the highest slab
            $highestSlab = ShippingRuleSlab::where('shipping_rule_id', $rule->id)
                ->orderBy('max_slab', 'desc')
                ->first();

            return $highestSlab ? $highestSlab->shipping_amount : 0;
        }

        // Price-based calculation for Tamil Nadu (uses amount after discount)
        // For other states if price-based, we use subtotal
        $calculationAmount = ($state === 'Tamil Nadu') ? ($subtotal - $discount) : $subtotal;

        \Log::info("Condition Type: {$conditionType}, Calculation Amount: {$calculationAmount} (Subtotal: {$subtotal}, Discount: {$discount})");

        $slab = ShippingRuleSlab::where('shipping_rule_id', $rule->id)
            ->where('min_slab', '<=', $calculationAmount)
            ->where(function ($query) use ($calculationAmount) {
                $query->where('max_slab', '>=', $calculationAmount)
                    ->orWhereNull('max_slab');
            })
            ->first();

        if ($slab) {
            return $slab->shipping_amount;
        }

        // If no slab matches, get the highest slab
        $highestSlab = ShippingRuleSlab::where('shipping_rule_id', $rule->id)
            ->orderBy('max_slab', 'desc')
            ->first();

        return $highestSlab ? $highestSlab->shipping_amount : 0;
    }

    /**
     * Helper: Parse weight string to grams
     * E.g., "250g" -> 250, "500g" -> 500, "1kg" -> 1000
     */
    private function parseWeight($weightString)
    {
        if (empty($weightString)) {
            return 0;
        }

        $weightString = strtolower(trim($weightString));

        // Handle kg format (e.g., "1kg", "1.5kg", "1 kg")
        if (preg_match('/(\d+(?:\.\d+)?)\s*kg/i', $weightString, $matches)) {
            return floatval($matches[1]) * 1000; // Convert to grams
        }

        // Handle grams format (e.g., "250g", "500g", "250 g")
        if (preg_match('/(\d+(?:\.\d+)?)\s*g/i', $weightString, $matches)) {
            return floatval($matches[1]);
        }

        // Fallback: try to extract just the number
        return floatval(preg_replace('/[^0-9.]/', '', $weightString));
    }

    /**
     * Helper: Calculate total weight of cart items in grams
     * Falls back to fetching weight from variant's quantity if selected_weight is empty
     */
    private function calculateTotalWeight($cartItems)
    {
        $totalWeight = 0;

        foreach ($cartItems as $item) {
            $weight = 0;

            // Strategy 1: Try to get weight from selected_weight field
            if (!empty($item->selected_weight)) {
                $weight = $this->parseWeight($item->selected_weight);
                if ($weight == 0) {
                    // It might be a text like "Jumbo Pack", try to find it in quantities and get its label (weight value)
                    $quantityDb = \App\Models\Quantity::where('name', $item->selected_weight)->first();
                    if ($quantityDb && !empty($quantityDb->label)) {
                        $weight = $this->parseWeight($quantityDb->label);
                    }
                }
            }

            // Strategy 2: If no weight found and we have variant_id, try to get from variant's quantity
            if ($weight == 0 && !empty($item->variant_id)) {
                $variant = \App\Models\ProductVariant::with('quantity')->find($item->variant_id);
                if ($variant && $variant->quantity) {
                    $valToParse = !empty($variant->quantity->label) ? $variant->quantity->label : $variant->quantity->name;
                    $weight = $this->parseWeight($valToParse ?? '');
                }
            }

            // Strategy 3: Try to get weight from product's default variant
            if ($weight == 0 && !empty($item->product_id)) {
                $product = \App\Models\Product::with('variants.quantity')->find($item->product_id);
                if ($product && $product->variants->count() > 0) {
                    $defaultVariant = $product->variants->first();
                    if ($defaultVariant && $defaultVariant->quantity) {
                        $valToParse = !empty($defaultVariant->quantity->label) ? $defaultVariant->quantity->label : $defaultVariant->quantity->name;
                        $weight = $this->parseWeight($valToParse ?? '');
                    }
                }
            }

            // Strategy 4: Default weight of 250g if no weight could be determined
            if ($weight == 0) {
                $weight = 250; // Default 250g per item
                \Log::info('Using default weight 250g for product: ' . ($item->product->productname ?? 'Unknown'));
            }

            $quantity = $item->quantity ?? 1;
            $totalWeight += $weight * $quantity;
        }

        \Log::info('Total cart weight calculated: ' . $totalWeight . 'g');
        return $totalWeight;
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        try {
            $request->validate([
                'coupon_code' => 'required|string',
                'subtotal' => 'required|numeric|min:0'
            ]);

            $code = strtoupper(trim($request->coupon_code));
            $subtotal = $request->subtotal;

            // Find coupon by code
            $coupon = Coupon::where('code', $code)->first();

            if (!$coupon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid coupon code'
                ], 400);
            }

            // Check if coupon is active
            if (!$coupon->status) {
                return response()->json([
                    'success' => false,
                    'message' => 'This coupon is not active'
                ], 400);
            }

            // Check start date
            if ($coupon->start_date && now()->lt($coupon->start_date)) {
                return response()->json([
                    'success' => false,
                    'message' => 'This coupon is not yet valid'
                ], 400);
            }

            // Check expiry date
            if ($coupon->end_date && now()->gt($coupon->end_date)) {
                return response()->json([
                    'success' => false,
                    'message' => 'This coupon has expired'
                ], 400);
            }

            // Check minimum cart value
            if ($coupon->min_amount && $subtotal < $coupon->min_amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Minimum order amount of â‚¹' . number_format($coupon->min_amount, 2) . ' required'
                ], 400);
            }

            // Check usage limit
            if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
                return response()->json([
                    'success' => false,
                    'message' => 'This coupon has reached its usage limit'
                ], 400);
            }

            // Check per-user limit (one user can use this coupon only N times)
            if ($coupon->per_user_limit) {
                $customerId = auth('customer')->id();
                if ($customerId) {
                    $userUsage = \DB::table('coupon_user')
                        ->where('coupon_id', $coupon->id)
                        ->where('user_id', $customerId)
                        ->count();

                    if ($userUsage >= $coupon->per_user_limit) {
                        return response()->json([
                            'success' => false,
                            'message' => 'You have already used this coupon the maximum number of times allowed.'
                        ], 400);
                    }
                }
            }

            // Calculate discount
            $discount = 0;
            if ($coupon->type === 'percentage') {
                $discount = ($subtotal * $coupon->value) / 100;
                // Apply max discount cap if set
                if ($coupon->max_discount && $discount > $coupon->max_discount) {
                    $discount = $coupon->max_discount;
                }
            } else {
                // Fixed discount
                $discount = $coupon->value;
                // Don't allow discount greater than subtotal
                if ($discount > $subtotal) {
                    $discount = $subtotal;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Coupon applied successfully!',
                'coupon' => [
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'discount' => round($discount, 2),
                    'description' => $coupon->description
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Apply coupon error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to apply coupon'
            ], 500);
        }
    }

    /**
     * Remove applied coupon
     */
    public function removeCoupon(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully'
        ]);
    }

    /**
     * Create Razorpay order for online payment
     */
    public function createRazorpayOrder(Request $request)
    {
        try {
            try {
                $request->validate([
                    'fname' => 'required|string',
                    'lname' => 'required|string',
                    'email' => 'required|email',
                    'phone' => 'required|string',
                    'billing_address' => 'required|string',
                    'city' => 'required|string',
                    'state' => 'required|string',
                    'zipcode' => 'required|string',
                    'ship_to_different' => 'sometimes|boolean',
                ]);
            } catch (\Illuminate\Validation\ValidationException $ve) {
                \Log::error('Razorpay Order Validation Failed: ' . json_encode($ve->errors()));
                throw $ve;
            }


            // Build billing address
            $billingData = [
                'name' => $request->fname . ' ' . $request->lname,
                'address' => $request->billing_address,
                'address2' => $request->input('billing_address2', ''),
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->zipcode,
                'phone' => $request->phone,
                'email' => $request->email,
            ];

            // Determine shipping address
            $shipToDifferent = $request->input('ship_to_different', 0);

            if ($shipToDifferent) {
                $shippingData = [
                    'title' => $request->shipping_title,
                    'name' => $billingData['name'],
                    'address' => $request->shipping_address,
                    'city' => $request->shipping_city,
                    'state' => $request->shipping_state,
                    'pincode' => $request->shipping_pincode,
                    'phone' => $request->shipping_phone,
                    'email' => $request->email,
                ];
            } else {
                $shippingData = $billingData;
            }

            // Get cart items
            if (auth('customer')->check()) {
                $customerId = auth('customer')->id();
                $cartItems = Cart::where('customer_id', $customerId)
                    ->where('status', 1)
                    ->with('product')
                    ->get();
                $customerType = 'registered';
                $customerTypeInt = 1;
            } else {
                $cart = session()->get('guest_cart', []);
                if (empty($cart)) {
                    return response()->json(['success' => false, 'message' => 'Your cart is empty'], 422);
                }

                $cartItems = collect([]);
                foreach ($cart as $cartKey => $item) {
                    $productId = $item['product_id'] ?? $cartKey;
                    $product = Product::find($productId);
                    if ($product) {
                        $cartItem = (object) [
                            'product_id' => $productId,
                            'variant_id' => $item['variant_id'] ?? null,
                            'selected_weight' => $item['selected_weight'] ?? null,
                            'quantity' => $item['quantity'],
                            'price_at_add_time' => $item['price_at_add_time'],
                            'product' => $product
                        ];
                        $cartItems->push($cartItem);
                    }
                }
                $customerId = null;
                $customerType = 'guest';
                $customerTypeInt = 0;
            }

            if ($cartItems->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Your cart is empty'], 422);
            }

            // Calculate subtotal
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price_at_add_time * $item->quantity;
            });

            // Get coupon discount
            $couponCode = $request->input('coupon_code', null);
            $couponDiscount = $request->input('coupon_discount', 0);

            // Calculate shipping charges
            $shippingCharge = $this->getShippingCharge($shippingData['state'], $subtotal, $cartItems, $couponDiscount);

            // Calculate final amounts
            $totalAmount = $subtotal + $shippingCharge;
            $finalAmount = $totalAmount - $couponDiscount;

            $orderId = session('active_checkout_order_id');
            $order = null;
            if ($orderId) {
                $order = Order::find($orderId);
            }

            if ($order) {
                $orderNumber = $order->order_number;
            } else {
                // Generate sequential order number (A + digits starting from 6001)
                $latestOrder = Order::where('order_number', 'LIKE', 'A%')
                    ->whereRaw('LENGTH(order_number) >= 5')
                    ->orderBy('id', 'desc')
                    ->first();

                $nextId = 6001;
                if ($latestOrder) {
                    // Extract number from Axxxx (remove first 1 chars)
                    $lastNumber = (int) substr($latestOrder->order_number, 1);
                    $nextId = max(6001, $lastNumber + 1);
                }

                $orderNumber = 'A' . $nextId;

                // Create the order with 'not_paid' status
                $order = Order::create([
                    'order_number' => $orderNumber,
                    'order_type' => 'frontend',
                    'order_source' => 'web',
                    'customer_id' => $customerId,
                    'customer_type' => $customerType,
                    'shipping_address' => [],
                    'billing_address' => [],
                    'payment_method' => 'online_gateway', // Default for drafts
                ]);
            }

            // Sync/Update the order details
            $order->update([
                'guest_details' => $customerType === 'guest' ? [
                    'name' => $billingData['name'],
                    'email' => $request->email,
                    'phone' => $request->phone,
                ] : null,
                'shipping_address' => $shippingData,
                'billing_address' => $billingData,
                'billing_type' => $shipToDifferent ? 'different' : 'same',
                'payment_method' => 'online_gateway',
                'payment_status' => 'not_paid',
                'subtotal' => $subtotal,
                'discount_amount' => $couponDiscount,
                'coupon_code' => $couponCode,
                'tax_amount' => 0,
                'shipping_amount' => $shippingCharge,
                'total_amount' => $totalAmount,
                'final_amount' => $finalAmount,
                'status' => 'pending',
                'placed_at' => now(),
                'notes' => $request->input('notes', null),
                'created_by_type' => 'customer',
                'created_by_id' => $customerId,
            ]);

            // Note: We don't clear session('active_checkout_order_id') here yet
            // because if the payment modal is closed, we still want to keep the same draft.
            // It will be cleared in verifyRazorpayPayment or if a NEW order is started.

            // Re-sync order items
            $order->items()->delete();
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->variant_id ?? null,
                    'product_productname' => $item->product->productname,
                    'variant_name' => $item->selected_weight ?? null,
                    'price' => $item->price_at_add_time,
                    'qty' => $item->quantity,
                    'total' => $item->price_at_add_time * $item->quantity,
                ]);
            }

            // Amount in paise
            $amountInPaise = (int) round($finalAmount * 100);

            // Create Razorpay order
            $keyId = config('razorpay.key_id');
            $keySecret = config('razorpay.key_secret');

            $orderData = [
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'receipt' => $orderNumber,
                'description' => 'Payment for Order #' . $orderNumber,
                'notes' => [
                    'order_id' => $order->id,
                    'order_number' => $orderNumber,
                    'customer_name' => ($request->fname . ' ' . $request->lname),
                    'customer_email' => $request->email,
                    'customer_phone' => $request->phone,
                    'site' => 'Chennai Angadi'
                ]
            ];

            $ch = curl_init('https://api.razorpay.com/v1/orders');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $keyId . ':' . $keySecret);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200) {
                $order->update(['status' => 'failed', 'notes' => 'Razorpay order creation failed: ' . $response]);
                \Log::error('Razorpay order creation failed: ' . $response);
                return response()->json(['success' => false, 'message' => 'Failed to create payment order'], 500);
            }

            $razorpayOrder = json_decode($response, true);
            
            // Update order with razorpay_order_id
            $order->update(['razorpay_order_id' => $razorpayOrder['id']]);

            return response()->json([
                'success' => true,
                'razorpay_order_id' => $razorpayOrder['id'],
                'razorpay_key_id' => $keyId,
                'amount' => $amountInPaise,
                'amount_display' => $finalAmount,
                'currency' => 'INR',
                'customer_name' => $request->fname . ' ' . $request->lname,
                'customer_email' => $request->email,
                'customer_phone' => $request->phone,
                'order_id' => $order->id,
                'order_number' => $orderNumber
            ]);

        } catch (\Exception $e) {
            \Log::error('Create Razorpay order error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
    /**
     * Verify Razorpay payment and place order
     */
    public function verifyRazorpayPayment(Request $request)
    {
        try {
            $request->validate([
                'razorpay_order_id' => 'required|string',
                'razorpay_payment_id' => 'required|string',
                'razorpay_signature' => 'required|string',
            ]);

            // Verify signature
            $keySecret = config('razorpay.key_secret');
            $expectedSignature = hash_hmac(
                'sha256',
                $request->razorpay_order_id . '|' . $request->razorpay_payment_id,
                $keySecret
            );

            if ($expectedSignature !== $request->razorpay_signature) {
                \Log::error('Razorpay signature verification failed');
                return response()->json(['success' => false, 'message' => 'Payment verification failed'], 400);
            }

            // Find the existing order
            $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();

            if (!$order) {
                \Log::error('Order not found for Razorpay Order ID: ' . $request->razorpay_order_id);
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }

            // Update the order with payment details
            $order->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'payment_status' => 'paid',
                'status' => 'processing',
                'placed_at' => now(),
            ]);

            // Save shipping address to address_book for registered customers if not already there
            if ($order->customer_type === 'registered' && $order->customer_id) {
                $shippingData = $order->shipping_address;
                $existingAddress = AddressBook::where('customer_id', $order->customer_id)
                    ->where('address', $shippingData['address'])
                    ->where('city', $shippingData['city'])
                    ->where('state', $shippingData['state'])
                    ->where('pincode', $shippingData['pincode'])
                    ->first();

                if (!$existingAddress) {
                    AddressBook::create([
                        'customer_id' => $order->customer_id,
                        'customer_type' => ($order->customer_type === 'registered' ? 1 : 0),
                        'title' => $shippingData['title'] ?? 'Shipping Address',
                        'phone' => $shippingData['phone'],
                        'email' => $shippingData['email'] ?? null,
                        'address' => $shippingData['address'],
                        'city' => $shippingData['city'],
                        'state' => $shippingData['state'],
                        'pincode' => $shippingData['pincode'],
                        'country' => 'India',
                        'is_default' => 0,
                        'status' => 1,
                    ]);
                }
            }

            // Clear the cart
            if (auth('customer')->check()) {
                Cart::where('customer_id', $order->customer_id)
                    ->where('status', 1)
                    ->delete();
            } else {
                session()->forget('guest_cart');
                
            }

            // Send order confirmation email
            try {
                $recipientEmail = $order->customer_type === 'guest' ? ($order->guest_details['email'] ?? null) : ($order->customer?->email);
                if ($recipientEmail) {
                    \Mail::to($recipientEmail)->send(new \App\Mail\OrderPlaced($order));
                }

                // Send Admin Notification Email for Online Payment Success
                if (config('app.admin_email')) {
                    $order->load('items');
                    \Mail::to(config('app.admin_email'))->send(new AdminOrderNotification($order));
                    \Log::info('Admin order notification sent for successful online payment', ['order' => $order->order_number]);
                }
            } catch (\Exception $emailError) {
                \Log::error('Order email failed: ' . $emailError->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment verified and order placed successfully!',
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'order_total' => $order->final_amount,
                'shipping_charge' => $order->shipping_amount,
            ]);

        } catch (\Exception $e) {
            \Log::error('Verify Razorpay payment error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Track order by order number
     * Returns order details including notes
     */
    public function trackOrder(Request $request)
    {
        try {
            $request->validate([
                'order_number' => 'required|string'
            ]);

            $orderNumber = strtoupper(trim($request->order_number));

            // Remove leading '#' if present
            if (substr($orderNumber, 0, 1) === '#') {
                $orderNumber = substr($orderNumber, 1);
            }

            // Find order by order number
            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found. Please check the order number and try again.'
                ], 404);
            }

            // Format the placed_at date
            $placedAt = $order->placed_at ? $order->placed_at->format('d M Y, h:i A') : 'N/A';

            return response()->json([
                'success' => true,
                'message' => 'Order found!',
                'order' => [
                    'order_number' => $order->order_number,
                    'status' => $order->status,
                    'placed_at' => $placedAt,
                    'subtotal' => $order->subtotal,
                    'shipping_amount' => $order->shipping_amount,
                    'discount_amount' => $order->discount_amount,
                    'final_amount' => $order->final_amount,
                    'notes' => $order->notes,
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Track order error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to track order. Please try again.'
            ], 500);
        }
    }

    /**
     * Save a draft order via AJAX before final submission
     */
    public function saveDraftOrder(Request $request)
    {
        try {
            // Minimum requirements to save a draft: Email
            if (!$request->email) {
                return response()->json(['success' => false, 'message' => 'Email is required'], 422);
            }

            // Get cart items
            if (auth('customer')->check()) {
                $customerId = auth('customer')->id();
                $cartItems = Cart::where('customer_id', $customerId)
                    ->where('status', 1)
                    ->with('product')
                    ->get();
                $customerType = 'registered';
            } else {
                $cart = session()->get('guest_cart', []);
                if (empty($cart)) {
                    return response()->json(['success' => false, 'message' => 'Cart is empty'], 422);
                }

                $cartItems = collect([]);
                foreach ($cart as $cartKey => $item) {
                    $productId = $item['product_id'] ?? $cartKey;
                    $product = Product::find($productId);
                    if ($product) {
                        $cartItems->push((object) [
                            'product_id' => $productId,
                            'variant_id' => $item['variant_id'] ?? null,
                            'selected_weight' => $item['selected_weight'] ?? null,
                            'price_at_add_time' => $item['price_at_add_time'],
                            'quantity' => $item['quantity'],
                            'product' => $product
                        ]);
                    }
                }
                $customerId = null;
                $customerType = 'guest';
            }

            if ($cartItems->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Cart is items are invalid'], 422);
            }

            // Calculate subtotal
            $subtotal = $cartItems->sum(function ($item) {
                return $item->price_at_add_time * $item->quantity;
            });

            // Extract and calculate shipping, coupon discount, COD charge from request
            $paymentOption = $request->input('payment_option', 'online_gateway');
            $couponCode = $request->input('coupon_code', null);
            $couponDiscount = floatval($request->input('coupon_discount', 0));
            $codCharge = floatval($request->input('cod_charge', 0));
            $shippingCharge = floatval($request->input('shipping_amount', 0));

            // Fallback for shipping if not provided in request but state exists
            if ($shippingCharge === 0.0 && $request->state) {
                $shippingCharge = $this->getShippingCharge($request->state, $subtotal, $cartItems, $couponDiscount);
            }

            // Fallback for COD charge if payment method is cash_on_delivery and not provided
            if ($codCharge === 0.0 && $paymentOption === 'cash_on_delivery') {
                $codCharge = 75.0; // Flat ₹75 COD charge
            }

            $totalAmount = $subtotal + $shippingCharge + $codCharge;
            $finalAmount = $totalAmount - $couponDiscount;

            $fname = $request->input('fname', '');
            $lname = $request->input('lname', '');
            $billingData = [
                'name' => trim($fname . ' ' . $lname),
                'email' => $request->email,
                'phone' => $request->input('phone', ''),
                'address' => $request->input('address', ''),
                'address2' => $request->input('address2', ''),
                'city' => $request->input('city', ''),
                'state' => $request->input('state', ''),
                'pincode' => $request->input('pincode', ''),
                'country' => 'India',
            ];

            $orderId = session('active_checkout_order_id');
            $order = null;

            if ($orderId) {
                $order = Order::find($orderId);
                // If order was already processed (e.g. status not pending), start a new draft
                if ($order && !in_array($order->status, ['pending', 'failed'])) {
                    $order = null;
                    session()->forget('active_checkout_order_id');
                }
            }

            if (!$order) {
                // Generate sequential order number (CA + 5 digits)
                $latestOrder = Order::where('order_number', 'LIKE', 'CA%')
                    ->whereRaw('LENGTH(order_number) = 7')
                    ->orderBy('id', 'desc')
                    ->first();

                $nextId = 1;
                if ($latestOrder) {
                    $lastNumber = (int) substr($latestOrder->order_number, 2);
                    $nextId = $lastNumber + 1;
                }
                $orderNumber = 'CA' . str_pad($nextId, 5, '0', STR_PAD_LEFT);

                $order = Order::create([
                    'order_number' => $orderNumber,
                    'order_type' => 'frontend',
                    'order_source' => 'web',
                    'customer_type' => $customerType,
                    'customer_id' => $customerId,
                    'payment_status' => ($paymentOption === 'cash_on_delivery') ? 'cod' : 'not_paid',
                    'status' => 'pending',
                    'payment_method' => $paymentOption,
                    'shipping_address' => [],
                    'billing_address' => [],
                    'placed_at' => now(),
                ]);
                session(['active_checkout_order_id' => $order->id]);
            }

            // Sync main order details
            $order->update([
                'guest_details' => $customerType === 'guest' ? [
                    'name' => $billingData['name'],
                    'email' => $request->email,
                    'phone' => $request->phone,
                ] : null,
                'shipping_address' => $billingData, // Use billing for both in draft
                'billing_address' => $billingData,
                'payment_method' => $paymentOption,
                'payment_status' => ($paymentOption === 'cash_on_delivery') ? 'cod' : 'not_paid',
                'subtotal' => $subtotal,
                'discount_amount' => $couponDiscount,
                'coupon_code' => $couponCode,
                'shipping_amount' => $shippingCharge,
                'cod_charge' => $codCharge,
                'total_amount' => $totalAmount,
                'final_amount' => $finalAmount,
                'notes' => $request->input('notes', null),
                'created_by_id' => $customerId,
            ]);

            // Sync Order Items (Delete and Recreate is easier for draft sync)
            $order->items()->delete();
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->variant_id ?? null,
                    'product_productname' => $item->product->productname,
                    'variant_name' => $item->selected_weight ?? null,
                    'price' => $item->price_at_add_time,
                    'qty' => $item->quantity,
                    'total' => $item->price_at_add_time * $item->quantity,
                ]);
            }

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);

        } catch (\Exception $e) {
            \Log::error('Save draft order error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
