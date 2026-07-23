@extends('layouts.app')
@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> <a href="{{ route('shop') }}">Shop</a>
                    <span></span> Checkout
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h1 class="heading-2 mb-10">Checkout</h1>
                    <div class="d-flex justify-content-between mb-30">
                        <h6 class="text-body">There are <span class="text-brand">{{ $cartItems->count() }}</span> products
                            in your cart</h6>
                    </div>

                    {{-- SECTION 1: CHECKOUT AS A GUEST OR REGISTER --}}
                    <div class="checkout-accordion-section mb-20">
                        <div class="checkout-accordion-header checkout-header-green">
                            <div class="d-flex align-items-center">
                                <div class="checkout-icon-wrapper">
                                    <i class="fi-rs-user"></i>
                                </div>
                                <span class="checkout-section-title"><strong>CHECKOUT AS A</strong> <span
                                        class="text-success">GUEST OR REGISTER</span></span>
                            </div>
                        </div>
                        <div class="checkout-accordion-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="checkout-radio-group">
                                        <div class="custome-radio mb-10">
                                            <input class="form-check-input" type="radio" name="checkout_type"
                                                id="checkout_guest" value="guest" onchange="toggleCheckoutType()">
                                            <label class="form-check-label text-success" for="checkout_guest">Checkout as
                                                Guest</label>
                                        </div>
                                        <div class="custome-radio">
                                            <input class="form-check-input" type="radio" name="checkout_type"
                                                id="checkout_login" value="login" onchange="toggleCheckoutType()">
                                            <label class="form-check-label text-success" for="checkout_login">Already
                                                Login</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    {{-- Guest Checkout Form --}}
                                    <div id="guest_checkout_form" style="display: none;">
                                        <div class="form-group mb-15">
                                            <label for="guest_email">Email Address <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="guest_email" name="guest_email"
                                                placeholder="Enter your email">
                                        </div>
                                        <button type="button" class="btn btn-success"
                                            onclick="continueAsGuest()">CONTINUE</button>
                                    </div>
                                    {{-- Login Form --}}
                                    <div id="login_checkout_form" style="display: none;">
                                        <div class="form-group mb-15">
                                            <label for="login_email">Email <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="login_email" name="login_id"
                                                placeholder="Email, Mobile or Username">
                                        </div>
                                        <div class="form-group mb-15">
                                            <label for="login_password">Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="login_password" name="password"
                                                placeholder="Password">
                                        </div>
                                        <button type="button" class="btn btn-success" id="login_btn"
                                            onclick="checkoutLoginSubmit()">LOGIN</button>
                                        <a href="{{ route('login') }}" class="text-primary ml-15">Lost your password?</a>
                                        <div id="login_message" class="mt-10"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: BILLING INFORMATION --}}
                    <div class="checkout-accordion-section mb-20 checkout-section-disabled" id="billing_section_wrapper">
                        <div class="checkout-accordion-header checkout-header-blue" id="billing_header">
                            <div class="d-flex align-items-center">
                                <div class="checkout-icon-wrapper checkout-icon-blue">
                                    <i class="fi-rs-document"></i>
                                </div>
                                <span class="checkout-section-title text-muted">BILLING INFORMATION</span>
                            </div>
                        </div>
                        <div class="checkout-accordion-body" id="billing_section" style="display: none;">
                            <form method="post" id="checkout_form">
                                @csrf
                                <h4 class="billing-info-title mb-30">Billing Information</h4>
                                <div class="row">
                                    {{-- Billing Details Column --}}
                                    <div class="col-lg-6">
                                        <h5 class="section-subtitle text-success mb-20"><em>Billing Details</em></h5>

                                        <div class="form-group mb-15">
                                            <label>Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" required name="billing_name"
                                                id="billing_name" placeholder="Enter your name">
                                        </div>

                                        <div class="form-group mb-15">
                                            <label>Mobile Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" required name="phone" id="billing_phone"
                                                placeholder="Enter your phone number">
                                        </div>

                                        <div class="form-group mb-15">
                                            <label>Address <span class="text-danger">*</span></label>
                                            <textarea class="form-control" required name="billing_address"
                                                id="billing_address" rows="2" placeholder="Enter your address"></textarea>
                                        </div>

                                        <div class="form-group mb-15">
                                            <label>City: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" required name="city" id="billing_city"
                                                placeholder="Town / City">
                                        </div>

                                        <div class="form-group mb-15">
                                            <label>State <span class="text-danger">*</span></label>
                                            <select name="state" id="billing_state" class="form-control" required
                                                onchange="clearStateError(); calculateShippingOnBillingChange();">
                                                <option value="">State</option>
                                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                <option value="Delhi">Delhi</option>
                                                <option value="Karnataka">Karnataka</option>
                                                <option value="Kerala">Kerala</option>
                                                <option value="Maharashtra">Maharashtra</option>
                                                <option value="Tamil Nadu">Tamil Nadu</option>
                                                <option value="Telangana">Telangana</option>
                                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            </select>
                                            <span id="billing_state_error" class="text-danger"
                                                style="font-size: 12px; display: none;">Please select your state</span>
                                        </div>

                                        <div class="form-group mb-15">
                                            <label>Postcode / Zip <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" required name="zipcode"
                                                id="billing_zipcode" placeholder="Postcode / Zip">
                                        </div>

                                        <div class="form-group mb-15">
                                            <label>LandMark <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" required name="billing_landmark"
                                                id="billing_landmark" placeholder="Enter your LandMark">
                                        </div>

                                        {{-- Hidden email field for guest checkout --}}
                                        <input type="hidden" name="email" id="billing_email">
                                    </div>

                                    {{-- Delivery Details Column --}}
                                    <div class="col-lg-6">
                                        <h5 class="section-subtitle text-success mb-20"><em>Delivery Details</em></h5>

                                        <div class="form-group mb-15">
                                            <label>Name: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_name" id="shipping_name"
                                                placeholder="Enter your name">
                                        </div>

                                        <div class="form-group mb-15">
                                            <label>Mobile Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_phone"
                                                id="shipping_phone" placeholder="Enter your phone number">
                                        </div>

                                        <div class="form-group mb-15">
                                            <label>Address <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="shipping_address" id="shipping_address"
                                                rows="2" placeholder="Enter your address"></textarea>
                                        </div>

                                        <div class="form-group mb-15">
                                            <label>City: <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_city" id="shipping_city"
                                                placeholder="Town / City">
                                        </div>

                                        <div class="form-group mb-15">
                                            <label>State <span class="text-danger">*</span></label>
                                            <select name="shipping_state" id="shipping_state" class="form-control"
                                                onchange="calculateShipping()">
                                                <option value="">Enter your state</option>
                                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                <option value="Delhi">Delhi</option>
                                                <option value="Karnataka">Karnataka</option>
                                                <option value="Kerala">Kerala</option>
                                                <option value="Maharashtra">Maharashtra</option>
                                                <option value="Tamil Nadu">Tamil Nadu</option>
                                                <option value="Telangana">Telangana</option>
                                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            </select>
                                        </div>

                                        <div class="form-group mb-15">
                                            <label>Postcode / Zip <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_pincode"
                                                id="shipping_pincode" placeholder="Postcode / Zip">
                                        </div>

                                        <div class="form-group mb-15">
                                            <label>Landmark <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="shipping_landmark"
                                                id="shipping_landmark" placeholder="Enter your landmark">
                                        </div>
                                    </div>
                                </div>

                                {{-- Same Address Checkbox --}}
                                <div class="row mt-20">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="custome-checkbox">
                                                <input class="form-check-input" type="checkbox" id="same_as_billing"
                                                    name="same_as_billing" value="1" onchange="copyBillingToShipping()">
                                                <label class="form-check-label" for="same_as_billing">
                                                    <span>Check this box if Billing Address and <a href="javascript:void(0)"
                                                            class="text-primary">Shipping Address</a> are the same.</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 text-end">
                                        <button type="button" class="btn btn-success btn-lg" onclick="placeOrder()">PLACE
                                            ORDER</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- SECTION 3: ORDER REVIEW --}}
                    <div class="checkout-accordion-section mb-20 checkout-section-disabled" id="order_section_wrapper">
                        <div class="checkout-accordion-header checkout-header-blue" id="order_header">
                            <div class="d-flex align-items-center">
                                <div class="checkout-icon-wrapper checkout-icon-blue">
                                    <i class="fi-rs-document"></i>
                                </div>
                                <span class="checkout-section-title text-muted">ORDER REVIEW</span>
                            </div>
                        </div>
                        <div class="checkout-accordion-body" id="order_review_section" style="display: none;">
                            <div class="table-responsive order_table checkout">
                                <table class="table no-border">
                                    <tbody>
                                        @forelse($cartItems as $item)
                                            @if($item->product)
                                                <tr>
                                                    <td class="product-des product-name">
                                                        <h6 class="mb-5">{{ $item->product->productname ?? 'Product Unavailable' }}
                                                        </h6>
                                                    </td>
                                                    <td class="product-des product-name text-muted text-end">
                                                        x {{ $item->quantity }}
                                                    </td>
                                                    <td class="product-des product-name text-muted text-end">
                                                        ₹{{ number_format($item->price_at_add_time * $item->quantity, 2) }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">No items in cart</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="divider-2 mt-20 mb-20"></div>
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Subtotal</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">₹{{ number_format($subtotal, 2) }}</h4>
                                        </td>
                                    </tr>
                                    <tr id="coupon_discount_row" style="display: none;">
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Coupon Discount <a href="javascript:void(0)"
                                                    onclick="removeCoupon()" class="text-danger"
                                                    style="font-size: 12px;">(Remove)</a></h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-success text-end" id="coupon_discount_display">-₹0.00</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Shipping</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end" id="shipping_display">
                                                ₹{{ number_format($shipping, 2) }}</h4>
                                        </td>
                                    </tr>
                                    <tr id="cod_charge_row" style="display: none;">
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">COD Charge</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-warning text-end" id="cod_charge_display">₹50.00</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted"><strong>Total</strong></h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end" id="total_display">
                                                ₹{{ number_format($total, 2) }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- SECTION 4: PAYMENT MODE --}}
                    <div class="checkout-accordion-section mb-20 checkout-section-disabled" id="payment_section_wrapper">
                        <div class="checkout-accordion-header checkout-header-blue" id="payment_header">
                            <div class="d-flex align-items-center">
                                <div class="checkout-icon-wrapper checkout-icon-blue">
                                    <i class="fi-rs-credit-card"></i>
                                </div>
                                <span class="checkout-section-title text-muted">PAYMENT MODE</span>
                            </div>
                        </div>
                        <div class="checkout-accordion-body" id="payment_section" style="display: none;">
                            <div class="payment_option">
                                <div class="custome-radio mb-10">
                                    <input class="form-check-input" required="" type="radio" name="payment_option"
                                        id="cash_on_delivery" value="cash_on_delivery"
                                        onchange="handlePaymentOptionChange()">
                                    <label class="form-check-label" for="cash_on_delivery">Cash on delivery</label>
                                </div>
                                <div class="custome-radio">
                                    <input class="form-check-input" required="" type="radio" name="payment_option"
                                        id="online_gateway" value="online_gateway" onchange="handlePaymentOptionChange()">
                                    <label class="form-check-label" for="online_gateway">Online Payment</label>
                                </div>
                            </div>
                            <div class="mt-30">
                                <form method="post" class="apply-coupon d-flex" id="coupon_form"
                                    onsubmit="return applyCoupon(event)">
                                    @csrf
                                    <input type="text" id="coupon_code" name="coupon_code"
                                        placeholder="Enter Coupon Code..." class="mr-10">
                                    <button type="submit" class="btn btn-md" id="apply_coupon_btn">Apply Coupon</button>
                                </form>
                                <div id="coupon_message" class="mt-10"></div>
                            </div>
                            <button id="place_order_btn" class="btn btn-fill-out btn-block mt-30" onclick="placeOrder()">Place an Order<i
                                    class="fi-rs-sign-out ml-15"></i></button>
                        </div>
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
            <p class="success-subtitle">Thank you for your purchase</p>
        </div>
    </div>

    <style>
        /* Checkout Accordion Styles */
        .checkout-accordion-section {
            background: #fff;
            margin-bottom: 15px;
        }

        .checkout-accordion-header {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .checkout-header-green {
            border-top: 3px solid #3BB77E;
            border-left: 1px solid #e8e8e8;
            border-right: 1px solid #e8e8e8;
        }

        .checkout-header-blue {
            border-bottom: 2px solid #87CEEB;
            background: #fff;
        }

        .checkout-icon-wrapper {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #FFC107;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .checkout-icon-wrapper i {
            color: #fff;
            font-size: 16px;
        }

        .checkout-icon-blue {
            background: #87CEEB;
        }

        .checkout-section-title {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .checkout-accordion-body {
            padding: 20px;
            border: 1px solid #e8e8e8;
            border-top: none;
        }

        .checkout-radio-group {
            padding: 15px;
            border: 1px solid #e8e8e8;
            border-radius: 5px;
        }

        /* Disabled section styles */
        .checkout-section-disabled {
            opacity: 0.6;
            pointer-events: none;
        }

        .checkout-section-disabled .checkout-accordion-header {
            cursor: not-allowed;
        }

        .checkout-section-enabled {
            opacity: 1;
            pointer-events: auto;
        }

        .checkout-section-enabled .checkout-accordion-header {
            cursor: pointer;
        }

        .text-success {
            color: #3BB77E !important;
        }

        /* Form styling */
        #guest_checkout_form .form-group,
        #login_checkout_form .form-group {
            margin-bottom: 15px;
        }

        #guest_checkout_form label,
        #login_checkout_form label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
            font-size: 13px;
        }

        #guest_checkout_form .form-control,
        #login_checkout_form .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn-success {
            background-color: #3BB77E !important;
            border-color: #3BB77E !important;
            color: #fff !important;
            padding: 10px 25px;
        }

        .btn-success:hover {
            background-color: #2b9962 !important;
            border-color: #2b9962 !important;
        }

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

        .success-animation {
            margin-bottom: 25px;
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

        /* Billing Form Styles */
        .billing-info-title {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #e8e8e8;
            padding-bottom: 15px;
        }

        .section-subtitle {
            font-size: 15px;
            font-weight: 500;
        }

        #billing_section .form-group label {
            font-weight: 500;
            color: #333;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }

        #billing_section .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px 15px;
            font-size: 14px;
            color: #666;
        }

        #billing_section .form-control:focus {
            border-color: #3BB77E;
            box-shadow: 0 0 0 2px rgba(59, 183, 126, 0.1);
        }

        #billing_section textarea.form-control {
            min-height: 60px;
            resize: vertical;
        }

        #billing_section select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 10px center;
            background-repeat: no-repeat;
            background-size: 20px;
        }

        .custome-checkbox label span a {
            color: #3BB77E;
            text-decoration: underline;
        }

        .btn-success.btn-lg {
            padding: 12px 40px;
            font-size: 16px;
            font-weight: 600;
            background: #006400 !important;
            border-color: #006400 !important;
        }

        .btn-success.btn-lg:hover {
            background: #005000 !important;
            border-color: #005000 !important;
        }

        /* Place an Order button full width */
        button#place_order_btn {
            width: 100% !important;
            display: block !important;
            box-sizing: border-box !important;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        const csrfToken = '{{ csrf_token() }}';
        const cartSubtotal = {{ $subtotal }};
        let currentShipping = {{ $shipping }};
        let currentCouponDiscount = {{ $sessionCouponDiscount ?? 0 }};
        let appliedCouponCode = {!! $sessionCouponCode ? "'" . $sessionCouponCode . "'" : 'null' !!};
        let savedAddresses = [];
        let currentCodCharge = 0;
        const COD_CHARGE_AMOUNT = 50;
        const COD_CHARGE_THRESHOLD = 600;
        let isLoggedIn = {{ auth('customer')->check() ? 'true' : 'false' }};

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });

        $(document).ready(function () {
            // Load coupon from session if applied in cart
            @if($sessionCouponCode && $sessionCouponDiscount > 0)
                $('#coupon_code').val('{{ $sessionCouponCode }}').prop('readonly', true);
                $('#apply_coupon_btn').text('Applied').addClass('btn-success').prop('disabled', true);
                $('#coupon_discount_row').show();
                $('#coupon_discount_display').text('-₹{{ number_format($sessionCouponDiscount, 2) }}');
                $('#coupon_message').html('<span class="text-success">Coupon applied from cart!</span>');
                updateTotalsDisplay();
            @endif

            @if(auth('customer')->check() && $customer)
                populateBillingFromCustomer(@json($customer));
                @if($savedAddresses && $savedAddresses->count() > 0)
                    savedAddresses = @json($savedAddresses);
                    populateAddressDropdown(savedAddresses);
                @endif
            @endif

                                        const billingState = $('select[name="state"]').val();
            if (billingState) calculateShipping();
        });

        // Toggle checkout type (Guest vs Login)
        function toggleCheckoutType() {
            const checkoutType = $('input[name="checkout_type"]:checked').val();
            if (checkoutType === 'guest') {
                $('#guest_checkout_form').slideDown();
                $('#login_checkout_form').hide();
            } else if (checkoutType === 'login') {
                $('#guest_checkout_form').hide();
                $('#login_checkout_form').slideDown();
            }
        }

        // Continue as guest - store email and redirect to billing page
        function continueAsGuest() {
            const email = $('#guest_email').val();
            if (!email) {
                toastr.warning('Please enter your email address', 'Warning');
                return;
            }
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                toastr.warning('Please enter a valid email address', 'Warning');
                return;
            }
            
            // Show loading state
            const continueBtn = $('#guest_checkout_form button');
            continueBtn.prop('disabled', true).text('Please wait...');
            
            // Make AJAX call to store email in session and get redirect URL
            $.ajax({
                url: '{{ route("checkout.guest-continue") }}',
                type: 'POST',
                data: { 
                    _token: csrfToken, 
                    guest_email: email 
                },
                success: function (response) {
                    if (response.success) {
                        // Redirect to billing information page
                        window.location.href = response.redirect_url;
                    } else {
                        toastr.error(response.message || 'Something went wrong', 'Error');
                        continueBtn.prop('disabled', false).text('CONTINUE');
                    }
                },
                error: function (xhr) {
                    const errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Failed to continue';
                    toastr.error(errorMsg, 'Error');
                    continueBtn.prop('disabled', false).text('CONTINUE');
                }
            });
        }

        // Enable all checkout sections
        function enableCheckoutSections() {
            $('#billing_section_wrapper, #order_section_wrapper, #payment_section_wrapper')
                .removeClass('checkout-section-disabled')
                .addClass('checkout-section-enabled');

            // Add click handlers
            $('#billing_header').attr('onclick', "toggleAccordion('billing_section')");
            $('#order_header').attr('onclick', "toggleAccordion('order_review_section')");
            $('#payment_header').attr('onclick', "toggleAccordion('payment_section')");
        }

        // Toggle accordion sections
        function toggleAccordion(sectionId) {
            const section = $('#' + sectionId);
            if (section.is(':visible')) {
                section.slideUp();
            } else {
                section.slideDown();
            }
        }

        // AJAX Login at checkout
        function checkoutLoginSubmit() {
            const login_id = $('#login_email').val();
            const password = $('#login_password').val();

            if (!login_id || !password) {
                $('#login_message').html('<span class="text-danger">Please enter login credentials</span>');
                return;
            }

            $('#login_btn').prop('disabled', true).text('Logging in...');

            $.ajax({
                url: '{{ route("checkout.login") }}',
                type: 'POST',
                data: { _token: csrfToken, login_id: login_id, password: password },
                success: function (response) {
                    if (response.success) {
                        $('#login_message').html('<span class="text-success">Login successful! Redirecting...</span>');
                        toastr.success('Logged in successfully!', 'Success');
                        // Redirect to billing information page
                        setTimeout(function () {
                            window.location.href = '{{ route("checkout.billing-information") }}';
                        }, 1000);
                    } else {
                        $('#login_message').html('<span class="text-danger">' + response.message + '</span>');
                        $('#login_btn').prop('disabled', false).text('LOGIN');
                    }
                },
                error: function (xhr) {
                    const errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Login failed';
                    $('#login_message').html('<span class="text-danger">' + errorMsg + '</span>');
                    $('#login_btn').prop('disabled', false).text('LOGIN');
                }
            });
        }

        function populateBillingForm(customer) {
            if (!customer) return;
            $('#billing_name').val(customer.username || '');
            $('#billing_address').val(customer.address || '');
            $('#billing_city').val(customer.city || '');
            $('#billing_state').val(customer.state || '');
            $('#billing_zipcode').val(customer.pincode || '');
            $('#billing_phone').val(customer.phone || '');
            $('#billing_email').val(customer.email || '');
        }

        function populateBillingFromCustomer(customer) {
            if (!customer) return;
            $('#billing_name').val(customer.username || '');
            $('#billing_address').val(customer.address || '');
            $('#billing_city').val(customer.city || '');
            $('#billing_state').val(customer.state || '');
            $('#billing_zipcode').val(customer.pin || '');
            $('#billing_phone').val(customer.mobilenumber || '');
            $('#billing_email').val(customer.email || '');
        }

        function populateAddressDropdown(addresses) {
            const $selector = $('#shipping_address_selector');
            $selector.find('option:not(:first):not([value="new"])').remove();
            addresses.forEach(function (addr, index) {
                const label = addr.title || addr.name || ('Address ' + (index + 1));
                $selector.find('option[value="new"]').before('<option value="' + index + '">' + label + ' - ' + addr.city + ', ' + addr.state + '</option>');
            });
            $('#saved-addresses-wrapper').show();
        }

        // Copy billing details to shipping fields when checkbox is checked
        function copyBillingToShipping() {
            const sameAsBilling = $('#same_as_billing').is(':checked');
            if (sameAsBilling) {
                // Copy billing values to shipping fields
                $('#shipping_name').val($('#billing_name').val());
                $('#shipping_phone').val($('#billing_phone').val());
                $('#shipping_address').val($('#billing_address').val());
                $('#shipping_city').val($('#billing_city').val());
                $('#shipping_state').val($('#billing_state').val());
                $('#shipping_pincode').val($('#billing_zipcode').val());
                $('#shipping_landmark').val($('#billing_landmark').val());

                // Calculate shipping with the billing state
                const billingState = $('#billing_state').val();
                if (billingState) {
                    calculateShippingWithState(billingState);
                }
                toastr.success('Shipping address copied from billing address', 'Success');
            } else {
                // Clear shipping fields when unchecked
                $('#shipping_name, #shipping_phone, #shipping_address, #shipping_city, #shipping_pincode, #shipping_landmark').val('');
                $('#shipping_state').val('');
            }
        }

        function handleAddressSelection() {
            const selection = $('#shipping_address_selector').val();
            if (selection === '' || selection === 'new') {
                $('#shipping_title, #shipping_address, #shipping_city, #shipping_state, #shipping_pincode, #shipping_phone').val('');
                $('#shipping-form-fields').show();
            } else {
                const addr = savedAddresses[parseInt(selection)];
                if (addr) {
                    $('#shipping_title').val(addr.title || '');
                    $('#shipping_address').val(addr.address || '');
                    $('#shipping_city').val(addr.city || '');
                    $('#shipping_state').val(addr.state || '');
                    $('#shipping_pincode').val(addr.pincode || '');
                    $('#shipping_phone').val(addr.phone || '');
                    $('#shipping-form-fields').show();
                }
            }
            calculateShipping();
        }

        function calculateShipping() {
            const sameAsBilling = $('#same_as_billing').is(':checked');
            let state = sameAsBilling ? $('select[name="state"]').val() : $('#shipping_state').val();
            if (!state) return;

            $.ajax({
                url: '{{ route("checkout.calculate-shipping") }}',
                type: 'POST',
                data: { _token: csrfToken, state: state, subtotal: cartSubtotal },
                success: function (response) {
                    if (response.success) {
                        currentShipping = response.shipping_charge;
                        updateTotalsDisplay();
                    }
                },
                error: function (xhr) { console.error('Shipping calculation error:', xhr); }
            });
        }

        function updateTotalsDisplay() {
            calculateCodCharge();
            const total = cartSubtotal - currentCouponDiscount + currentShipping + currentCodCharge;
            $('#shipping_display').text('₹' + currentShipping.toFixed(2));
            $('#total_display').text('₹' + total.toFixed(2));
        }

        function calculateCodCharge() {
            const paymentOption = $('input[name="payment_option"]:checked').val();
            if (paymentOption === 'cash_on_delivery') {
                const priceAfterCoupon = cartSubtotal - currentCouponDiscount;
                if (priceAfterCoupon < COD_CHARGE_THRESHOLD) {
                    currentCodCharge = COD_CHARGE_AMOUNT;
                    $('#cod_charge_row').show();
                    $('#cod_charge_display').text('₹' + COD_CHARGE_AMOUNT.toFixed(2));
                } else {
                    currentCodCharge = 0;
                    $('#cod_charge_row').hide();
                }
            } else {
                currentCodCharge = 0;
                $('#cod_charge_row').hide();
            }
        }

        function handlePaymentOptionChange() { updateTotalsDisplay(); }

        function applyCoupon(event) {
            event.preventDefault();
            const couponCode = $('#coupon_code').val().trim();
            if (!couponCode) {
                $('#coupon_message').html('<span class="text-danger">Please enter a coupon code</span>');
                return false;
            }
            $('#apply_coupon_btn').prop('disabled', true).text('Applying...');

            $.ajax({
                url: '{{ route("checkout.apply-coupon") }}',
                type: 'POST',
                data: { _token: csrfToken, coupon_code: couponCode, subtotal: cartSubtotal },
                success: function (response) {
                    if (response.success) {
                        currentCouponDiscount = response.coupon.discount;
                        appliedCouponCode = response.coupon.code;
                        $('#coupon_discount_row').show();
                        $('#coupon_discount_display').text('-₹' + currentCouponDiscount.toFixed(2));
                        $('#coupon_message').html('<span class="text-success">' + response.message + '</span>');
                        $('#coupon_code').prop('readonly', true);
                        $('#apply_coupon_btn').text('Applied').addClass('btn-success');
                        updateTotalsDisplay();
                        toastr.success(response.message, 'Success');
                    } else {
                        $('#coupon_message').html('<span class="text-danger">' + response.message + '</span>');
                        $('#apply_coupon_btn').prop('disabled', false).text('Apply Coupon');
                    }
                },
                error: function (xhr) {
                    const errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Failed to apply coupon';
                    $('#coupon_message').html('<span class="text-danger">' + errorMsg + '</span>');
                    $('#apply_coupon_btn').prop('disabled', false).text('Apply Coupon');
                }
            });
            return false;
        }

        function removeCoupon() {
            currentCouponDiscount = 0;
            appliedCouponCode = null;
            $('#coupon_discount_row').hide();
            $('#coupon_code').val('').prop('readonly', false);
            $('#apply_coupon_btn').prop('disabled', false).text('Apply Coupon').removeClass('btn-success');
            $('#coupon_message').html('');
            updateTotalsDisplay();
            toastr.info('Coupon removed', 'Info');
        }

        function placeOrder() {
            const billing_name = $('#billing_name').val();
            const email = $('#billing_email').val() || $('#guest_email').val();
            const phone = $('#billing_phone').val();
            const billing_address = $('#billing_address').val();
            const city = $('#billing_city').val();
            const state = $('#billing_state').val();
            const zipcode = $('#billing_zipcode').val();
            const billing_landmark = $('#billing_landmark').val();
            const payment_option = $('input[name="payment_option"]:checked').val();
            const sameAsBilling = $('#same_as_billing').is(':checked');

            if (!state) $('#billing_state_error').show();
            if (!billing_name || !email || !phone || !billing_address || !city || !state || !zipcode || !billing_landmark || !payment_option) {
                toastr.warning('Please fill all required fields', 'Warning');
                return;
            }

            let orderData = {
                _token: csrfToken,
                billing_name,
                email,
                phone,
                billing_address,
                city,
                state,
                zipcode,
                billing_landmark,
                payment_option,
                same_as_billing: sameAsBilling ? 1 : 0,
                coupon_code: appliedCouponCode || '',
                coupon_discount: currentCouponDiscount,
                cod_charge: currentCodCharge
            };

            // Always collect shipping details
            const shipping_name = $('#shipping_name').val();
            const shipping_address = $('#shipping_address').val();
            const shipping_city = $('#shipping_city').val();
            const shipping_state = $('#shipping_state').val();
            const shipping_pincode = $('#shipping_pincode').val();
            const shipping_phone = $('#shipping_phone').val();
            const shipping_landmark = $('#shipping_landmark').val();

            if (!shipping_name || !shipping_address || !shipping_city || !shipping_state || !shipping_pincode || !shipping_phone) {
                toastr.warning('Please fill all required shipping fields', 'Warning');
                return;
            }
            Object.assign(orderData, { shipping_name, shipping_address, shipping_city, shipping_state, shipping_pincode, shipping_phone, shipping_landmark });

            if (payment_option === 'online_gateway') processRazorpayPayment(orderData);
            else placeCODOrder(orderData);
        }

        function processRazorpayPayment(orderData) {
            toastr.info('Initializing payment...', 'Please wait');
            $.ajax({
                url: '{{ route("checkout.razorpay.create-order") }}',
                type: 'POST',
                data: orderData,
                success: function (response) {
                    if (response.success) openRazorpayCheckout(response, orderData);
                    else toastr.error(response.message || 'Failed to create payment order', 'Error');
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Failed to initialize payment', 'Error');
                }
            });
        }

        function openRazorpayCheckout(razorpayData, orderData) {
            var rzp = new Razorpay({
                key: razorpayData.razorpay_key_id,
                amount: razorpayData.amount,
                currency: razorpayData.currency,
                name: 'Chennai Angadi',
                description: 'Order Payment',
                order_id: razorpayData.razorpay_order_id,
                prefill: { name: razorpayData.customer_name, email: razorpayData.customer_email, contact: razorpayData.customer_phone },
                theme: { color: '#3BB77E' },
                handler: function (response) { verifyPaymentAndPlaceOrder(response, orderData); },
                modal: { ondismiss: function () { toastr.warning('Payment cancelled', 'Warning'); } }
            });
            rzp.on('payment.failed', function (response) {
                toastr.error('Payment failed: ' + response.error.description, 'Error');
            });
            rzp.open();
        }

        function verifyPaymentAndPlaceOrder(razorpayResponse, orderData) {
            toastr.info('Verifying payment...', 'Please wait');
            orderData.razorpay_order_id = razorpayResponse.razorpay_order_id;
            orderData.razorpay_payment_id = razorpayResponse.razorpay_payment_id;
            orderData.razorpay_signature = razorpayResponse.razorpay_signature;

            $.ajax({
                url: '{{ route("checkout.razorpay.verify-payment") }}',
                type: 'POST',
                data: orderData,
                success: function (response) {
                    if (response.success) { toastr.success('Payment successful!', 'Success'); showOrderSuccessModal(); }
                    else toastr.error(response.message || 'Payment verification failed', 'Error');
                },
                error: function (xhr) { toastr.error(xhr.responseJSON?.message || 'Payment verification failed', 'Error'); }
            });
        }

        function placeCODOrder(orderData) {
            $.ajax({
                url: '{{ route("checkout.place-order") }}',
                type: 'POST',
                data: orderData,
                success: function (response) {
                    if (response.success) showOrderSuccessModal();
                    else toastr.error(response.message, 'Error');
                },
                error: function (xhr) { toastr.error(xhr.responseJSON?.message || 'Failed to place order', 'Error'); }
            });
        }

        function showOrderSuccessModal() {
            $('#orderSuccessModal').fadeIn(300);
            let countdown = 5;
            const countdownInterval = setInterval(function () {
                countdown--;
                if (countdown <= 0) { clearInterval(countdownInterval); window.location.href = '{{ route("index") }}'; }
            }, 1000);
        }

        function clearStateError() { if ($('#billing_state').val()) $('#billing_state_error').hide(); }

        function calculateShippingOnBillingChange() {
            const sameAsBilling = $('#same_as_billing').is(':checked');
            const billingState = $('#billing_state').val();
            if (sameAsBilling && billingState) calculateShippingWithState(billingState);
        }

        function calculateShippingWithState(state) {
            if (!state) return;
            $.ajax({
                url: '{{ route("checkout.calculate-shipping") }}',
                type: 'POST',
                data: { _token: csrfToken, state: state, subtotal: cartSubtotal },
                success: function (response) { if (response.success) { currentShipping = response.shipping_charge; updateTotalsDisplay(); } },
                error: function (xhr) { console.error('Shipping calculation error:', xhr); }
            });
        }
    </script>
@endpush