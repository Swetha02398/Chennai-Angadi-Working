<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\ForgotPasswordController;
use App\Http\Controllers\Web\Auth\UserController;
use App\Http\Controllers\Web\Product\ProductController;
use App\Http\Controllers\Web\Category\MainCategoryController;
use App\Http\Controllers\Web\Category\SubCategoryController;
use App\Http\Controllers\Web\Category\ChildCategoryController;
use App\Http\Controllers\Web\Inventory\InventoryController;
use App\Http\Controllers\Web\Notification\NotificationController;
use App\Http\Controllers\Web\Coupon\CouponController;
use App\Http\Controllers\Web\Cart\CartController;
use App\Http\Controllers\Web\GstHsn\GstController;
use App\Http\Controllers\Web\GstHsn\HsnCodeController;
use App\Http\Controllers\Web\AddressBook\AddressController;
use App\Http\Controllers\Web\Offer\OfferController;
use App\Http\Controllers\Web\Review\ReviewController;
use App\Http\Controllers\Web\Quantity\QuantityController;
use App\Http\Controllers\Web\Shipping\ShippingZoneController;
use App\Http\Controllers\Web\Shipping\ShippingZoneRegionController;
use App\Http\Controllers\Web\Shipping\ShippingRuleController;
use App\Http\Controllers\Web\Slider\SliderController;
use App\Http\Controllers\Web\Order\BillingController;
use App\Http\Controllers\Web\Order\OrderController;
use App\Http\Controllers\Web\Report\ReportController;
use App\Http\Controllers\Web\EmailHistroy\EmailHistroyController;
use App\Http\Controllers\Web\Admin\AdminPermissionWebController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Guest routes (register & login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');

    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    // Forgot Password Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showEmailForm'])->name('password.request');
    Route::post('/forgot-password/email', [ForgotPasswordController::class, 'sendOtp'])->name('password.email');
    Route::get('/forgot-password/otp', [ForgotPasswordController::class, 'showOtpForm'])->name('password.otp.form');
    Route::post('/forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify.otp');
    Route::get('/forgot-password/reset', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/forgot-password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

// Logout (authenticated)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Category API Routes for dropdowns
Route::get('/get-subcategories/{category_id}', function ($category_id) {
    $subcategories = \App\Models\SubCategory::where('main_category_id', $category_id)
        ->where('status', 'active')
        ->get(['id', 'name']);
    return response()->json($subcategories);
})->name('get.subcategories');

Route::get('/get-childcategories/{subcategory_id}', function ($subcategory_id) {
    $childcategories = \App\Models\ChildCategory::where('sub_category_id', $subcategory_id)
        ->where('status', 'active')
        ->get(['id', 'name']);
    return response()->json($childcategories);
})->name('get.childcategories');

// Protected routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/dashboard/filter-orders', [ProductController::class, 'filterOrders'])->name('dashboard.filter.orders');

    // Profile
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('edit-profile');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('update-profile');

    // Search
    Route::get('/search', [ProductController::class, 'search'])->name('search');

    // =====================================================
    // ADMIN & ROLE MANAGEMENT (SuperAdmin only)
    // =====================================================
    Route::middleware('permission:roles-view')->prefix('admin')->group(function () {
        // Roles
        Route::get('/roles', [AdminPermissionWebController::class, 'index'])->name('admin.roles.index');
        Route::get('/roles/table', [AdminPermissionWebController::class, 'index'])->name('admin.roles.table');
        Route::get('/roles/create', [AdminPermissionWebController::class, 'create'])->name('admin.roles.create')->middleware('permission:roles-create');
        Route::post('/roles', [AdminPermissionWebController::class, 'store'])->name('admin.roles.store')->middleware('permission:roles-create');
        Route::get('/roles/{id}/edit', [AdminPermissionWebController::class, 'edit'])->name('admin.roles.edit')->middleware('permission:roles-edit');
        Route::put('/roles/{id}', [AdminPermissionWebController::class, 'update'])->name('admin.roles.update')->middleware('permission:roles-edit');
        Route::delete('/roles/{id}', [AdminPermissionWebController::class, 'destroy'])->name('admin.roles.destroy')->middleware('permission:roles-delete');
        Route::patch('/roles/{id}/toggle', [AdminPermissionWebController::class, 'toggleRole'])->name('admin.roles.toggle')->middleware('permission:roles-edit');

        // Admin Users
        Route::get('/users', [AdminPermissionWebController::class, 'adminUsers'])->name('admin.users.index');
        Route::get('/users/table', [AdminPermissionWebController::class, 'adminUsers'])->name('admin.users.table');
        Route::get('/users/list', [AdminPermissionWebController::class, 'adminUsers'])->name('admin.users');
        Route::get('/users/create', [AdminPermissionWebController::class, 'createAdmin'])->name('admin.users.create')->middleware('permission:roles-create');
        Route::post('/users', [AdminPermissionWebController::class, 'storeAdmin'])->name('admin.users.store')->middleware('permission:roles-create');
        Route::get('/users/{id}/edit', [AdminPermissionWebController::class, 'editAdmin'])->name('admin.users.edit')->middleware('permission:roles-edit');
        Route::put('/users/{id}', [AdminPermissionWebController::class, 'updateAdmin'])->name('admin.users.update')->middleware('permission:roles-edit');
        Route::delete('/users/{id}', [AdminPermissionWebController::class, 'deleteAdmin'])->name('admin.users.delete')->middleware('permission:roles-delete');
        Route::patch('/users/{id}/toggle', [AdminPermissionWebController::class, 'toggleUser'])->name('admin.users.toggle')->middleware('permission:roles-edit');
    });

    // =====================================================
    // MODULE ROUTES (with permission middleware)
    // =====================================================

    // Main Category
    Route::middleware('permission:categories-view')->group(function () {
        Route::resource('maincategory', MainCategoryController::class);
        Route::patch('/maincategory/{id}/toggle', [MainCategoryController::class, 'toggleStatus'])->name('maincategory.toggle');
    });

    // Sub Category
    Route::middleware('permission:categories-view')->group(function () {
        Route::resource('subcategory', SubCategoryController::class);
        Route::patch('/subcategory/{id}/toggle', [SubCategoryController::class, 'SubtoggleStatus'])->name('subcategory.toggle');
    });

    // Child Category
    Route::middleware('permission:categories-view')->group(function () {
        Route::resource('childcategory', ChildCategoryController::class);
        Route::patch('/childcategory/{id}/toggle', [ChildCategoryController::class, 'ChildtoggleStatus'])->name('childcategory.toggle');
    });


    /* PRODUCT ROUTES */
    Route::middleware('permission:products-view')->group(function () {
        Route::get('/product/table', [ProductController::class, 'table'])->name('product.table');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('/product/view/{id}', [ProductController::class, 'view'])->name('product.view');
        Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::patch('/product/{id}/toggle', [ProductController::class, 'toggleStatus'])->name('product.toggle');
        Route::get('/product/{id}/units', [ProductController::class, 'units'])->name('product.units');
        Route::post('/product/{id}/variants', [ProductController::class, 'storeVariant'])->name('product.variant.store');
        Route::delete('/product-variants/{id}', [ProductController::class, 'deleteVariant'])->name('product.variant.delete');
        Route::patch('/product-variants/{id}/stock', [ProductController::class, 'updateVariantStock'])->name('product.variant.stock.update');
        Route::delete('/product/{id}/image', [ProductController::class, 'deleteImage'])->name('product.image.delete');
        Route::delete('/product/{id}/images', [ProductController::class, 'deleteImages'])->name('product.images.delete');
    });

    /* Inventory */
    Route::middleware('permission:inventory-view')->group(function () {
        Route::get('/product/inventory-table', [ProductController::class, 'inventoryTable'])->name('product.inventory.table');
        Route::post('/product/update-stock', [ProductController::class, 'updateStock'])->name('product.stock.update');
    });


    /*Notifications Routes */
    Route::middleware('permission:notifications-view')->group(function () {
        Route::get('/notifications/table', [NotificationController::class, 'index'])->name('notifications.table');
        Route::get('/notifications/admin', [NotificationController::class, 'adminNotifications'])->name('notifications.admin');
        Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
        Route::post('/notifications/store', [NotificationController::class, 'store'])->name('notifications.store');
        Route::get('/notifications/{notification}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');
        Route::put('/notifications/{notification}', [NotificationController::class, 'update'])->name('notifications.update');
        Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.view');
        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::post('/notifications/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.markRead');
        Route::post('/send-to-all', [NotificationController::class, 'sendToAll'])->name('notifications.sendToAll');
        Route::patch('/notification/{id}/toggle', [NotificationController::class, 'toggleStatus'])->name('notification.toggle');
    });

    /*Coupon & Discount Routes */
    Route::middleware('permission:coupons-view')->group(function () {
        Route::get('/coupon/table', [CouponController::class, 'table'])->name('coupon.table');
        Route::get('/coupon/create', [CouponController::class, 'create'])->name('coupon.create');
        Route::post('/coupon/store', [CouponController::class, 'store'])->name('coupon.store');
        Route::patch('/coupon/{id}/toggle', [CouponController::class, 'toggleStatus'])->name('coupon.toggle');
        Route::get('/coupon/edit/{id}', [CouponController::class, 'edit'])->name('coupon.edit');
        Route::put('/coupon/update/{id}', [CouponController::class, 'update'])->name('coupon.update');
        Route::get('/coupon/view/{id}', [CouponController::class, 'view'])->name('coupon.view');
        Route::delete('/coupon/delete/{id}', [CouponController::class, 'delete'])->name('coupon.delete');
    });

    /* Customer Routes*/
    Route::middleware('permission:customers-view')->group(function () {
        Route::get('/customerRegister', [RegisterController::class, 'customerRegister'])->name('customerRegister');
        Route::get('/customer', [RegisterController::class, 'customer'])->name('customer');
        Route::post('/customerRegister', [RegisterController::class, 'store'])->name('store');
        Route::post('/check-uniqueness', [RegisterController::class, 'checkUniqueness'])->name('check.uniqueness');
        Route::get('/customer/delete/{id}', [RegisterController::class, 'deleteCustomer'])->name('customer.delete');
        Route::patch('/customer/{id}/toggle', [RegisterController::class, 'toggleStatus'])->name('customer.toggleStatus');
        Route::get('/customer/view/{id}', [RegisterController::class, 'customerView'])->name('customerView');
        Route::get('/customers/export', [RegisterController::class, 'export'])->name('customers.export');
    });

    /* Cart Routes */
    Route::middleware('permission:products-view')->group(function () {
        Route::get('/cart/create', [CartController::class, 'create'])->name('cart.create');
        Route::post('/cart/store', [CartController::class, 'store'])->name('cart.store');
        Route::get('/cart/table', [CartController::class, 'table'])->name('cart.table');
        Route::patch('/cart/{id}/toggle', [CartController::class, 'toggleStatus'])->name('cart.toggle');
        Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
        Route::get('/cart/view/{id}', [CartController::class, 'view'])->name('cart.view');
    });

    /* GST & HsnCode Settings Routes */
    // Route::middleware('permission:gsthsn-view')->group(function () {
    //     Route::get('/gsthsn/table', [GstController::class, 'table'])->name('gsthsn.table');
    //     Route::get('/gsthsn/create', [GstController::class, 'create'])->name('gsthsn.create');
    //     Route::post('/gsthsn/store', [GstController::class, 'store'])->name('gsthsn.store');
    //     Route::get('/gsthsn/edit/{id}', [GstController::class, 'edit'])->name('gsthsn.edit');
    //     Route::post('/gsthsn/update/{id}', [GstController::class, 'update'])->name('gsthsn.update');
    //     Route::delete('/gsthsn/delete/{id}', [GstController::class, 'destroy'])->name('gsthsn.delete');
    // });

    /*Hsn*/
    // Route::middleware('permission:hsncode-view')->group(function () {
    //     Route::get('/hsncode/table', [HsnCodeController::class, 'table'])->name('hsncode.table');
    //     Route::get('/hsncode/create', [HsnCodeController::class, 'create'])->name('hsncode.create');
    //     Route::post('/hsncode/store', [HsnCodeController::class, 'store'])->name('hsncode.store');
    //     Route::get('/hsncode/edit/{id}', [HsnCodeController::class, 'edit'])->name('hsncode.edit');
    //     Route::post('/hsncode/update/{id}', [HsnCodeController::class, 'update'])->name('hsncode.update');
    //     Route::delete('/hsncode/delete/{id}', [HsnCodeController::class, 'destroy'])->name('hsncode.delete');
    //     Route::patch('/hsncode/{id}/toggle', [HsnCodeController::class, 'toggleStatus'])->name('hsncode.toggle');
    //     Route::get('/hsncode/view/{id}', [HsnCodeController::class, 'view'])->name('hsncode.view');
    // });

    /*AddressBook*/
    Route::middleware('permission:products-view')->group(function () {
        Route::get('/addressbook/table', [AddressController::class, 'table'])->name('addressbook.table');
        Route::get('/addressbook/create', [AddressController::class, 'create'])->name('addressbook.create');
        Route::post('/addressbook/store', [AddressController::class, 'store'])->name('addressbook.store');
        Route::get('/addressbook/edit/{id}', [AddressController::class, 'edit'])->name('addressbook.edit');
        Route::patch('/addressbook/{id}/toggle', [AddressController::class, 'toggleStatus'])->name('addressbook.toggle');
        Route::post('/addressbook/update/{id}', [AddressController::class, 'update'])->name('addressbook.update');
        Route::get('/addressbook/delete/{id}', [AddressController::class, 'destroy'])->name('addressbook.destroy');
        Route::get('/addressbook/view/{id}', [AddressController::class, 'view'])->name('addressbook.view');
    });

    /*Offer*/
    Route::middleware('permission:offers-view')->group(function () {
        Route::get('/offer/table', [OfferController::class, 'table'])->name('offer.table');
        Route::get('/offer/create', [OfferController::class, 'create'])->name('offer.create');
        Route::post('/offer/store', [OfferController::class, 'store'])->name('offer.store');
        Route::get('/offer/edit/{id}', [OfferController::class, 'edit'])->name('offer.edit');
        Route::patch('/offer/{id}/toggle', [OfferController::class, 'toggleStatus'])->name('offer.toggle');
        Route::post('/offer/update/{id}', [OfferController::class, 'update'])->name('offer.update');
        Route::post('/offer/delete/{id}', [OfferController::class, 'destroy'])->name('offer.delete');
        Route::get('/offer/view/{id}', [OfferController::class, 'show'])->name('offer.show');
        Route::post('/offer/check-priority', [OfferController::class, 'checkPriority'])->name('offer.check-priority');
    });


    /* Reviews Routes */
    Route::middleware('permission:products-view')->group(function () {
        Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');
        Route::get('/reviews', [ReviewController::class, 'index'])->name('review.table');
        Route::post('/review/{id}/approve', [ReviewController::class, 'approve'])->name('review.approve');
        Route::delete('/review/{id}', [ReviewController::class, 'destroy'])->name('review.delete');
        Route::get('/review/{id}', [ReviewController::class, 'show'])->name('review.view');
    });

    Route::middleware('permission:quantity-view')->prefix('quantity')->name('quantity.')->group(function () {
        Route::get('/', [QuantityController::class, 'index'])->name('index');
        Route::get('/table', [QuantityController::class, 'index'])->name('table');
        Route::get('/create', [QuantityController::class, 'create'])->name('create');
        Route::post('/store', [QuantityController::class, 'store'])->name('store');
        Route::get('/{quantity}/edit', [QuantityController::class, 'edit'])->name('edit');
        Route::put('/{quantity}', [QuantityController::class, 'update'])->name('update');
        Route::delete('/{quantity}', [QuantityController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/toggle', [QuantityController::class, 'toggle'])->name('toggle');

    });

    //Shipping Routes
    Route::middleware('permission:shipping-view')->prefix('shipping')->name('shipping.')->group(function () {
        // Zones
        Route::get('/zone/table', [ShippingZoneController::class, 'index'])->name('zone.table');
        Route::get('/zone/create', [ShippingZoneController::class, 'create'])->name('zone.create');
        Route::post('/zone/store', [ShippingZoneController::class, 'store'])->name('zone.store');
        Route::get('/zone/{id}/edit', [ShippingZoneController::class, 'edit'])->name('zone.edit');
        Route::put('/zone/{id}', [ShippingZoneController::class, 'update'])->name('zone.update');
        Route::delete('/zone/{id}', [ShippingZoneController::class, 'destroy'])->name('zone.destroy');
        Route::patch('/zone/{id}/toggle', [ShippingZoneController::class, 'toggle'])->name('zone.toggle');

        // States
        Route::get('/state/table', [ShippingZoneRegionController::class, 'index'])->name('state.table');
        Route::get('/state/create', [ShippingZoneRegionController::class, 'create'])->name('state.create');
        Route::post('/state', [ShippingZoneRegionController::class, 'store'])->name('state.store');
        Route::get('/state/{id}/edit', [ShippingZoneRegionController::class, 'edit'])->name('state.edit');
        Route::put('/state/{id}', [ShippingZoneRegionController::class, 'update'])->name('state.update');
        Route::delete('/state/{id}', [ShippingZoneRegionController::class, 'destroy'])->name('state.delete');
        Route::patch('/state/{id}/toggle', [ShippingZoneRegionController::class, 'toggle'])->name('state.toggle');

        // Rules
        Route::get('/rules/table', [ShippingRuleController::class, 'index'])->name('rules.table');
        Route::get('/rules/create', [ShippingRuleController::class, 'create'])->name('rules.create');
        Route::post('/rules/store', [ShippingRuleController::class, 'store'])->name('rules.store');
        Route::get('/rules/{id}/edit', [ShippingRuleController::class, 'edit'])->name('rules.edit');
        Route::put('rules/{id}', [ShippingRuleController::class, 'update'])->name('rules.update');
        Route::delete('/rules/{id}', [ShippingRuleController::class, 'destroy'])->name('rules.delete');
        Route::patch('/rules/{id}/toggle', [ShippingRuleController::class, 'toggle'])->name('rules.toggle');
        Route::get('/rules/{id}', [ShippingRuleController::class, 'show'])->name('rules.view');
        Route::get('/get-states-by-zone/{zone_id}', [ShippingRuleController::class, 'getStatesByZone'])->name('get-states-by-zone');
    });

    /*Slider Routes*/
    Route::middleware('permission:sliders-view')->group(function () {
        Route::get('/slider', [SliderController::class, 'index'])->name('slider.table');
        Route::get('/slider/create', [SliderController::class, 'create'])->name('slider.create');
        Route::post('/slider', [SliderController::class, 'store'])->name('slider.store');
        Route::get('/slider/{id}/edit', [SliderController::class, 'edit'])->name('slider.edit');
        Route::put('/slider/{id}', [SliderController::class, 'update'])->name('slider.update');
        Route::delete('/slider/delete/{id}', [SliderController::class, 'destroy'])->name('slider.destroy');
        Route::patch('/slider/{id}/toggle', [SliderController::class, 'toggleStatus'])->name('slider.toggle');
    });


    // -----------------------------
    // Admin Billing (POS)
    // -----------------------------
    Route::middleware('permission:billing-view')->group(function () {
        Route::get('billing/create', [BillingController::class, 'create'])->name('admin.billing.create');
        Route::get('billing/table', [BillingController::class, 'index'])->name('billing.table');
        Route::get('billing/invoice/{id}', [BillingController::class, 'invoice'])->name('admin.billing.invoice');
        Route::get('billing/invoice-html/{id}', [BillingController::class, 'getInvoiceHtml'])->name('admin.billing.invoice.html');
        Route::delete('billing/delete/{id}', [BillingController::class, 'destroy'])->name('admin.billing.delete');

        Route::post('billing/checkout', [BillingController::class, 'checkout'])->name('admin.billing.checkout');
        Route::post('billing/save-draft', [BillingController::class, 'saveDraft'])->name('admin.billing.save.draft');
        Route::post('billing/payment/update', [BillingController::class, 'updatePaymentStatus'])->name('admin.billing.payment.update');
        Route::post('billing/create-razorpay-order', [BillingController::class, 'createRazorpayOrderAPI'])->name('admin.billing.create.razorpay.order');
        Route::post('billing/verify-payment', [BillingController::class, 'verifyPayment'])->name('admin.billing.verify.payment');

        // Product variants JSON (for Ajax)
        Route::get('products/{id}/variants', [BillingController::class, 'variants'])->name('admin.products.variants');

        // Tax and Shipping API endpoints
        Route::get('billing/product-tax/{id}', [BillingController::class, 'getProductTax'])->name('admin.billing.product.tax');
        Route::get('billing/shipping-states', [BillingController::class, 'getShippingStates'])->name('admin.billing.shipping.states');
        Route::post('billing/calculate-shipping', [BillingController::class, 'calculateShipping'])->name('admin.billing.calculate.shipping');
        Route::post('billing/apply-coupon', [BillingController::class, 'applyCoupon'])->name('admin.billing.apply.coupon');
    });

    // -----------------------------
    // Frontend Orders
    // -----------------------------
    Route::middleware('permission:orders-view')->group(function () {
        Route::get('orders/table', [OrderController::class, 'index'])->name('orders.table');
        Route::get('orders/view/{id}', [OrderController::class, 'view'])->name('orders.view');
        Route::get('orders/{id}/add-product', [OrderController::class, 'showAddProduct'])->name('orders.add-product-page');
        Route::get('orders/edit/{id}', [OrderController::class, 'edit'])->name('orders.edit');
        Route::get('orders/invoice/{id}', [OrderController::class, 'show'])->name('orders.invoice');
        Route::get('orders/invoice-html/{id}', [OrderController::class, 'getInvoiceHtml'])->name('orders.invoice.html');
        Route::patch('orders/status/{id}', [OrderController::class, 'updateStatus'])->name('orders.status.update');
        Route::post('orders/update-payment-status/{id}', [OrderController::class, 'updatePaymentStatus'])->name('orders.payment-status.update');
        Route::delete('orders/delete/{id}', [OrderController::class, 'destroy'])->name('orders.delete');
        Route::post('orders/update-notes/{id}', [OrderController::class, 'updateNotes'])->name('orders.notes.update');
        Route::get('orders/get-variants/{productId}', [OrderController::class, 'getVariants'])->name('orders.get-variants');
        Route::post('orders/add-product/{orderId}', [OrderController::class, 'addProduct'])->name('orders.add-product');
        Route::post('orders/add-products/{orderId}', [OrderController::class, 'addProducts'])->name('orders.add-products');
        Route::get('orders/search-products', [OrderController::class, 'searchProducts'])->name('orders.search-products');
    });

    // -----------------------------
    // Reports
    // -----------------------------
    Route::middleware('permission:reports-view')->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/filter', [ReportController::class, 'filter'])->name('reports.filter');
        Route::get('reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
    });

    // -----------------------------
    // Email History
    // -----------------------------
    Route::middleware('permission:email-history-view')->group(function () {
        Route::get('email-history/table', [EmailHistroyController::class, 'index'])->name('email-history.table');
        Route::delete('email-history/delete/{id}', [EmailHistroyController::class, 'destroy'])->name('email-history.delete');
    });

    // -----------------------------
    // Smart Cache Management
    // -----------------------------
    Route::middleware('is_super_admin')->prefix('admin/cache')->name('admin.cache.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Web\Admin\SmartCacheController::class, 'index'])->name('index');
        Route::post('/clear', [\App\Http\Controllers\Web\Admin\SmartCacheController::class, 'clear'])->name('clear');
        Route::post('/rebuild', [\App\Http\Controllers\Web\Admin\SmartCacheController::class, 'rebuild'])->name('rebuild');
        Route::post('/update-auto', [\App\Http\Controllers\Web\Admin\SmartCacheController::class, 'updateAutoClear'])->name('update-auto');
    });

    // -----------------------------
    // Contact Enquiries
    // -----------------------------
    Route::prefix('contact-enquiries')->name('admin.contact.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Web\Contact\ContactEnquiryController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\Web\Contact\ContactEnquiryController::class, 'show'])->name('show');
        Route::delete('/{id}', [\App\Http\Controllers\Web\Contact\ContactEnquiryController::class, 'destroy'])->name('destroy');
    });

});
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

