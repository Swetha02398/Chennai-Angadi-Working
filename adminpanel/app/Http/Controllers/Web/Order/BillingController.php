<?php

namespace App\Http\Controllers\Web\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\InvoiceMail;
use Razorpay\Api\Api;
use App\Models\ShippingRule;
use App\Models\ShippingRuleSlab;
use App\Mail\AdminOrderNotification;

class BillingController extends Controller
{
    /**
     * Show billing table (order list)
     */
    public function index(Request $request)
    {
        $query = Order::where('order_type', 'billing')
            ->with(['customer', 'items'])
            ->orderBy('id', 'desc');

        // SEARCH
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('order_number', 'LIKE', "%{$search}%")
                    ->orWhereHas('customer', function ($cq) use ($search) {
                        $cq->where('username', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%")
                            ->orWhere('mobilenumber', 'LIKE', "%{$search}%");
                    });
            });
        }

        // STATUS FILTER (Order Status: confirmed, pending, etc.)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // PAYMENT STATUS FILTER
        if ($request->filled('payment_status')) {
            if ($request->payment_status === 'cod') {
                $query->whereIn('payment_method', ['cash_on_delivery', 'cod']);
            } elseif ($request->payment_status === 'paid') {
                $query->where('payment_status', 'paid');
            } elseif ($request->payment_status === 'not_paid') {
                $query->where('payment_status', '!=', 'paid')
                      ->whereNotIn('payment_method', ['cash_on_delivery', 'cod']);
            }
        }

        // DATE FILTER
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('order.billing-table', [
            'orders' => $orders,
            'search' => $request->search,
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'date' => $request->date,
        ]);
    }


    /**
     * Show POS billing screen
     */
    public function create()
    {
        $products = Product::with(['variants.quantity', 'maincategory'])->get();
        $customers = \App\Models\Customer::where('status', 1)
            ->select('id', 'username', 'email', 'mobilenumber')
            ->orderBy('username', 'asc')
            ->get();

        return view('order.billing-create', compact('products', 'customers'));
    }

    /**
     * Get product tax data (AJAX)
     */
    public function getProductTax($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'hsn' => $product->hsn,
                'gst' => $product->gst,
                'sgst' => $product->sgst,
                'igst' => $product->igst,
            ]
        ]);
    }
    /**
     * Calculate Shipping (AJAX) - Based on State and Order Amount
     */
    public function calculateShipping(Request $request)
    {
        $state = $request->input('state');
        $orderTotal = $request->input('order_total', 0);
        $totalWeight = $request->input('total_weight', 0);

        if (!$state) {
            return response()->json([
                'success' => false,
                'message' => 'State is required',
                'shipping_amount' => 0
            ]);
        }

        // Find active shipping rule for the selected state
        $shippingRule = ShippingRule::where('is_active', 1)
            ->whereJsonContains('states', $state)
            ->with('slabs')
            ->first();

        if (!$shippingRule) {
            return response()->json([
                'success' => false,
                'message' => 'No shipping rule found for ' . $state,
                'shipping_amount' => 0
            ]);
        }

        // Determine the condition value based on condition_type
        $conditionType = $shippingRule->condition_type;
        // For 'weight' use weight, for 'final_amount' or 'price' use order total
        $conditionValue = ($conditionType === 'weight') ? $totalWeight : $orderTotal;

        // Debug log
        \Log::info('Shipping calculation', [
            'state' => $state,
            'condition_type' => $conditionType,
            'order_total' => $orderTotal,
            'condition_value' => $conditionValue,
            'rule_id' => $shippingRule->id
        ]);

        // Find the matching slab
        $matchingSlab = $shippingRule->slabs()
            ->where('min_slab', '<=', $conditionValue)
            ->where('max_slab', '>=', $conditionValue)
            ->first();

        if (!$matchingSlab) {
            // If no exact slab found, get the highest slab
            $matchingSlab = $shippingRule->slabs()->orderBy('max_slab', 'desc')->first();
        }

        $shippingAmount = $matchingSlab ? $matchingSlab->shipping_amount : 0;

        return response()->json([
            'success' => true,
            'shipping_amount' => $shippingAmount,
            'condition_type' => $conditionType,
            'zone' => $shippingRule->zone->name ?? 'N/A',
            'rule_id' => $shippingRule->id
        ]);
    }

    /**
     * Get available states for shipping (AJAX)
     */
    public function getShippingStates()
    {
        // Get all unique states from active shipping rules
        $rules = ShippingRule::where('is_active', 1)->get();
        $states = [];

        foreach ($rules as $rule) {
            if (is_array($rule->states)) {
                foreach ($rule->states as $state) {
                    if (!in_array($state, $states)) {
                        $states[] = $state;
                    }
                }
            }
        }

        sort($states);

        return response()->json([
            'success' => true,
            'states' => $states
        ]);
    }

    /**
     * Apply Coupon Code (AJAX)
     */
    public function applyCoupon(Request $request)
    {
        $code = strtoupper(trim($request->input('code')));
        $subtotal = $request->input('subtotal', 0);

        if (!$code) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a coupon code'
            ]);
        }

        // Find active coupon
        $coupon = \App\Models\Coupon::where('code', $code)
            ->where('status', 1)
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code'
            ]);
        }

        // Check dates
        $now = now();
        if ($coupon->start_date && $now < $coupon->start_date) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon is not yet active'
            ]);
        }
        if ($coupon->end_date && $now > $coupon->end_date) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon has expired'
            ]);
        }

        // Check usage limit
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon usage limit reached'
            ]);
        }

        // Check per-user limit
        $customerId = $request->input('customer_id');
        if ($coupon->per_user_limit && $customerId) {
            $userUsage = \DB::table('coupon_user')
                ->where('coupon_id', $coupon->id)
                ->where('user_id', $customerId)
                ->count();

            if ($userUsage >= $coupon->per_user_limit) {
                return response()->json([
                    'success' => false,
                    'message' => 'This customer has already used this coupon the maximum number of times allowed.'
                ]);
            }
        }

        // Check minimum amount
        if ($coupon->min_amount && $subtotal < $coupon->min_amount) {
            return response()->json([
                'success' => false,
                'message' => 'Minimum order amount is ₹' . number_format($coupon->min_amount, 2)
            ]);
        }

        // Calculate discount
        $discount = 0;
        if ($coupon->type === 'fixed') {
            $discount = $coupon->value;
        } else if ($coupon->type === 'percentage') {
            $discount = ($subtotal * $coupon->value / 100);
            // Apply max discount cap
            if ($coupon->max_discount && $discount > $coupon->max_discount) {
                $discount = $coupon->max_discount;
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'discount' => round($discount, 2),
            'coupon_code' => $coupon->code,
            'coupon_type' => $coupon->type,
            'coupon_value' => $coupon->value
        ]);
    }

    /**
     * Get product variants (AJAX)
     */
    public function variants($id)
    {
        $product = Product::with('variants.quantity')->findOrFail($id);
        $variants = $product->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'name' => $variant->quantity ? $variant->quantity->label : '',
                'price' => $variant->sell_price,
                'stock' => $variant->stock,
                'stock_status' => $variant->stock_status,
            ];
        });

        return response()->json([
            'success' => true,
            'variants' => $variants
        ]);
    }

    /**
     * Checkout / Create Order
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'customer_type' => 'required|in:registered,guest',
            'customer_id' => 'nullable|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.variant_id' => 'nullable|exists:product_variants,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'subtotal' => 'required|numeric',
            'final_amount' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            // Customer handling
            $customerData = $this->prepareCustomerData($request);

            // Tax and Shipping handling
            $taxAmount = 0;
            $shippingAmount = 0;

            if ($request->has('tax_data') && isset($request->tax_data['enabled']) && $request->tax_data['enabled']) {
                $taxAmount = $request->tax_data['total'] ?? 0;
            }

            if ($request->has('shipping_data') && isset($request->shipping_data['enabled']) && $request->shipping_data['enabled']) {
                $shippingAmount = $request->shipping_data['amount'] ?? 0;
            }

            $subtotal = $request->subtotal;
            $finalAmount = $request->final_amount;

            // Discount and coupon handling
            $discountAmount = $request->input('discount_amount', 0);
            $couponCode = $request->input('coupon_code', null);

            // Payment options from checkout modal
            $billingType = $request->input('billing_type', 'offline');
            $paymentMethod = $request->input('payment_method', 'cash');
            $paymentProvider = $request->input('payment_provider', 'cash');

            // Determine payment status - pending for online payments, paid for cash
            $paymentStatus = ($paymentMethod === 'cash') ? 'paid' : 'not_paid';
            $orderStatus = ($paymentMethod === 'cash') ? 'confirmed' : 'pending';

            // Check for existing draft order
            $orderId = $request->input('order_id');
            $order = null;
            if ($orderId) {
                $order = Order::find($orderId);
            }

            if ($order) {
                // Update existing order
                $order->update([
                    'customer_type' => $request->customer_type,
                    'customer_id' => $customerData['customer_id'],
                    'guest_details' => $customerData['guest_details'],
                    'shipping_address' => $customerData['shipping_address'],
                    'billing_address' => $customerData['billing_address'],
                    'billing_type' => $billingType,
                    'payment_method' => $paymentMethod,
                    'payment_provider' => $paymentProvider,
                    'payment_status' => $paymentStatus,
                    'subtotal' => $subtotal,
                    'discount_amount' => $discountAmount,
                    'tax_amount' => $taxAmount,
                    'shipping_amount' => $shippingAmount,
                    'total_amount' => $finalAmount,
                    'final_amount' => $finalAmount,
                    'status' => $orderStatus,
                    'placed_at' => now(),
                ]);

                // Clear existing items to refresh them
                $order->items()->delete();
            } else {
                // Create new order
                $order = Order::create([
                    'order_number' => $this->generateOrderNumber(),
                    'order_type' => 'billing',
                    'order_source' => 'admin_panel',
                    'customer_type' => $request->customer_type,
                    'customer_id' => $customerData['customer_id'],
                    'guest_details' => $customerData['guest_details'],
                    'shipping_address' => $customerData['shipping_address'],
                    'billing_address' => $customerData['billing_address'],
                    'billing_type' => $billingType,
                    'payment_method' => $paymentMethod,
                    'payment_provider' => $paymentProvider,
                    'payment_status' => $paymentStatus,
                    'subtotal' => $subtotal,
                    'discount_amount' => $discountAmount,
                    'tax_amount' => $taxAmount,
                    'shipping_amount' => $shippingAmount,
                    'total_amount' => $finalAmount,
                    'final_amount' => $finalAmount,
                    'status' => $orderStatus,
                    'placed_at' => now(),
                ]);
            }

            // Create order items
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $variant = isset($item['variant_id']) ? ProductVariant::find($item['variant_id']) : null;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['variant_id'] ?? null,
                    'product_productname' => $item['product_name'],
                    'variant_name' => $item['variant_name'] ?? null,
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'total' => $item['price'] * $item['qty'],
                ]);

                // Update stock
                if ($variant) {
                    $variant->stock = max(0, $variant->stock - $item['qty']);
                    // Update stock status based on remaining stock
                    $variant->stock_status = $variant->stock > 0 ? 'in_stock' : 'out_of_stock';
                    $variant->save();
                }
            }

            DB::commit();

            // Track coupon usage: increment global count & record per-user usage
            if ($couponCode) {
                $usedCoupon = \App\Models\Coupon::where('code', $couponCode)->first();
                if ($usedCoupon) {
                    $usedCoupon->increment('used_count');

                    // Record per-user usage for registered customers
                    $billingCustomerId = $customerData['customer_id'] ?? null;
                    if ($billingCustomerId) {
                        DB::table('coupon_user')->insert([
                            'coupon_id'  => $usedCoupon->id,
                            'user_id'    => $billingCustomerId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // Dispatch OrderPlaced event for invoice email - for all offline payment methods

            // Online payments will dispatch after successful Razorpay payment
            if (in_array($paymentMethod, ['cash', 'upi', 'card'])) {
                event(new \App\Events\OrderPlaced($order));
                
                // Send Admin Notification Email
                try {
                    $adminEmail = config('app.admin_email') 
                        ?? User::where('role', 'superadmin')->value('email') 
                        ?? User::where('role', 'admin')->value('email')
                        ?? 'care@chennaiangadi.com';
                        
                    Mail::to($adminEmail)->send(new AdminOrderNotification($order));
                    Log::info('Admin order notification sent from POS', ['order' => $order->order_number]);
                } catch (\Exception $e) {
                    Log::error('Failed to send admin notification from POS', ['error' => $e->getMessage()]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'requires_payment' => ($paymentMethod !== 'cash'), // Flag for frontend to open Razorpay
                'payment_method' => $paymentMethod
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Billing checkout failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Order creation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save draft order (called in background from POS)
     */
    public function saveDraft(Request $request)
    {
        $request->validate([
            'customer_type' => 'required|string|in:guest,registered',
            'items' => 'required|array',
            'final_amount' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $customerData = $this->prepareCustomerData($request);
            $finalAmount = $request->final_amount;
            $subtotal = $request->input('subtotal', $finalAmount);
            
            $orderId = $request->input('order_id');
            $order = null;
            if ($orderId) {
                $order = Order::find($orderId);
            }

            if ($order) {
                // Update existing draft
                $order->update([
                    'customer_id' => $customerData['customer_id'],
                    'guest_details' => $customerData['guest_details'],
                    'shipping_address' => $customerData['shipping_address'],
                    'billing_address' => $customerData['billing_address'],
                    'subtotal' => $subtotal,
                    'final_amount' => $finalAmount,
                    'total_amount' => $finalAmount,
                    'payment_status' => 'not_paid',
                ]);
                
                // Refresh items
                $order->items()->delete();
            } else {
                // Create new draft
                $order = Order::create([
                    'order_number' => $this->generateOrderNumber(),
                    'order_type' => 'billing',
                    'order_source' => 'admin_panel',
                    'customer_type' => $request->customer_type,
                    'customer_id' => $customerData['customer_id'],
                    'guest_details' => $customerData['guest_details'],
                    'shipping_address' => $customerData['shipping_address'],
                    'billing_address' => $customerData['billing_address'],
                    'payment_method' => 'online_gateway', // Default for drafts
                    'payment_status' => 'not_paid',
                    'subtotal' => $subtotal,
                    'final_amount' => $finalAmount,
                    'total_amount' => $finalAmount,
                    'status' => 'pending',
                ]);
            }

            // Create order items
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['variant_id'] ?? null,
                    'product_productname' => $item['product_name'],
                    'variant_name' => $item['variant_name'] ?? null,
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'total' => $item['price'] * $item['qty'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Draft save failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Draft save failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update payment status after Razorpay success
     */
    public function updatePaymentStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'razorpay_payment_id' => 'required|string',
            'status' => 'required|in:paid,failed',
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($request->status === 'paid') {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
                'razorpay_payment_id' => $request->razorpay_payment_id,
            ]);

            // Dispatch OrderPlaced event for invoice email
            event(new \App\Events\OrderPlaced($order));

            // Send Admin Notification Email for Online Payment Success
            try {
                $adminEmail = config('app.admin_email') 
                    ?? User::where('role', 'superadmin')->value('email') 
                    ?? User::where('role', 'admin')->value('email')
                    ?? 'care@chennaiangadi.com';
                    
                Mail::to($adminEmail)->send(new AdminOrderNotification($order));
                Log::info('Admin order notification sent from POS (Online Payment)', ['order' => $order->order_number]);
            } catch (\Exception $e) {
                Log::error('Failed to send admin notification from POS (Online Payment)', ['error' => $e->getMessage()]);
            }
        } else {
            $order->update([
                'payment_status' => 'failed',
                'razorpay_payment_id' => $request->razorpay_payment_id,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment status updated'
        ]);
    }

    /**
     * Create Razorpay Order (API) - Called before opening Razorpay checkout
     */
    public function createRazorpayOrderAPI(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'order_id' => 'required|exists:orders,id',
        ]);

        try {
            $order = Order::findOrFail($request->order_id);
            $amount = $request->amount;

            // Create Razorpay order
            $razorpayOrderId = $this->createRazorpayOrder($amount, $order->order_number, $order->id);

            // Store Razorpay order ID in our order
            $order->update(['razorpay_order_id' => $razorpayOrderId]);

            // Get customer details for prefill
            $prefillData = [
                'name' => '',
                'email' => '',
                'contact' => ''
            ];

            if ($order->customer_type === 'registered' && $order->customer) {
                $prefillData['name'] = $order->customer->username ?? '';
                $prefillData['email'] = $order->customer->email ?? '';
                $prefillData['contact'] = $order->customer->mobilenumber ?? '';
            } elseif ($order->customer_type === 'guest' && $order->guest_details) {
                $guest = $order->guest_details;
                $prefillData['name'] = $guest['first_name'] ?? $guest['name'] ?? '';
                $prefillData['email'] = $guest['email'] ?? '';
                $prefillData['contact'] = $guest['phone'] ?? '';
            }

            return response()->json([
                'success' => true,
                'razorpay_order_id' => $razorpayOrderId,
                'razorpay_key' => config('services.razorpay.key'),
                'amount' => $amount * 100, // in paisa
                'currency' => 'INR',
                'order_number' => $order->order_number,
                'prefill' => $prefillData
            ]);

        } catch (\Exception $e) {
            Log::error('Razorpay order creation failed', [
                'error' => $e->getMessage(),
                'order_id' => $request->order_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create payment order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify Razorpay Payment Signature (Security)
     * This verifies that the payment response actually came from Razorpay
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            // Verify signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Signature valid - update order
            $order = Order::findOrFail($request->order_id);
            $order->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
            ]);

            // Dispatch OrderPlaced event for invoice email
            event(new \App\Events\OrderPlaced($order));

            Log::info('Razorpay payment verified successfully', [
                'order_id' => $order->id,
                'razorpay_payment_id' => $request->razorpay_payment_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully',
                'order_number' => $order->order_number
            ]);

        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            Log::error('Razorpay signature verification failed', [
                'order_id' => $request->order_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed: Invalid signature'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Payment verification error', [
                'order_id' => $request->order_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show invoice
     */
    public function invoice($id)
    {
        $order = Order::with(['customer', 'items.product', 'items.variant.quantity'])
            ->findOrFail($id);

        return view('order.billing-invoice', compact('order'));
    }

    /**
     * Get invoice HTML for modal popup (AJAX)
     */
    public function getInvoiceHtml($id)
    {
        $order = Order::with(['customer', 'items.product', 'items.variant.quantity'])
            ->findOrFail($id);

        return view('order.billing-invoice-modal', compact('order'));
    }

    /**
     * Delete billing order
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);

            // Delete order items first
            $order->items()->delete();

            // Delete the order
            $order->delete();

            return redirect()->route('billing.table')
                ->with('success', 'Order #' . $order->order_number . ' deleted successfully');

        } catch (\Exception $e) {
            Log::error('Order deletion failed', [
                'order_id' => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('billing.table')
                ->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }

    // =====================
    // HELPER METHODS
    // =====================

    /**
     * Prepare customer data (guest or registered)
     */
    private function prepareCustomerData(Request $request)
    {
        // Check if shipping to same address
        $shipSameAddress = $request->input('ship_same_address', true);
        $separateShippingAddress = $request->input('shipping_address');

        // GUEST CUSTOMER
        if ($request->customer_type === 'guest') {

            $guest = $request->guest_details ?? [];

            $billingAddress = [
                'name' => $guest['first_name'] ?? '',
                'email' => $guest['email'] ?? '',
                'phone' => $guest['phone'] ?? '',
                'address' => $guest['address'] ?? '',
            ];

            // Use separate shipping address if provided
            $shippingAddress = $billingAddress;
            if (!$shipSameAddress && $separateShippingAddress) {
                $shippingAddress = [
                    'name' => $separateShippingAddress['name'] ?? '',
                    'email' => $separateShippingAddress['email'] ?? $guest['email'] ?? '',
                    'phone' => $separateShippingAddress['phone'] ?? '',
                    'address' => $separateShippingAddress['address'] ?? '',
                ];
            }

            return [
                'customer_id' => null,
                'guest_details' => $guest,
                'billing_address' => $billingAddress,
                'shipping_address' => $shippingAddress,
            ];
        }

        // REGISTERED CUSTOMER
        $customer = \App\Models\Customer::find($request->customer_id);

        if (!$customer) {
            throw new \Exception('Customer not found');
        }

        $billingAddress = [
            'name' => $customer->username,
            'email' => $customer->email,
            'phone' => $customer->mobilenumber,
            'address' => $customer->address,
        ];

        // Use separate shipping address if provided
        $shippingAddress = $billingAddress;
        if (!$shipSameAddress && $separateShippingAddress) {
            $shippingAddress = [
                'name' => $separateShippingAddress['name'] ?? '',
                'email' => $separateShippingAddress['email'] ?? $customer->email ?? '',
                'phone' => $separateShippingAddress['phone'] ?? '',
                'address' => $separateShippingAddress['address'] ?? '',
            ];
        }

        return [
            'customer_id' => $customer->id,
            'guest_details' => null,
            'billing_address' => $billingAddress,
            'shipping_address' => $shippingAddress,
        ];
    }

    /**
     * Generate unique order number
     */
    private function generateOrderNumber()
    {
        // Generate sequential order number (A + digits starting from 6001)
        $latestOrder = Order::where('order_number', 'LIKE', 'A%')
            ->whereRaw('LENGTH(order_number) >= 5')
            ->orderBy('id', 'desc')
            ->first();

        $nextId = 6001;
        
        if ($latestOrder) {
            $lastNumber = (int) substr($latestOrder->order_number, 1);
            $nextId = max(6001, $lastNumber + 1);
        }

        return 'A' . $nextId;
    }

    /**
     * Create Razorpay order
     */
    private function createRazorpayOrder($amount, $orderNumber = null, $orderId = null)
    {
        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $orderData = [
                'receipt' => $orderNumber ?? ('CA_' . time() . '_' . rand(1000, 9999)),
                'amount' => $amount * 100, // paisa
                'currency' => 'INR',
                'description' => 'Payment for Order #' . $orderNumber,
                'payment_capture' => 1,
                'notes' => [
                    'order_id' => $orderId,
                    'order_number' => $orderNumber
                ]
            ];

            $razorpayOrder = $api->order->create($orderData);

            Log::info('Razorpay order created', [
                'razorpay_order_id' => $razorpayOrder['id'],
                'amount' => $amount,
                'order_number' => $orderNumber
            ]);

            return $razorpayOrder['id'];
        } catch (\Exception $e) {
            Log::error('Razorpay order creation failed', ['error' => $e->getMessage()]);
            throw new \Exception('Razorpay order creation failed: ' . $e->getMessage());
        }
    }

    /**
     * Send invoice email to customer
     */
    private function sendInvoiceEmail(Order $order)
    {
        try {
            // Reload order with relationships for email
            $order->load(['customer', 'items.product', 'items.variant.quantity']);

            // Determine recipient email
            $recipientEmail = null;
            $recipientName = 'Customer';

            if ($order->customer_type === 'registered' && $order->customer) {
                $recipientEmail = $order->customer->email;
                $recipientName = $order->customer->username; // Customer model uses 'username' field
            } elseif ($order->customer_type === 'guest' && isset($order->guest_details['email'])) {
                $recipientEmail = $order->guest_details['email'];
                $recipientName = $order->guest_details['name'] ?? $order->guest_details['first_name'] ?? 'Guest';
            }

            // Send email if we have a valid email address
            if ($recipientEmail && filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                Mail::to($recipientEmail, $recipientName)
                    ->send(new InvoiceMail($order));

                Log::info('Invoice email sent successfully', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'recipient' => $recipientEmail
                ]);
            } else {
                Log::warning('Invoice email not sent - no valid email address', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_type' => $order->customer_type
                ]);
            }
        } catch (\Exception $e) {
            // Log error but don't fail the order
            Log::error('Failed to send invoice email', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'error' => $e->getMessage()
            ]);
        }
    }
}
