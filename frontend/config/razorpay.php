<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Razorpay API Keys
    |--------------------------------------------------------------------------
    |
    | These are your Razorpay API credentials. Make sure to set these
    | in your .env file for security.
    |
    */

    'key_id' => env('RAZORPAY_KEY_ID', ''),
    'key_secret' => env('RAZORPAY_KEY_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    |
    | The default currency for Razorpay transactions.
    |
    */

    'currency' => env('RAZORPAY_CURRENCY', 'INR'),
];
