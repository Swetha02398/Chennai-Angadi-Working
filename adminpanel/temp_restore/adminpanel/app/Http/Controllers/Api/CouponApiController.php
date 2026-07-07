<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponApiController extends Controller
{
    // Get all coupons
    public function index(Request $request)
    {
         $perPage = $request->query('per_page', 10);
        $coupons = Coupon::paginate($perPage)->withQueryString();
        return response()->json([
            'status' => true,
            'data' => $coupons,
        ]);
    }

    // Get single coupon
    public function show($id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $coupon,
        ]);
    }

   

     // Delete coupon
    public function destroy($id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon not found'
            ], 404);
        }

        $coupon->delete();

        return response()->json([
            'status' => true,
            'message' => 'Coupon deleted successfully'
        ]);
    }

    // Apply Coupon 
   
    public function applyCoupon(Request $request)
    {
        // ✅ 1. Validate input
        $request->validate([
            'code' => 'required|string',
            'cart_total' => 'required|numeric|min:0',
        ], [
            'code.required' => 'Coupon code is required',
            'cart_total.required' => 'Cart total is required',
            'cart_total.numeric' => 'Cart total must be a number',
        ]);

        $code = strtoupper(trim($request->code));

        // ✅ 2. Find coupon by code (case-insensitive)
        $coupon = Coupon::whereRaw('UPPER(code) = ?', [$code])->first();

        if (!$coupon) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid coupon code - Coupon not found',
            ], 404);
        }

        // ✅ 3. Check coupon active status
        if (!$coupon->status) {
            return response()->json([
                'status' => false,
                'message' => 'This coupon is inactive',
            ], 400);
        }

        // ✅ 4. Check start and end date/time
        $now = now('Asia/Kolkata');
        
        if ($coupon->start_date) {
            $startDate = \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d');
            $startTime = $coupon->start_time ? date('H:i:s', strtotime($coupon->start_time)) : '00:00:00';
            $startDateTime = \Carbon\Carbon::parse($startDate . ' ' . $startTime, 'Asia/Kolkata');
            
            if ($now->lt($startDateTime)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Coupon not started yet. Valid from: ' . $startDateTime->format('d M Y, h:i A'),
                ], 400);
            }
        }

        if ($coupon->end_date) {
            $endDate = \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d');
            $endTime = $coupon->end_time ? date('H:i:s', strtotime($coupon->end_time)) : '23:59:59';
            $endDateTime = \Carbon\Carbon::parse($endDate . ' ' . $endTime, 'Asia/Kolkata');
            
            if ($now->gt($endDateTime)) {
                // Auto-deactivate if expired
                $coupon->update(['status' => 0]);
                return response()->json([
                    'status' => false,
                    'message' => 'Coupon has expired',
                ], 400);
            }
        }

        // ✅ 5. Check usage limits
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json([
                'status' => false,
                'message' => 'Coupon usage limit reached',
            ], 400);
        }

        // ✅ 6. Check per-user limit
        if ($coupon->per_user_limit) {
            $user = Auth::guard('sanctum')->user();
            if ($user) {
                $userUsage = \DB::table('coupon_user')->where([
                    'coupon_id' => $coupon->id,
                    'user_id' => $user->id
                ])->count();

                if ($userUsage >= $coupon->per_user_limit) {
                    return response()->json([
                        'status' => false,
                        'message' => 'You have already reached the usage limit for this coupon.',
                    ], 400);
                }
            }
        }

        // ✅ 7. Check minimum cart amount
        if ($coupon->min_amount && $request->cart_total < $coupon->min_amount) {
            return response()->json([
                'status' => false,
                'message' => 'Minimum order amount not reached. Minimum required: ' . $coupon->min_amount,
            ], 400);
        }

        // ✅ 7. Calculate discount
        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = ($request->cart_total * $coupon->value) / 100;
            if ($coupon->max_discount) {
                $discount = min($discount, $coupon->max_discount);
            }
        } else {
            $discount = $coupon->value;
        }

        // ✅ 8. Final total after discount
        $finalTotal = max(0, $request->cart_total - $discount);

        // ✅ 9. Send response with standardized format
        return response()->json([
            'status' => true,
            'message' => 'Coupon applied successfully',
            'data' => [
                'coupon_id' => $coupon->id,
                'code' => $coupon->code,
                'type' => $coupon->type,
                'discount' => number_format($discount, 2),
                'original_total' => number_format($request->cart_total, 2),
                'final_total' => number_format($finalTotal, 2),
            ]
        ], 200);
    }

    // remove coupon
   public function removeCoupon(Request $request)
{
    // Validate cart total
    $request->validate([
        'cart_total' => 'required|numeric|min:0',
    ], [
        'cart_total.required' => 'Cart total is required',
        'cart_total.numeric' => 'Cart total must be a number',
    ]);

    // Coupon removed → no discount
    return response()->json([
        'status' => true,
        'message' => 'Coupon removed successfully',
        'data' => [
            'discount'      => 0,
            'original_total'=> number_format($request->cart_total, 2),
            'final_total'   => number_format($request->cart_total, 2),
            'coupon'        => null
        ]
    ], 200);
}
    


}
