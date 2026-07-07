@extends('layouts.app')
@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> <a href="{{ route('checkout') }}">Checkout</a>
                    <span></span> <a href="{{ route('checkout.billing-information') }}">Billing Information</a>
                    <span></span> <span class="text-success">Payment Mode</span>
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="heading-2 mb-30">Order Summary</h1>
                    c
                    {{-- Order Items --}}
                    <div class="order-items-section mb-30">
                        @forelse($cartItems as $item)
                            @if($item->product)
                                <div class="order-item d-flex justify-content-between align-items-center py-15 border-bottom">
                                    <div class="item-name">
                                        <h6 class="mb-0">{{ $item->product->productname ?? 'Product Unavailable' }}</h6>
                                    </div>
                                    <div class="item-qty text-muted">
                                        x {{ $item->quantity }}
                                    </div>
                                    <div class="item-price">
                                        <strong>₹{{ number_format($item->price_at_add_time * $item->quantity, 0) }}</strong>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-muted">No items in cart</p>
                        @endforelse
                    </div>

                    {{-- Order Totals --}}
                    <div class="order-totals-section mb-30">
                        <table class="table order-totals-table">
                            <tbody>
                                <tr>
                                    <td class="text-muted">Subtotal</td>
                                    <td class="text-end text-brand" id="subtotal_display">₹{{ number_format($subtotal, 0) }}</td>
                                </tr>
                                <tr id="coupon_discount_row" style="{{ ($sessionCouponDiscount > 0) ? '' : 'display: none;' }}">
                                    <td class="text-muted">
                                        Coupon Discount 
                                        <a href="javascript:void(0)" onclick="removeCoupon()" class="text-danger" style="font-size: 12px;">(Remove)</a>
                                    </td>
                                    <td class="text-end text-success" id="coupon_discount_display">
                                        -₹{{ number_format($sessionCouponDiscount, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Shipping</td>
                                    <td class="text-end text-brand" id="shipping_display">₹{{ number_format($shipping, 2) }}</td>
                                </tr>
                                <tr id="cod_charge_row" style="display: none;">
                                    <td class="text-muted">COD Charge</td>
                                    <td class="text-end text-warning" id="cod_charge_display">₹50.00</td>
                                </tr>
                                <tr class="total-row">
                                    <td><strong>Total</strong></td>
                                    <td class="text-end">
                                        <span class="total-amount" id="total_display">₹{{ number_format($total - $sessionCouponDiscount, 2) }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Payment Method Section --}}
                    <div class="payment-method-section mb-30">
                        <h4 class="mb-20">Payment Method</h4>
                        <div class="payment-options-box">
                            <div class="custome-radio mb-15">
                                <input class="form-check-input" required type="radio" name="payment_option"
                                    id="cash_on_delivery" value="cash_on_delivery" onchange="handlePaymentOptionChange()">
                                <label class="form-check-label" for="cash_on_delivery">Cash on delivery</label>
                            </div>
                            <div class="custome-radio">
                                <input class="form-check-input" required type="radio" name="payment_option"
                                    id="online_gateway" value="online_gateway" onchange="handlePaymentOptionChange()">
                                <label class="form-check-label" for="online_gateway">Online Payment</label>
                            </div>
                        </div>
                    </div>

                    {{-- Coupon Section --}}
                    <div class="coupon-section mb-30">
                        <div class="coupon-input-wrapper d-flex align-items-center">
                            <div class="coupon-icon">
                                <i class="fi-rs-ticket" style="font-size: 20px; color: #666;"></i>
                            </div>
                            <input type="text" id="coupon_code" name="coupon_code" 
                                placeholder="Enter Coupon Code..." 
                                class="form-control coupon-input"
                                value="{{ $sessionCouponCode ?? '' }}"
                                {{ $sessionCouponCode ? 'readonly' : '' }}>
                            <button type="button" class="btn btn-coupon {{ $sessionCouponCode ? 'btn-success' : '' }}" 
                                id="apply_coupon_btn" onclick="applyCoupon()"
                                {{ $sessionCouponCode ? 'disabled' : '' }}>
                                {{ $sessionCouponCode ? 'Applied' : 'Apply Coupon' }}
                            </button>
                        </div>
                        <div id="coupon_message" class="mt-10"></div>
                    </div>

                    {{-- Place Order Button --}}
                    <div class="place-order-section text-center">
                        <button type="button" class="btn btn-place-order" onclick="placeOrder()">PLACE ORDER</button>
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
        .order-items-section {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 8px;
            padding: 20px;
        }

        .order-item {
            padding: 15px 0;
        }

        .order-item .item-name h6 {
            font-weight: 500;
        }

        .order-totals-table {
            border: 1px solid #e8e8e8;
            border-radius: 8px;
        }

        .order-totals-table td {
            padding: 12px 20px;
            border: none;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-totals-table .total-row td {
            border-bottom: none;
        }

        .total-amount {
            font-size: 24px;
            font-weight: 700;
            color: #3BB77E;
        }

        .text-brand {
            color: #3BB77E !important;
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

        /* Place Order Button */
        .btn-place-order {
            background: #006400;
            color: #fff;
            padding: 15px 60px;
            font-size: 18px;
            font-weight: 600;
            border: none;
            border-radius: 4px;
        }

        .btn-place-order:hover {
            background: #005000;
            color: #fff;
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

        // Billing data from session
        const billingData = @json($billingData);

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });

        $(document).ready(function () {
            updateTotalsDisplay();
        });

        function handlePaymentOptionChange() {
            calculateCodCharge();
            updateTotalsDisplay();
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

        function updateTotalsDisplay() {
            const total = cartSubtotal - currentCouponDiscount + currentShipping + currentCodCharge;
            $('#total_display').text('₹' + total.toFixed(2));
        }

        function applyCoupon() {
            const couponCode = $('#coupon_code').val().trim();
            if (!couponCode) {
                $('#coupon_message').html('<span class="text-danger">Please enter a coupon code</span>');
                return;
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
            const payment_option = $('input[name="payment_option"]:checked').val();

            if (!payment_option) {
                toastr.warning('Please select a payment method', 'Warning');
                return;
            }

            let orderData = {
                _token: csrfToken,
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
                payment_option: payment_option,
                same_as_billing: 0,
                coupon_code: appliedCouponCode || '',
                coupon_discount: currentCouponDiscount,
                cod_charge: currentCodCharge
            };

            if (payment_option === 'online_gateway') {
                processRazorpayPayment(orderData);
            } else {
                placeCODOrder(orderData);
            }
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
    </script>
@endpush
