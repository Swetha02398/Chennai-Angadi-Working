<?php

namespace App\Http\Controllers\Web\Customer;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;

class DashController extends Controller
{
    public function myAccount()
    {
        // Check if customer is logged in using the 'customer' guard
        if (!Auth::guard('customer')->check()) {
            // Guest user - show page with empty orders
            $customer = null;
            $orders = collect([]);
            return view('customer.myAccount', compact('customer', 'orders'));
        }

        // Get the logged in customer
        $customer = Auth::guard('customer')->user();

        // Extra check: If customer is inactive, logout immediately
        if (empty($customer->status) || $customer->status == 0) {
            Auth::guard('customer')->logout();
            return redirect()->route('login')->with('error', 'Your account has been deactivated.');
        }

        // Fetch all orders for this customer with items (newest first)
        $orders = Order::where('customer_id', $customer->id)
            ->with('items')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.myAccount', compact('customer', 'orders'));

    }

    /**
     * Get order details for AJAX request
     */
    public function getOrderDetails($id)
    {
        try {
            // Check if customer is logged in
            if (!Auth::guard('customer')->check()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $customerId = Auth::guard('customer')->id();

            // Fetch order with items and product details, validate ownership
            $order = Order::where('id', $id)
                ->where('customer_id', $customerId)
                ->with(['items.product'])
                ->first();

            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order not found'], 404);
            }

            // Transform order to include product images
            $orderData = $order->toArray();
            $adminAssetUrl = env('ADMIN_ASSET_URL', '');

            // Add product image URL to each item
            foreach ($orderData['items'] as $key => $item) {
                $productImage = null;
                if (isset($item['product']) && isset($item['product']['productimage'])) {
                    $images = $item['product']['productimage'];
                    if (is_array($images) && count($images) > 0) {
                        $imagePath = $images[0];
                        // Clean the path - remove backslashes and get basename
                        $imagePath = str_replace('\\', '/', $imagePath);
                        $imageName = basename($imagePath);
                        $productImage = $adminAssetUrl . '/products/' . $imageName;
                    } elseif (is_string($images)) {
                        $images = str_replace('\\', '/', $images);
                        $imageName = basename($images);
                        $productImage = $adminAssetUrl . '/products/' . $imageName;
                    }
                }
                $orderData['items'][$key]['product_image'] = $productImage ?: asset('assets/imgs/shop/product-1-1.jpg');
            }

            return response()->json([
                'success' => true,
                'order' => $orderData
            ]);

        } catch (\Exception $e) {
            \Log::error('Get order details error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to fetch order details'], 500);
        }
    }


    public function profileUpdate(Request $req)
    {
        $customer = Auth::guard('customer')->user();

        $req->validate([
            'username' => 'required',
            'email' => 'required|email',
            'mobilenumber' => 'required',
            'address' => 'required',
            'pin' => 'required',
            'gender' => 'nullable',
            'dob' => 'nullable|date',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'profile_image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($req->hasFile('profile_image')) {
            $imageName = time() . '.' . $req->profile_image->extension();
            $req->profile_image->move(public_path('uploads/profile'), $imageName);
            $customer->profile_image = $imageName;
        }

        $customer->fill($req->except('profile_image'));
        $customer->save();

        return redirect()->route('customer.myAccount')->with('success', 'Profile updated successfully');
    }

    // Logout user
    public function logout()
    {
        Auth::guard('customer')->logout();
        return redirect('/');
    }





}
