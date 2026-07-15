@extends('layouts.app')
@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> <a href="{{ route('checkout') }}">Checkout</a>
                    <span></span> <a href="{{ route('checkout.billing-information') }}">Billing Information</a>
                    <span></span> Order Review <span> </span>
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row justify-content-center">
                <div class="row">
                    {{-- Left Column: Order of the Address --}}
                    <div class="col-lg-6 col-md-12 mb-30">
                        <h4 class="section-title"><em>Order of the Address</em></h4>

                        <div class="row mt-20">
                            {{-- Billing Address Box --}}
                            <div class="col-12 mb-20">
                                <div class="address-box">
                                    <div class="address-box-header billing-header">
                                        <strong>Billing Address</strong>
                                    </div>
                                    <div class="address-box-body">
                                        @if(!empty($billingData['billing_name']))
                                            <p><strong>{{ $billingData['billing_name'] }}</strong></p>
                                            <p>{{ $billingData['billing_address'] ?? '' }}</p>
                                            @if(!empty($billingData['billing_landmark']))
                                                <p>{{ $billingData['billing_landmark'] }}</p>
                                            @endif
                                            <p>{{ $billingData['city'] ?? '' }}, {{ $billingData['state'] ?? '' }} -
                                                {{ $billingData['zipcode'] ?? '' }}
                                            </p>
                                            <p>Phone: {{ $billingData['phone'] ?? '' }}</p>
                                        @else
                                            <p class="text-muted">No billing address provided</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Shipping Address Box --}}
                            <div class="col-12">
                                <div class="address-box">
                                    <div class="address-box-header shipping-header">
                                        <strong>Shipping Address</strong>
                                    </div>
                                    <div class="address-box-body">
                                        @if(!empty($billingData['shipping_name']))
                                            <p><strong>{{ $billingData['shipping_name'] }}</strong></p>
                                            <p>{{ $billingData['shipping_address'] ?? '' }}</p>
                                            @if(!empty($billingData['shipping_landmark']))
                                                <p>{{ $billingData['shipping_landmark'] }}</p>
                                            @endif
                                            <p>{{ $billingData['shipping_city'] ?? '' }},
                                                {{ $billingData['shipping_state'] ?? '' }}
                                                - {{ $billingData['shipping_pincode'] ?? '' }}
                                            </p>
                                            <p>Phone: {{ $billingData['shipping_phone'] ?? '' }}</p>
                                        @else
                                            <p class="text-muted">No shipping address provided</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column: Your Order --}}
                    <div class="col-lg-6 col-md-12">
                        <h4 class="section-title"><em>Your order</em></h4>

                        <div class="your-order-table mt-20">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product name</th>
                                        <th class="text-center">Unit Price</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cartItems as $item)
                                        @if($item->product)
                                            <tr>
                                                <td>{{ $item->product->productname ?? 'Product Unavailable' }} x
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="text-center">₹{{ number_format($item->price_at_add_time, 0) }}</td>
                                                <td class="text-end text-brand">
                                                    ₹{{ number_format($item->price_at_add_time * $item->quantity, 2) }}</td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No items in cart</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            {{-- Order Totals --}}
                            <table class="table order-totals-table">
                                <tbody>
                                    <tr>
                                        <td><strong>Subtotal</strong></td>
                                        <td class="text-end text-brand" id="subtotal_display">
                                            ₹{{ number_format($subtotal, 2) }}
                                        </td>
                                    </tr>
                                    <tr id="coupon_discount_row"
                                        style="{{ ($sessionCouponDiscount > 0) ? '' : 'display: none;' }}">
                                        <td>
                                            Coupon Discount
                                            <a href="javascript:void(0)" onclick="removeCoupon()" class="text-danger"
                                                style="font-size: 12px;">(Remove)</a>
                                        </td>
                                        <td class="text-end text-success" id="coupon_discount_display">
                                            -₹{{ number_format($sessionCouponDiscount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Shipping Charges:</strong></td>
                                        <td class="text-end text-brand" id="shipping_display">
                                            @if($shipping > 0)
                                                ₹{{ number_format($shipping, 2) }}
                                            @else
                                                <span class="text-success">Free</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr id="cod_charge_row" style="display: none;">
                                        <td><strong>COD Charge:</strong></td>
                                        <td class="text-end text-brand" id="cod_charge_display">₹0.00</td>
                                    </tr>

                                    <tr class="grand-total-row">
                                        <td><strong>Grand Total :</strong></td>
                                        <td class="text-end">
                                            <span class="grand-total-amount"
                                                id="total_display">₹{{ number_format($total - $sessionCouponDiscount, 2) }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Choose Payment Mode Section --}}
                    <div class="row mt-40">
                        <div class="col-12">
                            <h4 class="payment-mode-title">Choose Payment Mode</h4>

                            <div class="payment-options-container mt-30">
                                <div class="row justify-content-center">
                                    {{-- Online Payment Option --}}
                                    <div class="col-lg-4 col-md-5 col-sm-6 mb-20">
                                        <div class="payment-option-card" id="online_payment_card"
                                            onclick="selectPaymentMethod('online_gateway')">
                                            <div class="payment-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="50"
                                                    viewBox="0 0 100 80">
                                                    <rect x="10" y="10" width="60" height="40" rx="5" fill="#4CAF50"
                                                        stroke="#2E7D32" stroke-width="2" />
                                                    <rect x="15" y="20" width="25" height="5" fill="#FFC107" />
                                                    <rect x="15" y="30" width="50" height="3" fill="#FFF" />
                                                    <rect x="15" y="36" width="30" height="3" fill="#FFF" />
                                                    <circle cx="75" cy="45" r="18" fill="#FFC107" stroke="#FF9800"
                                                        stroke-width="2" />
                                                    <path d="M68 45 L75 50 L82 40" stroke="#4CAF50" stroke-width="3"
                                                        fill="none" />
                                                </svg>
                                            </div>
                                            <div class="payment-label">Online Payment</div>
                                            <div class="payment-radio">
                                                <input type="radio" name="payment_method" id="online_gateway"
                                                    value="online_gateway">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Cash On Delivery Option --}}
                                    <div class="col-lg-4 col-md-5 col-sm-6 mb-20">
                                        <div class="payment-option-card" id="cod_payment_card"
                                            onclick="selectPaymentMethod('cash_on_delivery')">
                                            <div class="payment-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="50"
                                                    viewBox="0 0 100 80">
                                                    <path
                                                        d="M25 60 Q20 60 20 50 L20 35 Q20 30 25 30 L45 30 Q50 30 50 35 L50 50 Q50 60 45 60 Z"
                                                        fill="#4CAF50" />
                                                    <rect x="55" y="15" width="25" height="20" rx="3" fill="#FFC107"
                                                        stroke="#FF9800" stroke-width="2" />
                                                    <rect x="58" y="20" width="8" height="5" fill="#FF9800" />
                                                    <path d="M50 50 L70 35 L85 55 L60 65 Z" fill="#4CAF50" />
                                                    <circle cx="35" cy="45" r="8" fill="#FFC107" />
                                                </svg>
                                            </div>
                                            <div class="payment-label">Cash On Delivery</div>
                                            <div class="payment-sublabel"> ₹50 COD charge for orders below ₹600</div>
                                            <div class="payment-radio">
                                                <input type="radio" name="payment_method" id="cash_on_delivery"
                                                    value="cash_on_delivery">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- COD Confirmation Banner (Hidden by default) --}}
                            <div id="cod_confirmation_section" style="display: none;">
                                <div class="cod-banner">
                                    <span>Cash On Delivery</span>
                                </div>
                                <div class="text-center mt-20">
                                    <button type="button" class="btn btn-confirm-order" onclick="confirmOrder()">Confirm
                                        Order</button>
                                </div>
                            </div>

                            {{-- Online Payment Button (Hidden by default) --}}
                            <div id="online_payment_section" style="display: none;">
                                <div class="text-center mt-20">
                                    <button type="button" class="btn btn-confirm-order"
                                        onclick="processOnlinePayment()">Proceed
                                        to Payment</button>
                                </div>
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
            <p class="order-id-text">Order ID: <span id="order_id_display">#CA000000</span></p>
            <p class="estimated-shipping-text" style="font-size: 16px; color: #555; margin-bottom: 5px;">
                Estimated Shipping: <span id="estimated_delivery_display" style="font-weight: 600; color: #333;"></span>
            </p>
            <p class="success-subtitle">Thank you for your purchase</p>
            <button type="button" class="btn btn-back-home" onclick="goToHome()">Back to Home</button>
        </div>
    </div>

    <style>
        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        /* Address Box Styles */
        .address-box {
            border: 1px solid #e8e8e8;
            border-radius: 4px;
            overflow: hidden;
        }

        .address-box-header {
            padding: 10px 15px;
            color: #fff;
            text-align: center;
        }

        .address-box-header.billing-header {
            background-color: #006400;
        }

        .address-box-header.shipping-header {
            background-color: #006400;
        }

        .address-box-body {
            padding: 15px;
            text-align: center;
            min-height: 100px;
        }

        .address-box-body p {
            margin-bottom: 5px;
            color: #555;
        }

        /* Your Order Table */
        .your-order-table .table {
            margin-bottom: 0;
        }

        .your-order-table .table thead th {
            background-color: #006400;
            color: #fff;
            font-weight: 500;
            padding: 10px 15px;
            font-size: 14px;
        }

        .your-order-table .table tbody td {
            padding: 12px 15px;
            font-size: 14px;
            vertical-align: middle;
        }

        .order-totals-table {
            margin-top: 15px;
        }

        .order-totals-table td {
            padding: 8px 0 !important;
            border: none !important;
        }

        .grand-total-row td {
            padding-top: 15px !important;
        }

        .grand-total-amount {
            font-size: 24px;
            font-weight: 700;
            color: #ff6600;
        }

        .text-brand {
            color: #ff6600 !important;
        }

        /* Payment Method Section */
        .payment-method-section h4 {
            font-weight: 600;
            color: #333;
        }

        .payment-options-box {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 8px;
            padding: 20px;
        }

        .custome-radio .form-check-input {
            margin-right: 10px;
        }

        .custome-radio .form-check-label {
            font-size: 15px;
            color: #333;
        }

        /* Coupon Section */
        .coupon-input-wrapper {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 8px;
            padding: 10px 15px;
        }

        .coupon-icon {
            margin-right: 15px;
        }

        .coupon-input {
            border: none;
            flex: 1;
            font-size: 14px;
        }

        .coupon-input:focus {
            box-shadow: none;
            outline: none;
        }

        .btn-coupon {
            background: #006d77;
            color: #fff;
            padding: 10px 25px;
            font-weight: 600;
            border: none;
            border-radius: 4px;
            white-space: nowrap;
        }

        .btn-coupon:hover {
            background: #005a63;
            color: #fff;
        }

        .btn-coupon.btn-success {
            background: #3BB77E;
        }

        /* Choose Payment Mode Section */
        .payment-mode-title {
            font-size: 24px;
            font-weight: 600;
            color: #333;
        }

        .payment-option-card {
            background: #fff;
            border: 2px solid #e8e8e8;
            border-radius: 8px;
            padding: 25px 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            min-height: 180px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .payment-option-card:hover {
            border-color: #4CAF50;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .payment-option-card.selected {
            border-color: #4CAF50;
            background: #f8fff8;
        }

        .payment-icon {
            margin-bottom: 15px;
        }

        .payment-label {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .payment-sublabel {
            font-size: 12px;
            color: #666;
            margin-bottom: 10px;
        }

        .payment-radio input[type="radio"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        /* COD Banner */
        .cod-banner {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: #fff;
            padding: 15px 30px;
            border-radius: 8px;
            text-align: center;
            font-size: 16px;
            font-weight: 600;
            margin-top: 25px;
        }

        /* Confirm Order Button */
        .btn-confirm-order {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: #fff;
            padding: 12px 40px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-confirm-order:hover {
            background: linear-gradient(135deg, #45a049 0%, #3d8b3d 100%);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
        }

        /* Order ID Text */
        .order-id-text {
            font-size: 18px;
            font-weight: 600;
            color: #4CAF50;
            margin: 15px 0;
        }

        .order-id-text span {
            color: #333;
        }

        /* Back to Home Button */
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
            transform: translateY(-2px);
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
        let currentCodCharge = 0;
        const COD_CHARGE_AMOUNT = 50;
        const COD_CHARGE_THRESHOLD = 600;
        let selectedPaymentMethod = null;

        // Billing data from session
        const billingData = @json($billingData);

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });

        $(document).ready(function () {
            updateTotalsDisplay();
        });

        // Select payment method
        function selectPaymentMethod(method) {
            selectedPaymentMethod = method;

            // Remove selected class from all cards
            $('.payment-option-card').removeClass('selected');

            // Add selected class to clicked card
            if (method === 'online_gateway') {
                $('#online_payment_card').addClass('selected');
                $('#online_gateway').prop('checked', true);

                // Reset COD charge
                currentCodCharge = 0;
                $('#cod_charge_row').hide();
                updateTotalsDisplay();

                $('#cod_confirmation_section').hide();
                $('#online_payment_section').show();
            } else if (method === 'cash_on_delivery') {
                $('#cod_payment_card').addClass('selected');
                $('#cash_on_delivery').prop('checked', true);

                // Calculate COD charge if price < 600
                let priceToCheck = cartSubtotal - currentCouponDiscount;
                let displayAmount = cartSubtotal - currentCouponDiscount + currentShipping;

                if (priceToCheck < 600) {
                    currentCodCharge = 50;
                    displayAmount += 50;

                } else {
                    currentCodCharge = 0;
                }

                if (currentCodCharge > 0) {
                    $('#cod_charge_display').text('₹' + currentCodCharge.toFixed(2));
                    $('#cod_charge_row').show();
                } else {
                    $('#cod_charge_row').hide();
                }

                // Update Banner Text
                $('.cod-banner span').text('Cash On Delivery: Pay ₹' + displayAmount.toFixed(2));

                updateTotalsDisplay();

                $('#online_payment_section').hide();
                $('#cod_confirmation_section').show();
            }
        }

        // Confirm COD Order
        function confirmOrder() {
            if (selectedPaymentMethod !== 'cash_on_delivery') {
                toastr.warning('Please select a payment method', 'Warning');
                return;
            }

            let orderData = buildOrderData('cash_on_delivery');
            placeCODOrder(orderData);
        }

        // Process Online Payment
        function processOnlinePayment() {
            if (selectedPaymentMethod !== 'online_gateway') {
                toastr.warning('Please select a payment method', 'Warning');
                return;
            }

            let orderData = buildOrderData('online_gateway');
            processRazorpayPayment(orderData);
        }

        // Build order data object
        function buildOrderData(paymentOption) {
            // Split billing_name into fname and lname for Razorpay API
            const nameParts = (billingData.billing_name || '').trim().split(' ');
            const fname = nameParts[0] || '';
            const lname = nameParts.slice(1).join(' ') || fname; // Use fname if no lname

            return {
                _token: csrfToken,
                fname: fname,
                lname: lname,
                billing_name: billingData.billing_name,
                email: billingData.email,
                phone: billingData.phone,
                billing_address: billingData.billing_address,
                city: billingData.city,
                state: billingData.state,
                zipcode: billingData.zipcode,
                billing_landmark: billingData.billing_landmark,
                shipping_name: billingData.shipping_name,
                shipping_address: billingData.shipping_address,
                shipping_city: billingData.shipping_city,
                shipping_state: billingData.shipping_state,
                shipping_pincode: billingData.shipping_pincode,
                shipping_phone: billingData.shipping_phone,
                shipping_landmark: billingData.shipping_landmark,
                payment_option: paymentOption,
                same_as_billing: 0,
                coupon_code: appliedCouponCode || '',
                coupon_discount: currentCouponDiscount,
                cod_charge: currentCodCharge
            };
        }

        function updateTotalsDisplay() {
            const total = cartSubtotal - currentCouponDiscount + currentShipping + currentCodCharge;
            $('#total_display').text('₹' + total.toFixed(2));
        }

        function removeCoupon() {
            currentCouponDiscount = 0;
            appliedCouponCode = null;
            $('#coupon_discount_row').hide();
            updateTotalsDisplay();
            toastr.info('Coupon removed', 'Info');
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
                    if (response.success) {
                        toastr.success('Payment successful!', 'Success');
                        showOrderSuccessModal(response.order_id);
                    }
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
                    if (response.success) {
                        showOrderSuccessModal(response.order_id);
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function (xhr) { toastr.error(xhr.responseJSON?.message || 'Failed to place order', 'Error'); }
            });
        }

        function showOrderSuccessModal(orderId) {
            // Display the order ID
            $('#order_id_display').text('#' + (orderId || 'CA000000'));

            // Calculate Estimated Delivery (Today + 5 days)
            const today = new Date();
            const deliveryDate = new Date(today);
            deliveryDate.setDate(today.getDate() + 5);

            // Format: DD MMM YYYY (e.g., 29 Jan 2026)
            const options = { day: 'numeric', month: 'short', year: 'numeric' };
            const formattedDate = deliveryDate.toLocaleDateString('en-GB', options);

            $('#estimated_delivery_display').text(formattedDate);

            $('#orderSuccessModal').fadeIn(300);
        }

        function goToHome() {
            window.location.href = '{{ route("index") }}';
        }
    </script>
@endpush