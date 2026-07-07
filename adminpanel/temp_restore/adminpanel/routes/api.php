<?php
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\NotificationApiController;
use App\Http\Controllers\Api\RegisterController;
use App\Helpers\NotificationHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CouponApiController;
use App\Http\Controllers\Api\AddressbookApiController;
use App\Http\Controllers\Api\OfferApiController;
use App\Http\Controllers\Api\SliderApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ShippingApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/customers/login', [RegisterController::class, 'login']);
Route::post('/customers/register', [RegisterController::class, 'customerRegister']);

// Forgot Password API Routes
Route::post('/customers/forgot-password', [RegisterController::class, 'forgotPassword']);
Route::post('/customers/verify-otp', [RegisterController::class, 'verifyOtp']);
Route::post('/customers/reset-password', [RegisterController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/customers', [RegisterController::class, 'customer']);
    Route::get('/customers/{id}', [RegisterController::class, 'customerView']);
    Route::delete('/customers/{id}', [RegisterController::class, 'deleteCustomer']);
    Route::patch('/customers/{id}/toggle', [RegisterController::class, 'toggleStatus']);
    Route::post('/customers/profile/update', [RegisterController::class, 'profileUpdate']);
    Route::post('/customers/logout', [RegisterController::class, 'logout']);
});

// Category API Routes

Route::get('/main-category', [CategoryApiController::class, 'getMainCategory']);
Route::get('/sub-category/{main_id}', [CategoryApiController::class, 'getSubCategory']);
Route::get('/child-category/{main_id}/{sub_id}', [CategoryApiController::class, 'getChildCategory']);
Route::get('/category/products', [CategoryApiController::class, 'getCategoryProducts']);


// Product API Routes - Specific routes MUST come before {id} wildcard
Route::get('/products/featured', [ProductApiController::class, 'featuredProducts']);
Route::get('/products/top-selling', [ProductApiController::class, 'topSellingProducts']);
Route::get('/products/trending', [ProductApiController::class, 'trendingProducts']);
Route::get('/products/hot-deals', [ProductApiController::class, 'hotDealProducts']);
Route::get('/products/filter', [ProductApiController::class, 'productsByCategory']);
Route::get('/products', [ProductApiController::class, 'allProducts']);
Route::get('/products/{id}', [ProductApiController::class, 'singleProduct']);

// Coupon API Routes
Route::prefix('coupon')->group(function () {
    Route::get('/', [CouponApiController::class, 'index']);
    Route::get('/{id}', [CouponApiController::class, 'show']);
    Route::delete('/delete/{id}', [CouponApiController::class, 'destroy']);
    Route::post('/apply', [CouponApiController::class, 'applyCoupon']);
    Route::post('/remove', [CouponApiController::class, 'removeCoupon']);
});

// Notifications API Routes
Route::prefix('notifications')->group(function () {
    Route::post('/update-token', [NotificationApiController::class, 'updateToken']);
    Route::get('/user/{userId}', [NotificationApiController::class, 'index']);
    Route::get('/{userId}', [NotificationApiController::class, 'index']);
    Route::post('/create', [NotificationApiController::class, 'store']);
    Route::get('/unread/{userId}', [NotificationApiController::class, 'unread']);
    Route::put('/update/{id}', [NotificationApiController::class, 'update']);
    Route::post('/read/{notificationUserId}/{userId}', [NotificationApiController::class, 'markRead']);
    Route::post('/read-all/{userId}', [NotificationApiController::class, 'markAllRead']);
    Route::delete('/{id}', [NotificationApiController::class, 'destroy']);
});





// Address Book API Routes

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/addresses', [AddressbookApiController::class, 'index']);
    Route::post('/addresses', [AddressbookApiController::class, 'store']);
    Route::get('/addresses/{id}', [AddressbookApiController::class, 'show']);
    Route::put('/addresses/{id}', [AddressbookApiController::class, 'update']);
    Route::delete('/addresses/{id}', [AddressbookApiController::class, 'destroy']);
    Route::get('/customer/addresses', [AddressbookApiController::class, 'customerAddress']);
    // Route::get('/customer/{id}/addresses', [AddressbookApiController::class, 'customerAddress']);

    // Customer Order Routes
    Route::get('/customer/orders', [OrderApiController::class, 'customerOrders']);
});


Route::get('offers', [OfferApiController::class, 'index']);
Route::get('offers/{id}', [OfferApiController::class, 'show']);
Route::delete('offers/{id}', [OfferApiController::class, 'destroy']);




Route::get('/sliders', [SliderApiController::class, 'index']);       // all / filter
Route::get('/sliders/grouped', [SliderApiController::class, 'grouped']); // grouped by position
Route::get('/sliders/{id}', [SliderApiController::class, 'show']);
// single


// Order API Routes
Route::get('/order/track/{order_number}', [OrderApiController::class, 'showByOrderNumber']); // Public tracking
Route::post('/orders/capture', [OrderApiController::class, 'checkoutCapture']);              // Capture draft order
Route::post('/orders', [OrderApiController::class, 'store']);                               // Create order (Public/Guest/Auth)
Route::post('/orders/razorpay/create', [OrderApiController::class, 'createRazorpayOrder']); // Create Razorpay order (Public)
Route::post('/orders/razorpay/verify', [OrderApiController::class, 'verifyPayment']);       // Verify Razorpay payment (Public)

// Admin Order Management (Protected)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/orders', [OrderApiController::class, 'index']);                    // Get all orders
    Route::get('/orders/{id}', [OrderApiController::class, 'show']);                // Get single order by ID
    Route::put('/orders/{id}/status', [OrderApiController::class, 'updateStatus']); // Update order status
    Route::put('/orders/{id}/notes', [OrderApiController::class, 'updateNotes']);   // Update order notes
    Route::delete('/orders/{id}', [OrderApiController::class, 'destroy']);          // Delete order
});


// Shipping API Routes
Route::post('/shipping/calculate', [ShippingApiController::class, 'calculateCharge']);
Route::get('/shipping/zones', [ShippingApiController::class, 'getShippingZones']);
Route::get('/shipping/states', [ShippingApiController::class, 'getShippingStates']);
Route::get('/shipping/rules', [ShippingApiController::class, 'getShippingRules']);

// -----------------------------
// Admin Cache Management API
// -----------------------------
Route::middleware(['auth:sanctum', 'is_super_admin'])->prefix('admin/cache')->group(function () {
    Route::get('/status', [\App\Http\Controllers\Api\Admin\SmartCacheApiController::class, 'status']);
    Route::post('/clear', [\App\Http\Controllers\Api\Admin\SmartCacheApiController::class, 'clear']);
    Route::post('/rebuild', [\App\Http\Controllers\Api\Admin\SmartCacheApiController::class, 'rebuild']);
    Route::get('/auto', [\App\Http\Controllers\Api\Admin\SmartCacheApiController::class, 'getAutoClear']);
    Route::post('/auto', [\App\Http\Controllers\Api\Admin\SmartCacheApiController::class, 'updateAutoClear']);
});

// -----------------------------
// Contact Enquiry API
// -----------------------------
Route::post('/contact/store', [\App\Http\Controllers\Api\ContactEnquiryApiController::class, 'store']);
