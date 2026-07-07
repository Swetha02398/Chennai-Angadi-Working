<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Customer\DashController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\WishlistController;
use App\Http\Controllers\Web\OfferProductController;
use App\Http\Controllers\Web\OurProductController;
use App\Http\Controllers\Web\AddtoCartController;
use App\Http\Controllers\Web\ReviewController;
use App\Http\Controllers\Web\CouponController;
use App\Http\Controllers\Web\CheckoutController;
//  Protected routes (authenticated users only)

Route::get('/index', [ProductController::class, 'index'])->name('index');
// add other protected routes here (search, dashboard, etc.)



Route::get('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('store');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/insert', [LoginController::class, 'insert'])->name('insert');

Route::post('/send-otp', [LoginController::class, 'sendOtp'])->name('send.otp');
Route::get('/forgetpassword', [LoginController::class, 'showForgetForm'])->name('auth.forgetpassword');
Route::post('/send-otp', [LoginController::class, 'sendOtp'])->name('sendotp');
Route::post('/verify-otp', [LoginController::class, 'verifyOtp'])->name('verifyotp');
Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('resetpassword');


// -----  Customer Profile ------
Route::get('/myAccount', [DashController::class, 'myAccount'])->name('customer.myAccount');
Route::get('/order/{id}', [DashController::class, 'getOrderDetails'])->name('customer.order.details')->middleware('auth:customer');
// Route::get('/profile', [DashController::class, 'profileView'])->name('customer.profile');
Route::post('/profile/update', [DashController::class, 'profileUpdate'])->name('update')->middleware('auth:customer');
Route::get('/logout', [DashController::class, 'logout'])->name('logout');


// 👇 Category show route (same controller)
Route::get('/ajax/categories', [CategoryController::class, 'ajaxList'])->name('ajax.categories');
// Category products loop route
Route::get('/category/{id}', [CategoryController::class, 'products'])->name('category.products');
// Subcategory products loop route
Route::get('/subcategory/{id}', [CategoryController::class, 'subcategoryProducts'])->name('subcategory.products');
// Child category products route
Route::get('/childcategory/{id}', [CategoryController::class, 'childcategoryProducts'])->name('childcategory.products');
// Quick view route
Route::get('/product/quick-view/{id}', [ProductController::class, 'quickView'])->name('product.quickview');

// Wishlist Routes
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])
    ->name('wishlist.toggle');
