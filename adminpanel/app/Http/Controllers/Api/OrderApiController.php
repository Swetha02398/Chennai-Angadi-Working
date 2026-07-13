<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\OrderHistory;
use App\Models\EmailHistory;
use App\Mail\OrderStatusUpdateMail;
use App\Mail\AdminOrderNotification;
use App\Models\User;
use Razorpay\Api\Api;

class OrderApiController extends Controller
{
    // 🔹 Capture checkout details (Lead / Abandoned Checkout API)
    public function checkoutCapture(Request $request)
    {
        $request->validate([
            'customer_type'          => 'required|in:registered,guest',
            'items'                  => 'required|array|min:1',
            'items.*.product_id'     => 'required|exists:products,id',
            'items.*.variant_id'     => 'nullable|exists:product_variants,id',
            'items.*.qty'            => 'required|integer|min:1',
            'items.*.price'          => 'required|numeric|min:0',
            'items.*.product_name'   => 'required|string',
            'items.*.variant_name'   => 'nullable|string',
            'subtotal'               => 'required|numeric|min:0',
            'final_amount'           => 'required|numeric|min:0',
            'shipping_address'       => 'required|array',
            'billing_address'        => 'nullable|array',
            'guest_details'          => 'nullable|array',
            'discount_amount'        => 'nullable|numeric|min:0',
            'coupon_code'            => 'nullable|string',
            'shipping_amount'        => 'nullable|numeric|min:0',
            'cod_charge'             => 'nullable|numeric|min:0',
            'order_number'           => 'nullable|string', // Pass this if updating an existing capture
        ]);

        DB::beginTransaction();
        try {
            // Customer handling
            $customerId   = null;
            $guestDetails = null;

            if ($request->customer_type === 'registered') {
                $user = auth('sanctum')->user();
                if (!$user) {
                    return response()->json(['status' => false, 'message' => 'Authentication required'], 401);
                }
                $customerId = $user->id;
            } else {
                $guestDetails = $request->guest_details;
                if (!$guestDetails || empty($guestDetails['email'])) {
                    return response()->json(['status' => false, 'message' => 'Guest email required'], 422);
                }
            }

            $orderNumber = $request->order_number;
            $order = null;

            if ($orderNumber) {
                $order = Order::where('order_number', $orderNumber)->first();
            }

            $updateData = [
                'order_type'      => 'frontend',
                'order_source'    => 'app',
                'customer_type'   => $request->customer_type,
                'customer_id'     => $customerId,
                'guest_details'   => $guestDetails,
                'shipping_address' => $request->shipping_address,
                'billing_address'  => $request->billing_address ?? $request->shipping_address,
                'payment_method'   => 'online_gateway', // Default for capture phase
                'payment_provider' => 'razorpay',
                'payment_status'  => 'not_paid',
                'subtotal'        => $request->subtotal,
                'discount_amount' => $request->input('discount_amount', 0),
                'shipping_amount' => $request->input('shipping_amount', 0),
                'cod_charge'      => $request->input('cod_charge', 0),
                'total_amount'    => $request->final_amount,
                'final_amount'    => $request->final_amount,
                'status'          => 'pending',
                'coupon_code'     => $request->input('coupon_code', null),
                'placed_at'       => now(),
            ];

            if ($order) {
                $order->update($updateData);
            } else {
                $updateData['order_number'] = $this->generateOrderNumber();
                $order = Order::create($updateData);
            }

            // Sync order items
            $order->items()->delete();
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id'            => $order->id,
                    'product_id'          => $item['product_id'],
                    'product_variant_id'  => $item['variant_id'] ?? null,
                    'product_productname' => $item['product_name'],
                    'variant_name'        => $item['variant_name'] ?? null,
                    'price'               => $item['price'],
                    'qty'                 => $item['qty'],
                    'total'               => $item['price'] * $item['qty'],
                ]);
            }

            DB::commit();

            return response()->json([
                'status'       => true,
                'message'      => 'Checkout details captured successfully',
                'order_id'     => $order->id,
                'order_number' => $order->order_number,
                'payment_status' => $order->payment_status
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout capture failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // 🔹 Create a new order (Place Order API)
    public function store(Request $request)
    {
        $request->validate([
            'customer_type'          => 'required|in:registered,guest',
            'items'                  => 'required|array|min:1',
            'items.*.product_id'     => 'required|exists:products,id',
            'items.*.variant_id'     => 'nullable|exists:product_variants,id',
            'items.*.qty'            => 'required|integer|min:1',
            'items.*.price'          => 'required|numeric|min:0',
            'items.*.product_name'   => 'required|string',
            'items.*.variant_name'   => 'nullable|string',
            'subtotal'               => 'required|numeric|min:0',
            'final_amount'           => 'required|numeric|min:0',
            'payment_method'         => 'required|in:cod,online',
            'shipping_address'       => 'nullable|array',
            'billing_address'        => 'nullable|array',
            'guest_details'          => 'nullable|array',
            'discount_amount'        => 'nullable|numeric|min:0',
            'coupon_code'            => 'nullable|string',
            'tax_amount'             => 'nullable|numeric|min:0',
            'shipping_amount'        => 'nullable|numeric|min:0',
            'cod_charge'             => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Customer handling
            $customerId   = null;
            $guestDetails = null;

            if ($request->customer_type === 'registered') {
                $user = auth('sanctum')->user();
                if (!$user) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Authentication required for registered customers'
                    ], 401);
                }
                $customerId = $user->id;

                // Build billing address from customer profile if not provided
                if (!$request->billing_address) {
                    $request->merge([
                        'billing_address' => [
                            'name'    => $user->username ?? $user->name ?? '',
                            'email'   => $user->email ?? '',
                            'phone'   => $user->mobilenumber ?? '',
                            'address' => $user->address ?? '',
                            'city'    => $user->city ?? '',
                            'state'   => $user->state ?? '',
                            'pincode' => $user->pin ?? $user->pincode ?? '',
                            'landmark' => $user->landmark ?? '',
                        ]
                    ]);
                }
            } else {
                // Guest customer
                $guestDetails = $request->guest_details;
                if (!$guestDetails || empty($guestDetails['email'])) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Guest details with email are required for guest orders'
                    ], 422);
                }

                // Build billing address from guest details if not provided
                if (!$request->billing_address) {
                    $request->merge([
                        'billing_address' => [
                            'name'    => $guestDetails['name'] ?? $guestDetails['first_name'] ?? '',
                            'email'   => $guestDetails['email'] ?? '',
                            'phone'   => $guestDetails['phone'] ?? '',
                            'address' => $guestDetails['address'] ?? '',
                            'city'    => $guestDetails['city'] ?? '',
                            'state'   => $guestDetails['state'] ?? '',
                            'pincode' => $guestDetails['pincode'] ?? $guestDetails['pin'] ?? '',
                            'landmark' => $guestDetails['landmark'] ?? '',
                        ]
                    ]);
                }
            }

            // Use billing address as shipping address if not provided
            $shippingAddress = $request->shipping_address ?? $request->billing_address;
            $billingAddress  = $request->billing_address;

            // Determine billing_type (same or different)
            $billingType = 'same';
            if ($request->shipping_address && $request->billing_address) {
                $isSame = (($request->shipping_address['address'] ?? '') === ($request->billing_address['address'] ?? '') &&
                          ($request->shipping_address['pincode'] ?? '') === ($request->billing_address['pincode'] ?? ''));
                $billingType = $isSame ? 'same' : 'different';
            }

            // Payment status and order status based on payment method
            $paymentMethod  = $request->payment_method;
            // COD → save as 'cash_on_delivery' (matching DB convention), payment not yet collected
            $paymentMethodDb = ($paymentMethod === 'cod') ? 'cash_on_delivery' : $paymentMethod;
            
            // Payment user status logic:
            // - Online: 'pending' (until verified)
            // - COD: 'cod' (requested by user)
            $paymentStatus = ($paymentMethod === 'cod') ? 'cod' : 'pending';
            $orderStatus   = ($paymentMethod === 'cod') ? 'confirmed' : 'pending';

            $subtotal       = $request->subtotal;
            $discountAmount = $request->input('discount_amount', 0);
            $taxAmount      = $request->input('tax_amount', 0);
            $shippingAmount = $request->input('shipping_amount', 0);
            $finalAmount    = $request->final_amount;
            $couponCode     = $request->input('coupon_code', null);

            // Validate stock for all items before creating order
            $stockWarnings = [];
            $validatedItems = [];

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) {
                    DB::rollBack();
                    return response()->json([
                        'status'  => false,
                        'message' => 'Product not found: ID ' . $item['product_id']
                    ], 404);
                }

                $qty = (int) $item['qty'];
                $variantId = $item['variant_id'] ?? null;

                if ($variantId) {
                    $variant = ProductVariant::with('quantity')->find($variantId);
                    if (!$variant) {
                        DB::rollBack();
                        return response()->json([
                            'status'  => false,
                            'message' => 'Product variant not found: ID ' . $variantId
                        ], 404);
                    }

                    $availableStock = $variant->stock ?? 0;
                    $variantLabel   = $variant->quantity ? $variant->quantity->name : '';

                    if ($availableStock <= 0) {
                        DB::rollBack();
                        return response()->json([
                            'status'  => false,
                            'message' => "{$product->productname} ({$variantLabel}) is out of stock"
                        ], 422);
                    }

                    if ($qty > $availableStock) {
                        $stockWarnings[] = "{$product->productname} ({$variantLabel}): Only {$availableStock} available, adjusted from {$qty}";
                        $qty = $availableStock;
                    }
                }

                $validatedItems[] = [
                    'product_id'   => $item['product_id'],
                    'variant_id'   => $variantId,
                    'qty'          => $qty,
                    'price'        => $item['price'],
                    'product_name' => $item['product_name'],
                    'variant_name' => $item['variant_name'] ?? null,
                ];
            }

            $shippingAmount = $request->input('shipping_amount', 0);
            $codCharge = $request->input('cod_charge', 0);
            $finalAmount = (float)$request->input('final_amount', 0);

            // Check if we are finalizing a previously captured order
            $existingOrderNumber = $request->input('order_number');
            $order = null;
            if ($existingOrderNumber) {
                $order = Order::where('order_number', $existingOrderNumber)->first();
            }

            if ($order) {
                $order->update([
                    'customer_id'     => $customerId,
                    'guest_details'   => $guestDetails,
                    'shipping_address' => $shippingAddress,
                    'billing_address'  => $billingAddress,
                    'billing_type'     => $billingType,
                    'payment_method'  => $paymentMethodDb,
                    'payment_provider' => ($paymentMethod === 'cod') ? 'cash' : 'razorpay',
                    'payment_status'  => $paymentStatus,
                    'subtotal'        => $subtotal,
                    'discount_amount' => $discountAmount,
                    'tax_amount'      => $taxAmount,
                    'shipping_amount' => $shippingAmount,
                    'cod_charge'      => $codCharge,
                    'total_amount'    => $finalAmount,
                    'final_amount'    => $finalAmount,
                    'status'          => $orderStatus,
                    'order_type'      => 'frontend',
                    'coupon_code'     => $couponCode,
                    'placed_at'       => now(),
                ]);
                $order->items()->delete(); // Re-sync items from the final order call
            } else {
                // Create new order
                $order = Order::create([
                    'order_number'    => $this->generateOrderNumber(),
                    'order_type'      => 'frontend',
                    'order_source'    => 'app',
                    'customer_type'   => $request->customer_type,
                    'customer_id'     => $customerId,
                    'guest_details'   => $guestDetails,
                    'shipping_address' => $shippingAddress,
                    'billing_address'  => $billingAddress,
                    'billing_type'     => $billingType,
                    'payment_method'  => $paymentMethodDb,
                    'payment_provider' => ($paymentMethod === 'cod') ? 'cash' : 'razorpay',
                    'payment_status'  => $paymentStatus,
                    'subtotal'        => $subtotal,
                    'discount_amount' => $discountAmount,
                    'tax_amount'      => $taxAmount,
                    'shipping_amount' => $shippingAmount,
                    'cod_charge'      => $codCharge,
                    'total_amount'    => $finalAmount,
                    'final_amount'    => $finalAmount,
                    'status'          => $orderStatus,
                    'coupon_code'     => $couponCode,
                    'placed_at'       => now(),
                ]);
            }

            // Create order items and update stock
            foreach ($validatedItems as $item) {
                OrderItem::create([
                    'order_id'            => $order->id,
                    'product_id'          => $item['product_id'],
                    'product_variant_id'  => $item['variant_id'],
                    'product_productname' => $item['product_name'],
                    'variant_name'        => $item['variant_name'],
                    'price'               => $item['price'],
                    'qty'                 => $item['qty'],
                    'total'               => $item['price'] * $item['qty'],
                ]);

                // Decrease stock
                if ($item['variant_id']) {
                    $variant = ProductVariant::find($item['variant_id']);
                    if ($variant) {
                        $variant->stock = max(0, $variant->stock - $item['qty']);
                        $variant->stock_status = $variant->stock > 0 ? 'in_stock' : 'out_of_stock';
                        $variant->save();
                    }
                }
            }

            // Update Coupon Usage
            if ($couponCode) {
                $appliedCoupon = \App\Models\Coupon::where('code', $couponCode)->first();
                if ($appliedCoupon) {
                    $appliedCoupon->increment('used_count');
                    
                    if ($customerId) {
                        DB::table('coupon_user')->insert([
                            'coupon_id' => $appliedCoupon->id,
                            'user_id' => $customerId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            DB::commit();

            // Create initial order history
            OrderHistory::create([
                'order_id' => $order->id,
                'status'   => $orderStatus,
                'message'  => 'Order placed via Application',
            ]);

            // Dispatch OrderPlaced event for invoice email (COD orders confirmed immediately)
            if ($paymentMethod === 'cod') {
                event(new \App\Events\OrderPlaced($order));
                
                // Send Admin Notification Email for COD
                try {
                    $adminEmail = config('app.admin_email') 
                        ?? User::where('role', 'superadmin')->value('email') 
                        ?? User::where('role', 'admin')->value('email')
                        ?? 'care@chennaiangadi.com';
                        
                    Mail::to($adminEmail)->send(new AdminOrderNotification($order));
                } catch (\Exception $adminEmailError) {
                    Log::error('Admin order notification email failed via API (COD): ' . $adminEmailError->getMessage());
                }
            }

            Log::info('Order created via API', [
                'order_id'     => $order->id,
                'order_number' => $order->order_number,
                'customer_type' => $request->customer_type,
                'payment_method' => $paymentMethod,
            ]);

            return response()->json([
                'status'           => true,
                'message'          => 'Order created successfully',
                'order_id'         => $order->id,
                'order_number'     => $order->order_number,
                'requires_payment' => ($paymentMethod !== 'cod'),
                'payment_method'   => $paymentMethod,
                'warnings'         => $stockWarnings,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation via API failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status'  => false,
                'message' => 'Order creation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    // 🔹 Create Razorpay order for online payment
    public function createRazorpayOrder(Request $request)
    {
        $request->validate([
            'order_number' => 'required|exists:orders,order_number',
            'amount'       => 'required|numeric|min:1',
        ]);

        try {
            $order  = Order::where('order_number', $request->order_number)->firstOrFail();
            $amount = $request->amount;

            // Create Razorpay order
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $razorpayOrder = $api->order->create([
                'receipt'         => $order->order_number,
                'amount'          => $amount * 100, // paisa
                'currency'        => 'INR',
                'description'     => 'Payment for Order #' . $order->order_number,
                'payment_capture' => 1,
                'notes'           => [
                    'order_id'     => $order->id,
                    'order_number' => $order->order_number,
                    'site'         => 'Chennai Angadi'
                ]
            ]);

            // Store Razorpay order ID
            $order->update(['razorpay_order_id' => $razorpayOrder['id']]);

            // Prefill data for Razorpay checkout
            $prefill = ['name' => '', 'email' => '', 'contact' => ''];
            if ($order->customer_type === 'registered' && $order->customer) {
                $prefill['name']    = $order->customer->username ?? '';
                $prefill['email']   = $order->customer->email ?? '';
                $prefill['contact'] = $order->customer->mobilenumber ?? '';
            } elseif ($order->customer_type === 'guest' && $order->guest_details) {
                $g = $order->guest_details;
                $prefill['name']    = $g['name'] ?? $g['first_name'] ?? '';
                $prefill['email']   = $g['email'] ?? '';
                $prefill['contact'] = $g['phone'] ?? '';
            }

            return response()->json([
                'status'            => true,
                'razorpay_order_id' => $razorpayOrder['id'],
                'razorpay_key'      => config('services.razorpay.key'),
                'amount'            => $amount * 100,
                'currency'          => 'INR',
                'order_number'      => $order->order_number,
                'prefill'           => $prefill,
            ]);

        } catch (\Exception $e) {
            Log::error('Razorpay order creation failed (API)', [
                'error'        => $e->getMessage(),
                'order_number' => $request->order_number,
            ]);

            return response()->json([
                'status'  => false,
                'message' => 'Failed to create payment order: ' . $e->getMessage()
            ], 500);
        }
    }

    // 🔹 Verify Razorpay payment signature
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'order_number'        => 'required|exists:orders,order_number',
            'razorpay_order_id'   => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature'  => 'required|string',
        ]);

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            // Verify signature
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);

            // Signature valid — update order
            $order = Order::where('order_number', $request->order_number)->firstOrFail();
            $order->update([
                'payment_status'      => 'paid',
                'status'              => 'confirmed',
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
            ]);

            // Dispatch OrderPlaced event for invoice email
            event(new \App\Events\OrderPlaced($order));

            // Send Admin Notification Email for Online Success
            try {
                $adminEmail = config('app.admin_email') 
                    ?? User::where('role', 'superadmin')->value('email') 
                    ?? User::where('role', 'admin')->value('email')
                    ?? 'care@chennaiangadi.com';
                    
                Mail::to($adminEmail)->send(new AdminOrderNotification($order));
            } catch (\Exception $adminEmailError) {
                Log::error('Admin order notification email failed via API (Online): ' . $adminEmailError->getMessage());
            }

            Log::info('Razorpay payment verified via API', [
                'order_id'           => $order->id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
            ]);

            return response()->json([
                'status'       => true,
                'message'      => 'Payment verified successfully',
                'order_number' => $order->order_number,
            ]);

        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            Log::error('Razorpay signature verification failed (API)', [
                'order_number' => $request->order_number,
                'error'    => $e->getMessage(),
            ]);

            return response()->json([
                'status'  => false,
                'message' => 'Payment verification failed: Invalid signature'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Payment verification error (API)', [
                'order_number' => $request->order_number,
                'error'    => $e->getMessage(),
            ]);

            return response()->json([
                'status'  => false,
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ], 500);
        }
    }

    // 🔹 Generate unique order number (A + digits starting from 6001)
    private function generateOrderNumber()
    {
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

    // 🔹 Get all orders
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        /** @var \Illuminate\Pagination\LengthAwarePaginator $orders */
        $orders = Order::with(['customer', 'items'])
            ->orderByDesc('id')
            ->paginate($perPage);
        
        $orders->withQueryString();

        return response()->json([
            'status' => true,
            'data' => $orders
        ]);
    }

    // 🔹 Get single order by ID
    public function show(int $id)
    {
        $order = Order::with(['customer', 'items'])->find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $order
        ]);
    }

    // 🔹 Track order by order number (for frontend order tracking page)
    public function showByOrderNumber(string $order_number)
    {
        $order = Order::with(['customer', 'items.product', 'items.variant', 'histories'])
            ->where('order_number', $order_number)
            ->first();

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'No order found with this Order ID. Please check and try again.'
            ], 404);
        }

        // Define the standard order status flow
        $statusFlow = ['pending', 'confirmed', 'packed', 'shipped', 'delivered'];

        // Build tracking timeline from order histories
        $timeline = $order->histories->map(function ($history) {
            return [
                'status'     => $history->status,
                'message'    => $history->message,
                'date'       => $history->created_at->format('d M Y'),
                'time'       => $history->created_at->format('h:i A'),
                'datetime'   => $history->created_at->toDateTimeString(),
            ];
        });

        // Current status index in the flow (for progress bar)
        $currentStatusIndex = array_search($order->status, $statusFlow);

        // Parse tracking info from notes (HTML content)
        $notes = $order->notes ?? '';
        $plainText = trim(strip_tags(str_replace(['<br/>', '<br>', '<br />'], "\n", $notes)));

        $trackingId = null;
        $trackingLink = null;
        $courierName = null;
        $orderMessage = null;

        // Extract the first line as order message (e.g., "Your order has been Shipped")
        $lines = array_filter(array_map('trim', explode("\n", $plainText)));
        if (!empty($lines)) {
            $orderMessage = reset($lines);
        }

        // Extract Tracking ID (e.g., "Tracking ID: 13214646")
        if (preg_match('/Tracking\s*ID[:\s]*([A-Za-z0-9]+)/i', $plainText, $matches)) {
            $trackingId = trim($matches[1]);
        }

        // Extract Tracking Link from <a href="...">
        if (preg_match('/href=["\']([^"\']+)["\']/', $notes, $matches)) {
            $trackingLink = trim($matches[1]);
        }

        // Extract Courier Name (e.g., "Courier Name: Professional Courier")
        if (preg_match('/Courier\s*Name[:\s]*([^\n<]+)/i', $plainText, $matches)) {
            $courierName = trim($matches[1]);
        }

        return response()->json([
            'status' => true,
            'data'   => [
                'order_number'    => $order->order_number,
                'order_status'    => $order->status,
                'payment_method'  => $order->payment_method,
                'payment_status'  => $order->payment_status,
                'placed_at'       => $order->placed_at ? $order->placed_at->format('d M Y, h:i A') : null,
                'delivered_at'    => $order->delivered_at ? $order->delivered_at->format('d M Y, h:i A') : null,

                // Amount details
                'subtotal'        => $order->subtotal,
                'discount_amount' => $order->discount_amount,
                'tax_amount'      => $order->tax_amount,
                'shipping_amount' => $order->shipping_amount,
                'total_amount'    => $order->total_amount,
                'final_amount'    => $order->final_amount,

                // Shipping address
                'shipping_address' => $order->shipping_address,

                // Courier / Tracking details
                'tracking_notes' => [
                    'message'       => $orderMessage,
                    'courier_name'  => $courierName,
                    'tracking_id'   => $trackingId,
                    'tracking_link' => $trackingLink,
                ],

                // Order items
                'items' => $order->items->map(function ($item) {
                    return [
                        'product_name'  => $item->product_productname,
                        'variant_name'  => $item->variant_name,
                        'price'         => $item->price,
                        'qty'           => $item->qty,
                        'total'         => $item->total,
                        'product_image' => $item->product->main_image ?? null,
                    ];
                }),

                // Tracking timeline
                'tracking_timeline' => $timeline,

                // Status flow for progress visualization
                'status_flow'          => $statusFlow,
                'current_status_index' => $currentStatusIndex !== false ? $currentStatusIndex : -1,
            ],
        ]);
    }

    // 🔹 Get orders for authenticated customer
    public function customerOrders()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access'
            ], 401);
        }

        $orders = Order::with(['items'])
            ->where('customer_id', $user->id)
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'status' => true,
            'order_count' => $orders->count(),
            'data' => $orders
        ]);
    }

    // 🔹 Update order status
    public function updateStatus(Request $request, int $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,packed,shipped,delivered,cancelled'
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $updateData = ['status' => $validated['status']];

        // Auto-update payment_status to 'paid' when COD order is delivered
        if ($validated['status'] === 'delivered' && in_array($order->payment_method, ['cash_on_delivery', 'cod'])) {
            $updateData['payment_status'] = 'paid';
        }

        $order->update($updateData);
        
        // Create OrderHistory record
        OrderHistory::create([
            'order_id' => $order->id,
            'status'   => $validated['status'],
            'message'  => ucfirst($validated['status']),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Order status updated successfully',
            'data' => $order
        ]);
    }

    // 🔹 Update order notes
    public function updateNotes(Request $request, int $id)
    {
        $validated = $request->validate([
            'notes' => 'required|string'
        ]);

        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $order->update(['notes' => $validated['notes']]);

        // Create OrderHistory record
        OrderHistory::create([
            'order_id' => $order->id,
            'status'   => $order->status,
            'message'  => $validated['notes'],
        ]);

        // Send status update email (logic from Web OrderController)
        try {
            $customerEmail = null;
            if ($order->customer_type === 'registered' && $order->customer) {
                $customerEmail = $order->customer->email;
            } elseif ($order->customer_type === 'guest' && $order->guest_details) {
                $customerEmail = $order->guest_details['email'] ?? null;
            }

            if ($customerEmail && filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
                $recipientName = null;
                if ($order->customer_type === 'registered' && $order->customer) {
                    $recipientName = $order->customer->username ?? $order->customer->name;
                } elseif ($order->billing_address) {
                    $recipientName = $order->billing_address['name'] ?? null;
                }

                $emailSubject = 'Order Update - ' . $order->order_number;
                
                Mail::to($customerEmail)->send(new OrderStatusUpdateMail($order, $order->status, $order->notes));

                // Log to EmailHistory
                EmailHistory::create([
                    'order_id' => $order->id,
                    'email_type' => 'status_update',
                    'recipient_email' => $customerEmail,
                    'recipient_name' => $recipientName,
                    'subject' => $emailSubject,
                    'order_number' => $order->order_number,
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send order status email via API: ' . $e->getMessage());
        }

        return response()->json([
            'status' => true,
            'message' => 'Order notes updated successfully',
            'data' => $order
        ]);
    }

    // 🔹 Delete order
    public function destroy(int $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found'
            ], 404);
        }

        // Delete order items first
        $order->items()->delete();
        $order->delete();

        return response()->json([
            'status' => true,
            'message' => 'Order deleted successfully'
        ]);
    }
}
