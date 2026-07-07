@extends('layouts.app')
@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> <a href="{{ route('checkout') }}">Checkout</a>
                    <span></span>Billing Information
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h1 class="heading-2 mb-30">Billing Information</h1>

                    <form method="post" id="checkout_form">
                        @csrf
                        <div class="row">
                            {{-- Billing Details Column --}}
                            <div class="col-lg-6">
                                <h5 class="section-subtitle text-success mb-20"><em>Billing Details</em></h5>

                                <div class="form-group mb-15">
                                    <label>Name: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required name="billing_name" id="billing_name"
                                        placeholder="Enter your name" value="{{ $customer->username ?? '' }}">
                                </div>

                                <div class="form-group mb-15">
                                    <label>Mobile Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required name="phone" id="billing_phone"
                                        placeholder="Enter your phone number" value="{{ $customer->mobilenumber ?? '' }}"
                                        maxlength="10" oninput="validateMobileNumber(this, 'billing_phone_error')">
                                    <span id="billing_phone_error" class="text-danger"
                                        style="font-size: 12px; display: none;">Please enter exactly 10 digits (numbers
                                        only)</span>
                                </div>

                                <div class="form-group mb-15">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" required name="billing_address" id="billing_address"
                                        rows="2" placeholder="Enter your address">{{ $customer->address ?? '' }}</textarea>
                                </div>

                                <div class="form-group mb-15">
                                    <label>City: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required name="city" id="billing_city"
                                        placeholder="Town / City" value="{{ $customer->city ?? '' }}">
                                </div>

                                <div class="form-group mb-15">
                                    <label>State <span class="text-danger">*</span></label>
                                    <select name="state" id="billing_state" class="form-control" required
                                        onchange="clearStateError(); calculateShippingOnBillingChange();">
                                        <option value="">State</option>
                                        <option value="Andhra Pradesh" {{ ($customer->state ?? '') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                                        <option value="Delhi" {{ ($customer->state ?? '') == 'Delhi' ? 'selected' : '' }}>
                                            Delhi</option>
                                        <option value="Karnataka" {{ ($customer->state ?? '') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                        <option value="Kerala" {{ ($customer->state ?? '') == 'Kerala' ? 'selected' : '' }}>
                                            Kerala</option>
                                        <option value="Maharashtra" {{ ($customer->state ?? '') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                        <option value="Tamil Nadu" {{ ($customer->state ?? '') == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                        <option value="Telangana" {{ ($customer->state ?? '') == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                        <option value="Uttar Pradesh" {{ ($customer->state ?? '') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                    </select>
                                    <span id="billing_state_error" class="text-danger"
                                        style="font-size: 12px; display: none;">Please select your state</span>
                                </div>

                                <div class="form-group mb-15">
                                    <label>Postcode / Zip <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required name="zipcode" id="billing_zipcode"
                                        placeholder="Postcode / Zip" value="{{ $customer->pin ?? '' }}" maxlength="6"
                                        oninput="validatePostcode(this, 'billing_zipcode_error')">
                                    <span id="billing_zipcode_error" class="text-danger"
                                        style="font-size: 12px; display: none;">Please enter exactly 6 digits (numbers
                                        only)</span>
                                </div>

                                <div class="form-group mb-15">
                                    <label>LandMark <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required name="billing_landmark"
                                        id="billing_landmark" placeholder="Enter your LandMark">
                                </div>

                                {{-- Hidden email field --}}
                                <input type="hidden" name="email" id="billing_email"
                                    value="{{ $guestEmail ?? ($customer->email ?? '') }}">
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
                                    <input type="text" class="form-control" name="shipping_phone" id="shipping_phone"
                                        placeholder="Enter your phone number" maxlength="10"
                                        oninput="validateMobileNumber(this, 'shipping_phone_error')">
                                    <span id="shipping_phone_error" class="text-danger"
                                        style="font-size: 12px; display: none;">Please enter exactly 10 digits (numbers
                                        only)</span>
                                </div>

                                <div class="form-group mb-15">
                                    <label>Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="shipping_address" id="shipping_address" rows="2"
                                        placeholder="Enter your address"></textarea>
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
                                    <input type="text" class="form-control" name="shipping_pincode" id="shipping_pincode"
                                        placeholder="Postcode / Zip" maxlength="6"
                                        oninput="validatePostcode(this, 'shipping_pincode_error')">
                                    <span id="shipping_pincode_error" class="text-danger"
                                        style="font-size: 12px; display: none;">Please enter exactly 6 digits (numbers
                                        only)</span>
                                </div>

                                <div class="form-group mb-15">
                                    <label>Landmark <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="shipping_landmark" id="shipping_landmark"
                                        placeholder="Enter your landmark">
                                </div>
                            </div>
                        </div>

                        {{-- Same Address Checkbox and Place Order Button --}}
                        <div class="row mt-20 mb-30">
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
                                <button type="button" class="btn btn-place-order-top" onclick="continueToPayment()">PLACE
                                    ORDER</button>
                            </div>
                        </div>
                    </form>

                    {{-- Order of the Address Section (Image 1 Layout) --}}

                </div>
            </div>
        </div>
    </main>

    <style>
        /* Billing Form Styles */
        .section-subtitle {
            font-size: 15px;
            font-weight: 500;
        }

        .form-group label {
            font-weight: 500;
            color: #333;
            font-size: 14px;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px 15px;
            font-size: 14px;
            color: #666;
        }

        .form-control:focus {
            border-color: #3BB77E;
            box-shadow: 0 0 0 2px rgba(59, 183, 126, 0.1);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.1);
        }

        textarea.form-control {
            min-height: 60px;
            resize: vertical;
        }

        select.form-control {
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

        .text-success {
            color: #3BB77E !important;
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
            min-height: 80px;
        }

        .address-box-body p {
            margin-bottom: 5px;
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

        /* Continue Button */
        .btn-continue {
            background-color: #ff8c00;
            color: #fff;
            padding: 12px 40px;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-continue:hover {
            background-color: #e67e00;
            color: #fff;
        }

        /* Place Order Button (Top) */
        .btn-place-order-top {
            background-color: #ff8c00;
            color: #fff;
            padding: 10px 30px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-transform: uppercase;
        }

        .btn-place-order-top:hover {
            background-color: #e67e00;
            color: #fff;
        }
    </style>
@endsection

@push('scripts')
    <script>
        const csrfToken = '{{ csrf_token() }}';
        const cartSubtotal = {{ $subtotal }};
        let currentShipping = {{ $shipping }};

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': csrfToken } });

        $(document).ready(function () {
            const billingState = $('#billing_state').val();
            if (billingState) calculateShipping();

            // Update address previews on input change
            $('#billing_name, #billing_address, #billing_city, #billing_state, #billing_zipcode, #billing_landmark').on('input change', updateBillingPreview);
            $('#shipping_name, #shipping_address, #shipping_city, #shipping_state, #shipping_pincode, #shipping_landmark').on('input change', updateShippingPreview);
        });

        // Update billing address preview
        function updateBillingPreview() {
            const address = $('#billing_address').val();
            const city = $('#billing_city').val();
            const state = $('#billing_state').val();
            const zipcode = $('#billing_zipcode').val();

            if (address || city || state || zipcode) {
                let previewHtml = '';
                if (address) previewHtml += '<p>' + address + '</p>';
                if (city || state || zipcode) {
                    previewHtml += '<p>' + [city, state, zipcode].filter(Boolean).join(', ') + '</p>';
                }
                $('#billing_address_preview').html(previewHtml);
            } else {
                $('#billing_address_preview').html('<p class="text-muted">Fill in billing details above</p>');
            }
        }

        // Update shipping address preview
        function updateShippingPreview() {
            const address = $('#shipping_address').val();
            const city = $('#shipping_city').val();
            const state = $('#shipping_state').val();
            const pincode = $('#shipping_pincode').val();
            const landmark = $('#shipping_landmark').val();

            if (address || city || state || pincode) {
                let previewHtml = '';
                if (address) previewHtml += '<p>' + address + '</p>';
                if (city || state || pincode) {
                    previewHtml += '<p>' + [city, state].filter(Boolean).join(', ') + (pincode ? ' - ' + pincode : '') + '</p>';
                }
                if (landmark) previewHtml += '<p>Landmark : ' + landmark + '</p>';
                $('#shipping_address_preview').html(previewHtml);
            } else {
                $('#shipping_address_preview').html('<p class="text-muted">Fill in delivery details above</p>');
            }
        }

        // Copy billing details to shipping fields when checkbox is checked
        function copyBillingToShipping() {
            const sameAsBilling = $('#same_as_billing').is(':checked');
            if (sameAsBilling) {
                $('#shipping_name').val($('#billing_name').val());
                $('#shipping_phone').val($('#billing_phone').val());
                $('#shipping_address').val($('#billing_address').val());
                $('#shipping_city').val($('#billing_city').val());
                $('#shipping_state').val($('#billing_state').val());
                $('#shipping_pincode').val($('#billing_zipcode').val());
                $('#shipping_landmark').val($('#billing_landmark').val());

                const billingState = $('#billing_state').val();
                if (billingState) {
                    calculateShippingWithState(billingState);
                }
                updateShippingPreview();
                toastr.success('Shipping address copied from billing address', 'Success');
            } else {
                $('#shipping_name, #shipping_phone, #shipping_address, #shipping_city, #shipping_pincode, #shipping_landmark').val('');
                $('#shipping_state').val('');
                updateShippingPreview();
            }
        }

        function calculateShipping() {
            const sameAsBilling = $('#same_as_billing').is(':checked');
            let state = sameAsBilling ? $('#billing_state').val() : $('#shipping_state').val();
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

        function calculateShippingWithState(state) {
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

        function calculateShippingOnBillingChange() {
            const sameAsBilling = $('#same_as_billing').is(':checked');
            const billingState = $('#billing_state').val();
            if (sameAsBilling && billingState) calculateShippingWithState(billingState);
            updateBillingPreview();
        }

        function clearStateError() {
            if ($('#billing_state').val()) $('#billing_state_error').hide();
        }

        // Validate mobile number - only 10 digits allowed
        function validateMobileNumber(input, errorId) {
            // Remove any non-numeric characters
            let value = input.value.replace(/[^0-9]/g, '');
            input.value = value;

            // Show/hide error based on validation
            const errorSpan = $('#' + errorId);
            if (value.length > 0 && (value.length !== 10 || /[^0-9]/.test(input.value))) {
                errorSpan.show();
                input.classList.add('is-invalid');
            } else if (value.length === 10) {
                errorSpan.hide();
                input.classList.remove('is-invalid');
            } else if (value.length === 0) {
                errorSpan.hide();
                input.classList.remove('is-invalid');
            } else {
                errorSpan.show();
                input.classList.add('is-invalid');
            }
        }

        // Validate postcode - only 6 digits allowed
        function validatePostcode(input, errorId) {
            // Remove any non-numeric characters
            let value = input.value.replace(/[^0-9]/g, '');
            input.value = value;

            // Show/hide error based on validation
            const errorSpan = $('#' + errorId);
            if (value.length > 0 && (value.length !== 6 || /[^0-9]/.test(input.value))) {
                errorSpan.show();
                input.classList.add('is-invalid');
            } else if (value.length === 6) {
                errorSpan.hide();
                input.classList.remove('is-invalid');
            } else if (value.length === 0) {
                errorSpan.hide();
                input.classList.remove('is-invalid');
            } else {
                errorSpan.show();
                input.classList.add('is-invalid');
            }
        }

        function updateTotalsDisplay() {
            const total = cartSubtotal + currentShipping;
            if (currentShipping == 0) {
                $('#shipping_display').html('<span class="text-success">Free</span>');
            } else {
                $('#shipping_display').text('₹' + currentShipping.toFixed(2));
            }
            $('#total_display').text('₹' + total.toFixed(2));
        }

        // Continue to Payment Mode page
        function continueToPayment() {
            const billing_name = $('#billing_name').val();
            const email = $('#billing_email').val();
            const phone = $('#billing_phone').val();
            const billing_address = $('#billing_address').val();
            const city = $('#billing_city').val();
            const state = $('#billing_state').val();
            const zipcode = $('#billing_zipcode').val();
            const billing_landmark = $('#billing_landmark').val();

            // Validate billing fields
            if (!state) $('#billing_state_error').show();
            if (!billing_name || !email || !phone || !billing_address || !city || !state || !zipcode || !billing_landmark) {
                toastr.warning('Please fill all required billing fields', 'Warning');
                return;
            }

            // Validate billing phone (10 digits only)
            const phoneRegex = /^[0-9]{10}$/;
            if (!phoneRegex.test(phone)) {
                $('#billing_phone_error').show();
                toastr.error('Billing mobile number must be exactly 10 digits (numbers only)', 'Error');
                return;
            }

            // Validate billing postcode (6 digits only)
            const postcodeRegex = /^[0-9]{6}$/;
            if (!postcodeRegex.test(zipcode)) {
                $('#billing_zipcode_error').show();
                toastr.error('Billing postcode must be exactly 6 digits (numbers only)', 'Error');
                return;
            }

            // Validate shipping fields
            const shipping_name = $('#shipping_name').val();
            const shipping_address = $('#shipping_address').val();
            const shipping_city = $('#shipping_city').val();
            const shipping_state = $('#shipping_state').val();
            const shipping_pincode = $('#shipping_pincode').val();
            const shipping_phone = $('#shipping_phone').val();

            if (!shipping_name || !shipping_address || !shipping_city || !shipping_state || !shipping_pincode || !shipping_phone) {
                toastr.warning('Please fill all required shipping/delivery fields', 'Warning');
                return;
            }

            // Validate shipping phone (10 digits only)
            if (!phoneRegex.test(shipping_phone)) {
                $('#shipping_phone_error').show();
                toastr.error('Shipping mobile number must be exactly 10 digits (numbers only)', 'Error');
                return;
            }

            // Validate shipping postcode (6 digits only)
            if (!postcodeRegex.test(shipping_pincode)) {
                $('#shipping_pincode_error').show();
                toastr.error('Shipping postcode must be exactly 6 digits (numbers only)', 'Error');
                return;
            }

            // Store data in session and redirect to payment page
            const formData = {
                _token: csrfToken,
                billing_name: billing_name,
                email: email,
                phone: phone,
                billing_address: billing_address,
                city: city,
                state: state,
                zipcode: zipcode,
                billing_landmark: billing_landmark,
                shipping_name: shipping_name,
                shipping_address: shipping_address,
                shipping_city: shipping_city,
                shipping_state: shipping_state,
                shipping_pincode: shipping_pincode,
                shipping_phone: shipping_phone,
                shipping_landmark: $('#shipping_landmark').val()
            };

            $.ajax({
                url: '{{ route("checkout.save-billing") }}',
                type: 'POST',
                data: formData,
                success: function (response) {
                    if (response.success) {
                        window.location.href = response.redirect_url;
                    } else {
                        toastr.error(response.message || 'Failed to save billing information', 'Error');
                    }
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON?.message || 'Failed to continue', 'Error');
                }
            });
        }
    </script>
@endpush