// ============================================================
// TEMPORARY: Manual Order + Invoice Mail Test Route
// Visit: /test-order-mail
// Purpose: Create a real order for Swetha, send InvoiceMail,
//          and surface the exact SMTP error if mail fails.
// DELETE THIS ROUTE AFTER TESTING IS DONE.
// ============================================================
Route::get('/test-order-mail', function () {
    // ---------- 1. Dump active mail config for debugging ----------
    $mailConfig = [
        'MAIL_MAILER (active driver)' => config('mail.default'),
        'SMTP Host'                   => config('mail.mailers.smtp.host'),
        'SMTP Port'                   => config('mail.mailers.smtp.port'),
        'SMTP Encryption'             => config('mail.mailers.smtp.encryption'),
        'SMTP Username'               => config('mail.mailers.smtp.username'),
        'SMTP Password set?'          => config('mail.mailers.smtp.password') ? 'YES (' . strlen(config('mail.mailers.smtp.password')) . ' chars)' : 'NO - EMPTY!',
        'From Address'                => config('mail.from.address'),
        'From Name'                   => config('mail.from.name'),
    ];

    $output = "<h2>Mail Config (Active)</h2><pre>" . print_r($mailConfig, true) . "</pre><hr>";

    // ---------- 2. Check if MAIL_MAILER is NOT smtp ----------
    if (config('mail.default') !== 'smtp') {
        $output .= "<h2 style='color:red;'>WARNING: MAIL_MAILER is set to '" . config('mail.default') . "' - NOT smtp!</h2>";
        $output .= "<p>This is WHY mail goes to <code>storage/logs/laravel.log</code> instead of being sent via SMTP.</p>";
        $output .= "<p><strong>Fix:</strong> Set <code>MAIL_MAILER=smtp</code> in your <code>.env</code> file, then run <code>php artisan config:clear</code>.</p>";
        return $output;
    }

    // ---------- 3. Find customer Swetha ----------
    $customer = \App\Models\Customer::where('email', 'swethamary22022005@gmail.com')->first();

    if (!$customer) {
        $output .= "<p style='color:red;'>Customer with email swethamary22022005@gmail.com not found in customers table.</p>";
        return $output;
    }

    $output .= "<p>Found customer: <b>{$customer->username}</b> (ID: {$customer->id}, Email: {$customer->email})</p>";

    // ---------- 4. Pick first available product ----------
    $product = \App\Models\Product::where('status', 1)->first();

    if (!$product) {
        $output .= "<p style='color:red;'>No active products found.</p>";
        return $output;
    }

    $variant = \App\Models\ProductVariant::where('product_id', $product->id)
        ->where('stock', '>', 0)
        ->first();

    $price = $variant ? $variant->selling_price : ($product->selling_price ?? $product->price ?? 100);
    $output .= "<p>Using product: <b>{$product->productname}</b> (Price: Rs.{$price})</p>";

    // ---------- 5. Create Order (COD) ----------
    try {
        $order = \App\Models\Order::create([
            'order_number'    => 'TEST-' . strtoupper(uniqid()),
            'order_type'      => 'billing',
            'order_source'    => 'admin_panel',
            'customer_type'   => 'registered',
            'customer_id'     => $customer->id,
            'guest_details'   => null,
            'shipping_address' => [
                'name'    => $customer->username,
                'address' => $customer->address ?? 'Test Address',
                'city'    => $customer->city ?? 'Chennai',
                'state'   => $customer->state ?? 'Tamil Nadu',
                'pin'     => $customer->pin ?? '600001',
                'phone'   => $customer->mobilenumber ?? '0000000000',
            ],
            'billing_address' => [
                'name'    => $customer->username,
                'address' => $customer->address ?? 'Test Address',
                'city'    => $customer->city ?? 'Chennai',
                'state'   => $customer->state ?? 'Tamil Nadu',
                'pin'     => $customer->pin ?? '600001',
                'phone'   => $customer->mobilenumber ?? '0000000000',
            ],
            'billing_type'    => 'offline',
            'payment_method'  => 'cash',
            'payment_provider' => 'cash',
            'payment_status'  => 'paid',
            'subtotal'        => $price,
            'discount_amount' => 0,
            'tax_amount'      => 0,
            'shipping_amount' => 0,
            'total_amount'    => $price,
            'final_amount'    => $price,
            'status'          => 'confirmed',
            'placed_at'       => now(),
        ]);

        \App\Models\OrderItem::create([
            'order_id'            => $order->id,
            'product_id'          => $product->id,
            'product_variant_id'  => $variant->id ?? null,
            'product_productname' => $product->productname,
            'variant_name'        => $variant->name ?? null,
            'price'               => $price,
            'qty'                 => 1,
            'total'               => $price,
        ]);

        $output .= "<p>Order created: <b>{$order->order_number}</b> (ID: {$order->id})</p><hr>";

    } catch (\Exception $e) {
        $output .= "<p style='color:red;'>Order creation failed: " . htmlspecialchars($e->getMessage()) . "</p>";
        return $output;
    }

    // ---------- 6. Send InvoiceMail (the real test) ----------
    try {
        $order->load(['customer', 'items.product', 'items.variant.quantity']);

        $recipientEmail = $customer->email;

        $output .= "<h2>Sending InvoiceMail to: {$recipientEmail}</h2>";

        \Illuminate\Support\Facades\Mail::to($recipientEmail, $customer->username)
            ->send(new \App\Mail\InvoiceMail($order));

        $output .= "<h2 style='color:green;'>Mail sent successfully to {$recipientEmail}!</h2>";
        $output .= "<p>Check the inbox (and spam folder) of <b>{$recipientEmail}</b> for Invoice #{$order->order_number}</p>";

        try {
            \App\Models\EmailHistory::create([
                'order_id'        => $order->id,
                'email_type'      => 'order_confirmation',
                'recipient_email' => $recipientEmail,
                'recipient_name'  => $customer->username,
                'subject'         => 'Order Successfully Placed - Invoice #' . $order->order_number,
                'order_number'    => $order->order_number,
                'status'          => 'sent',
                'sent_at'         => now(),
            ]);
            $output .= "<p>Logged to email_history table.</p>";
        } catch (\Exception $logEx) {
            $output .= "<p>Email sent, but failed to log to email_history: " . htmlspecialchars($logEx->getMessage()) . "</p>";
        }

    } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
        $output .= "<h2 style='color:red;'>SMTP Transport Error</h2>";
        $output .= "<pre style='background:#fff0f0;padding:15px;border:2px solid red;'>" . htmlspecialchars($e->getMessage()) . "</pre>";
        $output .= "<p><b>Common causes:</b></p><ul>";
        $output .= "<li>Connection refused = wrong host/port</li>";
        $output .= "<li>Authentication failed = wrong username/password</li>";
        $output .= "<li>SSL/TLS handshake error = wrong encryption (try tls for port 587, ssl for port 465)</li>";
        $output .= "</ul>";

    } catch (\Exception $e) {
        $output .= "<h2 style='color:red;'>Mail Failed</h2>";
        $output .= "<p><b>Exception class:</b> " . get_class($e) . "</p>";
        $output .= "<pre style='background:#fff0f0;padding:15px;border:2px solid red;'>" . htmlspecialchars($e->getMessage()) . "</pre>";
        $output .= "<pre style='font-size:11px;'>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    }

    return $output;
});


