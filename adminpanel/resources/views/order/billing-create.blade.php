@extends('layouts.app')
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Razorpay Checkout Script --}}
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        .pos-wrapper {
            display: flex;
            height: 85vh;
            gap: 10px
        }

        .product-panel {
            width: 50%;
            border-right: 1px solid #ddd;
            overflow: auto;
            padding: 10px
        }

        .cart-panel {
            width: 50%;
            padding: 15px;
            display: flex;
            flex-direction: column;
            height: 85vh;
            overflow: hidden
        }

        .cart-content {
            flex: 1;
            overflow-y: auto;
            min-height: 0
        }

        .cart-footer {
            flex-shrink: 0;
            background: #fff;
            padding-top: 10px;
            border-top: 1px solid #eee
        }

        .product-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-bottom: 1px solid #eee;
            background: #fff
        }

        .product-row:hover {
            background: #f9f9f9
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ddd
        }

        .product-info {
            flex: 1
        }

        .product-info strong {
            display: block;
            font-size: 14px;
            color: #333
        }

        .product-info small {
            color: #777;
            font-size: 12px
        }

        .product-price {
            font-weight: bold;
            color: #28a745;
            margin-right: 10px;
            font-size: 16px;
            width: 75px;
            text-align: right;
            display: inline-block;
        }

        .btn-add {
            background: #28a745;
            color: #fff;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: bold;
            padding: 0
        }

        .btn-add:hover {
            background: #218838;
            transform: scale(1.1)
        }

        .btn-add:disabled {
            background: #28a745;
            cursor: not-allowed;
            opacity: 0.5;
            pointer-events: none;
        }

        .btn-add:disabled:hover {
            transform: none;
        }

        .btn-variant {
            background: #28a745;
            color: #fff;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            padding: 0
        }

        .btn-variant:hover {
            background: #218838;
            transform: scale(1.1)
        }

        .btn-variant:disabled {
            background: #28a745;
                cursor: not-allowed;
                opacity: 0.5;
                pointer-events: none;
            }

            .btn-variant:disabled:hover {
                transform: none;
            }

            .cart-table {
                width: 100%;
                margin-bottom: 0
            }

            .cart-table th,
            .cart-table td {
                padding: 8px;
                border-bottom: 1px solid #eee;
                text-align: left
            }

            .cart-table th {
                background: #f5f5f5;
                font-size: 12px;
                font-weight: 600
            }

            .total-box {
                border-top: 2px solid #333;
                padding-top: 10px;
                margin-bottom: 15px
            }

            .customer-section {
                margin-bottom: 15px;
                padding: 10px;
                background: #f9f9f9;
                border-radius: 4px
            }

            .customer-label {
                font-weight: 600;
                margin-bottom: 8px;
                display: block
            }

            .customer-select {
                width: 100%;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px
            }

            .actions {
                display: flex;
                gap: 10px;
                margin-top: auto
            }

            .btn-checkout {
                flex: 1;
                background: #28a745;
                color: #fff;
                border: none;
                height: 40px;
                border-radius: 6px;
                font-weight: 600;
                cursor: pointer
            }

            .btn-cancel {
                flex: 1;
                background: #dc3545;
                color: #fff;
                border: none;
                height: 40px;
                border-radius: 6px;
                font-weight: 600;
                cursor: pointer
            }

            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1000;
                overflow-y: auto;
            }

            body:has(.modal.show) {
                overflow: hidden;
            }

            .modal.show {
                display: flex;
                align-items: flex-start; /* flex-start prevents top cut-off when scrolling tall flex containers */
                justify-content: center;
                padding-top: 5vh;
                padding-bottom: 5vh;
            }

            .modal-content {
                background: #fff;
                padding: 20px;
                border-radius: 8px;
                width: 90%;
                max-width: 500px
            }

            .modal-header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 15px
            }

            .modal-body .form-group {
                margin-bottom: 12px
            }

            .modal-body label {
                display: block;
                margin-bottom: 4px;
                font-weight: 600;
                font-size: 13px
            }

            .modal-body input,
            .modal-body textarea {
                width: 100%;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px
            }

            .modal-footer {
                margin-top: 15px;
                display: flex;
                gap: 10px;
                justify-content: flex-end
            }

            .btn-secondary {
                background: #6c757d;
                color: #fff;
                border: none;
                padding: 8px 16px;
                border-radius: 4px;
                cursor: pointer
            }

            .btn-primary {
                background: #007bff;
                color: #fff;
                border: none;
                padding: 8px 16px;
                border-radius: 4px;
                cursor: pointer
            }

            .customer-item:hover {
                background: #f0f8ff
            }
        </style>

        <div class="pos-wrapper">

            {{-- LEFT PRODUCTS --}}
            <div class="product-panel">
                <h4 style="margin-bottom:15px">Products</h4>

                {{-- Search Input --}}
                <div style="margin-bottom:15px">
                    <input type="text" id="productSearch" placeholder="Search products..."
                        style="width:100%;padding:10px;border:1px solid #ddd;border-radius:4px;font-size:14px">
                </div>

                <div id="noProductsMessage" style="display:none;padding:30px;text-align:center;color:#999">No products found
                </div>

                @foreach($products as $product)
                    <div class="product-row" data-product-id="{{ $product->id }}" data-product-name="{{ strtolower($product->productname) }}">
                        {{-- Product Image --}}
                        @if($product->first_image)
                            <img src="{{ asset($product->first_image) }}" class="product-img" alt="{{ $product->productname }}">
                        @else
                            <img src="{{ asset('images/no-image.png') }}" class="product-img" alt="No Image">
                        @endif

                        {{-- Product Info --}}
                        <div class="product-info">
                            <strong>{{ $product->productname }}</strong>
                            @if($product->variants->count() == 1)
                                @php $singleVariant = $product->variants->first(); @endphp
                                @if($singleVariant && $singleVariant->quantity)
                                    <small>{{ $singleVariant->quantity->name ?? $singleVariant->quantity->label }} (<span id="stock-display-{{ $singleVariant->id }}"
                                            class="stock-display">Stock: {{ $singleVariant->stock }}</span>)</small>
                                @endif
                            @else
                                <small>Stock: {{ $product->variants->sum('stock') }}</small>
                            @endif
                        </div>

                        {{-- Price --}}
                        @if($product->variants->count() > 0)
                            <span class="product-price">₹{{ number_format($product->variants->first()->sell_price, 2) }}</span>
                        @endif

                        {{-- Action Button --}}
                        @if($product->variants->count() > 1)
                            {{-- Multiple Variants - Show > --}}
                            <button class="btn-variant" onclick="toggleVariants({{ $product->id }})">
                                ›
                            </button>
                        @elseif($product->variants->count() == 1)
                            {{-- Single Variant - Show + --}}
                            @php $variant = $product->variants->first(); @endphp
                            <button class="btn-add" id="btn-add-{{ $variant->id }}" data-variant-id="{{ $variant->id }}"
                                data-initial-stock="{{ $variant->stock }}" onclick="addToCart(
                                                                                        {{ $product->id }},
                                                                                        {{ $variant->id }},
                                                                                        '{{ $product->productname }}',
                                                                                        '{{ $variant->quantity ? ($variant->quantity->name ?? $variant->quantity->label) : '' }}',
                                                                                        {{ $variant->sell_price }},
                                                                                        {{ $product->gst ?? 0 }},
                                                                                        {{ $product->sgst ?? 0 }},
                                                                                        {{ $product->igst ?? 0 }},
                                                                                        {{ $variant->stock }}
                                                                                    )" {{ $variant->stock <= 0 ? 'disabled' : '' }}>
                                +
                            </button>
                        @endif
                    </div>

                    {{-- Variants (Hidden by default) --}}
                    @if($product->variants->count() > 1)
                        <div id="variants-{{ $product->id }}" style="display:none;padding-left:60px;background:#f5f5f5">
                            @foreach($product->variants as $variant)
                                <div style="display:flex; align-items:center; padding:10px; border-bottom:1px solid #ddd;">
                                    <div style="flex:1;">
                                        @if($variant->quantity)
                                            <strong style="font-size:13px">{{ $variant->quantity->name ?? $variant->quantity->label }}</strong>
                                            <small style="color:#777"> (<span id="stock-display-{{ $variant->id }}" class="stock-display">Stock:
                                                    {{ $variant->stock }}</span>)</small>
                                        @endif
                                    </div>
                                    
                                    <span class="product-price" style="margin-right:10px;">&#8377;{{ number_format($variant->sell_price, 2) }}</span>
                                    
                                    <button class="btn-add" id="btn-add-{{ $variant->id }}" data-variant-id="{{ $variant->id }}"
                                        data-initial-stock="{{ $variant->stock }}" onclick="addToCart(
                                                                                                                {{ $product->id }},
                                                                                                                {{ $variant->id }},
                                                                                                                '{{ $product->productname }}',
                                                                                                                '{{ $variant->quantity ? ($variant->quantity->name ?? $variant->quantity->label) : '' }}',
                                                                                                                {{ $variant->sell_price }},
                                                                                                                {{ $product->gst ?? 0 }},
                                                                                                                {{ $product->sgst ?? 0 }},
                                                                                                                {{ $product->igst ?? 0 }},
                                                                                                                {{ $variant->stock }}
                                                                                                            )" {{ $variant->stock <= 0 ? 'disabled' : '' }}>
                                        +
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- RIGHT CART --}}
            <div class="cart-panel">
                <h4 style="margin-bottom:15px;flex-shrink:0">Billing Cart</h4>

                {{-- Scrollable Cart Content --}}
                <div class="cart-content">
                    {{-- Customer Type Selection --}}
                    <div class="customer-section">
                        <label class="customer-label">Customer Type</label>
                        <select class="customer-select" id="customerType" onchange="handleCustomerType()">
                            <option value="" disabled selected>Select Customer Type</option>
                            <option value="guest">Guest</option>
                            <option value="registered">Registered</option>
                        </select>

                        {{-- Display Selected Customer --}}
                        <div id="selectedCustomerDisplay"
                            style="margin-top:8px;padding:8px;background:#e8f5e9;border-radius:4px;display:none">
                            <small style="color:#2e7d32;font-weight:600"><i class="mdi mdi-account-check"></i> <span
                                    id="selectedCustomerName"></span></small>

                            <div style="margin-top:10px;padding-top:10px;border-top:1px solid #c8e6c9">
                                <div style="text-align: left !important; display: block !important; overflow: hidden;">
                                    <input type="checkbox" id="regShipSameAddress" checked
                                        onchange="toggleRegisteredShippingOption()" style="float:left; margin:3px 8px 0 0; width:auto !important; height:auto !important;">
                                    <label for="regShipSameAddress" style="cursor:pointer;font-weight:normal;float:left;margin:0;white-space:nowrap;">🚚 Ship to Same Address</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Cart Table --}}
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cartBody">
                            <tr>
                                <td colspan="5" align="center" style="padding:30px;color:#999">Cart empty</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Fixed Footer - Totals and Buttons --}}
                <div class="cart-footer">
                    {{-- Totals --}}
                    <div class="total-box">
                        <div style="display:flex; align-items:center; margin-bottom:8px;">
                            <div style="flex:1;">Subtotal:</div>
                            <div style="width:90px; text-align:right;">₹<span id="subtotal">0.00</span></div>
                            <div style="width:32px;"></div>
                        </div>

                        {{-- Add Tax Row --}}
                        <div style="display:flex; align-items:center; margin-bottom:8px;">
                            <div style="flex:1;">Add Tax</div>
                            <div style="width:90px; text-align:right;">₹<span id="taxAmount">0.00</span></div>
                            <div style="width:32px; display:flex; justify-content:flex-end;">
                                <button type="button" onclick="openTaxModal()"
                                    style="background:#28a745;color:#fff;border:none;width:24px;height:24px;border-radius:50%;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;flex-shrink:0;padding:0;margin:0;">
                                    +
                                </button>
                            </div>
                            <input type="hidden" id="tax" value="0">
                        </div>

                        {{-- Add Shipping Row --}}
                        <div style="display:flex; align-items:center; margin-bottom:12px;">
                            <div style="flex:1;">Add Shipping</div>
                            <div style="width:90px; text-align:right;">₹<span id="shippingAmount">0.00</span></div>
                            <div style="width:32px; display:flex; justify-content:flex-end;">
                                <button type="button" onclick="openShippingModal()"
                                    style="background:#28a745;color:#fff;border:none;width:24px;height:24px;border-radius:50%;cursor:pointer;font-size:16px;display:flex;align-items:center;justify-content:center;flex-shrink:0;padding:0;margin:0;">
                                    +
                                </button>
                            </div>
                            <input type="hidden" id="shipping" value="0">
                        </div>

                        <div style="display:flex; align-items:center; font-size:18px; font-weight:bold; border-top:1px solid #ddd; padding-top:8px;">
                            <div style="flex:1;">Total:</div>
                            <div style="width:90px; text-align:right;">₹<span id="grandTotal">0.00</span></div>
                            <div style="width:25px;"></div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="actions">
                        <button class="btn-cancel" onclick="clearCart()"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                        <button class="btn-checkout" onclick="checkout()"><i class="bi bi-cart-check me-1"></i> Checkout</button>
                    </div>
                </div>
            </div>

        </div>

        {{-- Guest Details Modal --}}
        <div class="modal" id="guestModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Guest Details</h5>
                    <button onclick="closeGuestModal()"
                        style="background:none;border:none;font-size:24px;cursor:pointer">&times;</button>
                </div>
                    <div class="modal-body pb-0">
                        <div class="form-group mb-3">
                            <input type="text" id="guestName" class="form-control" placeholder="Name *" required>
                            <small class="text-danger error-text d-none" id="err-guestName">Name is required</small>
                        </div>
                        <div class="form-group mb-3">
                            <input type="tel" id="guestPhone" class="form-control" placeholder="Phone Number *" required 
                                maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                            <small class="text-danger error-text d-none" id="err-guestPhone">Phone number must be 10 digits</small>
                        </div>
                    <div class="form-group">
                        <textarea id="guestAddress" rows="3" placeholder="Address"></textarea>
                    </div>

                    {{-- Ship Same Address Checkbox --}}
                    <div class="form-group" style="margin-top:15px;padding-top:15px;border-top:1px solid #eee; text-align:left !important; display:block !important; overflow:hidden;">
                        <input type="checkbox" id="guestShipSameAddress" checked onchange="toggleGuestShippingFields()"
                            style="float:left; margin:3px 8px 0 0; width:auto !important; height:auto !important;">
                        <label for="guestShipSameAddress" style="cursor:pointer;font-weight:normal;float:left;margin:0;white-space:nowrap;">🚚 Ship to Same Address</label>
                    </div>

                    {{-- Shipping Address Fields (Hidden by default) --}}
                    <div id="guestShippingFields"
                        style="display:none;margin-top:15px;padding:15px;background:#f9f9f9;border-radius:4px">
                        <h6 style="margin-bottom:12px;color:#333">📦 Shipping Address</h6>
                        <div class="form-group">
                            <input type="text" id="guestShipName" placeholder="Shipping Name *">
                        </div>
                        <div class="form-group">
                            <input type="text" id="guestShipPhone" placeholder="Shipping Phone *">
                        </div>
                        <div class="form-group">
                            <textarea id="guestShipAddress" rows="3" placeholder="Shipping Address *"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content: flex-start; gap: 5px;">
                    <button class="btn-secondary" onclick="closeGuestModal()" style="width: 100px; height: 38px; border-radius: 4px !important;"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                    <button class="btn-primary" onclick="saveGuest()" style="width: 100px; height: 38px; border-radius: 4px !important;"><i class="bi bi-save me-1"></i> Save</button>
                </div>
            </div>
        </div>

        {{-- Customer Selection Modal --}}
        <div class="modal" id="customerModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Select Customer</h5>
                    <button onclick="closeCustomerModal()"
                        style="background:none;border:none;font-size:24px;cursor:pointer">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" id="customerSearch" placeholder="Search customers..."
                            style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px">
                    </div>
                    <div id="customerList" style="max-height:300px;overflow-y:auto;border:1px solid #ddd;border-radius:4px">
                        @foreach($customers as $customer)
                            <div class="customer-item" onclick="selectCustomer({{ $customer->id }}, '{{ $customer->username }}')"
                                style="padding:12px;border-bottom:1px solid #eee;cursor:pointer;display:flex;align-items:center;gap:10px"
                                data-name="{{ strtolower($customer->username) }}"
                                data-email="{{ strtolower($customer->email ?? '') }}"
                                data-phone="{{ $customer->mobilenumber ?? '' }}">
                                <i class="mdi mdi-account-circle" style="font-size:24px;color:#007bff"></i>
                                <div>
                                    <strong style="display:block">{{ $customer->username }}</strong>
                                    @if($customer->email)
                                        <small style="color:#777">{{ $customer->email }}</small>
                                    @endif
                                    @if($customer->mobilenumber)
                                        <small style="color:#777"> • {{ $customer->mobilenumber }}</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" onclick="closeCustomerModal()"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                </div>
            </div>
        </div>

        {{-- Tax Calculation Modal --}}
        <div class="modal" id="taxModal">
            <div class="modal-content" style="max-width:650px">
                <div class="modal-header">
                    <h5>Add Tax (GST) - Product Wise</h5>
                    <button onclick="closeTaxModal()"
                        style="background:none;border:none;font-size:24px;cursor:pointer">&times;</button>
                </div>
                <div class="modal-body">
                    {{-- Product Tax Breakdown Table --}}
                    <div style="max-height:250px;overflow-y:auto;margin-bottom:15px">
                        <table style="width:100%;border-collapse:collapse;font-size:13px">
                            <thead>
                                <tr style="background:#f5f5f5">
                                    <th style="padding:8px;text-align:left;border-bottom:1px solid #ddd">Product</th>
                                    <th style="padding:8px;text-align:right;border-bottom:1px solid #ddd">Amount</th>
                                    <th style="padding:8px;text-align:center;border-bottom:1px solid #ddd">GST%</th>
                                    <th style="padding:8px;text-align:center;border-bottom:1px solid #ddd">SGST%</th>
                                    <th style="padding:8px;text-align:center;border-bottom:1px solid #ddd">IGST%</th>
                                    <th style="padding:8px;text-align:right;border-bottom:1px solid #ddd">Tax</th>
                                </tr>
                            </thead>
                            <tbody id="taxProductsBody">
                                <tr>
                                    <td colspan="6" style="padding:20px;text-align:center;color:#999">No products in cart</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Tax Summary --}}
                    <div style="background:#f5f5f5;padding:12px;border-radius:4px">
                        <div style="display:flex;justify-content:space-between;margin-bottom:6px">
                            <span>Subtotal:</span>
                            <span>₹<span id="taxModalSubtotal">0</span></span>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:6px;color:#666">
                            <span>Total GST:</span>
                            <span>₹<span id="gstAmount">0</span></span>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:6px;color:#666">
                            <span>Total SGST:</span>
                            <span>₹<span id="sgstAmount">0</span></span>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:6px;color:#666">
                            <span>Total IGST:</span>
                            <span>₹<span id="igstAmount">0</span></span>
                        </div>
                        <div
                            style="display:flex;justify-content:space-between;font-weight:bold;border-top:1px solid #ddd;padding-top:8px;margin-top:6px">
                            <span>Total Tax:</span>
                            <span style="color:#28a745">₹<span id="totalTaxPreview">0</span></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" onclick="closeTaxModal()"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                    <button class="btn-primary" onclick="applyTax()">Apply Tax</button>
                </div>
            </div>
        </div>

        {{-- Shipping Calculation Modal --}}
        <div class="modal" id="shippingModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Shipping</h5>
                    <button onclick="closeShippingModal()"
                        style="background:none;border:none;font-size:24px;cursor:pointer">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Delivery State *</label>
                        <select id="shippingState" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:4px">
                            <option value="">Select State</option>
                        </select>
                    </div>
                    <div style="background:#f5f5f5;padding:10px;border-radius:4px;margin-top:10px">
                        <div style="display:flex;justify-content:space-between;margin-bottom:5px">
                            <span>Order Total:</span>
                            <span>₹<span id="shippingModalSubtotal">0</span></span>
                        </div>
                        <div id="shippingZoneInfo" style="display:none;margin-bottom:5px;color:#666">
                            <span>Zone: <span id="shippingZoneName">-</span></span>
                        </div>
                        <div
                            style="display:flex;justify-content:space-between;font-weight:bold;border-top:1px solid #ddd;padding-top:5px">
                            <span>Shipping Cost:</span>
                            <span>₹<span id="shippingPreview">0</span></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="justify-content: flex-start; gap: 5px;">
                    <button class="btn-secondary" onclick="closeShippingModal()"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                    <button class="btn-primary" onclick="calculateAndApplyShipping()">Calculate & Apply</button>
                </div>
            </div>
        </div>

        {{-- Shipping Address Modal (for Registered Users with different shipping) --}}
        <div class="modal" id="shippingAddressModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>📦 Shipping Address</h5>
                    <button onclick="closeShippingAddressModal()"
                        style="background:none;border:none;font-size:24px;cursor:pointer">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name *</label>
                        <input type="text" id="regShipName" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="regShipEmail">
                    </div>
                    <div class="form-group">
                        <label>Phone *</label>
                        <input type="text" id="regShipPhone" required>
                    </div>
                    <div class="form-group">
                        <label>Address *</label>
                        <textarea id="regShipAddress" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-secondary" onclick="closeShippingAddressModal()"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                    <button class="btn-primary" onclick="saveRegisteredShippingAddress()"><i class="bi bi-save me-1"></i> Save</button>
                </div>
            </div>
        </div>

        {{-- Checkout Modal --}}
        <div class="modal" id="checkoutModal">
            <div class="modal-content" style="max-width:550px; padding: 0 !important; border: none;">
                <div class="modal-header" style="padding: 8px 10px; border-bottom: 1px solid #ddd;">
                    <h5 style="margin: 0; font-size: 16px;">💳 Checkout</h5>
                    <button onclick="closeCheckoutModal()"
                        style="background:none;border:none;font-size:24px;line-height:1;margin:0;padding:0;cursor:pointer">&times;</button>
                </div>
                <div class="modal-body" style="padding: 5px 10px;">
                    {{-- Customer Info --}}
                    <div style="background:#f5f5f5;padding:5px 8px;border-radius:4px;margin-bottom:8px">
                        <div style="display:flex;justify-content:space-between;margin-bottom:8px">
                            <span>Paying as:</span>
                            <strong id="checkoutCustomerType">Guest</strong>
                        </div>
                        <div id="checkoutCustomerName" style="color:#666;font-size:13px"></div>
                    </div>

                    {{-- Coupon Code --}}
                    <div class="form-group" style="margin-bottom:8px">
                        <label style="font-weight:600;margin-bottom:2px;display:block;font-size:13px">Apply Coupon Code</label>
                        <div style="display:flex;gap:5px">
                            <input type="text" id="couponCodeInput" placeholder="Enter coupon code" style="flex:1;padding:4px 8px;font-size:13px">
                            <button type="button" onclick="applyCoupon()"
                                style="background:#007bff;color:#fff;border:none;padding:4px 10px;border-radius:4px;cursor:pointer;font-size:13px">Apply</button>
                        </div>
                        <div id="couponMessage" style="margin-top:2px;font-size:11px"></div>
                    </div>

                    {{-- Order Summary --}}
                    <div style="background:#f9f9f9;padding:5px 8px;border-radius:4px;margin-bottom:8px">
                        <div style="display:flex;justify-content:space-between;margin-bottom:5px">
                            <span>Subtotal:</span>
                            <span>₹<span id="checkoutSubtotal">0</span></span>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:5px;color:#28a745">
                            <span>Discount:</span>
                            <span>-₹<span id="checkoutDiscount">0</span></span>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:5px">
                            <span>Tax:</span>
                            <span>₹<span id="checkoutTax">0</span></span>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:5px">
                            <span>Shipping:</span>
                            <span>₹<span id="checkoutShipping">0</span></span>
                        </div>
                        <div
                            style="display:flex;justify-content:space-between;font-weight:bold;border-top:1px solid #ddd;padding-top:8px;margin-top:5px;font-size:16px">
                            <span>Total:</span>
                            <span style="color:#28a745">₹<span id="checkoutTotal">0</span></span>
                        </div>
                    </div>

                    {{-- Payment Mode --}}
                    <div class="form-group" style="margin-bottom:5px">
                        <label style="font-weight:600;margin-bottom:2px;display:block;font-size:13px">Payment Mode</label>
                        <select id="paymentMode" style="width:100%;padding:4px 8px;border:1px solid #ddd;border-radius:4px;font-size:13px">
                            <option value="COD">COD</option>
                            <option value="Gpay">Gpay</option>
                            <option value="Online Payment">Online Payment</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 5px 10px; justify-content: flex-start; gap: 5px; border-top: 1px solid #ddd;">
                    <button class="btn-secondary" onclick="closeCheckoutModal()" style="width: 140px; height: 32px; border-radius: 4px !important; white-space: nowrap; font-size:13px; padding:0"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                    <button class="btn-primary" onclick="processPayment()" style="width: 140px; height: 32px; border-radius: 4px !important; background:#28a745; white-space: nowrap; font-size:13px; padding:0"><i class="bi bi-check2-circle me-1"></i> Process Payment</button>
                </div>
            </div>
        </div>

        {{-- Order Success Modal with Invoice Popup --}}
        <div class="modal" id="successModal">
            <div class="modal-content"
                style="max-width:850px;max-height:90vh;overflow:hidden;display:flex;flex-direction:column">
                {{-- Header --}}
                <div
                    style="background:#28a745;color:#fff;padding:15px 20px;border-radius:8px 8px 0 0;display:flex;align-items:center;justify-content:space-between;flex-shrink:0">
                    <div style="display:flex;align-items:center;gap:10px">
                        <span style="font-size:28px">✅</span>
                        <div>
                            <h4 style="margin:0;font-size:18px">Order Created Successfully!</h4>
                            <div id="successOrderNumber" style="font-size:14px;opacity:0.9;margin-top:2px"></div>
                        </div>
                    </div>
                </div>

                {{-- Invoice Content Container --}}
                <div id="invoicePopupContent" style="flex:1;overflow-y:auto;padding:15px;background:#f5f5f5;min-height:400px">
                    <div style="text-align:center;padding:50px;color:#666">
                        <div style="font-size:40px;margin-bottom:10px">⏳</div>
                        <p>Loading invoice...</p>
                    </div>
                </div>

                {{-- Footer Buttons --}}
                <div
                    style="padding:15px 20px;background:#fff;border-top:1px solid #ddd;display:flex;gap:10px;justify-content:flex-end;flex-shrink:0">
                    <button onclick="printInvoiceModal()"
                        style="background:#007bff;color:#fff;border:none;padding:12px 24px;border-radius:6px;cursor:pointer;font-size:14px;font-weight:600;display:flex;align-items:center;gap:6px">
                        🖨️ Print Invoice
                    </button>
                    <button onclick="closeSuccessModal()"
                        style="background:#6c757d;color:#fff;border:none;padding:12px 24px;border-radius:6px;cursor:pointer;font-size:14px;font-weight:600;display:flex;align-items:center;gap:6px">
                        <i class="bi bi-x-circle"></i> Close
                    </button>
                </div>
            </div>
        </div>

        <script>
            let cart = [];
            let customerData = { type: 'guest', id: null, details: {} };
            let draftOrderId = null;
            let variantStocks = {}; // Track remaining stock for each variant

            // ===== SESSION STORAGE PERSISTENCE =====
            function saveStateToSession() {
                const state = {
                    cart: cart,
                    customerData: customerData,
                    draftOrderId: draftOrderId,
                    appliedCoupon: appliedCoupon,
                    selectedCustomerName: document.getElementById('selectedCustomerName')?.innerText || ''
                };
                sessionStorage.setItem('pos_billing_state', JSON.stringify(state));
                console.log('POS state saved to sessionStorage');
            }

            function loadStateFromSession() {
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('new') === '1') {
                    sessionStorage.removeItem('pos_billing_state');
                    window.history.replaceState({}, document.title, window.location.pathname);
                }

                const savedState = sessionStorage.getItem('pos_billing_state');
                if (savedState) {
                    try {
                        const state = JSON.parse(savedState);
                        cart = state.cart || [];
                        customerData = state.customerData || { type: 'guest', id: null, details: {} };
                        draftOrderId = state.draftOrderId || null;
                        appliedCoupon = state.appliedCoupon || { code: null, discount: 0 };
                        
                        console.log('POS state loaded from sessionStorage', state);
                        
                        // Re-render UI
                        if (customerData.type === 'registered' && customerData.id) {
                            const name = state.selectedCustomerName || 'Customer';
                            // Restore display manually instead of calling selectCustomer to avoid redundant saves/modals
                            document.getElementById('selectedCustomerName').innerText = name;
                            document.getElementById('selectedCustomerDisplay').style.display = 'block';
                            document.getElementById('customerType').value = 'registered';
                        } else if (customerData.type === 'guest' && customerData.details && customerData.details.first_name) {
                            // Update guest modal fields so they are there if opened
                            document.getElementById('guestName').value = customerData.details.first_name;
                            document.getElementById('guestEmail').value = customerData.details.email;
                            document.getElementById('guestPhone').value = customerData.details.phone;
                            document.getElementById('guestAddress').value = customerData.details.address;
                        }
                        
                        renderCart();
                    } catch (e) {
                        console.error('Error loading state from sessionStorage:', e);
                    }
                }
            }

            /**
             * Save draft order to database in background
             */
            let saveDraftTimeout = null;
            function saveDraft() {
                // Debounce to avoid too many requests
                if (saveDraftTimeout) clearTimeout(saveDraftTimeout);
                
                saveDraftTimeout = setTimeout(() => {
                    // Only save if customer is selected
                    const isGuestSelected = customerData.type === 'guest' && customerData.details && (customerData.details.first_name || customerData.details.name);
                    const isRegisteredSelected = customerData.type === 'registered' && customerData.id;
                    
                    if (!isGuestSelected && !isRegisteredSelected) {
                        console.log('Draft save skipped: No customer selected');
                        return;
                    }

                    // Don't save empty cart drafts
                    if (cart.length === 0) {
                         console.log('Draft save skipped: Cart empty');
                         return;
                    }

                    const subtotal = parseFloat(document.getElementById('subtotal').innerText || 0);
                    const tax = parseFloat(document.getElementById('tax').value || 0);
                    const shipping = parseFloat(document.getElementById('shipping').value || 0);
                    const discount = appliedCoupon.discount || 0;
                    const total = subtotal - discount + tax + shipping;

                    fetch("{{ route('admin.billing.save.draft') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({
                            order_id: draftOrderId,
                            customer_type: customerData.type,
                            customer_id: customerData.id,
                            guest_details: customerData.details,
                            items: cart,
                            subtotal: subtotal,
                            final_amount: total
                        })
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            draftOrderId = res.order_id;
                            saveStateToSession();
                            console.log('Draft saved successfully: #' + res.order_number);
                        }
                    })
                    .catch(err => console.error('Draft save error:', err));
                }, 1000); // 1 second debounce
            }

            function toggleVariants(productId) {
                const el = document.getElementById('variants-' + productId);
                el.style.display = el.style.display === 'none' ? 'block' : 'none';
            }

            function addToCart(pid, vid, pname, vname, price, gst = 0, sgst = 0, igst = 0, initialStock = 0) {
                // Initialize stock tracking if not already done
                if (!(vid in variantStocks)) {
                    variantStocks[vid] = initialStock;
                }

                // Check if stock is available
                if (variantStocks[vid] <= 0) {
                    alert('Out of stock!');
                    return;
                }

                let item = cart.find(i => i.variant_id === vid);
                if (item) {
                    // Check if we can add more
                    if (item.qty >= variantStocks[vid]) {
                        alert('Cannot add more than available stock!');
                        return;
                    }
                    item.qty++;
                    item.total = item.qty * item.price;
                } else {
                    cart.push({
                        product_id: pid,
                        variant_id: vid,
                        product_name: pname,
                        variant_name: vname,
                        price: price,
                        qty: 1,
                        total: price,
                        gst: gst,
                        sgst: sgst,
                        igst: igst
                    });
                }

                // Update stock display and button state
                updateStockDisplay(vid);
                renderCart();
                saveStateToSession();
            }

            function updateStockDisplay(vid) {
                // Get current quantity in cart for this variant
                const cartItem = cart.find(i => i.variant_id === vid);
                const qtyInCart = cartItem ? cartItem.qty : 0;
                const remainingStock = variantStocks[vid] - qtyInCart;

                // Update stock display
                const stockDisplay = document.getElementById('stock-display-' + vid);
                if (stockDisplay) {
                    stockDisplay.textContent = 'Stock: ' + remainingStock;

                    // Change color based on stock level
                    if (remainingStock === 0) {
                        stockDisplay.style.color = '#dc3545'; // Red
                        stockDisplay.textContent = 'Out of Stock';
                    } else if (remainingStock <= 5) {
                        stockDisplay.style.color = '#ff9800'; // Orange
                    } else {
                        stockDisplay.style.color = '#777'; // Default gray
                    }
                }

                // Update button state
                const addButton = document.getElementById('btn-add-' + vid);
                if (addButton) {
                    if (remainingStock <= 0) {
                        addButton.disabled = true;
                        addButton.style.opacity = '0.5';
                        addButton.style.cursor = 'not-allowed';
                    } else {
                        addButton.disabled = false;
                        addButton.style.opacity = '1';
                        addButton.style.cursor = 'pointer';
                    }
                }
            }

            function removeItem(index) {
                const item = cart[index];
                cart.splice(index, 1);

                // Update stock display when item is removed
                updateStockDisplay(item.variant_id);
                renderCart();
                saveStateToSession();
            }

            function increaseQty(index) {
                const item = cart[index];
                const cartQty = item.qty;
                const remainingStock = variantStocks[item.variant_id] - cartQty;
                
                if (remainingStock > 0) {
                    item.qty++;
                    item.total = item.qty * item.price;
                    updateStockDisplay(item.variant_id);
                    renderCart();
                    saveStateToSession();
                } else {
                    alert('Out of stock!');
                }
            }

            function decreaseQty(index) {
                const item = cart[index];
                if (item.qty > 1) {
                    item.qty--;
                    item.total = item.qty * item.price;
                    updateStockDisplay(item.variant_id);
                    renderCart();
                    saveStateToSession();
                } else {
                    removeItem(index);
                }
            }

            function clearCart() {
                if (confirm('Clear cart?')) {
                    clearCartNoConfirm();
                }
            }

            function clearCartNoConfirm() {
                // Store variant IDs before clearing
                const variantIds = cart.map(item => item.variant_id);
                cart = [];
                draftOrderId = null; // Fix: Clear order ID so next order is new
                appliedCoupon = { code: null, discount: 0 }; // Clear coupon

                // Update all stock displays
                variantIds.forEach(vid => updateStockDisplay(vid));
                renderCart();
                saveStateToSession();
            }

            function renderCart() {
                let body = '';
                let subtotal = 0;

                if (cart.length === 0) {
                    body = `<tr><td colspan="5" align="center" style="padding:30px;color:#999">Cart empty</td></tr>`;
                } else {
                    cart.forEach((c, i) => {
                        subtotal += c.total;
                        body += `
                                    <tr>
                                        <td>${c.product_name} <small>(${c.variant_name})</small></td>
                                        <td>₹${parseFloat(c.price).toFixed(2)}</td>
                                        <td>
                                            <div style="display:flex; align-items:center; gap:5px;">
                                                <button type="button" onclick="decreaseQty(${i})" style="width:24px; height:24px; border:1px solid #ccc; background:#fff; border-radius:3px; cursor:pointer; display:flex; align-items:center; justify-content:center;">-</button>
                                                <span>${c.qty}</span>
                                                <button type="button" onclick="increaseQty(${i})" style="width:24px; height:24px; border:1px solid #ccc; background:#fff; border-radius:3px; cursor:pointer; display:flex; align-items:center; justify-content:center;">+</button>
                                            </div>
                                        </td>
                                        <td>₹${parseFloat(c.total).toFixed(2)}</td>
                                        <td><button type="button" onclick="removeItem(${i})" style="background:#dc3545;color:#fff;border:none;padding:4px 8px;border-radius:3px;cursor:pointer">×</button></td>
                                    </tr>`;
                    });
                }

                document.getElementById('cartBody').innerHTML = body;
                document.getElementById('subtotal').innerText = subtotal.toFixed(2);
                calculateTotal();
                saveDraft(); // Auto-save draft on cart change
            }

            function calculateTotal() {
                let subtotal = parseFloat(document.getElementById('subtotal').innerText || 0);
                let tax = parseFloat(document.getElementById('tax').value || 0);
                let shipping = parseFloat(document.getElementById('shipping').value || 0);
                document.getElementById('grandTotal').innerText = (subtotal + tax + shipping).toFixed(2);
            }

            // ===== TAX MODAL FUNCTIONS =====
            function openTaxModal() {
                const subtotal = parseFloat(document.getElementById('subtotal').innerText || 0);
                if (subtotal <= 0) {
                    alert('Please add items to cart first');
                    return;
                }
                document.getElementById('taxModalSubtotal').innerText = subtotal.toFixed(2);
                document.getElementById('taxModal').classList.add('show');
                renderProductTaxBreakdown();
            }

            function closeTaxModal() {
                document.getElementById('taxModal').classList.remove('show');
            }

            // Render product-wise tax breakdown table
            function renderProductTaxBreakdown() {
                let tableBody = '';
                let totalGst = 0, totalSgst = 0, totalIgst = 0, subtotal = 0;

                if (cart.length === 0) {
                    tableBody = '<tr><td colspan="6" style="padding:20px;text-align:center;color:#999">No products in cart</td></tr>';
                } else {
                    cart.forEach(item => {
                        const itemTotal = item.price * item.qty;
                        const gstAmt = (itemTotal * (item.gst || 0) / 100);
                        const sgstAmt = (itemTotal * (item.sgst || 0) / 100);
                        const igstAmt = (itemTotal * (item.igst || 0) / 100);
                        const itemTax = gstAmt + sgstAmt + igstAmt;

                        totalGst += gstAmt;
                        totalSgst += sgstAmt;
                        totalIgst += igstAmt;
                        subtotal += itemTotal;

                        tableBody += `
                                        <tr>
                                            <td style="padding:8px;border-bottom:1px solid #eee">${item.product_name} <small>(${item.variant_name})</small></td>
                                            <td style="padding:8px;border-bottom:1px solid #eee;text-align:right">₹${itemTotal.toFixed(2)}</td>
                                            <td style="padding:8px;border-bottom:1px solid #eee;text-align:center">${item.gst || 0}%</td>
                                            <td style="padding:8px;border-bottom:1px solid #eee;text-align:center">${item.sgst || 0}%</td>
                                            <td style="padding:8px;border-bottom:1px solid #eee;text-align:center">${item.igst || 0}%</td>
                                            <td style="padding:8px;border-bottom:1px solid #eee;text-align:right;font-weight:600">₹${itemTax.toFixed(2)}</td>
                                        </tr>
                                    `;
                    });
                }

                document.getElementById('taxProductsBody').innerHTML = tableBody;
                document.getElementById('taxModalSubtotal').innerText = subtotal.toFixed(2);
                document.getElementById('gstAmount').innerText = totalGst.toFixed(2);
                document.getElementById('sgstAmount').innerText = totalSgst.toFixed(2);
                document.getElementById('igstAmount').innerText = totalIgst.toFixed(2);
                document.getElementById('totalTaxPreview').innerText = (totalGst + totalSgst + totalIgst).toFixed(2);
            }

            // Apply calculated tax to the order
            function applyTax() {
                const totalTax = parseFloat(document.getElementById('totalTaxPreview').innerText || 0);
                document.getElementById('tax').value = totalTax;
                document.getElementById('taxAmount').innerText = totalTax.toFixed(2);
                closeTaxModal();
                calculateTotal();
            }

            // ===== SHIPPING MODAL FUNCTIONS =====
            function openShippingModal() {
                const subtotal = parseFloat(document.getElementById('subtotal').innerText || 0);
                if (subtotal <= 0) {
                    alert('Please add items to cart first');
                    return;
                }
                document.getElementById('shippingModalSubtotal').innerText = subtotal.toFixed(2);
                document.getElementById('shippingModal').classList.add('show');
            }

            function closeShippingModal() {
                document.getElementById('shippingModal').classList.remove('show');
            }

            // Load shipping states on page load
            function loadShippingStates() {
                fetch("{{ route('admin.billing.shipping.states') }}")
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.states.length > 0) {
                            const select = document.getElementById('shippingState');
                            data.states.forEach(state => {
                                const option = document.createElement('option');
                                option.value = state;
                                option.textContent = state;
                                select.appendChild(option);
                            });
                        }
                    })
                    .catch(err => console.error('Error loading states:', err));
            }

            // Calculate and apply shipping from modal
            function calculateAndApplyShipping() {
                const state = document.getElementById('shippingState').value;
                const subtotal = parseFloat(document.getElementById('shippingModalSubtotal').innerText || 0);

                if (!state) {
                    alert('Please select a delivery state');
                    return;
                }

                fetch("{{ route('admin.billing.calculate.shipping') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        state: state,
                        order_total: subtotal,
                        total_weight: 0,
                        items: cart
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('shipping').value = parseFloat(data.shipping_amount).toFixed(2);
                            document.getElementById('shippingAmount').innerText = parseFloat(data.shipping_amount).toFixed(2);
                            document.getElementById('shippingPreview').innerText = parseFloat(data.shipping_amount).toFixed(2);

                            // Show zone info in modal
                            document.getElementById('shippingZoneInfo').style.display = 'block';
                            document.getElementById('shippingZoneName').innerText = data.zone + ' (' + (data.condition_type === 'weight' ? 'Weight Based' : 'Amount Based') + ')';

                            closeShippingModal();
                            calculateTotal();
                        } else {
                            alert(data.message || 'Could not calculate shipping');
                        }
                    })
                    .catch(err => {
                        console.error('Shipping calculation error:', err);
                        alert('Error calculating shipping');
                    });
            }

            // Load states and saved POS state on page load
            document.addEventListener('DOMContentLoaded', function() {
                loadShippingStates();
                loadStateFromSession();
            });

            // Product Search
            document.getElementById('productSearch').addEventListener('input', function () {
                const query = this.value.toLowerCase().trim();
                const productRows = document.querySelectorAll('.product-row');
                let visibleCount = 0;

                productRows.forEach(row => {
                    const productName = row.getAttribute('data-product-name');
                    const productId = row.getAttribute('data-product-id');
                    const variantsDiv = document.getElementById('variants-' + productId);

                    if (productName.includes(query)) {
                        row.style.display = 'flex';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                        if (variantsDiv) variantsDiv.style.display = 'none';
                    }
                });

                // Show/hide "No products found" message
                const noProductsMsg = document.getElementById('noProductsMessage');
                if (visibleCount === 0 && query !== '') {
                    noProductsMsg.style.display = 'block';
                } else {
                    noProductsMsg.style.display = 'none';
                }
            });

            function handleCustomerType() {
                const type = document.getElementById('customerType').value;
                console.log('Customer type selected:', type);

                if (type === 'guest') {
                    console.log('Opening guest modal...');
                    // Hide selected customer display
                    document.getElementById('selectedCustomerDisplay').style.display = 'none';
                    const guestModal = document.getElementById('guestModal');
                    if (guestModal) {
                        guestModal.classList.add('show');
                        console.log('Guest modal opened');
                    } else {
                        console.error('Guest modal element not found!');
                    }
                } else if (type === 'registered') {
                    console.log('Opening customer modal...');
                    const customerModal = document.getElementById('customerModal');
                    if (customerModal) {
                        customerModal.classList.add('show');
                        console.log('Customer modal opened');
                    } else {
                        console.error('Customer modal element not found!');
                    }
                }
            }

            function closeGuestModal() {
                document.getElementById('guestModal').classList.remove('show');
            }

            function closeCustomerModal() {
                document.getElementById('customerModal').classList.remove('show');
                // Reset to guest if no customer was selected
                if (customerData.type !== 'registered' || !customerData.id) {
                    document.getElementById('customerType').value = 'guest';
                }
            }

            function saveGuest() {
                try {
                    const nameInput = document.getElementById('guestName');
                    const phoneInput = document.getElementById('guestPhone');
                    const errName = document.getElementById('err-guestName');
                    const errPhone = document.getElementById('err-guestPhone');
                    
                    const name = nameInput.value.trim();
                    const phone = phoneInput.value.trim();
                    const email = ''; // No longer collecting email
                    const address = document.getElementById('guestAddress').value;

                    let valid = true;

                    // Clean previous errors
                    nameInput.classList.remove('is-invalid');
                    errName.classList.add('d-none');
                    phoneInput.classList.remove('is-invalid');
                    errPhone.classList.add('d-none');

                    if (!name) {
                        nameInput.classList.add('is-invalid');
                        errName.classList.remove('d-none');
                        valid = false;
                    }

                    if (!phone || phone.length !== 10) {
                        phoneInput.classList.add('is-invalid');
                        errPhone.classList.remove('d-none');
                        valid = false;
                    }

                    if (!valid) return;

                if (customerData.type !== 'guest' || (customerData.details && customerData.details.phone !== phone)) {
                    draftOrderId = null; // Important: Clear draft context when guest phone fundamentally changes
                }

                // Check if ship same address
                const shipSameAddress = document.getElementById('guestShipSameAddress').checked;

                let shippingAddress = null;
                if (!shipSameAddress) {
                    const shipName = document.getElementById('guestShipName').value;
                    const shipPhone = document.getElementById('guestShipPhone').value;
                    const shipAddr = document.getElementById('guestShipAddress').value;

                    if (!shipName || !shipPhone || !shipAddr) {
                        alert('Please fill shipping address fields');
                        return;
                    }

                    shippingAddress = {
                        name: shipName,
                        email: email, // empty
                        phone: shipPhone,
                        address: shipAddr
                    };
                }

                customerData = {
                    type: 'guest',
                    id: null,
                    details: {
                        first_name: name,
                        email: email,
                        phone: phone,
                        address: address
                    },
                    ship_same_address: shipSameAddress,
                    shipping_address: shippingAddress
                };

                    // Keep dropdown at Guest
                    document.getElementById('customerType').value = 'guest';

                    saveStateToSession();
                    closeGuestModal();
                    saveDraft(); // Auto-save draft after guest details entered
                } catch(e) {
                    console.error("Save Guest Error:", e);
                    alert("Developer Error: Failed to save guest details. " + e.message);
                }
            }

            // Toggle guest shipping fields visibility
            function toggleGuestShippingFields() {
                const shipSame = document.getElementById('guestShipSameAddress').checked;
                document.getElementById('guestShippingFields').style.display = shipSame ? 'none' : 'block';
            }

            function selectCustomer(id, name) {
                if (customerData.id !== id) {
                    draftOrderId = null; // Important: Clear draft context when assigning a completely different customer
                }

                customerData = {
                    type: 'registered',
                    id: id,
                    details: {},
                    ship_same_address: true,
                    shipping_address: null
                };

                // Display selected customer name
                document.getElementById('selectedCustomerName').innerText = name;
                document.getElementById('selectedCustomerDisplay').style.display = 'block';

                // Reset shipping checkbox to checked
                document.getElementById('regShipSameAddress').checked = true;

                // Keep dropdown at Registered
                document.getElementById('customerType').value = 'registered';

                saveStateToSession();
                closeCustomerModal();
                saveDraft(); // Auto-save draft after customer selected
            }

            // Toggle registered user shipping option
            function toggleRegisteredShippingOption() {
                const shipSame = document.getElementById('registeredShipSameAddress').checked;

                if (!shipSame) {
                    // Open shipping address modal
                    document.getElementById('shippingAddressModal').classList.add('show');
                } else {
                    // Reset to same address
                    customerData.ship_same_address = true;
                    customerData.shipping_address = null;
                }
            }

            // Close shipping address modal
            function closeShippingAddressModal() {
                document.getElementById('shippingAddressModal').classList.remove('show');
                // Reset checkbox if cancelled
                document.getElementById('registeredShipSameAddress').checked = true;
                customerData.ship_same_address = true;
                customerData.shipping_address = null;
            }

            // Save registered user's shipping address
            function saveRegisteredShippingAddress() {
                const shipName = document.getElementById('regShipName').value;
                const shipPhone = document.getElementById('regShipPhone').value;
                const shipAddress = document.getElementById('regShipAddress').value;

                if (!shipName || !shipPhone || !shipAddress) {
                    alert('Please fill required shipping address fields');
                    return;
                }

                customerData.ship_same_address = false;
                customerData.shipping_address = {
                    name: shipName,
                    email: document.getElementById('regShipEmail').value || '',
                    phone: shipPhone,
                    address: shipAddress
                };

                document.getElementById('shippingAddressModal').classList.remove('show');
                saveDraft(); // Auto-save draft after shipping address updated
            }

            // Customer Search
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('customerSearch');
                if (searchInput) {
                    searchInput.addEventListener('input', function () {
                        const query = this.value.toLowerCase();
                        const items = document.querySelectorAll('.customer-item');
                        items.forEach(item => {
                            const name = item.dataset.name;
                            const email = item.dataset.email;
                            const phone = item.dataset.phone || '';
                            if (name.includes(query) || email.includes(query) || phone.includes(query)) {
                                item.style.display = 'flex';
                            } else {
                                item.style.display = 'none';
                            }
                        });
                    });
                }
            });

            // Prevent double submission flag
            let isSubmitting = false;
            let appliedCoupon = { code: null, discount: 0 };

            // Open checkout modal instead of directly creating order
            function checkout() {
                if (cart.length === 0) {
                    alert('Cart is empty');
                    return;
                }

                // Validate customer selection
                const customerType = document.getElementById('customerType').value;

                if (!customerType) {
                    alert('Please select a Customer Type (Guest or Registered)');
                    return;
                }

                // If Guest, check if guest details are filled
                if (customerType === 'guest') {
                    if (!customerData.details || !customerData.details.first_name || !customerData.details.phone) {
                        alert('Please fill Guest details (Name, Phone)');
                        document.getElementById('guestModal').classList.add('show');
                        return;
                    }
                }

                // If Registered, check if customer is selected
                if (customerType === 'registered') {
                    if (!customerData.id) {
                        alert('Please select a Registered Customer');
                        document.getElementById('customerModal').classList.add('show');
                        return;
                    }
                }

                // Open checkout modal
                openCheckoutModal();
            }

            // ===== CHECKOUT MODAL FUNCTIONS =====
            function openCheckoutModal() {
                // Set customer info
                const customerType = customerData.type === 'registered' ? 'Registered' : 'Guest';
                document.getElementById('checkoutCustomerType').innerText = customerType;

                let customerName = '';
                if (customerData.type === 'guest' && customerData.details) {
                    customerName = customerData.details.first_name || '';
                } else if (customerData.type === 'registered') {
                    customerName = document.getElementById('selectedCustomerName')?.innerText || '';
                }
                document.getElementById('checkoutCustomerName').innerText = customerName;

                // Set order summary
                const subtotal = parseFloat(document.getElementById('subtotal').innerText || 0);
                const tax = parseFloat(document.getElementById('tax').value || 0);
                const shipping = parseFloat(document.getElementById('shipping').value || 0);
                const discount = appliedCoupon.discount || 0;
                const total = subtotal - discount + tax + shipping;

                document.getElementById('checkoutSubtotal').innerText = subtotal.toFixed(2);
                document.getElementById('checkoutDiscount').innerText = discount.toFixed(2);
                document.getElementById('checkoutTax').innerText = tax.toFixed(2);
                document.getElementById('checkoutShipping').innerText = shipping.toFixed(2);
                document.getElementById('checkoutTotal').innerText = total.toFixed(2);

                // Reset coupon
                document.getElementById('couponCodeInput').value = appliedCoupon.code || '';
                document.getElementById('couponMessage').innerHTML = '';

                document.getElementById('checkoutModal').classList.add('show');
            }

            function closeCheckoutModal() {
                document.getElementById('checkoutModal').classList.remove('show');
            }

            // Apply coupon
            function applyCoupon() {
                const code = document.getElementById('couponCodeInput').value.trim();
                const subtotal = parseFloat(document.getElementById('subtotal').innerText || 0);
                const msgDiv = document.getElementById('couponMessage');

                if (!code) {
                    msgDiv.innerHTML = '<span style="color:#dc3545">Please enter a coupon code</span>';
                    return;
                }

                fetch("{{ route('admin.billing.apply.coupon') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ code: code, subtotal: subtotal })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            appliedCoupon = { code: data.coupon_code, discount: data.discount };
                            msgDiv.innerHTML = '<span style="color:#28a745">✓ ' + data.message + ' (-₹' + data.discount + ')</span>';
                            updateCheckoutTotal();
                        } else {
                            appliedCoupon = { code: null, discount: 0 };
                            msgDiv.innerHTML = '<span style="color:#dc3545">' + data.message + '</span>';
                            updateCheckoutTotal();
                        }
                    })
                    .catch(err => {
                        msgDiv.innerHTML = '<span style="color:#dc3545">Error applying coupon</span>';
                        console.error(err);
                    });
            }

            function updateCheckoutTotal() {
                const subtotal = parseFloat(document.getElementById('checkoutSubtotal').innerText || 0);
                const tax = parseFloat(document.getElementById('checkoutTax').innerText || 0);
                const shipping = parseFloat(document.getElementById('checkoutShipping').innerText || 0);
                const discount = appliedCoupon.discount || 0;
                const total = subtotal - discount + tax + shipping;

                document.getElementById('checkoutDiscount').innerText = discount.toFixed(2);
                document.getElementById('checkoutTotal').innerText = total.toFixed(2);
                saveStateToSession();
            }

            // Process payment - create order
            function processPayment() {
                if (isSubmitting) return;
                isSubmitting = true;

                const billingType = 'offline';
                const paymentMode = document.getElementById('paymentMode').value;
                const paymentMethod = paymentMode === 'COD' ? 'cash_on_delivery' : 'online';
                const paymentProvider = paymentMode === 'COD' ? 'cash' : (paymentMode === 'Gpay' ? 'cash' : 'razorpay');

                const subtotal = parseFloat(document.getElementById('subtotal').innerText || 0);
                const tax = parseFloat(document.getElementById('tax').value || 0);
                const shipping = parseFloat(document.getElementById('shipping').value || 0);
                const discount = appliedCoupon.discount || 0;
                const total = subtotal - discount + tax + shipping;

                // First create the order
                fetch("{{ route('admin.billing.checkout') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        order_id: draftOrderId,
                        customer_type: customerData.type,
                        customer_id: customerData.id,
                        guest_details: customerData.details,
                        ship_same_address: customerData.ship_same_address !== false,
                        shipping_address: customerData.shipping_address || null,
                        items: cart,
                        subtotal: subtotal,
                        discount_amount: discount,
                        coupon_code: appliedCoupon.code,
                        billing_type: billingType,
                        payment_method: paymentMethod,
                        payment_provider: paymentProvider,
                        tax_data: { enabled: true, total: tax },
                        shipping_data: { enabled: true, amount: shipping },
                        final_amount: total
                    })
                })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            // Check if online payment is required
                            // Trigger Razorpay if: (billing is online AND method is upi/card) OR provider is razorpay
                            const needsRazorpay = (res.requires_payment && billingType === 'online' && (paymentMethod === 'upi' || paymentMethod === 'card'))
                                || (paymentProvider === 'razorpay' && paymentMethod !== 'cash');

                            if (needsRazorpay) {
                                // Open Razorpay checkout
                                openRazorpayCheckout(res.order_id, res.order_number, total);
                            } else {
                                // Cash/Offline payment - show success immediately
                                isSubmitting = false;
                                sessionStorage.removeItem('pos_billing_state'); // Clear state on success
                                closeCheckoutModal();
                                showSuccessModal(res.order_number, res.order_id);
                                clearCartNoConfirm();
                            }
                        } else {
                            isSubmitting = false;
                            alert('Error: ' + res.message);
                        }
                    })
                    .catch(err => {
                        isSubmitting = false;
                        alert('Error creating order');
                        console.error(err);
                    });
            }

            // Auto-update payment method options based on billing type
            document.addEventListener('DOMContentLoaded', function () {
                const billingTypeRadios = document.querySelectorAll('input[name="billingType"]');
                billingTypeRadios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        updatePaymentOptions(this.value);
                    });
                });
            });

            function updatePaymentOptions(billingType) {
                const paymentMethodSelect = document.getElementById('paymentMethod');
                const paymentProviderSelect = document.getElementById('paymentProvider');

                if (billingType === 'online') {
                    // Online - show UPI/Card options
                    paymentMethodSelect.innerHTML = `
                                    <option value="upi">UPI</option>
                                    <option value="card">Card</option>
                                `;
                    paymentProviderSelect.innerHTML = `
                                    <option value="razorpay">Razorpay</option>
                                `;
                } else {
                    // Offline - show Cash option
                    paymentMethodSelect.innerHTML = `
                                    <option value="cash">Cash</option>
                                    <option value="upi">UPI</option>
                                    <option value="card">Card</option>
                                `;
                    paymentProviderSelect.innerHTML = `
                                    <option value="cash">Cash</option>
                                    <option value="razorpay">Razorpay</option>
                                    <option value="gpay">Google Pay</option>
                                `;
                }
            }

            // ===== RAZORPAY PAYMENT INTEGRATION =====
            // Opens real Razorpay checkout - works with both test and live keys
            function openRazorpayCheckout(orderId, orderNumber, amount) {
                // First, create Razorpay order on backend
                fetch("{{ route('admin.billing.create.razorpay.order') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        order_id: orderId,
                        amount: amount
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            // Check if Razorpay key is configured
                            if (!data.razorpay_key || data.razorpay_key === 'rzp_test_xxxxxxxxxx') {
                                alert('Razorpay API keys not configured. Please add your Razorpay keys to .env file.\n\nRZP_KEY=' + (data.razorpay_key || 'not set'));
                                isSubmitting = false;
                                return;
                            }

                            // Open REAL Razorpay checkout popup
                            var options = {
                                key: data.razorpay_key,
                                amount: data.amount, // in paisa
                                currency: data.currency,
                                name: 'Order #' + data.order_number + ' | Chennai Angadi',
                                description: 'Payment for Order #' + data.order_number,
                                image: '{{ asset("assets/imgs/theme/ChennaiAngadiLogo.png") }}',
                                order_id: data.razorpay_order_id,
                                prefill: {
                                    name: data.prefill.name,
                                    email: data.prefill.email,
                                    contact: data.prefill.contact
                                },
                                notes: {
                                    order_id: orderId,
                                    order_number: data.order_number
                                },
                                handler: function (response) {
                                    // Payment successful - verify on backend
                                    verifyRazorpayPayment(orderId, response);
                                },
                                 modal: {
                                    ondismiss: function () {
                                        isSubmitting = false;
                                        sessionStorage.removeItem('pos_billing_state');
                                        closeCheckoutModal();
                                        showSuccessModal(orderNumber, orderId);
                                        clearCartNoConfirm();
                                        alert('Payment cancelled / interrupted. Order #' + orderNumber + ' has been saved with Not Paid status.');
                                    },
                                    escape: true,
                                    backdropclose: false
                                },
                                theme: {
                                    color: '#28a745'
                                }
                            };
 
                            var rzp = new Razorpay(options);
 
                            rzp.on('payment.failed', function (response) {
                                console.error('Payment failed:', response.error);
                                isSubmitting = false;
                                sessionStorage.removeItem('pos_billing_state');
                                closeCheckoutModal();
                                showSuccessModal(orderNumber, orderId);
                                clearCartNoConfirm();
                                alert('Payment failed: ' + response.error.description + '\n\nOrder #' + orderNumber + ' has been saved with Not Paid status.');
                            });

                            rzp.open();
                        } else {
                            isSubmitting = false;
                            alert('Error creating payment order: ' + data.message);
                        }
                    })
                    .catch(err => {
                        isSubmitting = false;
                        console.error('Error initiating payment:', err);
                        alert('Error initiating payment. Please try again.');
                    });
            }

            // Verify payment with backend (signature verification for security)
            function verifyRazorpayPayment(orderId, response) {
                fetch("{{ route('admin.billing.verify.payment') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        order_id: orderId,
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_signature: response.razorpay_signature
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        isSubmitting = false;
                        closeCheckoutModal();

                        if (data.success) {
                            showSuccessModal(data.order_number, orderId);
                        } else {
                            alert('Payment verification failed: ' + data.message);
                            window.location.href = "{{ route('billing.table') }}";
                        }
                    })
                    .catch(err => {
                        isSubmitting = false;
                        console.error('Error verifying payment:', err);
                        alert('Payment completed but verification failed. Please check order status.');
                        window.location.href = "{{ route('billing.table') }}";
                    });
            }


            // ===== SUCCESS MODAL FUNCTIONS =====
            let lastOrderData = {};

            function showSuccessModal(orderNumber, orderId) {
                // Store order data
                lastOrderData = {
                    orderNumber: orderNumber,
                    orderId: orderId,
                    cart: [...cart],
                    customerData: { ...customerData },
                    subtotal: parseFloat(document.getElementById('subtotal').innerText || 0),
                    tax: parseFloat(document.getElementById('tax').value || 0),
                    shipping: parseFloat(document.getElementById('shipping').value || 0),
                    discount: appliedCoupon.discount || 0
                };
                lastOrderData.total = lastOrderData.subtotal - lastOrderData.discount + lastOrderData.tax + lastOrderData.shipping;

                // Show order number in header
                document.getElementById('successOrderNumber').innerText = 'Order Id ' + orderNumber;

                // Show loading state
                document.getElementById('invoicePopupContent').innerHTML = `
                                <div style="text-align:center;padding:50px;color:#666">
                                    <div style="font-size:40px;margin-bottom:10px">⏳</div>
                                    <p>Loading invoice...</p>
                                </div>
                            `;

                // Show the modal
                document.getElementById('successModal').classList.add('show');

                // Fetch invoice HTML via AJAX
                fetchInvoiceHtml(orderId);
            }

            function fetchInvoiceHtml(orderId) {
                fetch("{{ url('billing/invoice-html') }}/" + orderId)
                    .then(res => {
                        if (!res.ok) throw new Error('Failed to load invoice');
                        return res.text();
                    })
                    .then(html => {
                        document.getElementById('invoicePopupContent').innerHTML = `
                                        <div style="background:#fff;padding:10px;border-radius:4px;box-shadow:0 1px 3px rgba(0,0,0,0.1)">
                                            ${html}
                                        </div>
                                    `;
                    })
                    .catch(err => {
                        console.error('Error fetching invoice:', err);
                        document.getElementById('invoicePopupContent').innerHTML = `
                                        <div style="text-align:center;padding:50px;color:#dc3545">
                                            <div style="font-size:40px;margin-bottom:10px">⚠️</div>
                                            <p>Error loading invoice</p>
                                            <button onclick="fetchInvoiceHtml(${orderId})" style="background:#007bff;color:#fff;border:none;padding:8px 16px;border-radius:4px;cursor:pointer;margin-top:10px">
                                                Retry
                                            </button>
                                        </div>
                                    `;
                    });
            }

            function printInvoiceModal() {
                // Get the invoice content
                const invoiceContent = document.getElementById('invoicePopupContent').innerHTML;

                // Create a hidden iframe for printing (no popup window)
                let printFrame = document.getElementById('printFrame');
                if (!printFrame) {
                    printFrame = document.createElement('iframe');
                    printFrame.id = 'printFrame';
                    printFrame.style.cssText = 'position:absolute;left:-9999px;top:-9999px;width:0;height:0;border:none;';
                    document.body.appendChild(printFrame);
                }

                const frameDoc = printFrame.contentWindow || printFrame.contentDocument;
                const doc = frameDoc.document || frameDoc;

                doc.open();
                doc.write(`
                                <!DOCTYPE html>
                                <html>
                                <head>
                                    <title>Invoice - ${lastOrderData.orderNumber}</title>
                                    <style>
                                        * { margin: 0; padding: 0; box-sizing: border-box; }
                                        body { font-family: Arial, sans-serif; padding: 10px; }
                                        @media print {
                                            @page { size: A4 portrait; margin: 10mm; }
                                        }
                                    </style>
                                </head>
                                <body>
                                    ${invoiceContent}
                                </body>
                                </html>
                            `);
                doc.close();

                // Wait for content to load then print
                setTimeout(() => {
                    printFrame.contentWindow.focus();
                    printFrame.contentWindow.print();
                }, 300);
            }

            function closeSuccessModal() {
                document.getElementById('successModal').classList.remove('show');
                // Reset cart and go to billing table
                cart = [];
                appliedCoupon = { code: null, discount: 0 };
                renderCart();
                window.location.href = "{{ route('billing.table') }}";
            }

            function viewInvoice() {
                // Open invoice in new tab
                window.open("{{ url('billing/invoice') }}/" + lastOrderData.orderId, '_blank');
            }
        </script>

@endsection