Route::get('/wishlist', [WishlistController::class, 'wishlistview'])->name('customer.wishlist');
Route::delete('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

// Offer PRoducts route

Route::get('/offers', [OfferProductController::class, 'index'])->name('offers.index');
Route::get('/offer-section', [OfferProductController::class, 'section'])->name('offer.section');



// our product routes

Route::get('/', [OurProductController::class, 'index'])->name('home');
Route::get('/index', [OurProductController::class, 'index'])->name('index');


// ✅ AJAX filter route
Route::get('/filter-products/{categorySlug?}', [OurProductController::class, 'categoryFilterAjax'])->name('filter.products');
Route::get('/product/{id}', [OurProductController::class, 'view'])->name('product.details');

//Shop page route
Route::get('/shop', [OurProductController::class, 'shop'])->name('shop');


// Add to cart route - NO AUTH REQUIRED (session-based for guests)
Route::post('/add-to-cart', [AddtoCartController::class, 'addtocart'])->name('add-to-cart');
Route::get('/cart', [AddtoCartController::class, 'cartPage'])->name('cart.page');
Route::get('/cart-json', [AddtoCartController::class, 'getCartJson'])->name('cart.json');
Route::post('/update-cart-qty', [AddtoCartController::class, 'updateQty'])->name('update.cart.qty');
Route::post('/cart/update-quantity', [AddtoCartController::class, 'updateCartQuantity'])->name('cart.update-quantity');
Route::post('/remove-from-cart', [AddtoCartController::class, 'removeFromCart'])->name('remove.from.cart');
Route::post('/cart/remove', [AddtoCartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/clear-cart', [AddtoCartController::class, 'clearCart'])->name('clear.cart');
Route::get('/cart-count', [AddtoCartController::class, 'getCartCount'])->name('cart.count');
Route::post('/cart/store-coupon', [AddtoCartController::class, 'storeCouponInSession'])->name('cart.store-coupon');
Route::post('/cart/clear-coupon', [AddtoCartController::class, 'clearCouponFromSession'])->name('cart.clear-coupon');

// Checkout routes - Works for both guests and logged-in users
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/guest-continue', [CheckoutController::class, 'guestContinue'])->name('checkout.guest-continue');
Route::post('/checkout/save-draft', [CheckoutController::class, 'saveDraftOrder'])->name('checkout.save-draft');
Route::get('/checkout/billing-information', [CheckoutController::class, 'billingInformation'])->name('checkout.billing-information');
Route::post('/checkout/save-billing', [CheckoutController::class, 'saveBilling'])->name('checkout.save-billing');
Route::get('/checkout/order-review', [CheckoutController::class, 'orderReview'])->name('checkout.order-review');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
Route::post('/checkout/login', [CheckoutController::class, 'checkoutLogin'])->name('checkout.login');
Route::post('/checkout/calculate-shipping', [CheckoutController::class, 'calculateShipping'])->name('checkout.calculate-shipping');
Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
Route::post('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.remove-coupon');
Route::post('/checkout/razorpay/create-order', [CheckoutController::class, 'createRazorpayOrder'])->name('checkout.razorpay.create-order');
Route::post('/checkout/razorpay/verify-payment', [CheckoutController::class, 'verifyRazorpayPayment'])->name('checkout.razorpay.verify-payment');
Route::post('/checkout/track-order', [CheckoutController::class, 'trackOrder'])->name('checkout.track-order');
Route::post('/checkout/abandon-guest', [CheckoutController::class, 'abandonGuestSession'])->name('checkout.abandon-guest');
Route::get('/checkout-order', [CheckoutController::class, 'checkoutOrder'])->name('checkout-order');

// Review routes

// routes/web.php (frontend routes)
Route::post('/review-submit', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth:customer');
Route::post('/apply-coupon', [CouponController::class, 'apply'])->name('coupon.apply')->middleware('auth:customer');


// about us page route
Route::get('/about', [ProductController::class, 'about'])->name('pages.about');

// Contact us page route
Route::get('/contact', [ProductController::class, 'contact'])->name('pages.contact');
Route::post('/contact', [ProductController::class, 'storeContact'])->name('pages.contact.store');

// Offer page route
Route::get('/offer', [ProductController::class, 'offer'])->name('pages.offer');

// privacy policy page route
Route::get('/privacy-policy', [ProductController::class, 'privacyPolicy'])->name('pages.privacy-policy');

// terms and condition page route
Route::get('/terms-condition', [ProductController::class, 'termsCondition'])->name('pages.terms-condition');

// return and refund page route
Route::get('/return-refund', [ProductController::class, 'returnRefund'])->name('pages.return-refund');

// shipping details page route
Route::get('/shipping-details', [ProductController::class, 'shippingDetails'])->name('pages.shipping-details');
// order track page route
Route::get('/order-track', [ProductController::class, 'ordertrack'])->name('order.track');

// Search routes
Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/search/suggestions', [ProductController::class, 'searchSuggestions'])->name('search.suggestions');




Route::get('/test-mail', function () {
    try {
        Mail::raw('This is a TEST mail from Laravel at ' . now(), function ($message) {
            $message->to('swethamary22022005@gmail.com')
                    ->subject('Laravel SMTP Test - ' . time());
        });

        return 'Mail Sent Successfully';
    } catch (\Exception $e) {
        return 'Mail Failed: ' . $e->getMessage();
    }
});