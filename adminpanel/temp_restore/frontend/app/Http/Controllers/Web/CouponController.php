<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Apply coupon code
     * Note: This route is deprecated - use checkout/apply-coupon instead
     */
    public function apply(Request $request)
    {
        // Redirect to checkout apply coupon route
        return app(\App\Http\Controllers\Web\CheckoutController::class)->applyCoupon($request);
    }
}
