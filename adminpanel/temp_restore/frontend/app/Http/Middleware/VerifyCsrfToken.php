<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'checkout/place-order',
        'checkout/razorpay/*',
        'checkout/calculate-shipping',
        'checkout/apply-coupon',
        'checkout/remove-coupon',
        'checkout/login',
        'send-otp',
        'verify-otp',
        'reset-password',
        'add-to-cart',
        'update-cart-qty',
        'cart/update-quantity',
        'remove-from-cart',
        'cart/remove',
        'clear-cart',
        'cart/store-coupon',
        'cart/clear-coupon',
        'wishlist/toggle',
        'checkout/guest-continue',
        'checkout/save-draft',
        'contact',
    ];
}
