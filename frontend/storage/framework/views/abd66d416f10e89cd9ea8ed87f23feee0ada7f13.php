
<?php $__env->startSection('content'); ?>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="<?php echo e(route('index')); ?>" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> <a href="<?php echo e(route('shop')); ?>">Shop</a>
                    <span></span> Checkout
                </div>
            </div>
        </div>
        <div class="container py-3">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading-2 mb-2">Checkout</h4>
                    <h6 class="text-body">There are <span class="text-brand"><?php echo e($cartItems->count()); ?></span> products
                            in your cart</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php if(!auth('customer')->check()): ?>
                                <div class="toggle_info my-3 <?php echo e(session('guest_checkout_email') ? 'checkout-auth-hidden' : ''); ?>" id="registered_login_section">
                                    <span><i class="fi-rs-user mr-10"></i><span class="text-muted font-lg">Already have an
                                            account?</span> <a href="#loginform" data-bs-toggle="collapse"
                                            class="collapsed font-lg" aria-expanded="false">Click here to login</a></span>

                                            <div class="panel-collapse collapse login_form" id="loginform">
                                    <div class="row pt-3">

                                        <form method="post" id="checkout_login_form" novalidate>
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="form-group col-6">
                                                <input type="text" name="login_id" id="login_id"
                                                    placeholder="Email Id">
                                            </div>
                                            <div class="form-group col-6">
                                                <input type="password" name="password" id="login_password"
                                                    placeholder="Password">
                                            </div>
                                            </div>

                                            <div class="row">
                                                <div class="custome-checkbox col-6 align-items-center d-flex">
                                                        <input class="form-check-input" type="checkbox" name="checkbox"
                                                            id="remember" value="">
                                                        <label class="form-check-label" for="remember"><span>Remember
                                                                me</span></label>
                                                    </div>
                                                    <div class="form-group col-6 mb-0">
                                                        <button type="button" class="btn btn-checkout-login" onclick="checkoutLogin()">Log in</button>
                                                    </div>
                                            </div>
                                            <div id="login_message" class="mt-10"></div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                                
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-12">
                            <?php if(!auth('customer')->check()): ?>
                                <!-- <div class="toggle_info">
                                    <span><i class="fi-rs-shopping-bag mr-10"></i><span class="text-muted font-lg">Checkout as a
                                            guest?</span> <a href="#guestform" data-bs-toggle="collapse"
                                            class="collapsed font-lg" aria-expanded="false">Click here to continue</a></span>

                                    <div class="panel-collapse collapse login_form" id="guestform">
                                    
                                </div>
                                </div> -->
                                
                                <div id="guest_checkout_container" class="<?php echo e(($guestEmail || auth('customer')->check()) ? 'checkout-auth-hidden' : ''); ?>">
                                    <form method="post" id="guest_checkout_form" class="row" novalidate>
                                        <?php echo csrf_field(); ?>
                                        <div class="form-group col-8 mb-0" id="guest_email_container">
                                            <input type="email" name="guest_email" id="guest_email"
                                                placeholder="Email address *" value="<?php echo e($guestEmail ?? ''); ?>" style="height:45px;">
                                            <span class="error_msg" id="err-guest_email" style="color: red; font-size: 13px; display: none;">Please enter a valid email address</span>
                                        </div>
                                        <div class="form-group col-4 d-flex mb-0 ps-0" id="guest_continue_container">
                                            <button type="button" class="btn btn-md fs-14 flex-fill"
                                                onclick="guestCheckout()" style="height:45px;">Continue</button>
                                        </div>
                                    </form>
                                </div>
                                <div id="guest_message" class="my-2">
                                    <?php if($guestEmail && !auth('customer')->check()): ?>
                                        <span class="text-success">Guest Login Successfully!</span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                    <div class="row">
                        <h5 class="mb-3">Billing Details</h5>
                        <form method="post" id="checkout_form" novalidate>
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <!-- <label>First name <span class="text-danger">*</span></label>
                                <label>Last name <span class="text-danger">*</span></label>
                                <label>Address <span class="text-danger">*</span></label>
                                <label>Address line2</label>
                                <label>State <span class="text-danger">*</span></label>
                                <label>Postcode / ZIP <span class="text-danger">*</span></label>
                                <label>Phone <span class="text-danger">*</span></label> -->

                                <div class="form-group col-lg-6">                                    
                                    <input type="text" required name="billing_fname" id="billing_fname"
                                        placeholder="First Name *"
                                        value="<?php echo e(explode(' ', $customer->username ?? '')[0] ?? ''); ?>">
                                    <span id="billing_fname_error" class="error_msg" style="color: red; font-size: 13px; display: none;">First Name is required</span>
                                </div>
                                <div class="form-group col-lg-6">                                    
                                    <input type="text" required name="billing_lname" id="billing_lname"
                                        placeholder="Last Name *"
                                        value="<?php echo e(implode(' ', array_slice(explode(' ', $customer->username ?? ''), 1))); ?>">
                                    <span id="billing_lname_error" class="error_msg" style="color: red; font-size: 13px; display: none;">Last Name is required</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6">                                    
                                    <input type="text" name="billing_address" id="billing_address" required
                                        placeholder="Address Line1*" value="<?php echo e($customer->address ?? ''); ?>">
                                    <span id="billing_address_error" class="error_msg" style="color: red; font-size: 13px; display: none;">Address is required</span>
                                </div>
                                <div class="form-group col-lg-6">                                    
                                    <input type="text" name="billing_address2" id="billing_address2"
                                        placeholder="Address Line2">
                                </div>
                            </div>
                             
                             <div class="row">
                                <div class="form-group col-lg-6">                                    
                                    <input required type="text" name="city" id="billing_city" placeholder="City / Town *"
                                        value="<?php echo e($customer->city ?? ''); ?>">
                                    <span id="billing_city_error" class="error_msg" style="color: red; font-size: 13px; display: none;">City is required</span>
                                </div>
                            
                                <div class="form-group col-lg-6">                                    
                                    <select name="state" id="billing_state" required
                                        onchange="clearStateError(); calculateShippingOnBillingChange();"
                                        style="width:100%; height:45px; border:1px solid #ececec; border-radius:5px; padding-left:10px; padding-right:25px; font-size:16px; color:#7E7E7E; appearance:auto;">
                                        <option value="">Select State</option>
                                        <?php $__currentLoopData = $shippingStates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($state); ?>" <?php echo e(($customer->state ?? '') == $state ? 'selected' : ''); ?>><?php echo e($state); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <span id="billing_state_error" class="error_msg"
                                        >Please select your state</span>
                                </div>
                             </div>  
                            
                            <div class="row">
                                <div class="form-group col-lg-6">                                    
                                    <input required type="text" name="zipcode" id="billing_zipcode"
                                        placeholder="Postcode / ZIP *" value="<?php echo e($customer->pin ?? ''); ?>" maxlength="6"
                                        oninput="validatePostcode(this, 'billing_zipcode_error')">
                                    <span id="billing_zipcode_error" class="error_msg"
                                        >Please enter exactly 6 digits (numbers
                                        only)</span>
                                </div>
                                <div class="form-group col-lg-6">
                                    <input type="text" required name="phone" id="billing_phone" placeholder="Mobile # *"
                                        value="<?php echo e($customer->mobilenumber ?? ''); ?>" maxlength="10"
                                        oninput="validateMobileNumber(this, 'billing_phone_error')">
                                    <span id="billing_phone_error" class="error_msg"
                                        >Please enter 10 digits (numbers
                                        only)</span>
                                </div>
                            </div>

                            
                            <div class="ship_detail">
                                <div class="form-group">
                                    <div class="chek-form">
                                        <div class="custome-checkbox">
                                            <input class="form-check-input" type="checkbox" name="ship_to_different"
                                                id="ship_to_different" value="1" onchange="toggleShippingFields()">
                                            <label class="form-check-label label_info" for="ship_to_different"><span>Ship to
                                                    different address?</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div id="shipping_fields" style="display: none;">
                                    <h5 class="my-3">Delivery Details</h5>
                                    <div class="row">
                                        <!-- <label>First name <span class="text-danger">*</span></label>
                                        <label>Last name <span class="text-danger">*</span></label>
                                        <label>Address <span class="text-danger">*</span></label>
                                        <label>Address line2</label>
                                        <label>City / Town <span class="text-danger">*</span></label>
                                        <label>State <span class="text-danger">*</span></label>
                                        <label>Postcode / ZIP <span class="text-danger">*</span></label>
                                        <label>Phone <span class="text-danger">*</span></label> -->
                                        <div class="form-group col-lg-6">                                            
                                            <input type="text" name="shipping_fname" id="shipping_fname"
                                                placeholder="First Name *">
                                            <span id="shipping_fname_error" class="error_msg" style="color: red; font-size: 13px; display: none;">First Name is required</span>
                                        </div>
                                        <div class="form-group col-lg-6">                                            
                                            <input type="text" name="shipping_lname" id="shipping_lname"
                                                placeholder="Last Name *">
                                            <span id="shipping_lname_error" class="error_msg" style="color: red; font-size: 13px; display: none;">Last Name is required</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">                                           
                                            <input type="text" name="shipping_address" id="shipping_address"
                                                placeholder="Address Line1 *">
                                            <span id="shipping_address_error" class="error_msg" style="color: red; font-size: 13px; display: none;">Address is required</span>
                                        </div>
                                        <div class="form-group col-lg-6">                                            
                                            <input type="text" name="shipping_address2" id="shipping_address2"
                                                placeholder="Address Line2">
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="form-group col-lg-6">                                        
                                        <input type="text" name="shipping_city" id="shipping_city"
                                            placeholder="City / Town *">
                                        <span id="shipping_city_error" class="error_msg" style="color: red; font-size: 13px; display: none;">City is required</span>
                                    </div>
                                        <div class="form-group col-lg-6">                                            
                                            <select name="shipping_state" id="shipping_state" onchange="calculateShipping()"
                                                style="width:100%; height:45px; border:1px solid #ececec; border-radius:5px; padding-left:10px; padding-right:25px; font-size:16px; color:#7E7E7E; appearance:auto;">
                                                <option value="">Select State</option>
                                                <?php $__currentLoopData = $shippingStates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($state); ?>"><?php echo e($state); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-lg-6">                                            
                                            <input type="text" name="shipping_pincode" id="shipping_pincode"
                                                placeholder="Postcode / ZIP *" maxlength="6"
                                                oninput="validatePostcode(this, 'shipping_pincode_error')">
                                            <span id="shipping_pincode_error" class="error_msg"
                                                >Please Enter Correct Pincode</span>
                                        </div>
                                        <div class="form-group col-lg-6">                                           
                                            <input type="text" name="shipping_phone" id="shipping_phone"
                                                placeholder="Mobile *" maxlength="10"
                                                oninput="validateMobileNumber(this, 'shipping_phone_error')">
                                            <span id="shipping_phone_error" class="error_msg"
                                                >Please enter exactly 10 digits
                                                (numbers only)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-30 mt-30">
                                    <textarea rows="5" name="notes" id="order_notes" placeholder="Additional notes (optional)" style="width: 100%; border: 1px solid #ececec; border-radius: 10px; padding: 10px 20px;"></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="border cart-totals mb-3 p-3">
                        <div class="d-flex align-items-end justify-content-between mb-2 align-items-center">
                            <h5>Your Order</h5>
                            <h6 class="text-muted">Subtotal</h6>
                        </div>
                        <div class="divider-2 mb-3"></div>
                        <div class="table-responsive order_table checkout">
                            <table class="table no-border">
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php if($item->product): ?>
                                            <tr
                                                data-cart-id="<?php echo e(auth('customer')->check() ? $item->id : 'guest_' . ($item->variant_id ? $item->product_id . '_' . $item->variant_id : $item->product_id)); ?>">
                                                <td class="image product-thumbnail">
                                                    <?php
                                                        $images = $item->product->productimage;
                                                        if (is_array($images) && count($images) > 0) {
                                                            $primaryImage = $images[0];
                                                        } else {
                                                            $primaryImage = null;
                                                        }
                                                        if ($primaryImage) {
                                                            $primaryImage = str_replace('\\', '/', $primaryImage);
                                                            $primaryImage = basename($primaryImage);
                                                        }
                                                    ?>
                                                    <a href="<?php echo e(route('product.details', $item->product->slug)); ?>">
                                                        <img src="<?php echo e(env('ADMIN_ASSET_URL')); ?>/products/<?php echo e($primaryImage); ?>"
                                                            alt="<?php echo e($item->product->productname); ?>"
                                                            onerror="this.src='<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>'">
                                                    </a>
                                                </td>
                                                <td>
                                                    <h6 class="w-160 mb-5"><a
                                                            href="<?php echo e(route('product.details', $item->product->slug)); ?>"
                                                            class="text-heading"><?php echo e($item->product->productname); ?></a></h6>
                                                    <?php
                                                        $weightName = null;
                                                        if (isset($item->selected_weight) && $item->selected_weight) {
                                                            $weightName = $item->selected_weight;
                                                        } elseif (isset($item->variant_id) && $item->variant_id) {
                                                            $cartVariant = $item->product->variants()->with('quantity')->where('id', $item->variant_id)->first();
                                                            $weightName = $cartVariant && $cartVariant->quantity ? ($cartVariant->quantity->name ?? $cartVariant->quantity->label) : null;
                                                        }
                                                    ?>
                                                    <?php if($weightName): ?>
                                                        <span
                                                            style="color: #3BB77E; font-size: 13px; font-weight: 700;"><?php echo e($weightName); ?>

                                                            - ₹<?php echo e(number_format($item->price_at_add_time, 0)); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="qty-wrapper-box m-auto">
                                                        <button type="button" class="btn-qty-decrease"
                                                            onclick="updateCartQty('<?php echo e(auth('customer')->check() ? $item->id : 'guest_' . ($item->variant_id ? $item->product_id . '_' . $item->variant_id : $item->product_id)); ?>', 'decrease')">
                                                            <i class="fi-rs-minus-small"></i>
                                                        </button>
                                                        <span class="qty-display"
                                                            id="qty-<?php echo e(auth('customer')->check() ? $item->id : 'guest_' . ($item->variant_id ? $item->product_id . '_' . $item->variant_id : $item->product_id)); ?>"><?php echo e($item->quantity); ?></span>
                                                        <button type="button" class="btn-qty-increase"
                                                            onclick="updateCartQty('<?php echo e(auth('customer')->check() ? $item->id : 'guest_' . ($item->variant_id ? $item->product_id . '_' . $item->variant_id : $item->product_id)); ?>', 'increase')">
                                                            <i class="fi-rs-plus-small"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h4 class="text-brand"
                                                        id="row-total-<?php echo e(auth('customer')->check() ? $item->id : 'guest_' . ($item->variant_id ? $item->product_id . '_' . $item->variant_id : $item->product_id)); ?>">
                                                        ₹ <?php echo e(number_format($item->price_at_add_time * $item->quantity, 0)); ?></h4>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn-delete-item"
                                                        onclick="deleteCartItem('<?php echo e(auth('customer')->check() ? $item->id : 'guest_' . ($item->variant_id ? $item->product_id . '_' . $item->variant_id : $item->product_id)); ?>')"
                                                        title="Remove item">
                                                        <i class="fi-rs-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <h5 class="text-muted">Your cart is empty</h5>
                                                <a href="<?php echo e(route('index')); ?>" class="btn btn-sm mt-3">Continue Shopping</a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- <div class="divider-2 mb-10 mt-10"></div> -->
                        <table class="table no-border">
                            <tbody>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-black">Subtotal</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end" id="subtotal_display">
                                            ₹<?php echo e(number_format($subtotal, 0)); ?></h4>
                                    </td>
                                </tr>
                                <tr id="coupon_discount_row"
                                    style="<?php echo e(($sessionCouponDiscount > 0) ? '' : 'display: none;'); ?>">
                                    <td class="cart_total_label">
                                        <h6 class="text-black">Coupon Discount
                                            <a href="javascript:void(0)" onclick="removeCoupon()" class="text-danger"
                                                style="font-size: 12px;">(Remove)</a>
                                        </h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end" id="coupon_discount_display">
                                            -₹ <?php echo e(number_format($sessionCouponDiscount, 0)); ?></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-black">Shipping Charges</h6>
                                    </td>
                                    <td class="cart_total_amount text-end">
                                        <h4 class="text-brand" id="shipping_display">
                                        <?php if($shipping > 0): ?>
                                            ₹ <?php echo e(number_format($shipping, 0)); ?>

                                        <?php else: ?>
                                            Free
                                        <?php endif; ?>
                                        </h4>
                                    </td>
                                </tr>
                                <tr id="cod_charge_row" style="display: none;">
                                    <td class="cart_total_label">
                                        <h6 class="text-black">COD Charge</h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end" id="cod_charge_display">₹0.00</h4>
                                    </td>
                                </tr>
                                <!-- <tr>
                                    <td scope="col" colspan="2">
                                        <div class="divider-2 mt-10 mb-10"></div>
                                    </td>
                                </tr> -->
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-black"><strong>Grand Total</strong></h6>
                                    </td>
                                    <td class="cart_total_amount">
                                        <h4 class="text-brand text-end" id="total_display">
                                            ₹<?php echo e(number_format($total - $sessionCouponDiscount, 0)); ?></h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <form method="post" class="apply-coupon">
                            <input type="text" id="coupon_code" placeholder="Enter Coupon Code..."
                                value="<?php echo e($sessionCouponCode ?? ''); ?>" <?php echo e($sessionCouponCode ? 'readonly' : ''); ?>>
                            <button type="button" class="btn m-0 p-0 <?php echo e($sessionCouponCode ? 'btn-success' : ''); ?>"
                                id="apply_coupon_btn" onclick="applyCoupon()" <?php echo e($sessionCouponCode ? 'disabled' : ''); ?>><?php echo e($sessionCouponCode ? 'Applied' : 'Apply Coupon'); ?></button>
                        </form>
                        <div id="coupon_message" class="mt-10"></div>
                    </div>
                    <div class="payment">
                        <h5 class="mt-2 mb-3">Payment</h5>
                        <div class="payment_option">                            
                            <div class="custome-radio">
                                <input class="form-check-input" required type="radio" name="payment_option"
                                    id="online_gateway" value="online_gateway" onchange="handlePaymentOptionChange()"
                                    checked>
                                <label class="form-check-label" for="online_gateway">Online Payment</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" required type="radio" name="payment_option"
                                    id="cash_on_delivery" value="cash_on_delivery" onchange="handlePaymentOptionChange()">
                                <label class="form-check-label" for="cash_on_delivery">Cash on delivery</label>
                                <p class="text-black" style="font-size: 15px; margin-left: 25px;">₹75 COD charge on orders below ₹600</p>
                            </div>
                        </div>
                        <a href="#" class="btn btn-fill-out btn-block mt-2 col-12" onclick="placeOrder(); return false;">Place an
                            Order<i class="fi-rs-sign-out ml-15"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Order Success Modal -->
    <div id="orderSuccessModal" class="order-success-overlay" style="display: none;">
        <div class="order-success-container">
            <div class="success-animation">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none" />
                    <path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                </svg>
            </div>
            <h2 class="success-title">Order Placed Successfully!</h2>
            <p class="order-id-text">Order ID: <span id="order_id_display">#CA000000</span></p>
            <p class="estimated-delivery-text" style="font-size: 16px; color: #555; margin-bottom: 5px;">
                Estimated Shipping: <span id="estimated_delivery_display" style="font-weight: 600; color: #333;"></span>
            </p>
            <p class="success-subtitle">Thank you for your purchase</p>
            <button type="button" class="btn btn-back-home" onclick="goToHome()">Back to Home</button>
        </div>
    </div>

    <style>
        /* Order Success Modal */
        .order-success-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.95) 0%, rgba(16, 185, 129, 0.95) 100%);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .order-success-container {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 24px;
            padding: 50px 60px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.25);
        }

        .checkmark {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: block;
            stroke-width: 3;
            stroke: #10B981;
            margin: 0 auto;
        }

        .checkmark-circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke: #10B981;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .checkmark-check {
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }

        @keyframes stroke {
            100% {
                stroke-dashoffset: 0;
            }
        }

        .success-title {
            font-size: 28px;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 8px;
        }

        .success-subtitle {
            font-size: 16px;
            color: #6B7280;
        }

        .order-id-text {
            font-size: 18px;
            font-weight: 600;
            color: #4CAF50;
            margin: 15px 0;
        }

        .btn-back-home {
            background: #ff8c00;
            color: #fff;
            padding: 12px 40px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .btn-back-home:hover {
            background: #e67e00;
            color: #fff;
        }

        /* COD charge label */
        .custome-radio p {
            margin-top: 2px;
        }

        /* Remove spinner arrows from number inputs */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
            appearance: textfield;
        }

        /* Validation Icons and Colors */
        .is-invalid, .is-invalid:focus {
            border-color: #dc3545 !important;
            background-color: #fff6f6 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 10px center !important;
            background-size: 20px 20px !important;
            padding-right: 40px !important;
            transition: none !important;
            box-shadow: none !important;
            appearance: none !important;
        }

        .is-valid, .is-valid:focus {
            border-color: #198754 !important;
            background-color: #f6fff6 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8' fill='%23198754'%3e%3cpath d='M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 10px center !important;
            background-size: 20px 20px !important;
            padding-right: 40px !important;
            transition: none !important;
            box-shadow: none !important;
            appearance: none !important;
        }

        /* Autofill Handling */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px #f6fff6 inset !important;
            -webkit-text-fill-color: #333 !important;
            transition: background-color 5000s ease-in-out 0s;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8' fill='%23198754'%3e%3cpath d='M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right calc(.375em + .1875rem) center !important;
            background-size: calc(.75em + .375rem) calc(.75em + .375rem) !important;
        }

        /* Fix table layout to prevent horizontal scroll */
        .order_table.checkout {
            overflow-x: hidden !important;
        }

        .order_table.checkout table {
            table-layout: fixed;
            width: 100%;
        }

        .order_table.checkout .product-thumbnail {
            width: 60px;
            padding: 5px;
        }

        .order_table.checkout .product-thumbnail img {
            max-width: 50px;
            height: auto;
        }

        .order_table.checkout td:nth-child(2) {
            width: auto;
            min-width: 100px;
        }

        .order_table.checkout td:nth-child(2) h6 {
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .order_table.checkout td:nth-child(3) {
            width: 120px;
            text-align: center;
        }

        .order_table.checkout td:nth-child(4) {
            width: 80px;
            text-align: right;
        }

        .order_table.checkout td:nth-child(5) {
            width: 40px;
            text-align: center;
        }

        /* Quantity control buttons - Unified Box Design */
        .qty-wrapper-box {
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #ececec;
            border-radius: 4px;
            height: 32px;
            background: #fff;
            overflow: hidden;
            width: 80px;
        }

        .btn-qty-decrease,
        .btn-qty-increase {
            background: transparent;
            border: none;
            width: 25px;
            height: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 0;
            flex-shrink: 0;
        }

        .btn-qty-decrease:hover,
        .btn-qty-increase:hover {
            background: #f5f5f5;
            color: #3BB77E;
        }

        .btn-qty-decrease i,
        .btn-qty-increase i {
            font-size: 14px;
            line-height: 1;
        }

        .qty-display {
            font-weight: 600;
            font-size: 14px;
            min-width: 20px;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            border-left: 1px solid #ececec;
            border-right: 1px solid #ececec;
            flex-grow: 1;
        }

        /* Delete button */
        .btn-delete-item {
            background: transparent;
            border: none;
            color: #dc3545;
            cursor: pointer;
            padding: 5px;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .btn-delete-item:hover {
            color: #c82333;
            transform: scale(1.1);
        }

        .btn-delete-item i {
            font-size: 16px;
        }

        /* =========================================
                                                   MOBILE CHECKOUT ORDER - Responsive Fixes
                                                   ========================================= */
        @media (max-width: 767.98px) {

            /* Reorder: Payment first, then Coupon, then Your Order on mobile */
            .col-lg-5 {
                display: flex;
                flex-direction: column;
            }

            .col-lg-5 .payment.ml-30 {
                order: 1;
            }

            .col-lg-5 .cart-totals {
                order: 2;
            }

            .col-lg-5 > .ml-30.mb-30 {
                order: 3;
            }

            /* Outer card - reduce padding and remove left margin */
            .cart-totals.ml-30 {
                margin-left: 0 !important;
                padding: 15px !important;
            }

            .payment.ml-30 {
                margin-left: 0 !important;
            }

            .ml-30.mb-30 {
                margin-left: 0 !important;
            }

            /* Header row */
            .cart-totals .d-flex.align-items-end.justify-content-between.mb-30 {
                margin-bottom: 15px !important;
            }

            .cart-totals .d-flex.align-items-end.justify-content-between.mb-30 h4 {
                font-size: 16px;
            }

            .cart-totals .d-flex.align-items-end.justify-content-between.mb-30 h6 {
                font-size: 13px;
            }

            /* Stack each cart item row vertically */
            .order_table.checkout table {
                table-layout: auto !important;
            }

            .order_table.checkout table tbody tr {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                padding: 10px 0;
                border-bottom: 1px solid #f0f0f0;
                gap: 4px;
            }

            .order_table.checkout table tbody tr:last-child {
                border-bottom: none;
            }

            /* Product image */
            .order_table.checkout td.image.product-thumbnail {
                width: 50px !important;
                padding: 0 5px 0 0 !important;
                display: block;
            }

            .order_table.checkout .product-thumbnail img {
                max-width: 45px !important;
                height: 45px !important;
                object-fit: cover;
                border-radius: 5px;
            }

            /* Product name/variant - take remaining width */
            .order_table.checkout td:nth-child(2) {
                flex: 1 !important;
                min-width: 0 !important;
                width: auto !important;
                padding: 0 !important;
            }

            .order_table.checkout td:nth-child(2) h6 {
                font-size: 13px !important;
                white-space: normal !important;
                overflow: visible !important;
                text-overflow: unset !important;
                line-height: 1.3;
                margin-bottom: 2px !important;
            }

            .order_table.checkout td:nth-child(2) h6.w-160 {
                width: auto !important;
                max-width: 100% !important;
            }

            .order_table.checkout td:nth-child(2) span {
                font-size: 11px !important;
            }

            /* Qty controls */
            .order_table.checkout td:nth-child(3) {
                width: auto !important;
                padding: 0 !important;
            }

            .btn-qty-decrease,
            .btn-qty-increase {
                width: 24px !important;
                height: 24px !important;
            }

            .btn-qty-decrease i,
            .btn-qty-increase i {
                font-size: 12px !important;
            }

            .qty-display {
                font-size: 13px !important;
                min-width: 20px !important;
            }

            /* Row total price */
            .order_table.checkout td:nth-child(4) {
                width: auto !important;
                padding: 0 5px !important;
            }

            .order_table.checkout td:nth-child(4) h4 {
                font-size: 14px !important;
            }

            /* Delete button */
            .order_table.checkout td:nth-child(5) {
                width: auto !important;
                padding: 0 !important;
            }

            .btn-delete-item {
                padding: 2px !important;
            }

            .btn-delete-item i {
                font-size: 14px !important;
            }

            /* Summary totals - proper alignment */
            .cart-totals>table.no-border {
                width: 100%;
            }

            .cart-totals>table.no-border tr {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 1px solid #f1f1f1;
            }

            .cart-totals>table.no-border td {
                display: block !important;
                width: auto !important;
                border: none !important;
            }

            .cart-totals>table.no-border td.cart_total_label {
                text-align: left;
            }

            .cart-totals>table.no-border td.cart_total_amount {
                text-align: right;
            }

            .cart-totals>table.no-border td.cart_total_label h6 {
                font-size: 13px !important;
                margin: 0;
            }

            .cart-totals>table.no-border td.cart_total_amount h4 {
                font-size: 14px !important;
                margin: 0;
            }

            /* Coupon section */
            .apply-coupon {
                flex-direction: column;
            }

            .apply-coupon input {
                font-size: 13px !important;
                margin-bottom: 8px;
            }

            .apply-coupon .btn {
                font-size: 13px !important;
                width: 100%;
            }

            /* Payment section */
            .payment h4 {
                font-size: 16px !important;
            }

            .payment .custome-radio label {
                font-size: 13px;
            }

            .payment .btn-fill-out {
                font-size: 14px !important;
                padding: 10px 20px !important;
                width: 100%;
                display: block;
                box-sizing: border-box;
            }

            /* Fix State select dropdown on mobile */
            #billing_state,
            #shipping_state {
                height: 44px !important;
                font-size: 14px !important;
                padding-left: 12px !important;
                border-radius: 6px !important;
                -webkit-appearance: menulist !important;
                -moz-appearance: menulist !important;
                appearance: menulist !important;
                background-color: #fff !important;
            }

            /* Fix all checkout form inputs on mobile */
            .col-lg-7 .form-group input,
            .col-lg-7 .form-group select {
                height: 44px !important;
                font-size: 14px !important;
                padding: 8px 12px !important;
                border-radius: 6px !important;
            }

            .col-lg-7 .form-group label {
                font-size: 13px !important;
                margin-bottom: 4px !important;
            }

            .col-lg-7 h4 {
                font-size: 16px !important;
            }

            .container.mb-80.mt-50 {
                margin-top: 20px !important;
                margin-bottom: 30px !important;
            }
        }

        /* ===== Mobile Inline Select Dropdown ===== */
        .mobile-select-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #fff;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 6px 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            max-height: 200px;
            overflow-y: auto;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .mobile-select-dropdown.open {
            display: block;
        }

        .mobile-select-dropdown li {
            padding: 10px 12px;
            font-size: 14px;
            color: #333;
            border-bottom: 1px solid #f5f5f5;
            cursor: pointer;
        }

        .mobile-select-dropdown li:active {
            background: #f0f0f0;
        }

        .mobile-select-dropdown li.selected {
            background: #3BB77E;
            color: #fff;
        }

        .mobile-select-dropdown li:last-child {
            border-bottom: none;
        }

        /* Custom trigger to replace native select on mobile */
        @media (max-width: 767.98px) {
            .mobile-select-wrap {
                position: relative;
            }

            .mobile-select-trigger {
                display: flex !important;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                height: 44px;
                border: 1px solid #ececec;
                border-radius: 6px;
                padding: 8px 12px;
                font-size: 14px;
                color: #7E7E7E;
                background: #fff;
                cursor: pointer;
                user-select: none;
            }

            .mobile-select-trigger .trigger-arrow {
                font-size: 10px;
                color: #999;
                transition: transform 0.2s;
            }

            .mobile-select-trigger.open .trigger-arrow {
                transform: rotate(180deg);
            }

            .mobile-select-trigger.has-value {
                color: #333;
            }

            select.mobile-hidden {
                display: none !important;
            }
        }

        @media (min-width: 768px) {

            .mobile-select-trigger,
            .mobile-select-dropdown {
                display: none !important;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var csrfToken = '<?php echo e(csrf_token()); ?>';
        var cartSubtotal = Math.round(<?php echo e($subtotal); ?>);
        var currentShipping = <?php echo e($shipping); ?>;
        var currentCouponDiscount = <?php echo e($sessionCouponDiscount ?? 0); ?>;
        var appliedCouponCode = <?php echo $sessionCouponCode ? "'" . $sessionCouponCode . "'" : 'null'; ?>;
        var currentCodCharge = 0;
        var COD_CHARGE_AMOUNT = 75;
        var COD_CHARGE_THRESHOLD = 600;
        var customerEmail = '<?php echo e(auth("customer")->check() ? auth("customer")->user()->email : session("guest_checkout_email", "")); ?>';

        // Real-time validation for checkout
        function setupRealTimeValidationCheckout(formId) {
            const form = document.getElementById(formId);
            if (!form) return;

            const inputs = form.querySelectorAll('input, select, textarea');
            
            // Function to check value and toggle classes
            function checkValue(input) {
                if (input.value.trim() || (input.type === 'checkbox' && input.checked)) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else if (input.hasAttribute('required')) {
                    // Only remove is-valid if it was required and is now empty
                    // but don't add is-invalid automatically until touched or submitted
                    input.classList.remove('is-valid');
                } else {
                    input.classList.remove('is-valid');
                }
            }

            inputs.forEach(input => {
                // Check initial value
                checkValue(input);

                input.addEventListener('input', function() {
                    checkValue(this);
                    // Find common error spans for billing/shipping and hide them
                    let baseId = this.id;
                    let errorSpan = document.getElementById(baseId + '_error');
                    if (errorSpan) errorSpan.style.display = 'none';
                    
                    // Specific cases for checkout login/guest
                    if (this.id === 'login_id') $('#login_message').html('');
                    if (this.id === 'guest_email') {
                        $('#guest_message').html('');
                        $('#err-guest_email').hide();
                    }
                });

                input.addEventListener('change', function() {
                    if (this.tagName === 'SELECT' && this.value.trim()) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                        let errorSpan = document.getElementById(this.id + '_error');
                        if (errorSpan) errorSpan.style.display = 'none';
                    } else if (this.tagName === 'SELECT') {
                        this.classList.remove('is-valid');
                    }
                });
            });
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        // ========== AUTO-SAVE DRAFT ORDER ==========
        var autoSaveTimer;
        function autoSaveDraft(sync = false) {
            if (sync) {
                executeSaveDraft(true);
            } else {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(function() {
                    executeSaveDraft(false);
                }, 1000);
            }
        }

        function executeSaveDraft(isSync = false) {
            // Determine email: auth user email (if logged in) or guest input
            var email = '<?php echo e(auth("customer")->check() ? auth("customer")->user()->email : ""); ?>' || $('#guest_email').val();
            var fname = $('#billing_fname').val();
            
            // At least email is required to save a draft
            if (!email) {
                console.log('Skipping draft save: Email missing');
                return;
            }

            var formData = {
                email: email,
                fname: fname,
                lname: $('#billing_lname').val(),
                phone: $('#billing_phone').val(),
                address: $('#billing_address').val(),
                address2: $('#billing_address2').val(),
                city: $('#billing_city').val(),
                state: $('#billing_state').val(),
                pincode: $('#billing_zipcode').val(),
                notes: $('#order_notes').val(),
                payment_option: $('input[name="payment_option"]:checked').val() || '',
                coupon_code: appliedCouponCode || '',
                coupon_discount: currentCouponDiscount || 0,
                cod_charge: currentCodCharge || 0,
                shipping_amount: currentShipping || 0,
                _token: csrfToken
            };

            $.ajax({
                url: '<?php echo e(route("checkout.save-draft")); ?>',
                type: 'POST',
                data: formData,
                async: !isSync,
                success: function(response) {
                    if (response.success) {
                        console.log('Draft order saved:', response.order_number);
                    }
                },
                error: function(xhr) {
                    console.error('Draft save error:', xhr.responseText);
                }
            });
        }

        function executeSaveDraftBeacon() {
            var email = '<?php echo e(auth("customer")->check() ? auth("customer")->user()->email : ""); ?>' || $('#guest_email').val();
            var fname = $('#billing_fname').val();
            
            if (!email) return;

            var fd = new FormData();
            fd.append('email', email);
            fd.append('fname', fname);
            fd.append('lname', $('#billing_lname').val());
            fd.append('phone', $('#billing_phone').val());
            fd.append('address', $('#billing_address').val());
            fd.append('address2', $('#billing_address2').val());
            fd.append('city', $('#billing_city').val());
            fd.append('state', $('#billing_state').val());
            fd.append('pincode', $('#billing_zipcode').val());
            fd.append('notes', $('#order_notes').val());
            fd.append('payment_option', $('input[name="payment_option"]:checked').val() || '');
            fd.append('coupon_code', appliedCouponCode || '');
            fd.append('coupon_discount', currentCouponDiscount || 0);
            fd.append('cod_charge', currentCodCharge || 0);
            fd.append('shipping_amount', currentShipping || 0);
            fd.append('_token', csrfToken);

            navigator.sendBeacon('<?php echo e(route("checkout.save-draft")); ?>', fd);
        }

        // Trigger auto-save before leaving the page via Beacon API
        $(window).on('beforeunload', function() {
            executeSaveDraftBeacon(); 
        });

        // Attach immediate auto-save on change or blur
        $(document).on('change blur', '#billing_fname, #billing_lname, #billing_address, #billing_address2, #billing_city, #billing_state, #billing_zipcode, #billing_phone, #guest_email, #order_notes, input[name="payment_option"]', function() {
            autoSaveDraft(true);
        });

        // Attach debounced auto-save on keyup
        $(document).on('keyup', '#billing_fname, #billing_lname, #billing_address, #billing_address2, #billing_city, #billing_state, #billing_zipcode, #billing_phone, #guest_email, #order_notes', function() {
            autoSaveDraft(false);
        });

        // Auto-sync guest email input to customerEmail variable
        $(document).on('keyup change blur', '#guest_email', function() {
            customerEmail = $(this).val().trim();
            console.log('Guest email synced:', customerEmail);
        });

        // Handle expired CSRF token (419) globally — auto-refresh page
        $(document).ajaxError(function (event, xhr) {
            if (xhr.status === 419) {
                toastr.error('Session expired. Refreshing page...', 'Error');
                setTimeout(function () { location.reload(); }, 1500);
            }
        });

        $(document).ready(function () {
            setupRealTimeValidationCheckout('checkout_login_form');
            setupRealTimeValidationCheckout('guest_checkout_form');
            setupRealTimeValidationCheckout('checkout_form');

            console.log('Checkout page loaded. Subtotal:', cartSubtotal);
            updateTotalsDisplay();
            
            // Immediately save initial draft if pre-filled details exist (e.g. for logged in user)
            autoSaveDraft(false);

            // ===== Mobile Inline Select Dropdown =====
            if (window.innerWidth <= 767) {
                initMobileSelect('billing_state');
                // Shipping state will be initialized when it becomes visible
                var shipObserver = new MutationObserver(function () {
                    var shippingFields = document.getElementById('shipping_fields');
                    if (shippingFields && shippingFields.style.display !== 'none') {
                        initMobileSelect('shipping_state');
                        shipObserver.disconnect();
                    }
                });
                var shippingFields = document.getElementById('shipping_fields');
                if (shippingFields) {
                    shipObserver.observe(shippingFields, { attributes: true, attributeFilter: ['style'] });
                }
            }
        });

        function initMobileSelect(selectId) {
            var sel = document.getElementById(selectId);
            if (!sel || sel.dataset.mobileInit) return;
            sel.dataset.mobileInit = '1';
            sel.classList.add('mobile-hidden');

            // Create wrapper
            var wrap = document.createElement('div');
            wrap.className = 'mobile-select-wrap';

            // Create trigger
            var trigger = document.createElement('div');
            trigger.className = 'mobile-select-trigger';
            trigger.id = selectId + '_trigger';
            var curText = sel.options[sel.selectedIndex] ? sel.options[sel.selectedIndex].text : 'Select an option...';
            trigger.innerHTML = '<span>' + curText + '</span><span class="trigger-arrow">&#9660;</span>';
            if (sel.value) trigger.classList.add('has-value');

            // Create inline dropdown
            var dropdown = document.createElement('ul');
            dropdown.className = 'mobile-select-dropdown';
            dropdown.id = selectId + '_dropdown';

            // Build options
            for (var i = 0; i < sel.options.length; i++) {
                var opt = sel.options[i];
                var li = document.createElement('li');
                li.textContent = opt.text;
                li.dataset.value = opt.value;
                if (opt.value === sel.value && sel.value !== '') li.classList.add('selected');
                li.addEventListener('click', (function (sId, trigEl, ddEl) {
                    return function () {
                        var val = this.dataset.value;
                        var s = document.getElementById(sId);
                        s.value = val;
                        trigEl.querySelector('span').textContent = this.textContent;
                        if (val) { trigEl.classList.add('has-value'); } else { trigEl.classList.remove('has-value'); }
                        ddEl.querySelectorAll('li').forEach(function (l) { l.classList.remove('selected'); });
                        this.classList.add('selected');
                        s.dispatchEvent(new Event('change', { bubbles: true }));
                        ddEl.classList.remove('open');
                        trigEl.classList.remove('open');
                    };
                })(selectId, trigger, dropdown));
                dropdown.appendChild(li);
            }

            wrap.appendChild(trigger);
            wrap.appendChild(dropdown);
            sel.parentNode.insertBefore(wrap, sel.nextSibling);

            // Toggle dropdown on trigger click
            trigger.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                document.querySelectorAll('.mobile-select-dropdown.open').forEach(function (d) { if (d !== dropdown) d.classList.remove('open'); });
                document.querySelectorAll('.mobile-select-trigger.open').forEach(function (t) { if (t !== trigger) t.classList.remove('open'); });
                var isOpen = dropdown.classList.toggle('open');
                trigger.classList.toggle('open', isOpen);
            });
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.mobile-select-wrap')) {
                document.querySelectorAll('.mobile-select-dropdown.open').forEach(function (d) { d.classList.remove('open'); });
                document.querySelectorAll('.mobile-select-trigger.open').forEach(function (t) { t.classList.remove('open'); });
            }
        });

        // ========== HIDE MESSAGES ON LOAD & SESSION TRACKING ==========
        $(document).ready(function () {
            // Check for guest session mismatch (Logout on Tab Close behavior)
            <?php if($guestEmail && !auth('customer')->check()): ?>
                if (!sessionStorage.getItem('guest_active')) {
                    // Browser says no guest session, but Server says yes -> Abandon it
                    $.post('<?php echo e(route("checkout.abandon-guest")); ?>', { _token: csrfToken }, function() {
                        window.location.reload();
                    });
                } else {
                    // Both agree -> Show a brief notice as requested
                    if ($('#guest_message').html().trim() === "") {
                        $('#guest_message').html('<span class="text-info">You are already using guest checkout.</span>');
                    }
                }
            <?php endif; ?>

            // Hide all messages after 0.5s
            if ($('#guest_message').children().length > 0) {
                setTimeout(function () {
                    $('#guest_message').fadeOut(300, function () { $(this).html(''); $(this).show(); });
                }, 500);
            }
            if ($('#login_message').children().length > 0) {
                setTimeout(function () {
                    $('#login_message').fadeOut(300, function () { $(this).html(''); $(this).show(); });
                }, 500);
            }
        });

        // ========== LOGIN ==========
        function checkoutLogin() {
            var login_id = $('#login_id').val();
            var password = $('#login_password').val();

            if (!login_id || !password) {
                if (!login_id) $('#login_id').addClass('is-invalid').removeClass('is-valid');
                if (!password) $('#login_password').addClass('is-invalid').removeClass('is-valid');
                toastr.warning('Please enter login credentials', 'Warning');
                return;
            }

            console.log('Attempting login with:', login_id);

            $.ajax({
                url: '<?php echo e(route("checkout.login")); ?>',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    login_id: login_id,
                    password: password
                },
                success: function (response) {
                    console.log('Login response:', response);
                    if (response.success) {
                        toastr.success(response.message || 'Login successful!');
                        $('#login_message').html('<span class="text-success">Login successful! Your details have been filled.</span>');
                        // Auto-fill billing fields from customer data
                        if (response.customer) {
                            var fullName = response.customer.username || '';
                            var nameParts = fullName.trim().split(' ');
                            $('#billing_fname').val(nameParts[0] || '');
                            $('#billing_lname').val(nameParts.slice(1).join(' ') || '');
                            $('#billing_phone').val(response.customer.phone || '');
                            $('#billing_address').val(response.customer.address || '');
                            $('#billing_city').val(response.customer.city || '');
                            if (response.customer.state) {
                                $('#billing_state').val(response.customer.state);
                            }
                            $('#billing_zipcode').val(response.customer.pincode || '');
                            // Update customer email for order confirmation
                            if (response.customer.email) {
                                customerEmail = response.customer.email;
                            }
                        }
                        // UI Updates and Page Reload after 0.5s
                        setTimeout(function () {
                            // Clear guest state
                            sessionStorage.removeItem('guest_active');
                            // Reload page to synchronize server-side merged cart
                            location.reload();
                        }, 500);
                    } else {
                        $('#login_id, #login_password').addClass('is-invalid').removeClass('is-valid');
                        toastr.error(response.message || 'Login failed', 'Error');
                        $('#login_message').html('<span class="text-danger">' + (response.message || 'Login failed') + '</span>');
                    }
                },
                error: function (xhr) {
                    console.log('Login error:', xhr.status, xhr.responseJSON);
                    var errorMsg = 'Login failed';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    toastr.error(errorMsg, 'Error');
                    $('#login_message').html('<span class="text-danger">' + errorMsg + '</span>');
                }
            });
        }

        // ========== GUEST CHECKOUT ==========
        function guestCheckout() {
            var email = $('#guest_email').val();

            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email || !emailRegex.test(email)) {
                $('#guest_email').addClass('is-invalid').removeClass('is-valid');
                $('#err-guest_email').show();
                toastr.warning('Please enter a valid email address', 'Warning');
                return;
            }
            $('#err-guest_email').hide();

            // Store guest email in session
            $.ajax({
                url: '<?php echo e(route("checkout.guest-continue")); ?>',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    guest_email: email
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success('You can now proceed with checkout', 'Success');
                        $('#guest_message').html('<span class="text-success">Guest Login Successfully!</span>');
                        // Update customer email for order confirmation
                        customerEmail = email;

                        // Mark guest session as active in browser
                        sessionStorage.setItem('guest_active', 'true');

                        // Save draft order immediately now that the guest email is locked in
                        autoSaveDraft(true);

                        // Hide form and sections after 0.5s
                        setTimeout(function () {
                            $('#guest_checkout_container').addClass('checkout-auth-hidden');
                            $('#registered_login_section').addClass('checkout-auth-hidden');
                            
                            // Fade out guest success message
                            $('#guest_message').fadeOut(300, function() { $(this).html(''); });
                        }, 500);
                    } else {
                        toastr.error(response.message || 'Failed to save email', 'Error');
                        $('#guest_message').html('<span class="text-danger">' + (response.message || 'Failed') + '</span>');
                    }
                },
                error: function (xhr) {
                    var errorMsg = 'Failed to save email';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    toastr.error(errorMsg, 'Error');
                    $('#guest_message').html('<span class="text-danger">' + errorMsg + '</span>');
                }
            });
        }

        // ========== BILLING VALIDATION ==========
        function validateMobileNumber(input, errorId) {
            var value = input.value.replace(/[^0-9]/g, '');
            input.value = value;
            var errorSpan = document.getElementById(errorId);
            if (value.length > 0 && value.length !== 10) {
                errorSpan.style.display = 'inline';
                input.classList.add('is-invalid');
            } else {
                errorSpan.style.display = 'none';
                input.classList.remove('is-invalid');
            }
        }

        function validatePostcode(input, errorId) {
            var value = input.value.replace(/[^0-9]/g, '');
            input.value = value;
            var errorSpan = document.getElementById(errorId);
            if (value.length > 0 && value.length !== 6) {
                errorSpan.style.display = 'inline';
                input.classList.add('is-invalid');
            } else {
                errorSpan.style.display = 'none';
                input.classList.remove('is-invalid');
            }
        }

        function clearStateError() {
            if ($('#billing_state').val()) {
                $('#billing_state_error').hide();
            }
        }

        // ========== TOGGLE SHIPPING FIELDS ==========
        function toggleShippingFields() {
            var shipToDifferent = $('#ship_to_different').is(':checked');
            if (shipToDifferent) {
                // Show the delivery form for a different address
                $('#shipping_fields').slideDown();
            } else {
                // Hide delivery form and clear its fields — billing will be used
                $('#shipping_fname, #shipping_lname, #shipping_phone, #shipping_address, #shipping_address2, #shipping_city, #shipping_pincode').val('');
                $('#shipping_state').val('');
                $('#shipping_fields').slideUp();
                // Recalculate shipping based on billing state
                var billingState = $('#billing_state').val();
                if (billingState) {
                    calculateShippingWithState(billingState);
                }
            }
        }

        // ========== SHIPPING CALCULATION ==========
        function calculateShipping() {
            var shipToDifferent = $('#ship_to_different').is(':checked');
            var state = shipToDifferent ? $('#shipping_state').val() : $('#billing_state').val();
            console.log('Calculating shipping for state:', state, 'Subtotal:', cartSubtotal, 'Discount:', currentCouponDiscount);
            if (!state) return;

            $.ajax({
                url: '<?php echo e(route("checkout.calculate-shipping")); ?>',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    state: state,
                    subtotal: cartSubtotal,
                    coupon_discount: currentCouponDiscount
                },
                success: function (response) {
                    if (response.success) {
                        console.log('Shipping calculation response:', response);
                        currentShipping = response.shipping_charge;
                        updateTotalsDisplay();
                    }
                },
                error: function (xhr) {
                    console.error('Shipping calculation error:', xhr);
                }
            });
        }

        function calculateShippingWithState(state) {
            if (!state) return;
            console.log('Calculating shipping with explicit state:', state, 'Subtotal:', cartSubtotal, 'Discount:', currentCouponDiscount);
            $.ajax({
                url: '<?php echo e(route("checkout.calculate-shipping")); ?>',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    state: state,
                    subtotal: cartSubtotal,
                    coupon_discount: currentCouponDiscount
                },
                success: function (response) {
                    if (response.success) {
                        console.log('Shipping calculation (with state) response:', response);
                        currentShipping = response.shipping_charge;
                        updateTotalsDisplay();
                    }
                },
                error: function (xhr) {
                    console.error('Shipping calculation error:', xhr);
                }
            });
        }

        function calculateShippingOnBillingChange() {
            var shipToDifferent = $('#ship_to_different').is(':checked');
            var billingState = $('#billing_state').val();
            // If NOT shipping to a different address, billing state drives shipping calc
            if (!shipToDifferent && billingState) {
                calculateShippingWithState(billingState);
            }
        }

        // ========== COUPON ==========
        function applyCoupon() {
            var couponCode = $('#coupon_code').val().trim();
            if (!couponCode) {
                $('#coupon_message').html('<span class="text-danger">Please enter a coupon code</span>');
                toastr.warning('Please enter a coupon code', 'Warning');
                return;
            }

            console.log('Applying coupon:', couponCode, 'Subtotal:', cartSubtotal);
            $('#apply_coupon_btn').prop('disabled', true).text('Applying...');

            $.ajax({
                url: '<?php echo e(route("checkout.apply-coupon")); ?>',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    coupon_code: couponCode,
                    subtotal: cartSubtotal
                },
                success: function (response) {
                    console.log('Coupon response:', response);
                    if (response.success) {
                        currentCouponDiscount = response.coupon.discount;
                        appliedCouponCode = response.coupon.code;
                        $('#coupon_discount_row').show();
                        $('#coupon_discount_display').text('-₹ ' + Math.round(currentCouponDiscount)).removeClass('text-success').addClass('text-brand');
                        $('#coupon_message').html('<h4 class="text-brand mt-2" style="font-size: 18px; font-weight: bold;">' + response.message + '</h4>');
                        $('#coupon_code').prop('readonly', true);
                        $('#apply_coupon_btn').text('Applied').addClass('btn-success');
                        calculateShipping(); // Recalculate shipping based on new discount
                        updateTotalsDisplay();
                        toastr.success(response.message, 'Success');
                    } else {
                        $('#coupon_message').html('<h4 class="text-danger mt-2" style="font-size: 18px; font-weight: bold;">' + response.message + '</h4>');
                        $('#apply_coupon_btn').prop('disabled', false).text('Apply Coupon');
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function (xhr) {
                    console.log('Coupon error:', xhr.status, xhr.responseJSON);
                    var errorMsg = 'Failed to apply coupon';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    $('#coupon_message').html('<h4 class="text-danger mt-2" style="font-size: 18px; font-weight: bold;">' + errorMsg + '</h4>');
                    $('#apply_coupon_btn').prop('disabled', false).text('Apply Coupon');
                    toastr.error(errorMsg, 'Error');
                }
            });
        }

        function removeCoupon() {
            currentCouponDiscount = 0;
            appliedCouponCode = null;
            $('#coupon_discount_row').css('display', 'none');
            $('#coupon_code').val('').prop('readonly', false);
            $('#apply_coupon_btn').prop('disabled', false).text('Apply Coupon').removeClass('btn-success');
            $('#coupon_message').html('');
            calculateShipping(); // Recalculate shipping after removing discount
            updateTotalsDisplay();
            toastr.info('Coupon removed', 'Info');
        }

        // ========== PAYMENT OPTION ==========
        function handlePaymentOptionChange() {
            calculateCodCharge();
            updateTotalsDisplay();
        }

        function calculateCodCharge() {
            var paymentOption = $('input[name="payment_option"]:checked').val();
            if (paymentOption === 'cash_on_delivery') {
                if (cartSubtotal >= 600) {
                    currentCodCharge = 0;
                    $('#cod_charge_row').show();
                    $('#cod_charge_display').html('<span class="text-success" style="color: #3BB77E !important; font-weight: bold;">Free</span>');
                } else {
                    currentCodCharge = COD_CHARGE_AMOUNT;
                    $('#cod_charge_row').show();
                    $('#cod_charge_display').text('₹' + COD_CHARGE_AMOUNT.toFixed(2));
                }
            } else {
                currentCodCharge = 0;
                $('#cod_charge_row').hide();
            }
        }

        function updateTotalsDisplay() {
            $('#subtotal_display').text('₹' + Math.round(cartSubtotal));
            var total = cartSubtotal - currentCouponDiscount + currentShipping + currentCodCharge;
            $('#total_display').text('₹' + Math.round(total));
            if (currentShipping == 0) {
                $('#shipping_display').text('Free');
            } else {
                $('#shipping_display').text('₹' + Math.round(currentShipping));
            }
        }

        // ========== PLACE ORDER ==========
        function placeOrder() {
            var billing_fname = $('#billing_fname').val();
            var billing_lname = $('#billing_lname').val();
            var billing_name = (billing_fname + ' ' + billing_lname).trim();
            var phone = $('#billing_phone').val();
            var billing_address = $('#billing_address').val();
            var billing_address2 = $('#billing_address2').val();
            var city = $('#billing_city').val();
            var state = $('#billing_state').val();
            var zipcode = $('#billing_zipcode').val();

            let billingValid = true;
            function checkBilling(id, errorId) {
                let input = $('#' + id);
                let error = $('#' + errorId);
                if (!input.val()) {
                    input.addClass('is-invalid').removeClass('is-valid');
                    if (error.length) error.show();
                    billingValid = false;
                } else {
                    input.removeClass('is-invalid').addClass('is-valid');
                    if (error.length) error.hide();
                }
            }

            checkBilling('billing_fname', 'billing_fname_error');
            checkBilling('billing_lname', 'billing_lname_error');
            checkBilling('billing_phone', 'billing_phone_error');
            checkBilling('billing_address', 'billing_address_error');
            checkBilling('billing_city', 'billing_city_error');
            checkBilling('billing_state', 'billing_state_error');
            checkBilling('billing_zipcode', 'billing_zipcode_error');

            if (!billingValid) {
                toastr.warning('Please fill all required billing fields', 'Warning');
                return;
            }

            // Ensure email is present for guest
            if (!customerEmail) {
                var guestEmailInput = $('#guest_email').val();
                if (guestEmailInput) {
                    customerEmail = guestEmailInput.trim();
                } else {
                    toastr.warning('Please enter your email address', 'Warning');
                    $('#guest_email').focus();
                    return;
                }
            }

            // Validate email format
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(customerEmail)) {
                toastr.error('Please enter a valid email address', 'Error');
                $('#guest_email').focus();
                return;
            }

            // Validate phone
            var phoneRegex = /^[0-9]{10}$/;
            if (!phoneRegex.test(phone)) {
                $('#billing_phone_error').show();
                toastr.error('Billing mobile number must be exactly 10 digits', 'Error');
                return;
            }

            // Validate postcode
            var postcodeRegex = /^[0-9]{6}$/;
            if (!postcodeRegex.test(zipcode)) {
                $('#billing_zipcode_error').show();
                toastr.error('Billing postcode must be exactly 6 digits', 'Error');
                return;
            }

            // Determine shipping address based on "Ship to different address?" checkbox
            var shipToDifferent = $('#ship_to_different').is(':checked');
            var shipping_name, shipping_address, shipping_address2, shipping_city, shipping_state, shipping_pincode, shipping_phone;

            if (shipToDifferent) {
                // Customer wants to ship to a DIFFERENT address — use delivery fields
                var shipping_fname = $('#shipping_fname').val();
                var shipping_lname = $('#shipping_lname').val();
                shipping_name = (shipping_fname + ' ' + shipping_lname).trim();
                shipping_address = $('#shipping_address').val();
                shipping_address2 = $('#shipping_address2').val();
                shipping_city = $('#shipping_city').val();
                shipping_state = $('#shipping_state').val();
                shipping_pincode = $('#shipping_pincode').val();
                shipping_phone = $('#shipping_phone').val();

                let shippingValid = true;
                function checkShipping(id, errorId) {
                    let input = $('#' + id);
                    let error = $('#' + errorId);
                    if (!input.val()) {
                        input.addClass('is-invalid').removeClass('is-valid');
                        if (error.length) error.show();
                        shippingValid = false;
                    } else {
                        input.removeClass('is-invalid').addClass('is-valid');
                        if (error.length) error.hide();
                    }
                }

                checkShipping('shipping_fname', 'shipping_fname_error');
                checkShipping('shipping_lname', 'shipping_lname_error');
                checkShipping('shipping_address', 'shipping_address_error');
                checkShipping('shipping_city', 'shipping_city_error');
                checkShipping('shipping_state', '');
                checkShipping('shipping_pincode', 'shipping_pincode_error');
                checkShipping('shipping_phone', 'shipping_phone_error');

                if (!shippingValid) {
                    toastr.warning('Please fill all required delivery fields', 'Warning');
                    return;
                }

                if (!phoneRegex.test(shipping_phone)) {
                    $('#shipping_phone').addClass('is-invalid');
                    $('#shipping_phone_error').show();
                    toastr.error('Delivery mobile number must be exactly 10 digits', 'Error');
                    return;
                }

                if (!postcodeRegex.test(shipping_pincode)) {
                    $('#shipping_pincode').addClass('is-invalid');
                    $('#shipping_pincode_error').show();
                    toastr.error('Delivery postcode must be exactly 6 digits', 'Error');
                    return;
                }
            } else {
                // No different address — deliver to billing address
                shipping_name = billing_name;
                shipping_address = billing_address;
                shipping_address2 = billing_address2;
                shipping_city = city;
                shipping_state = state;
                shipping_pincode = zipcode;
                shipping_phone = phone;
            }

            // Validate payment method
            var payment_option = $('input[name="payment_option"]:checked').val();
            if (!payment_option) {
                toastr.warning('Please select a payment method', 'Warning');
                return;
            }

            // Build order data
            var orderData = {
                _token: csrfToken,
                fname: billing_fname,
                lname: billing_lname,
                billing_name: billing_name,
                email: customerEmail,
                phone: phone,
                billing_address: billing_address,
                billing_address2: billing_address2 || '',
                city: city,
                state: state,
                zipcode: zipcode,
                shipping_name: shipping_name,
                shipping_address: shipping_address,
                shipping_address2: shipping_address2 || '',
                shipping_city: shipping_city,
                shipping_state: shipping_state,
                shipping_pincode: shipping_pincode,
                shipping_phone: shipping_phone,
                payment_option: payment_option,
                ship_to_different: shipToDifferent ? 1 : 0,
                coupon_code: appliedCouponCode || '',
                coupon_discount: currentCouponDiscount,
                cod_charge: currentCodCharge
            };

            console.log('Placing order:', orderData);

            if (payment_option === 'online_gateway') {
                processRazorpayPayment(orderData);
            } else {
                placeCODOrder(orderData);
            }
        }

        // ========== RAZORPAY ==========
        function processRazorpayPayment(orderData) {
            toastr.info('Initializing payment...', 'Please wait');
            $.ajax({
                url: '<?php echo e(route("checkout.razorpay.create-order")); ?>',
                type: 'POST',
                data: orderData,
                success: function (response) {
                    if (response.success) {
                        openRazorpayCheckout(response, orderData);
                    } else {
                        toastr.error(response.message || 'Failed to create payment order', 'Error');
                    }
                },
                error: function (xhr) {
                    var msg = 'Failed to initialize payment';
                    if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    toastr.error(msg, 'Error');
                }
            });
        }

        function openRazorpayCheckout(razorpayData, orderData) {
            var rzp = new Razorpay({
                key: razorpayData.razorpay_key_id,
                amount: razorpayData.amount,
                currency: razorpayData.currency,
                name: 'Order #' + razorpayData.order_number + ' | Chennai Angadi',
                description: 'Payment for Order #' + razorpayData.order_number,
                order_id: razorpayData.razorpay_order_id,
                notes: {
                    order_id: razorpayData.order_id,
                    order_number: razorpayData.order_number
                },
                prefill: {
                    name: razorpayData.customer_name,
                    email: razorpayData.customer_email,
                    contact: razorpayData.customer_phone
                },
                theme: {
                    color: '#3BB77E'
                },
                handler: function (response) {
                    verifyPaymentAndPlaceOrder(response, orderData);
                },
                modal: {
                    ondismiss: function () {
                        toastr.warning('Payment process interrupted. Your order #' + razorpayData.order_number + ' has been saved as "Not Paid". You can pay later from your account.', 'Order Saved');
                    }
                }
            });
            rzp.on('payment.failed', function (response) {
                toastr.error('Payment failed: ' + response.error.description + '. Your order #' + razorpayData.order_number + ' is saved as "Not Paid".', 'Payment Failed');
            });
            rzp.open();
        }

        function verifyPaymentAndPlaceOrder(razorpayResponse, orderData) {
            toastr.info('Verifying payment...', 'Please wait');
            
            // We only need these three for verification now
            var verificationData = {
                _token: csrfToken,
                razorpay_order_id: razorpayResponse.razorpay_order_id,
                razorpay_payment_id: razorpayResponse.razorpay_payment_id,
                razorpay_signature: razorpayResponse.razorpay_signature
            };

            $.ajax({
                url: '<?php echo e(route("checkout.razorpay.verify-payment")); ?>',
                type: 'POST',
                data: verificationData,
                success: function (response) {
                    if (response.success) {
                        toastr.success('Payment successful!', 'Success');
                        showOrderSuccessModal(response.order_number || response.order_id);
                    } else {
                        toastr.error(response.message || 'Payment verification failed', 'Error');
                    }
                },
                error: function (xhr) {
                    var msg = 'Payment verification failed';
                    if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    toastr.error(msg, 'Error');
                }
            });
        }

        // ========== COD ORDER ==========
        function placeCODOrder(orderData) {
            $.ajax({
                url: '<?php echo e(route("checkout.place-order")); ?>',
                type: 'POST',
                data: orderData,
                success: function (response) {
                    if (response.success) {
                        showOrderSuccessModal(response.order_number || response.order_id);
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function (xhr) {
                    var msg = 'Failed to place order';
                    if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    toastr.error(msg, 'Error');
                }
            });
        }

        // ========== SUCCESS MODAL ==========
        function showOrderSuccessModal(orderId) {
            $('#order_id_display').text('#' + (orderId || 'CA000000'));

            var today = new Date();
            var deliveryDate = new Date(today);
            deliveryDate.setDate(today.getDate() + 5);
            var options = {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            };
            var formattedDate = deliveryDate.toLocaleDateString('en-GB', options);
            $('#estimated_delivery_display').text(formattedDate);

            $('#orderSuccessModal').fadeIn(300);
        }

        function goToHome() {
            window.location.href = '<?php echo e(route("index")); ?>?t=' + new Date().getTime();
        }

        // ========== CART QUANTITY UPDATE ==========
        function updateCartQty(cartId, action) {
            $.ajax({
                url: '<?php echo e(route("cart.update-quantity")); ?>',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    cart_id: cartId,
                    action: action
                },
                success: function (response) {
                    if (response.success) {
                        if (response.removed) {
                            $('tr[data-cart-id="' + cartId + '"]').fadeOut(300, function () {
                                $(this).remove();
                                if (response.cartCount === 0) {
                                    location.reload();
                                }
                            });
                            toastr.success(response.message || 'Item removed from cart', 'Success');
                        } else {
                            $('#qty-' + cartId).text(response.quantity);
                            $('#row-total-' + cartId).text('₹' + Math.round(response.row_total));
                        }

                        cartSubtotal = Math.round(response.subtotal);
                        console.log('Cart updated. New subtotal:', cartSubtotal);
                        calculateCodCharge();
                        calculateShipping(); // Recalculate shipping as subtotal changed
                        updateTotalsDisplay(); 

                        if (response.cartCount !== undefined) {
                            $('#top-header-cart-count, #mobile-header-cart-count, #bottom-header-cart-count').text(response.cartCount);
                        }
                    } else {
                        toastr.error(response.message || 'Failed to update quantity', 'Error');
                    }
                },
                error: function (xhr) {
                    var msg = 'Failed to update quantity';
                    if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    toastr.error(msg, 'Error');
                }
            });
        }

        // ========== DELETE CART ITEM ==========
        function deleteCartItem(cartId) {
            if (!confirm('Are you sure you want to remove this item from cart?')) {
                return;
            }

            $.ajax({
                url: '<?php echo e(route("cart.remove")); ?>',
                type: 'POST',
                data: {
                    _token: csrfToken,
                    cart_id: cartId
                },
                success: function (response) {
                    if (response.success) {
                        $('tr[data-cart-id="' + cartId + '"]').fadeOut(300, function () {
                            $(this).remove();
                            if (response.cartCount === 0) {
                                location.reload();
                            }
                        });

                        var subtotal = response.subtotal;
                        cartSubtotal = Math.round(subtotal);
                        calculateCodCharge();
                        calculateShipping(); // Recalculate shipping as subtotal changed
                        updateTotalsDisplay(); 

                        $('#top-header-cart-count, #mobile-header-cart-count, #bottom-header-cart-count').text(response.cartCount);
                        toastr.success('Item removed from cart', 'Success');
                    } else {
                        toastr.error(response.message || 'Failed to remove item', 'Error');
                    }
                },
                error: function (xhr) {
                    var msg = 'Failed to remove item';
                    if (xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                    toastr.error(msg, 'Error');
                }
            });
        }
        // ========== ABANDON GUEST SESSION ON TAB CLOSE ==========
        <?php if(!auth('customer')->check()): ?>
        window.addEventListener('beforeunload', function (e) {
            // Only abandon if not placing an order and session has guest data
            if (!window.isPlacingOrder && "<?php echo e(session('guest_checkout_email')); ?>") {
                var url = '<?php echo e(route("checkout.abandon-guest")); ?>';
                var data = new FormData();
                data.append('_token', '<?php echo e(csrf_token()); ?>');
                navigator.sendBeacon(url, data);
            }
        });
        <?php endif; ?>

        // Flag to prevent abandonment when actually submitting the order
        window.isPlacingOrder = false;
        
        // Wrap existing placeOrder to set the flag
        var originalPlaceOrder = placeOrder;
        placeOrder = function() {
            window.isPlacingOrder = true;
            originalPlaceOrder();
        };
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\chennais\frontend\resources\views/checkout/checkout-order.blade.php ENDPATH**/ ?>