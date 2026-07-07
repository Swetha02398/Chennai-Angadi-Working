<?php

namespace App\Http\Controllers\Web\Cart;
use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartTotal;
use App\Models\Product;
use App\Models\Customer;

class CartController extends Controller
{
    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('status', true)->get();

        // Render the create form view (not the table). The table is shown at the `cart.table` route.
        return view('Cart.cart-create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $customerId = $request->customer_id;

        $cartItem = Cart::firstOrNew([
            'customer_id' => $customerId,
            'product_id' => $product->id
        ]);

        $cartItem->quantity += $request->quantity;
        $cartItem->price_at_add_time = $product->price;
        $cartItem->taxable = $product->taxable;
        $cartItem->tax_rate = $product->tax_rate;
        $cartItem->tax_amount = $product->taxable ? (($product->price * $cartItem->quantity) * $product->tax_rate / 100) : 0;
        $cartItem->row_total = ($product->price * $cartItem->quantity) + $cartItem->tax_amount;
        $cartItem->user_type = 1; // since admin adds for registered customer
        $cartItem->save();

        // update totals
        $this->updateCartTotals($customerId);
         NotificationHelper::sendToAll(
            'New Cart Item Added',
            'A new cart item for product "' . $product->name . '" has been added for customer ID ' . $customerId . '.',
            'high',
            'admin'
        );

        // After adding an item, redirect to the cart table so the user can see the updated list.
        return redirect()->route('cart.table')->with('success', 'Item added to cart for selected customer!');
    }

    private function updateCartTotals($customerId)
    {
        $cartItems = Cart::where('customer_id', $customerId)->get();

        $subtotal = $cartItems->sum(fn($item) => $item->price_at_add_time * $item->quantity);
        $tax = $cartItems->sum('tax_amount');
        $shipping = 50;
        $discount = 0;
        $total = $subtotal + $tax + $shipping - $discount;

        CartTotal::updateOrCreate(
            ['customer_id' => $customerId],
            [
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'discount' => $discount,
                'total' => $total,
                'items_count' => $cartItems->sum('quantity'),
                'currency' => 'INR',
            ]
        );
    }
    
    public function toggleStatus($id)
    {
     $cart = Cart::findOrFail($id);

     // Toggle 1 ↔ 0
     $cart->status = $cart->status == 1 ? 0 : 1;
     $cart->save();
     return redirect()->route('cart.table')->with('success', 'Cart status updated successfully!');

    } 

    public function table(Request $request)
    {
        $query = Cart::with('customer', 'product')->orderBy('customer_id');
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('customer', function($q) use ($search) {
                $q->where('username', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%');
            })->orWhereHas('product', function($q) use ($search) {
                $q->where('productname', 'LIKE', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Pagination with 10 items per page
        $carts = $query->paginate(10);
        
        return view('Cart.cart-table', [
            'carts' => $carts,
            'search' => $request->search ?? '',
            'status' => $request->status ?? ''
        ]);
    }
    public function delete($id)
    {
        $cart = Cart::findOrFail($id);
        $customerId = $cart->customer_id;
        $cart->delete();

        // update totals
        $this->updateCartTotals($customerId);

        return redirect()->route('cart.table')->with('success', 'Cart item deleted successfully!');
    }
    public function view($id)
    {
        $cart = Cart::with('customer', 'product')->findOrFail($id);
        return view('Cart.cart-view', ['cartItem' => $cart]);
    }
}
