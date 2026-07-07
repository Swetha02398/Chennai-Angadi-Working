<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function wishlistview()
    {
        // Check if user is logged in
        if (!Auth::guard('customer')->check()) {
            // Guest user - get wishlist from session
            $guestWishlist = session()->get('guest_wishlist', []);

            // Get products from guest wishlist
            $wishlists = collect([]);
            if (!empty($guestWishlist)) {
                $products = Product::with('variants')->whereIn('id', $guestWishlist)->get();
                // Convert to a format similar to Wishlist model for view compatibility
                foreach ($products as $product) {
                    $wishlists->push((object) [
                        'product_id' => $product->id,
                        'product' => $product
                    ]);
                }
            }

            return view('wishlist.wishlist', compact('wishlists'));
        }

        $customerId = Auth::guard('customer')->id();

        $wishlists = Wishlist::with(['product', 'product.variants'])
            ->where('customer_id', $customerId)
            ->latest()
            ->get();

        return view('wishlist.wishlist', compact('wishlists'));
    }

    public function remove($id)
    {
        // Check if user is logged in
        if (!Auth::guard('customer')->check()) {
            // Guest user - remove from session
            $guestWishlist = session()->get('guest_wishlist', []);
            $guestWishlist = array_filter($guestWishlist, function ($productId) use ($id) {
                return $productId != $id;
            });
            session()->put('guest_wishlist', array_values($guestWishlist));

            return redirect()->route('customer.wishlist')
                ->with('success', 'Product removed from your wishlist!');
        }

        $customerId = Auth::guard('customer')->id();

        $wishlist = Wishlist::where('customer_id', $customerId)
            ->where('product_id', $id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return redirect()->route('customer.wishlist')
                ->with('success', 'Product removed from your wishlist!');
        }

        return redirect()->route('customer.wishlist')
            ->with('error', 'Product not found in your wishlist!');
    }


    // ❤️ Add / Remove wishlist - Works for both guests and logged-in users

    public function toggle(Request $request)
    {
        // Get product_id from request (works for both JSON and form data)
        $productId = $request->input('product_id');

        if (!$productId) {
            return response()->json([
                'error' => 'Product ID is required',
                'added' => false,
                'debug' => 'product_id was null or empty'
            ], 400);
        }

        // Validate product exists
        $product = Product::find($productId);
        if (!$product) {
            return response()->json([
                'error' => 'Product not found',
                'added' => false
            ], 404);
        }

        // Check if user is logged in
        if (!auth('customer')->check()) {
            // GUEST USER: Use session-based wishlist
            $guestWishlist = session()->get('guest_wishlist', []);

            // Check if product is already in wishlist
            $key = array_search($productId, $guestWishlist);

            if ($key !== false) {
                // Product exists in wishlist, so REMOVE it
                unset($guestWishlist[$key]);
                session()->put('guest_wishlist', array_values($guestWishlist));

                return response()->json([
                    'added' => false,
                    'removed' => true,
                    'count' => count($guestWishlist),
                    'debug' => 'Guest: Product removed from session wishlist',
                    'product_id_received' => $productId
                ]);
            }

            // Product not in wishlist, so ADD it
            $guestWishlist[] = (int) $productId;
            session()->put('guest_wishlist', $guestWishlist);

            return response()->json([
                'added' => true,
                'removed' => false,
                'count' => count($guestWishlist),
                'debug' => 'Guest: Product added to session wishlist',
                'product_id_received' => $productId
            ]);
        }

        // LOGGED-IN USER: Use database
        $customer = auth('customer')->user();

        // Debug: Log all request data
        \Log::info('Wishlist toggle request', [
            'product_id' => $productId,
            'customer_id' => $customer->id,
            'all_input' => $request->all()
        ]);

        $wishlist = Wishlist::where('customer_id', $customer->id)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            // Product exists in wishlist, so REMOVE it
            $wishlist->delete();
            return response()->json([
                'added' => false,
                'removed' => true,
                'count' => Wishlist::where('customer_id', $customer->id)->count(),
                'debug' => 'Product was found in wishlist, removed it',
                'product_id_received' => $productId
            ]);
        }

        // Product not in wishlist, so ADD it
        Wishlist::create([
            'customer_id' => $customer->id,
            'product_id' => $productId
        ]);

        return response()->json([
            'added' => true,
            'removed' => false,
            'count' => Wishlist::where('customer_id', $customer->id)->count(),
            'debug' => 'Product was NOT in wishlist, added it',
            'product_id_received' => $productId
        ]);
    }

}
