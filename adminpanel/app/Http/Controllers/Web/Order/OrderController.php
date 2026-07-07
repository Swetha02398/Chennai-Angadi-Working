<?php

namespace App\Http\Controllers\Web\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\EmailHistory;
use App\Mail\OrderStatusUpdateMail;
use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Show frontend orders table (orders from website/app)
     */
    public function index(Request $request)
    {
        $query = Order::where('order_type', 'frontend')
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

        // STATUS FILTER
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // PAYMENT STATUS FILTER
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // DATE FILTER
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->paginate(10)->withQueryString();

        return view('order.orders-table', [
            'orders' => $orders,
            'search' => $request->search,
            'status' => $request->status,
            'payment_status' => $request->payment_status,
            'date' => $request->date,
        ]);
    }

    /**
     * Show order details view page
     */
    public function view($id)
    {
        $order = Order::with(['customer', 'items.product', 'items.variant.quantity'])
            ->findOrFail($id);

        // Get all products for the add product dropdown
        $products = \App\Models\Product::with('variants.quantity')
            ->orderBy('productname')
            ->get();

        return view('order.order-view', compact('order', 'products'));
    }

    /**
     * Show add product page for an order
     */
    public function showAddProduct($id)
    {
        $order = Order::with(['customer'])->findOrFail($id);

        return view('order.Order-addproduct', compact('order'));
    }

    /**
     * Show order edit page (Raise Invoice)
     */
    public function edit($id)
    {
        $order = Order::with(['customer', 'items.product', 'items.variant.quantity'])
            ->findOrFail($id);

        // Get order histories from OrderHistory model
        $orderHistories = \App\Models\OrderHistory::where('order_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('order.order-edit', compact('order', 'orderHistories'));
    }

    /**
     * Show order details / invoice
     */
    public function show($id)
    {
        $order = Order::with(['customer', 'items.product', 'items.variant.quantity'])
            ->findOrFail($id);

        return view('order.order-invoice', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled,returned',
        ]);

        $order = Order::findOrFail($id);

        $updateData = ['status' => $request->status];

        // Auto-update payment_status to 'paid' when COD order is delivered
        if ($request->status === 'delivered' && in_array($order->payment_method, ['cash_on_delivery', 'cod'])) {
            $updateData['payment_status'] = 'paid';
        }

        $order->update($updateData);

        // Create OrderHistory record
        \App\Models\OrderHistory::create([
            'order_id' => $order->id,
            'status' => $request->status,
            'message' => ucfirst($request->status),
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    /**
     * Update payment status via AJAX
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'payment_status' => 'required|in:Paid,COD,Not Paid',
            ]);

            $order = Order::findOrFail($id);
            $newStatus = $request->payment_status;
            
            $updateData = [];

            if ($newStatus === 'Paid') {
                $updateData['payment_status'] = 'paid';
                if (in_array($order->payment_method, ['cod', 'cash_on_delivery'])) {
                    $updateData['payment_method'] = 'cash';
                }
            } elseif ($newStatus === 'COD') {
                $updateData['payment_method'] = 'cod';
                $updateData['payment_status'] = 'pending';
            } elseif ($newStatus === 'Not Paid') {
                $updateData['payment_status'] = 'not_paid';
                if ($order->payment_method === 'cod') {
                    $updateData['payment_method'] = 'online_gateway';
                }
            }

            $order->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Payment status updated successfully',
                'new_status' => $newStatus
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete order
     */
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);

            // Delete order items first
            $order->items()->delete();

            // Delete the order
            $order->delete();

            return redirect()->route('orders.table')
                ->with('success', 'Order #' . $order->order_number . ' deleted successfully');

        } catch (\Exception $e) {
            return redirect()->route('orders.table')
                ->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }

    /**
     * Get invoice HTML for modal popup (AJAX)
     */
    public function getInvoiceHtml($id)
    {
        $order = Order::with(['customer', 'items.product', 'items.variant.quantity'])
            ->findOrFail($id);

        return view('order.order-invoice-modal', compact('order'));
    }

    /**
     * Update order notes and status via AJAX
     */
    public function updateNotes(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string',
            'status' => 'nullable|in:pending,confirmed,processing,packed,shipped,delivered,cancelled',
        ]);

        try {
            $order = Order::with('customer')->findOrFail($id);

            // Save notes as-is without escaping HTML
            $order->notes = $request->input('notes');

            // Update status if provided
            if ($request->has('status')) {
                $order->status = $request->input('status');

                // Auto-update payment_status to 'paid' when COD order is delivered
                if ($request->input('status') === 'delivered' && in_array($order->payment_method, ['cash_on_delivery', 'cod'])) {
                    $order->payment_status = 'paid';
                }
            }

            $order->save();

            // Create OrderHistory record
            \App\Models\OrderHistory::create([
                'order_id' => $order->id,
                'status' => $order->status,
                'message' => ($request->input('notes') && trim($request->input('notes')) !== '') ? $request->input('notes') : ucfirst($order->status),
            ]);

            // Send status update email to customer
            $customerEmail = null;
            if ($order->customer_type === 'registered' && $order->customer) {
                $customerEmail = $order->customer->email;
            } elseif ($order->customer_type === 'guest' && $order->guest_details) {
                $customerEmail = $order->guest_details['email'] ?? null;
            }

            // Fallback to billing address email if available
            if (!$customerEmail && $order->billing_address) {
                $customerEmail = $order->billing_address['email'] ?? null;
            }

            \Log::info('Order status update email attempt', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'customer_type' => $order->customer_type,
                'customer_email' => $customerEmail,
                'new_status' => $order->status
            ]);

            // Get recipient name
            $recipientName = null;
            if ($order->customer_type === 'registered' && $order->customer) {
                $recipientName = $order->customer->username ?? $order->customer->name;
            } elseif ($order->billing_address) {
                $recipientName = $order->billing_address['name'] ?? null;
            } elseif ($order->guest_details) {
                $recipientName = $order->guest_details['name'] ?? null;
            }

            if ($customerEmail) {
                $emailSubject = 'Order Status Update - ' . $order->order_number;
                try {
                    Mail::to($customerEmail)->send(new OrderStatusUpdateMail($order, $order->status, $order->notes));

                    // Log to EmailHistory table
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

                    \Log::info('Order status email sent successfully', [
                        'order_id' => $order->id,
                        'recipient' => $customerEmail
                    ]);
                } catch (\Exception $mailException) {
                    // Log failed email to history
                    EmailHistory::create([
                        'order_id' => $order->id,
                        'email_type' => 'status_update',
                        'recipient_email' => $customerEmail,
                        'recipient_name' => $recipientName,
                        'subject' => $emailSubject,
                        'order_number' => $order->order_number,
                        'status' => 'failed',
                        'error_message' => $mailException->getMessage(),
                        'sent_at' => now(),
                    ]);
                    \Log::error('Failed to send order status email: ' . $mailException->getMessage());
                }
            } else {
                \Log::warning('No customer email found for order status update', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully',
                'notes' => $order->notes,
                'status' => $order->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get variants for a product (AJAX)
     */
    public function getVariants($productId)
    {
        try {
            $product = \App\Models\Product::with('variants.quantity')->findOrFail($productId);

            return response()->json([
                'success' => true,
                'variants' => $product->variants->map(function ($variant) {
                    return [
                        'id' => $variant->id,
                        'sell_price' => $variant->sell_price,
                        'quantity' => $variant->quantity ? ['name' => $variant->quantity->name] : null
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch variants: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search products for add product modal (AJAX)
     */
    public function searchProducts(Request $request)
    {
        try {
            $query = $request->input('query', '');

            $products = \App\Models\Product::with(['variants.quantity'])
                ->where('productname', 'LIKE', "%{$query}%")
                ->orderBy('productname')
                ->limit(20)
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'productname' => $product->productname,
                        'sell_price' => $product->sell_price ?? 0,
                        'variants' => $product->variants->map(function ($variant) {
                            $isOutOfStock = ($variant->stock_status == 0 || $variant->stock <= 0);
                            return [
                                'id' => $variant->id,
                                'sell_price' => $variant->sell_price ?? 0,
                                'quantity_name' => $variant->quantity ? $variant->quantity->name : null,
                                'stock' => $variant->stock ?? 0,
                                'stock_status' => $variant->stock_status ?? 0,
                                'is_out_of_stock' => $isOutOfStock
                            ];
                        })
                    ];
                });

            return response()->json([
                'success' => true,
                'products' => $products
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search products: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add product to an existing order
     */
    public function addProduct(Request $request, $orderId)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        try {
            $order = Order::findOrFail($orderId);
            $product = \App\Models\Product::findOrFail($request->product_id);

            $variantName = null;
            if ($request->variant_id) {
                $variant = \App\Models\ProductVariant::with('quantity')->find($request->variant_id);
                $variantName = $variant && $variant->quantity ? $variant->quantity->name : null;
            }

            // Create order item
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_variant_id' => $request->variant_id ?: null,
                'product_productname' => $product->productname,
                'variant_name' => $variantName,
                'price' => $request->price,
                'qty' => $request->quantity,
                'total' => $request->price * $request->quantity,
            ]);

            // Decrease stock count
            if ($request->variant_id) {
                $variant = \App\Models\ProductVariant::find($request->variant_id);
                if ($variant) {
                    $variant->stock = max(0, $variant->stock - $request->quantity);
                    // Update stock status based on remaining stock
                    $variant->stock_status = $variant->stock > 0 ? 'in_stock' : 'out_of_stock';
                    $variant->save();
                }
            }

            // Update order totals
            $order->total_amount = $order->items()->sum('total');
            $order->final_amount = $order->total_amount + ($order->shipping_amount ?? 0) + ($order->cod_charge ?? 0);
            $order->save();

            // Send invoice email to customer
            $this->sendInvoiceEmail($order);

            return response()->json([
                'success' => true,
                'message' => 'Product added to order successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add multiple products to an existing order (batch)
     */
    public function addProducts(Request $request, $orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            $products = $request->input('products', []);

            if (empty($products)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No products provided'
                ], 400);
            }

            $addedCount = 0;
            $warnings = [];

            foreach ($products as $item) {
                $productId = $item['productId'] ?? null;
                $variantId = $item['variantId'] ?? null;
                $quantity = intval($item['quantity'] ?? 1);
                $price = floatval($item['price'] ?? 0);

                if (!$productId || $quantity < 1 || $price <= 0) {
                    continue;
                }

                $product = \App\Models\Product::find($productId);
                if (!$product) {
                    continue;
                }

                // Check stock availability
                $availableStock = null;
                if ($variantId) {
                    $variant = \App\Models\ProductVariant::with('quantity')->find($variantId);
                    if ($variant) {
                        $availableStock = $variant->stock ?? 0;
                        $variantName = $variant && $variant->quantity ? $variant->quantity->name : null;

                        // Check if stock is sufficient
                        if ($availableStock <= 0) {
                            $warnings[] = "{$product->productname} ({$variantName}) is out of stock";
                            continue;
                        }

                        // Limit quantity to available stock
                        if ($quantity > $availableStock) {
                            $warnings[] = "{$product->productname} ({$variantName}): Only {$availableStock} available, added {$availableStock} instead of {$quantity}";
                            $quantity = $availableStock;
                        }
                    } else {
                        continue;
                    }
                } else {
                    $variantName = null;
                }

                // Create order item
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_variant_id' => $variantId ?: null,
                    'product_productname' => $product->productname,
                    'variant_name' => $variantName,
                    'price' => $price,
                    'qty' => $quantity,
                    'total' => $price * $quantity,
                ]);

                // Decrease stock count
                if ($variantId) {
                    $variant = \App\Models\ProductVariant::find($variantId);
                    if ($variant) {
                        $variant->stock = max(0, $variant->stock - $quantity);
                        // Update stock status based on remaining stock
                        $variant->stock_status = $variant->stock > 0 ? 'in_stock' : 'out_of_stock';
                        $variant->save();
                    }
                }

                $addedCount++;
            }

            // Update order totals
            $order->total_amount = $order->items()->sum('total');
            $order->final_amount = $order->total_amount + ($order->shipping_amount ?? 0) + ($order->cod_charge ?? 0);
            $order->save();

            // Send invoice email to customer
            $this->sendInvoiceEmail($order);

            return response()->json([
                'success' => true,
                'message' => "{$addedCount} product(s) added to order successfully!",
                'warnings' => $warnings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add products: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send invoice email to customer
     */
    private function sendInvoiceEmail($order)
    {
        try {
            // Load relationships needed for invoice
            $order->load([
                'customer',
                'items.variant.quantity',
                'items.product'
            ]);

            // Determine recipient email
            $recipientEmail = null;
            $recipientName = null;

            if ($order->customer_type === 'registered' && $order->customer) {
                $recipientEmail = $order->customer->email;
                $recipientName = $order->customer->username;
            } elseif ($order->customer_type === 'guest' && isset($order->guest_details['email'])) {
                $recipientEmail = $order->guest_details['email'];
                $recipientName = $order->guest_details['first_name'] ?? $order->guest_details['name'] ?? 'Guest';
            }

            // Fallback to billing address email
            if (!$recipientEmail && $order->billing_address) {
                $recipientEmail = $order->billing_address['email'] ?? null;
                $recipientName = $order->billing_address['name'] ?? 'Customer';
            }

            if (!$recipientEmail || !filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
                Log::warning('Invoice email not sent - invalid email', [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_type' => $order->customer_type,
                ]);
                return;
            }

            $emailSubject = 'Order Successfully Placed - Invoice #' . $order->order_number;

            // Send invoice email
            Mail::mailer('smtp')
                ->to([['email' => $recipientEmail, 'name' => $recipientName]])
                ->send(new InvoiceMail($order));

            // Log to EmailHistory table
            EmailHistory::create([
                'order_id' => $order->id,
                'email_type' => 'order_confirmation',
                'recipient_email' => $recipientEmail,
                'recipient_name' => $recipientName,
                'subject' => $emailSubject,
                'order_number' => $order->order_number,
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            Log::info('Invoice email sent successfully (admin order)', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'recipient' => $recipientEmail
            ]);

        } catch (\Exception $e) {
            // Log failed email to history
            if (isset($recipientEmail)) {
                EmailHistory::create([
                    'order_id' => $order->id,
                    'email_type' => 'order_confirmation',
                    'recipient_email' => $recipientEmail,
                    'recipient_name' => $recipientName ?? null,
                    'subject' => 'Order Confirmation',
                    'order_number' => $order->order_number,
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                    'sent_at' => now(),
                ]);
            }

            Log::error('Failed to send invoice email (admin order)', [
                'order_id' => $order->id ?? 'unknown',
                'error' => $e->getMessage()
            ]);
        }
    }
}

