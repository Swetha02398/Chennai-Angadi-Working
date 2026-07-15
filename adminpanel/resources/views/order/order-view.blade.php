@extends('layouts.app')
@section('content')
<style>
    .order-view-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin: 20px 0;
        width: 100%;
    }
    .order-view-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        margin-bottom: 15px;
    }
    .order-view-header .back-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 18px;
        font-weight: 600;
        color: #333;
        text-decoration: none;
    }
    .order-view-header .back-btn:hover {
        color: #00bcd4;
    }
    .order-view-header .back-btn i {
        font-size: 20px;
    }
    .order-view-header .action-buttons {
        display: flex;
        gap: 10px;
    }
    .order-view-header .action-buttons .btn {
        padding: 8px 16px;
        font-size: 14px;
        border-radius: 5px;
    }
    
    .invoice-container {
        padding: 25px;
        background: #fff;
    }
    
    /* Invoice Header */
    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }
    .invoice-header .logo img {
        height: 70px;
        width: auto;
    }
    .invoice-header .title {
        text-align: center;
        flex: 1;
    }
    .invoice-header .title h2 {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin: 0;
    }
    .invoice-header .company-info {
        text-align: right;
        font-size: 12px;
        color: #333;
        line-height: 1.6;
    }
    .invoice-header .company-info .name {
        font-weight: bold;
        font-size: 14px;
    }
    
    /* Address Section */
    .address-section {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        gap: 30px;
    }
    .address-box {
        flex: 1;
    }
    .address-box .label {
        font-weight: bold;
        color: #dc3545;
        font-size: 14px;
        margin-bottom: 8px;
    }
    .address-box .customer-name {
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 4px;
        text-transform: capitalize;
    }
    .address-box .address-details {
        font-size: 13px;
        color: #555;
        line-height: 1.6;
    }
    
    .order-info-box {
        text-align: right;
        min-width: 180px;
    }
    .order-info-box .order-label {
        font-size: 12px;
        color: #666;
    }
    .order-info-box .order-id {
        font-weight: bold;
        font-size: 18px;
        color: #333;
    }
    .order-info-box .order-date {
        font-size: 13px;
        color: #666;
        margin-top: 5px;
    }
    
    /* Items Table */
    .items-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .items-table th {
        background: #f5f5f5;
        border: 1px solid #ddd;
        padding: 12px 15px;
        font-weight: bold;
        font-size: 12px;
        text-transform: uppercase;
        color: #333;
    }
    .items-table th:first-child {
        text-align: center;
        width: 60px;
    }
    .items-table th:nth-child(2) {
        text-align: left;
    }
    .items-table th:nth-child(3),
    .items-table th:nth-child(4),
    .items-table th:nth-child(5) {
        text-align: center;
    }
    .items-table td {
        border: 1px solid #ddd;
        padding: 12px 15px;
        font-size: 13px;
        vertical-align: middle;
    }
    .items-table td:first-child {
        text-align: center;
    }
    .items-table td:nth-child(3),
    .items-table td:nth-child(4),
    .items-table td:nth-child(5) {
        text-align: center;
    }
    .items-table tbody tr:hover {
        background: #fafafa;
    }
    
    /* Summary Section */
    .summary-section {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }
    .summary-table {
        width: 300px;
        border-collapse: collapse;
    }
    .summary-table tr {
        border: 1px solid #ddd;
    }
    .summary-table td {
        padding: 10px 15px;
        font-size: 13px;
    }
    .summary-table td:first-child {
        text-align: right;
        color: #dc3545;
        font-weight: 600;
    }
    .summary-table td:last-child {
        text-align: right;
        color: #dc3545;
        min-width: 100px;
    }
    .summary-table .total-row td {
        font-size: 16px;
        font-weight: bold;
        background: #fff8f8;
    }
    
    /* Footer */
    .invoice-footer {
        text-align: center;
        font-size: 12px;
        color: #666;
        padding-top: 20px;
        border-top: 1px dashed #ddd;
        line-height: 1.8;
    }
    .invoice-footer a {
        color: #dc3545;
        text-decoration: none;
        font-weight: 600;
    }

    @media print {
        /* Hide all non-invoice elements */
        .order-view-header,
        .order-view-header .action-buttons,
        .print-options-modal,
        #printOptionsModal,
        .sidebar,
        .aside,
        aside,
        nav,
        .navbar,
        .navbar-fixed-top,
        header,
        .header,
        .topbar,
        .main-header,
        .nav-header,
        .sidebar-wrapper,
        .modal,
        .modal-backdrop,
        .brand-wrap,
        .screen-overlay,
        footer,
        .footer,
        .main-footer,
        .site-footer,
        .copyright {
            display: none !important;
        }
        
        /* Add page margins for consistent printing */
        @page {
            size: A4 portrait;
            margin: 8mm;
        }
        
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            height: auto !important;
            overflow: visible !important;
            background: #fff !important;
            background-color: #fff !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        
        * {
            background-color: transparent !important;
        }
        
        .main-wrap,
        .main,
        main,
        .content,
        .content-main,
        .container,
        section {
            background: #fff !important;
            background-color: #fff !important;
        }
        
        /* Remove all borders */
        .order-view-container,
        .invoice-container,
        #gstNotIncludedInvoice,
        #gstIncludedInvoice {
            box-shadow: none !important;
            border: none !important;
            margin: 0 !important;
            padding: 0 !important;
            max-width: 100% !important;
            width: 100% !important;
        }
        
        .content-main,
        .container {
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            border: none !important;
        }
        
        /* Compact the invoice for one page */
        #gstNotIncludedInvoice .ngi-top-section,
        #gstNotIncludedInvoice .ngi-from-section,
        #gstNotIncludedInvoice .ngi-header {
            margin-bottom: 10px !important;
        }
        
        #gstNotIncludedInvoice .ngi-table th,
        #gstNotIncludedInvoice .ngi-table td {
            padding: 5px 8px !important;
            font-size: 11px !important;
        }
        
        #gstNotIncludedInvoice .ngi-footer {
            margin-top: 10px !important;
            padding-top: 10px !important;
        }
        
        /* Compact GST Included invoice for one page */
        #gstIncludedInvoice .gi-top-section,
        #gstIncludedInvoice .gi-from-section,
        #gstIncludedInvoice .gi-header {
            margin-bottom: 8px !important;
        }
        
        #gstIncludedInvoice .gi-table th,
        #gstIncludedInvoice .gi-table td {
            padding: 4px 3px !important;
            font-size: 9px !important;
        }
        
        #gstIncludedInvoice .gi-footer {
            margin-top: 8px !important;
            padding-top: 8px !important;
        }

        .invoice-container, #gstNotIncludedInvoice, #gstIncludedInvoice {
            padding-bottom: 20px !important; 
        }
        
        /* Hide GST Not Included and regular invoice when printing GST Included */
        body.print-gst-included #gstNotIncludedInvoice,
        body.print-gst-included #printableInvoice {
            display: none !important;
        }
        body.print-gst-included #gstIncludedInvoice {
            display: block !important;
        }
        /* Hide GST Included and regular invoice when printing GST Not Included */
        body.print-gst-not-included #printableInvoice,
        body.print-gst-not-included #gstIncludedInvoice {
            display: none !important;
        }
        body.print-gst-not-included #gstNotIncludedInvoice {
            display: block !important;
        }
    }
    
    /* Hide GST Not Included invoice by default on screen */
    #gstNotIncludedInvoice {
        display: none;
    }
</style>

<section class="content-main">
    <div class="container">
        <!-- Header with Back Button and Actions - Outside Card -->
        <div class="order-view-header">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('orders.table') }}" class="back-btn">
                    <i class="bi bi-arrow-left-circle"></i>
                </a>
                <h2 class="mb-0">Order Details</h2>
            </div>
            <div class="action-buttons">
                <a href="{{ route('orders.add-product-page', $order->id) }}" class="btn btn-warning">
                    <i class="bi bi-plus-circle me-1"></i> Add Product
                </a>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#printOptionsModal">
                    <i class="bi bi-printer-fill me-1"></i> Print Invoice
                </button>
                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-success">
                    <i class="bi bi-chat-dots me-1"></i> Comments
                </a>
            </div>
        </div>

        <div class="order-view-container">
            <!-- Invoice Content -->
            <div class="invoice-container" id="printableInvoice">
                <!-- Invoice Header -->
                <div class="invoice-header">
                    <div class="logo">
                        <img src="{{ asset('assets/imgs/theme/ChennaiAngadiLogo.png') }}" alt="Chennai Angadi">
                    </div>
                    <div class="title">
                        <h2>Estimate Invoice</h2>
                    </div>
                    <div class="company-info">
                        <div class="name">Chennai Angadi</div>
                        <div>15/8, Muthu St, Mylapore, Chennai - 4</div>
                        <div>Mobile: +91 90946 76665 | Email:</div>
                        <div>care@chennaiangadi.com</div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="address-section">
                    <!-- Bill To -->
                    <div class="address-box">
                        <div class="label">Bill To</div>
                        @php
                            $billingAddress = $order->billing_address;
                            $customerName = '';
                            $addressLine = '';
                            $mobile = '';
                            
                            if ($order->customer_type === 'registered' && $order->customer) {
                                $customerName = $order->customer->username ?? $order->customer->name ?? 'N/A';
                                $mobile = $order->customer->mobilenumber ?? $order->customer->phone ?? 'N/A';
                            } elseif ($order->customer_type === 'guest' && $order->guest_details) {
                                $customerName = $order->guest_details['first_name'] ?? $order->guest_details['name'] ?? 'Guest';
                                $mobile = $order->guest_details['phone'] ?? $order->guest_details['mobile'] ?? 'N/A';
                            }
                            
                            if ($billingAddress) {
                                $addressParts = [];
                                if (!empty($billingAddress['address'])) $addressParts[] = $billingAddress['address'];
                                if (!empty($billingAddress['city'])) $addressParts[] = $billingAddress['city'];
                                if (!empty($billingAddress['state'])) $addressParts[] = $billingAddress['state'];
                                if (!empty($billingAddress['pincode'])) $addressParts[] = $billingAddress['pincode'];
                                $addressLine = implode(', ', $addressParts);
                            }
                        @endphp
                        <div class="customer-name">{{ $customerName }}</div>
                        <div class="address-details">
                            {{ $addressLine ?: 'N/A' }}<br>
                            Mobile: {{ $mobile }}
                        </div>
                    </div>

                    <!-- Ship To -->
                    <div class="address-box">
                        <div class="label">Ship To</div>
                        @php
                            $shippingAddress = $order->shipping_address ?? $order->billing_address;
                            $shipName = '';
                            $shipAddressLine = '';
                            $shipMobile = '';
                            
                            if ($shippingAddress) {
                                $shipName = $shippingAddress['name'] ?? $customerName;
                                $shipMobile = $shippingAddress['phone'] ?? $shippingAddress['mobile'] ?? $mobile;
                                
                                $shipParts = [];
                                if (!empty($shippingAddress['address'])) $shipParts[] = $shippingAddress['address'];
                                if (!empty($shippingAddress['city'])) $shipParts[] = $shippingAddress['city'];
                                if (!empty($shippingAddress['state'])) $shipParts[] = $shippingAddress['state'];
                                if (!empty($shippingAddress['pincode'])) $shipParts[] = $shippingAddress['pincode'];
                                $shipAddressLine = implode(', ', $shipParts);
                            }
                        @endphp
                        <div class="customer-name">{{ $shipName ?: $customerName }}</div>
                        <div class="address-details">
                            {{ $shipAddressLine ?: $addressLine ?: 'N/A' }}<br>
                            Mobile: {{ $shipMobile ?: $mobile }}
                        </div>
                    </div>

                    <!-- Order Info -->
                    <div class="order-info-box">
                        <div class="order-label">Order ID:</div>
                        <div class="order-id">{{ $order->order_number }}</div>
                        <div class="order-date">Order Date: {{ $order->created_at->format('d-m-Y h:i A') }}</div>
                    </div>
                </div>

                <!-- Items Table -->
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Products</th>
                            <th>Hsn Code</th>
                            <th>Price</th>
                            <th>GST%</th>
                            <th>SGST%</th>
                            <th>IGST%</th>
                            <th>Qty</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $itemSubtotal = 0; 
                            $viewTotalGst = 0;
                            $viewTotalSgst = 0;
                            $viewTotalIgst = 0;
                        @endphp
                        @foreach($order->items as $index => $item)
                            @php 
                                $qty = $item->quantity ?? $item->qty ?? 1;
                                $lineTotal = $item->price * $qty;
                                $itemSubtotal += $lineTotal;
                                
                                // Get tax values from product
                                $product = $item->product;
                                $productHsn = $product->hsn ?? 'N/A';
                                $productGst = $product->gst ?? 0;
                                $productSgst = $product->sgst ?? 0;
                                $productIgst = $product->igst ?? 0;
                                
                                // Calculate tax amounts
                                $gstAmount = ($lineTotal * $productGst) / 100;
                                $sgstAmount = ($lineTotal * $productSgst) / 100;
                                $igstAmount = ($lineTotal * $productIgst) / 100;
                                
                                $viewTotalGst += $gstAmount;
                                $viewTotalSgst += $sgstAmount;
                                $viewTotalIgst += $igstAmount;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    {{ $item->product_productname ?? $item->product->productname ?? 'N/A' }}
                                    @php
                                        $displayVariant = $item->variant->quantity->name ?? $item->variant->quantity->label ?? $item->variant_name;
                                    @endphp
                                    @if($displayVariant) - {{ $displayVariant }} @endif
                                </td>
                                <td>{{ $productHsn }}</td>
                                <td>₹ {{ number_format($item->price, 0) }}</td>
                                <td style="color: #0066cc;">{{ $productGst }}% (₹{{ number_format($gstAmount, 0) }})</td>
                                <td style="color: #0066cc;">{{ $productSgst }}% (₹{{ number_format($sgstAmount, 0) }})</td>
                                <td style="color: #0066cc;">{{ $productIgst }}% (₹{{ number_format($igstAmount, 0) }})</td>
                                <td>{{ $qty }}</td>
                                <td>₹ {{ number_format($lineTotal, 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <!-- Summary rows inside table for alignment -->
                    <tfoot>
                        @if($viewTotalGst > 0)
                        <tr>
                            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #ddd;">GST (CGST)</td>
                            <td style="text-align: center; color: #dc3545; border: 1px solid #ddd;">₹ {{ number_format($viewTotalGst, 2) }}</td>
                        </tr>
                        @endif
                        @if($viewTotalSgst > 0)
                        <tr>
                            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #ddd;">SGST</td>
                            <td style="text-align: center; color: #dc3545; border: 1px solid #ddd;">₹ {{ number_format($viewTotalSgst, 2) }}</td>
                        </tr>
                        @endif
                        @if($viewTotalIgst > 0)
                        <tr>
                            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #ddd;">IGST</td>
                            <td style="text-align: center; color: #dc3545; border: 1px solid #ddd;">₹ {{ number_format($viewTotalIgst, 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #ddd;">Shipping Charges</td>
                            <td style="text-align: center; color: #dc3545; border: 1px solid #ddd;">
                                @if(($order->shipping_amount ?? 0) == 0)
                                    Free
                                @else
                                    ₹ {{ number_format($order->shipping_amount, 0) }}
                                @endif
                            </td>
                        </tr>
                        @if(in_array($order->payment_method, ['cash_on_delivery', 'cod']))
                        <tr>
                            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #ddd;">COD Charges</td>
                            <td style="text-align: center; color: #dc3545; border: 1px solid #ddd;">
                                @if(($order->cod_charge ?? 0) == 0)
                                    Free
                                @else
                                    ₹ {{ number_format($order->cod_charge, 0) }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        @if(($order->discount_amount ?? 0) > 0)
                        <tr>
                            <td colspan="8" style="text-align: right; font-weight: 600; color: #28a745; border: 1px solid #ddd;">Coupon @if($order->coupon_code)({{ $order->coupon_code }})@endif</td>
                            <td style="text-align: center; color: #28a745; border: 1px solid #ddd;">- ₹ {{ number_format($order->discount_amount, 2) }}</td>
                        </tr>
                        @endif
                        @php $viewTotalTax = $viewTotalGst + $viewTotalSgst + $viewTotalIgst; @endphp
                        <tr>
                            <td colspan="8" style="text-align: right; font-weight: bold; font-size: 14px; color: #dc3545; border: 1px solid #ddd; background: #fff8f8;">TOTAL (Incl. GST)</td>
                            <td style="text-align: center; font-weight: bold; font-size: 14px; color: #dc3545; border: 1px solid #ddd; background: #fff8f8;">₹ {{ number_format(($order->final_amount ?? $order->total_amount) + $viewTotalTax, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Footer -->
                <div class="invoice-footer">
                    <p>Thank you for shopping with us and we hope to serve you again in the future</p>
                    <p>Please feel free to write to us at <a href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a> for any queries, suggestions, complaints or anything else.</p>
                </div>
            </div>
        </div>
        
        <!-- GST Not Included Invoice (Hidden, shows only when printing) -->
        <div id="gstNotIncludedInvoice" class="order-view-container" style="padding: 25px;">
            <style>
                #gstNotIncludedInvoice .ngi-top-section { display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 12px; }
                #gstNotIncludedInvoice .ngi-to-section { flex: 1; }
                #gstNotIncludedInvoice .ngi-to-label { color: #333; font-weight: bold; margin-bottom: 3px; }
                #gstNotIncludedInvoice .ngi-customer-name { font-weight: 600; font-size: 13px; }
                #gstNotIncludedInvoice .ngi-address-line { color: #333; line-height: 1.5; }
                #gstNotIncludedInvoice .ngi-order-box { border-left: 1px dashed #999; padding-left: 15px; text-align: left; }
                #gstNotIncludedInvoice .ngi-order-id-label { font-size: 11px; color: #666; }
                #gstNotIncludedInvoice .ngi-order-id { font-weight: bold; font-size: 14px; color: #000; }
                #gstNotIncludedInvoice .ngi-state { font-size: 11px; color: #333; margin-top: 3px; }
                #gstNotIncludedInvoice .ngi-from-section { font-size: 12px; padding: 10px 0; border-bottom: 1px dashed #999; margin-bottom: 15px; }
                #gstNotIncludedInvoice .ngi-from-label { font-weight: bold; }
                #gstNotIncludedInvoice .ngi-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
                #gstNotIncludedInvoice .ngi-logo img { height: 50px; width: auto; }
                #gstNotIncludedInvoice .ngi-title { text-align: center; flex: 1; }
                #gstNotIncludedInvoice .ngi-title h3 { font-size: 18px; font-weight: bold; margin: 0; text-transform: uppercase; }
                #gstNotIncludedInvoice .ngi-company { text-align: right; font-size: 11px; line-height: 1.4; }
                #gstNotIncludedInvoice .ngi-company-name { font-weight: 600; font-size: 12px; }
                #gstNotIncludedInvoice .ngi-table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
                #gstNotIncludedInvoice .ngi-table th { background: #f0f0f0; border: 1px solid #999; padding: 8px 10px; font-size: 11px; font-weight: bold; text-align: center; }
                #gstNotIncludedInvoice .ngi-table th:nth-child(2) { text-align: left; }
                #gstNotIncludedInvoice .ngi-table td { border: 1px solid #999; padding: 8px 10px; font-size: 12px; text-align: center; }
                #gstNotIncludedInvoice .ngi-table td:nth-child(2) { text-align: left; }
                #gstNotIncludedInvoice .ngi-summary-row { display: flex; justify-content: space-between; border: 1px solid #999; border-top: none; font-size: 12px; }
                #gstNotIncludedInvoice .ngi-summary-row .label { padding: 8px 10px; flex: 1; font-weight: 600; color: #dc3545; }
                #gstNotIncludedInvoice .ngi-summary-row .amount { padding: 8px 10px; width: 100px; text-align: right; border-left: 1px solid #999; color: #dc3545; }
                #gstNotIncludedInvoice .ngi-total-row { font-size: 14px; font-weight: bold; }
                #gstNotIncludedInvoice .ngi-total-row .amount { font-weight: bold; }
                #gstNotIncludedInvoice .ngi-footer { margin-top: 20px; text-align: center; font-size: 11px; color: #333; line-height: 1.6; border-top: 1px dashed #999; padding-top: 15px; }
                #gstNotIncludedInvoice .ngi-footer a { color: #dc3545; text-decoration: none; }
            </style>
            
            <!-- Top Section -->
            <div class="ngi-top-section">
                <div class="ngi-to-section">
                    <div class="ngi-to-label">To,</div>
                    @php
                        $shippingAddress = $order->shipping_address ?? $order->billing_address;
                        $customerName = '';
                        $addressLine = '';
                        $mobile = '';
                        
                        if ($shippingAddress) {
                            $customerName = $shippingAddress['name'] ?? '';
                            $addressParts = [];
                            if (!empty($shippingAddress['address'])) $addressParts[] = $shippingAddress['address'];
                            if (!empty($shippingAddress['city'])) $addressParts[] = $shippingAddress['city'];
                            if (!empty($shippingAddress['state'])) $addressParts[] = $shippingAddress['state'];
                            if (!empty($shippingAddress['pincode'])) $addressParts[] = $shippingAddress['pincode'];
                            $addressLine = implode(', ', $addressParts);
                            $mobile = $shippingAddress['phone'] ?? $shippingAddress['mobile'] ?? '';
                        }
                        
                        // Fallback
                        if (empty($customerName)) {
                            $customerName = ($order->customer_type === 'registered' && $order->customer) ? ($order->customer->username ?? $order->customer->name) : ($order->guest_details['first_name'] ?? $order->guest_details['name'] ?? 'Guest');
                        }
                        if (empty($mobile)) {
                            $mobile = ($order->customer_type === 'registered' && $order->customer) ? ($order->customer->mobilenumber ?? $order->customer->phone) : ($order->guest_details['phone'] ?? $order->guest_details['mobile'] ?? 'N/A');
                        }
                        if (empty($addressLine) && $order->billing_address) {
                            $addressParts = [];
                            if (!empty($order->billing_address['address'])) $addressParts[] = $order->billing_address['address'];
                            if (!empty($order->billing_address['city'])) $addressParts[] = $order->billing_address['city'];
                            if (!empty($order->billing_address['state'])) $addressParts[] = $order->billing_address['state'];
                            if (!empty($order->billing_address['pincode'])) $addressParts[] = $order->billing_address['pincode'];
                            $addressLine = implode(', ', $addressParts);
                        }
                    @endphp
                    <div class="ngi-customer-name">{{ $customerName }}</div>
                    <div class="ngi-address-line">
                        {{ $addressLine ?: 'N/A' }}<br>
                        Mobile: {{ $mobile }}
                    </div>
                </div>
                <div class="ngi-order-box">
                    <div class="ngi-order-id-label">Order ID</div>
                    <div class="ngi-order-id">{{ $order->order_number }}</div>
                    <div class="ngi-state">{{ $order->billing_address['state'] ?? 'Tamil Nadu' }}</div>
                    <div class="ngi-state">Order Date: {{ $order->created_at->format('d-m-Y h:i A') }}</div>
                </div>
            </div>
            
            <!-- From Section -->
            <div class="ngi-from-section">
                <span class="ngi-from-label">From,</span><br>
                Chennai Angadi, New #15/Old #8, Muthu Street, Mylapore, Chennai - 4, Mobile: +91 90946 76665
            </div>
            
            <!-- Header -->
            <div class="ngi-header">
                <div class="ngi-logo">
                    <img src="{{ asset('assets/imgs/theme/ChennaiAngadiLogo.png') }}" alt="Chennai Angadi">
                </div>
                <div class="ngi-title">
                    <h3>Estimate Invoice</h3>
                </div>
                <div class="ngi-company">
                    <div class="ngi-company-name">Chennai Angadi</div>
                    <div>15/8, Muthu St, Mylapore, Chennai 4</div>
                    <div>Mobile: +91 90946 76665 | Email: care@chennaiangadi.com</div>
                </div>
            </div>
            
            <!-- Products Table -->
            <table class="ngi-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">S.NO.</th>
                        <th>PRODUCTS</th>
                        <th style="width: 80px;">PRICE</th>
                        <th style="width: 50px;">QTY</th>
                        <th style="width: 100px;">SUB TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @php $ngiSubtotal = 0; @endphp
                    @foreach($order->items as $index => $item)
                        @php 
                            $qty = $item->quantity ?? $item->qty ?? 1;
                            $lineTotal = $item->price * $qty;
                            $ngiSubtotal += $lineTotal;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{ $item->product_productname ?? $item->product->productname ?? 'N/A' }} 
                                @php
                                    $displayVariant = $item->variant->quantity->name ?? $item->variant->quantity->label ?? $item->variant_name;
                                @endphp
                                @if($displayVariant) - {{ $displayVariant }} @endif
                            </td>
                            <td>₹ {{ number_format($item->price, 0) }}</td>
                            <td>{{ $qty }}</td>
                            <td>₹ {{ number_format($lineTotal, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Summary -->
            <div class="ngi-summary-row">
                <span class="label">Shipping Charges</span>
                <span class="amount">
                    @if(($order->shipping_amount ?? 0) == 0)
                        Free
                    @else
                        ₹ {{ number_format($order->shipping_amount, 0) }}
                    @endif
                </span>
            </div>
            @if(in_array($order->payment_method, ['cash_on_delivery', 'cod']))
            <div class="ngi-summary-row">
                <span class="label">COD Charges</span>
                <span class="amount">
                    @if(($order->cod_charge ?? 0) == 0)
                        Free
                    @else
                        ₹ {{ number_format($order->cod_charge, 0) }}
                    @endif
                </span>
            </div>
            @endif
            @if(($order->discount_amount ?? 0) > 0)
            <div class="ngi-summary-row">
                <span class="label" style="color: #28a745 !important;">Coupon @if($order->coupon_code)({{ $order->coupon_code }})@endif</span>
                <span class="amount" style="color: #28a745 !important;">- ₹ {{ number_format($order->discount_amount, 2) }}</span>
            </div>
            @endif
            <div class="ngi-summary-row ngi-total-row">
                <span class="label">TOTAL</span>
                <span class="amount">₹ {{ number_format($order->final_amount ?? $order->total_amount, 2) }}</span>
            </div>
            
            <!-- Footer -->
            <div class="ngi-footer">
                <p>Thank you for shopping with us and we hope to serve you again in the future</p>
                <p>Please feel free to write to us at <a href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a> for any queries, suggestions, complaints or anything else.</p>
            </div>
        </div>
        
        <!-- GST Included Invoice (Hidden, shows only when printing GST Included) -->
        <div id="gstIncludedInvoice" class="order-view-container" style="padding: 25px;">
            <style>
                #gstIncludedInvoice { display: none; }
                #gstIncludedInvoice .gi-top-section { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 11px; }
                #gstIncludedInvoice .gi-to-section { flex: 1; }
                #gstIncludedInvoice .gi-to-label { color: #333; font-weight: bold; margin-bottom: 2px; }
                #gstIncludedInvoice .gi-customer-name { font-weight: 600; font-size: 12px; }
                #gstIncludedInvoice .gi-address-line { color: #333; line-height: 1.4; font-size: 11px; }
                #gstIncludedInvoice .gi-order-box { border-left: 1px dashed #999; padding-left: 12px; text-align: left; }
                #gstIncludedInvoice .gi-order-id-label { font-size: 10px; color: #666; }
                #gstIncludedInvoice .gi-order-id { font-weight: bold; font-size: 13px; color: #000; }
                #gstIncludedInvoice .gi-state { font-size: 10px; color: #333; margin-top: 2px; }
                #gstIncludedInvoice .gi-from-section { font-size: 11px; padding: 8px 0; border-bottom: 1px dashed #999; margin-bottom: 12px; }
                #gstIncludedInvoice .gi-from-label { font-weight: bold; }
                #gstIncludedInvoice .gi-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
                #gstIncludedInvoice .gi-logo img { height: 40px; width: auto; }
                #gstIncludedInvoice .gi-title { text-align: center; flex: 1; }
                #gstIncludedInvoice .gi-title h3 { font-size: 16px; font-weight: bold; margin: 0; text-transform: uppercase; }
                #gstIncludedInvoice .gi-company { text-align: right; font-size: 10px; line-height: 1.3; }
                #gstIncludedInvoice .gi-company-name { font-weight: 600; font-size: 11px; }
                #gstIncludedInvoice .gi-table { width: 100%; border-collapse: collapse; margin-bottom: 0; font-size: 10px; table-layout: fixed; }
                #gstIncludedInvoice .gi-table th { background: #f0f0f0; border: 1px solid #999; padding: 5px 4px; font-size: 9px; font-weight: bold; text-align: center; white-space: nowrap; }
                #gstIncludedInvoice .gi-table td { border: 1px solid #999; padding: 5px 4px; font-size: 10px; text-align: center; white-space: nowrap; }
                #gstIncludedInvoice .gi-table td.product-name { text-align: left; white-space: normal; }
                #gstIncludedInvoice .gi-summary-row { display: flex; justify-content: space-between; border: 1px solid #999; border-top: none; font-size: 11px; }
                #gstIncludedInvoice .gi-summary-row .label { padding: 6px 8px; flex: 1; font-weight: 600; color: #dc3545; }
                #gstIncludedInvoice .gi-summary-row .amount { padding: 6px 8px; width: 80px; text-align: right; border-left: 1px solid #999; color: #dc3545; }
                #gstIncludedInvoice .gi-total-row { font-size: 12px; font-weight: bold; }
                #gstIncludedInvoice .gi-footer { margin-top: 15px; text-align: center; font-size: 10px; color: #333; line-height: 1.5; border-top: 1px dashed #999; padding-top: 10px; }
                #gstIncludedInvoice .gi-footer a { color: #dc3545; text-decoration: none; }
                #gstIncludedInvoice .gst-highlight { color: #0066cc; font-weight: 600; }
            </style>
            
            <!-- Top Section -->
            <div class="gi-top-section">
                <div class="gi-to-section">
                    <div class="gi-to-label">To,</div>
                    @php
                        // Already defined above but ensuring for safety in this scope if needed 
                        // Actually in the same file/request context
                        $shippingAddress = $order->shipping_address ?? $order->billing_address;
                        $customerName = '';
                        $addressLine = '';
                        $mobile = '';
                        
                        if ($shippingAddress) {
                            $customerName = $shippingAddress['name'] ?? '';
                            $addressParts = [];
                            if (!empty($shippingAddress['address'])) $addressParts[] = $shippingAddress['address'];
                            if (!empty($shippingAddress['city'])) $addressParts[] = $shippingAddress['city'];
                            if (!empty($shippingAddress['state'])) $addressParts[] = $shippingAddress['state'];
                            if (!empty($shippingAddress['pincode'])) $addressParts[] = $shippingAddress['pincode'];
                            $addressLine = implode(', ', $addressParts);
                            $mobile = $shippingAddress['phone'] ?? $shippingAddress['mobile'] ?? '';
                        }
                        
                        // Fallback
                        if (empty($customerName)) {
                            $customerName = ($order->customer_type === 'registered' && $order->customer) ? ($order->customer->username ?? $order->customer->name) : ($order->guest_details['first_name'] ?? $order->guest_details['name'] ?? 'Guest');
                        }
                        if (empty($mobile)) {
                            $mobile = ($order->customer_type === 'registered' && $order->customer) ? ($order->customer->mobilenumber ?? $order->customer->phone) : ($order->guest_details['phone'] ?? $order->guest_details['mobile'] ?? 'N/A');
                        }
                        if (empty($addressLine) && $order->billing_address) {
                            $addressParts = [];
                            if (!empty($order->billing_address['address'])) $addressParts[] = $order->billing_address['address'];
                            if (!empty($order->billing_address['city'])) $addressParts[] = $order->billing_address['city'];
                            if (!empty($order->billing_address['state'])) $addressParts[] = $order->billing_address['state'];
                            if (!empty($order->billing_address['pincode'])) $addressParts[] = $order->billing_address['pincode'];
                            $addressLine = implode(', ', $addressParts);
                        }
                    @endphp
                    <div class="gi-customer-name">{{ $customerName }}</div>
                    <div class="gi-address-line">
                        {{ $addressLine ?: 'N/A' }}<br>
                        Mobile: {{ $mobile }}
                    </div>
                </div>
                <div class="gi-order-box">
                    <div class="gi-order-id-label">Order ID</div>
                    <div class="gi-order-id">{{ $order->order_number }}</div>
                    <div class="gi-state">{{ $order->billing_address['state'] ?? 'Tamil Nadu' }}</div>
                    <div class="gi-state">Order Date: {{ $order->created_at->format('d-m-Y h:i A') }}</div>
                </div>
            </div>
            
            <!-- From Section -->
            <div class="gi-from-section">
                <span class="gi-from-label">From,</span><br>
                Chennai Angadi, New #15/Old #8, Muthu Street, Mylapore, Chennai - 4, Mobile: +91 90946 76665
            </div>
            
            <!-- Header -->
            <div class="gi-header">
                <div class="gi-logo">
                    <img src="{{ asset('assets/imgs/theme/ChennaiAngadiLogo.png') }}" alt="Chennai Angadi">
                </div>
                <div class="gi-title">
                    <h3>ESTIMATE INVOICE</h3>
                </div>
                <div class="gi-company">
                    <div class="gi-company-name">Chennai Angadi</div>
                    <div>15/8, Muthu St, Mylapore, Chennai 4</div>
                    <div>Mobile: +91 90946 76665 | Email: care@chennaiangadi.com</div>
                </div>
            </div>
            
            <!-- Products Table with GST -->
            @php 
                $giSubtotal = 0; 
                $totalGst = 0;
                $totalSgst = 0;
                $totalIgst = 0;
            @endphp
            <table class="gi-table">
                <thead>
                    <tr>
                        <th style="width: 6%;">S.NO.</th>
                        <th style="width: 22%;">PRODUCTS</th>
                        <th style="width: 8%;">Hsn Code</th>
                        <th style="width: 8%;">PRICE</th>
                        <th style="width: 12%;">GST%</th>
                        <th style="width: 12%;">SGST%</th>
                        <th style="width: 12%;">IGST%</th>
                        <th style="width: 6%;">QTY</th>
                        <th style="width: 14%;">SUB TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $index => $item)
                        @php 
                            $qty = $item->quantity ?? $item->qty ?? 1;
                            $lineTotal = $item->price * $qty;
                            $giSubtotal += $lineTotal;
                            
                            // Get tax values from product
                            $product = $item->product;
                            $productHsn = $product->hsn ?? 'N/A';
                            $productGst = $product->gst ?? 0;
                            $productSgst = $product->sgst ?? 0;
                            $productIgst = $product->igst ?? 0;
                            
                            // Calculate tax amounts for this line
                            $gstAmount = ($lineTotal * $productGst) / 100;
                            $sgstAmount = ($lineTotal * $productSgst) / 100;
                            $igstAmount = ($lineTotal * $productIgst) / 100;
                            
                            $totalGst += $gstAmount;
                            $totalSgst += $sgstAmount;
                            $totalIgst += $igstAmount;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="product-name">
                                {{ $item->product_productname ?? $item->product->productname ?? 'N/A' }}
                                @php
                                    $displayVariant = $item->variant_name;
                                    if ($item->variant && $item->variant->quantity) {
                                        $displayVariant = $item->variant->quantity->name ?? $item->variant->quantity->label ?? $item->variant_name;
                                    }
                                @endphp
                                @if($displayVariant) - {{ $displayVariant }} @endif
                            </td>
                            <td>{{ $productHsn }}</td>
                            <td>₹{{ number_format($item->price, 0) }}</td>
                            <td class="gst-highlight">{{ $productGst }}% (₹{{ number_format($gstAmount, 0) }})</td>
                            <td class="gst-highlight">{{ $productSgst }}% (₹{{ number_format($sgstAmount, 0) }})</td>
                            <td class="gst-highlight">{{ $productIgst }}% (₹{{ number_format($igstAmount, 0) }})</td>
                            <td>{{ $qty }}</td>
                            <td>₹ {{ number_format($lineTotal, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <!-- Summary rows inside table for alignment -->
                <tfoot>
                    @if($totalGst > 0)
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">GST (CGST)</td>
                        <td style="text-align: center; color: #dc3545; border: 1px solid #999;">₹ {{ number_format($totalGst, 2) }}</td>
                    </tr>
                    @endif
                    @if($totalSgst > 0)
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">SGST</td>
                        <td style="text-align: center; color: #dc3545; border: 1px solid #999;">₹ {{ number_format($totalSgst, 2) }}</td>
                    </tr>
                    @endif
                    @if($totalIgst > 0)
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">IGST</td>
                        <td style="text-align: center; color: #dc3545; border: 1px solid #999;">₹ {{ number_format($totalIgst, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">Shipping Charges</td>
                        <td style="text-align: center; color: #dc3545; border: 1px solid #999;">
                            @if(($order->shipping_amount ?? 0) == 0)
                                Free
                            @else
                                ₹ {{ number_format($order->shipping_amount, 0) }}
                            @endif
                        </td>
                    </tr>
                    @if(in_array($order->payment_method, ['cash_on_delivery', 'cod']))
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">COD Charges</td>
                        <td style="text-align: center; color: #dc3545; border: 1px solid #999;">
                            @if(($order->cod_charge ?? 0) == 0)
                                Free
                            @else
                                ₹ {{ number_format($order->cod_charge, 0) }}
                            @endif
                        </td>
                    </tr>
                    @endif
                    @if(($order->discount_amount ?? 0) > 0)
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: 600; color: #28a745; border: 1px solid #999;">Coupon @if($order->coupon_code)({{ $order->coupon_code }})@endif</td>
                        <td style="text-align: center; color: #28a745; border: 1px solid #999;">- ₹ {{ number_format($order->discount_amount, 2) }}</td>
                    </tr>
                    @endif
                    @php $totalTax = $totalGst + $totalSgst + $totalIgst; @endphp
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: bold; font-size: 12px; color: #dc3545; border: 1px solid #999;">TOTAL (Incl. GST)</td>
                        <td style="text-align: center; font-weight: bold; font-size: 12px; color: #dc3545; border: 1px solid #999;">₹ {{ number_format(($order->final_amount ?? $order->total_amount) + $totalTax, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
            
            <!-- Footer -->
            <div class="gi-footer">
                <p>Thank you for shopping with us and we hope to serve you again in the future</p>
                <p>Please feel free to write to us at <a href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a> for any queries, suggestions, complaints or anything else.</p>
            </div>
        </div>
    </div>
</section>

<!-- Comments Modal -->
<div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="commentsModalLabel">
                    <i class="bi bi-chat-dots me-1"></i> Comments - <span id="modalOrderNumber"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="commentsForm">
                <div class="modal-body">
                    <input type="hidden" id="commentOrderId" name="order_id">
                    <div class="mb-3">
                        <label for="commentStatus" class="form-label"><strong>Status</strong></label>
                        <select class="form-select" id="commentStatus" name="status">
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="packed">Packed</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="commentNotes" class="form-label"><strong>Notes</strong></label>
                        <textarea class="form-control" id="commentNotes" name="notes" rows="10" required></textarea>
                        <div class="invalid-feedback">Notes cannot be empty.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveCommentsBtn">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        Save Notes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="addProductModalLabel">
                    <i class="bi bi-plus-circle me-1"></i> Add Products to Order
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Search Input -->
                <div class="mb-3">
                    <label for="productSearch" class="form-label"><strong>Search Product</strong></label>
                    <input type="text" class="form-control" id="productSearch" placeholder="Type product name to search..." autocomplete="off">
                </div>
                
                <!-- Search Results Table -->
                <div id="searchResultsContainer" style="display: none;">
                    <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                        <table class="table table-bordered table-hover table-sm" id="productResultsTable">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th style="width: 40px;"></th>
                                    <th>Product</th>
                                    <th>Variant (Gram)</th>
                                    <th>Price (₹)</th>
                                    <th style="width: 100px;">Quantity</th>
                                </tr>
                            </thead>
                            <tbody id="productResultsBody">
                                <!-- Results will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- No Results Message -->
                <div id="noResultsMessage" class="text-center text-muted py-3" style="display: none;">
                    <i class="bi bi-search"></i> No products found. Try a different search term.
                </div>
                
                <!-- Selected Products Section -->
                <div id="selectedProductsSection" style="display: none;">
                    <hr class="my-3">
                    <h6 class="mb-3"><i class="bi bi-cart-check"></i> Selected Products (<span id="selectedCount">0</span>)</h6>
                    <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                        <table class="table table-bordered table-sm" id="selectedProductsTable">
                            <thead class="table-success">
                                <tr>
                                    <th>Product</th>
                                    <th>Variant</th>
                                    <th>Price (₹)</th>
                                    <th>Qty</th>
                                    <th>Total (₹)</th>
                                    <th style="width: 40px;"></th>
                                </tr>
                            </thead>
                            <tbody id="selectedProductsBody">
                            </tbody>
                            <tfoot class="table-warning">
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                                    <td><strong id="grandTotal">₹ 0.00</strong></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" id="addProductsBtn" disabled>
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    <i class="bi bi-plus-circle me-1"></i> Add Selected Products
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Print Options Modal -->
<div class="modal fade" id="printOptionsModal" tabindex="-1" aria-labelledby="printOptionsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 320px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-body p-0">
                <!-- Header Section -->
                <div class="text-center py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="mb-2">
                        <i class="bi bi-printer-fill text-white" style="font-size: 32px;"></i>
                    </div>
                    <h5 class="text-white mb-0 fw-semibold">Print Invoice</h5>
                    <small class="text-white-50">Select invoice type</small>
                </div>
                
                <!-- Options Section -->
                <div class="p-4">
                    <button type="button" class="btn w-100 mb-3 py-3 d-flex align-items-center justify-content-center" id="printGstIncluded" 
                        style="background: #f0fdf4; border: 2px solid #22c55e; border-radius: 10px; color: #166534; font-weight: 600; transition: all 0.2s;">
                        <i class="bi bi-receipt-cutoff me-2" style="font-size: 20px;"></i>
                        GST Included
                    </button>
                    <button type="button" class="btn w-100 py-3 d-flex align-items-center justify-content-center" id="printGstNotIncluded"
                        style="background: #fefce8; border: 2px solid #eab308; border-radius: 10px; color: #854d0e; font-weight: 600; transition: all 0.2s;">
                        <i class="bi bi-receipt me-2" style="font-size: 20px;"></i>
                        GST Not Included
                    </button>
                </div>
                
                <!-- Cancel Link -->
                <div class="text-center pb-4">
                    <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const commentsBtn = document.getElementById('commentsBtn');
    const commentsModalEl = document.getElementById('commentsModal');
    const commentsForm = document.getElementById('commentsForm');
    const commentOrderIdInput = document.getElementById('commentOrderId');
    const commentNotesTextarea = document.getElementById('commentNotes');
    const commentStatusSelect = document.getElementById('commentStatus');
    const saveCommentsBtn = document.getElementById('saveCommentsBtn');

    // Only attach comments functionality if elements exist
    if (commentsBtn && commentsModalEl) {
        const commentsModal = new bootstrap.Modal(commentsModalEl);
        
        // Open comments modal
        commentsBtn.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            const orderNumber = this.dataset.orderNumber;
        const existingNotes = this.dataset.notes;
        const existingStatus = this.dataset.status;

        commentOrderIdInput.value = orderId;
        document.getElementById('modalOrderNumber').textContent = orderNumber;
        commentNotesTextarea.value = existingNotes || '';
        commentStatusSelect.value = existingStatus || 'pending';
        commentNotesTextarea.classList.remove('is-invalid');

        commentsModal.show();
    });

    // Handle form submission
    commentsForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const orderId = commentOrderIdInput.value;
        const notes = commentNotesTextarea.value.trim();
        const status = commentStatusSelect.value;

        if (!notes) {
            commentNotesTextarea.classList.add('is-invalid');
            return;
        }

        commentNotesTextarea.classList.remove('is-invalid');
        saveCommentsBtn.disabled = true;
        saveCommentsBtn.querySelector('.spinner-border').classList.remove('d-none');

        fetch(`{{ url('orders/update-notes') }}/${orderId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ notes: notes, status: status })
        })
        .then(response => response.json())
        .then(data => {
            saveCommentsBtn.disabled = false;
            saveCommentsBtn.querySelector('.spinner-border').classList.add('d-none');

            if (data.success) {
                // Update button data attributes
                commentsBtn.dataset.notes = data.notes;
                commentsBtn.dataset.status = data.status;

                commentsModal.hide();

                if (typeof toastr !== 'undefined') {
                    toastr.success(data.message);
                } else {
                    alert(data.message);
                }
            } else {
                if (typeof toastr !== 'undefined') {
                    toastr.error(data.message);
                } else {
                    alert('Error: ' + data.message);
                }
            }
        })
        .catch(error => {
            saveCommentsBtn.disabled = false;
            saveCommentsBtn.querySelector('.spinner-border').classList.add('d-none');
            console.error('Error:', error);
            if (typeof toastr !== 'undefined') {
                toastr.error('An error occurred while saving notes.');
            } else {
                alert('An error occurred while saving notes.');
            }
        });
    });
    } // End of if (commentsBtn && commentsModalEl)

    // =============================================
    // Add Product Modal - Multi-Select with Quantities
    // ==============================================
    const productSearch = document.getElementById('productSearch');
    const searchResultsContainer = document.getElementById('searchResultsContainer');
    const productResultsBody = document.getElementById('productResultsBody');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const selectedProductsSection = document.getElementById('selectedProductsSection');
    const selectedProductsBody = document.getElementById('selectedProductsBody');
    const selectedCount = document.getElementById('selectedCount');
    const grandTotal = document.getElementById('grandTotal');
    const addProductsBtn = document.getElementById('addProductsBtn');
    
    // Store selected products
    let selectedProducts = [];
    
    let searchTimeout;
    
    // Update selected products display
    function updateSelectedProductsDisplay() {
        selectedProductsBody.innerHTML = '';
        let total = 0;
        
        selectedProducts.forEach((item, index) => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.productName}</td>
                <td>${item.variantName}</td>
                <td>₹ ${parseFloat(item.price).toFixed(2)}</td>
                <td>${item.quantity}</td>
                <td>₹ ${parseFloat(itemTotal).toFixed(2)}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger remove-item btn-action-col d-inline-flex align-items-center justify-content-center " data-index="${index}"><i class="bi bi-trash me-1"></i> Delete</button>
                </td>
            `;
            selectedProductsBody.appendChild(row);
        });
        
        selectedCount.textContent = selectedProducts.length;
        grandTotal.textContent = '₹ ' + parseFloat(total).toFixed(2);
        
        if (selectedProducts.length > 0) {
            selectedProductsSection.style.display = 'block';
            addProductsBtn.disabled = false;
        } else {
            selectedProductsSection.style.display = 'none';
            addProductsBtn.disabled = true;
        }
        
        // Add remove item handlers
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.dataset.index);
                selectedProducts.splice(index, 1);
                updateSelectedProductsDisplay();
                updateCheckboxStates();
            });
        });
    }
    
    // Update checkbox states based on selected products
    function updateCheckboxStates() {
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            const key = checkbox.dataset.productId + '-' + checkbox.dataset.variantId;
            const isSelected = selectedProducts.some(p => (p.productId + '-' + p.variantId) === key);
            checkbox.checked = isSelected;
        });
    }
    
    // Add product to selection
    function addProductToSelection(productId, productName, variantId, variantName, price, quantity) {
        const key = productId + '-' + variantId;
        const existingIndex = selectedProducts.findIndex(p => (p.productId + '-' + p.variantId) === key);
        
        if (existingIndex >= 0) {
            // Update quantity if already exists
            selectedProducts[existingIndex].quantity = quantity;
        } else {
            // Add new product
            selectedProducts.push({
                productId,
                productName,
                variantId,
                variantName,
                price: parseFloat(price),
                quantity: parseInt(quantity)
            });
        }
        updateSelectedProductsDisplay();
    }
    
    // Remove product from selection
    function removeProductFromSelection(productId, variantId) {
        const key = productId + '-' + variantId;
        selectedProducts = selectedProducts.filter(p => (p.productId + '-' + p.variantId) !== key);
        updateSelectedProductsDisplay();
    }
    
    if (productSearch) {
        productSearch.addEventListener('input', function() {
            const query = this.value.trim();
            
            clearTimeout(searchTimeout);
            
            if (query.length < 2) {
                searchResultsContainer.style.display = 'none';
                noResultsMessage.style.display = 'none';
                return;
            }
            
            // Show loading indicator
            noResultsMessage.innerHTML = '<i class="bi bi-hourglass-split"></i> Searching...';
            noResultsMessage.style.display = 'block';
            searchResultsContainer.style.display = 'none';
            
            // Debounce search
            searchTimeout = setTimeout(() => {
                const searchUrl = `{{ url('orders/search-products') }}?query=${encodeURIComponent(query)}`;
                
                fetch(searchUrl, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    productResultsBody.innerHTML = '';
                    
                    if (data.success && data.products && data.products.length > 0) {
                        noResultsMessage.style.display = 'none';
                        searchResultsContainer.style.display = 'block';
                        
                        data.products.forEach(product => {
                            if (product.variants && product.variants.length > 0) {
                                product.variants.forEach(variant => {
                                    const isOutOfStock = variant.is_out_of_stock;
                                    const key = product.id + '-' + variant.id;
                                    const isSelected = selectedProducts.some(p => (p.productId + '-' + p.variantId) === key);
                                    
                                    const row = document.createElement('tr');
                                    if (isOutOfStock) {
                                        row.style.opacity = '0.5';
                                        row.style.backgroundColor = '#f8f8f8';
                                    }
                                    
                                    const stockBadge = isOutOfStock 
                                        ? '<span class="badge bg-danger ms-2">Out of Stock</span>' 
                                        : '<span class="badge bg-success ms-2">In Stock</span>';
                                    
                                    row.innerHTML = `
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input product-checkbox"
                                                data-product-id="${product.id}"
                                                data-product-name="${product.productname}"
                                                data-variant-id="${variant.id}"
                                                data-variant-name="${variant.quantity_name || 'Default'}"
                                                data-price="${variant.sell_price}"
                                                ${isOutOfStock ? 'disabled' : ''}
                                                ${isSelected ? 'checked' : ''}>
                                        </td>
                                        <td>${product.productname}</td>
                                        <td>${variant.quantity_name || 'Default'}${stockBadge}</td>
                                        <td>₹ ${parseFloat(variant.sell_price).toFixed(2)}</td>
                                        <td>
                                            <input type="number" class="form-control form-control-sm qty-input" 
                                                value="1" min="1" max="999" style="width: 70px;"
                                                data-product-id="${product.id}"
                                                data-variant-id="${variant.id}"
                                                ${isOutOfStock ? 'disabled' : ''}>
                                        </td>
                                    `;
                                    productResultsBody.appendChild(row);
                                });
                            } else {
                                // Product without variants
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input product-checkbox"
                                            data-product-id="${product.id}"
                                            data-product-name="${product.productname}"
                                            data-variant-id=""
                                            data-variant-name="Default"
                                            data-price="${product.sell_price || 0}">
                                    </td>
                                    <td>${product.productname}</td>
                                    <td>Default</td>
                                    <td>₹ ${parseFloat(product.sell_price || 0).toFixed(2)}</td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm qty-input" 
                                            value="1" min="1" max="999" style="width: 70px;"
                                            data-product-id="${product.id}"
                                            data-variant-id="">
                                    </td>
                                `;
                                productResultsBody.appendChild(row);
                            }
                        });
                        
                        // Add checkbox change handlers
                        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                            checkbox.addEventListener('change', function() {
                                const row = this.closest('tr');
                                const qtyInput = row.querySelector('.qty-input');
                                const productId = this.dataset.productId;
                                const productName = this.dataset.productName;
                                const variantId = this.dataset.variantId;
                                const variantName = this.dataset.variantName;
                                const price = this.dataset.price;
                                const quantity = parseInt(qtyInput.value) || 1;
                                
                                if (this.checked) {
                                    addProductToSelection(productId, productName, variantId, variantName, price, quantity);
                                } else {
                                    removeProductFromSelection(productId, variantId);
                                }
                            });
                        });
                        
                        // Add quantity change handlers
                        document.querySelectorAll('.qty-input').forEach(input => {
                            input.addEventListener('change', function() {
                                const row = this.closest('tr');
                                const checkbox = row.querySelector('.product-checkbox');
                                if (checkbox.checked) {
                                    const productId = checkbox.dataset.productId;
                                    const productName = checkbox.dataset.productName;
                                    const variantId = checkbox.dataset.variantId;
                                    const variantName = checkbox.dataset.variantName;
                                    const price = checkbox.dataset.price;
                                    const quantity = parseInt(this.value) || 1;
                                    addProductToSelection(productId, productName, variantId, variantName, price, quantity);
                                }
                            });
                        });
                    } else {
                        searchResultsContainer.style.display = 'none';
                        noResultsMessage.innerHTML = '<i class="bi bi-search"></i> No products found. Try a different search term.';
                        noResultsMessage.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error searching products:', error);
                    searchResultsContainer.style.display = 'none';
                    noResultsMessage.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Error searching. Please try again.';
                    noResultsMessage.style.display = 'block';
                });
            }, 300);
        });
    }
    
    // Handle Add Products Button Click
    if (addProductsBtn) {
        addProductsBtn.addEventListener('click', function() {
            if (selectedProducts.length === 0) {
                alert('Please select at least one product.');
                return;
            }
            
            const spinner = this.querySelector('.spinner-border');
            this.disabled = true;
            spinner.classList.remove('d-none');
            
            fetch('{{ route('orders.add-products', $order->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ products: selectedProducts })
            })
            .then(response => response.json())
            .then(data => {
                this.disabled = false;
                spinner.classList.add('d-none');
                
                if (data.success) {
                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById('addProductModal')).hide();
                    
                    // Show success message
                    if (typeof toastr !== 'undefined') {
                        toastr.success(data.message || 'Products added successfully!');
                    } else {
                        alert(data.message || 'Products added successfully!');
                    }
                    
                    // Reload page to show updated order
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(data.message || 'Failed to add products');
                    } else {
                        alert('Error: ' + (data.message || 'Failed to add products'));
                    }
                }
            })
            .catch(error => {
                this.disabled = false;
                spinner.classList.add('d-none');
                console.error('Error:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('An error occurred while adding products.');
                } else {
                    alert('An error occurred while adding products.');
                }
            });
        });
    }
    
    // Reset modal when closed
    document.getElementById('addProductModal').addEventListener('hidden.bs.modal', function() {
        productSearch.value = '';
        productResultsBody.innerHTML = '';
        searchResultsContainer.style.display = 'none';
        noResultsMessage.style.display = 'none';
        selectedProductsSection.style.display = 'none';
        selectedProducts = [];
        updateSelectedProductsDisplay();
    });

    // =============================================
    // Print Options Modal Handlers
    // =============================================
    const printGstIncludedBtn = document.getElementById('printGstIncluded');
    const printGstNotIncludedBtn = document.getElementById('printGstNotIncluded');
    const printOptionsModalEl = document.getElementById('printOptionsModal');
    
    if (printGstIncludedBtn && printOptionsModalEl) {
        const printOptionsModal = bootstrap.Modal.getInstance(printOptionsModalEl) || new bootstrap.Modal(printOptionsModalEl);
        
        // Function to handle print with cleanup
        function printInvoice(gstType) {
            // Remove any existing print classes
            document.body.classList.remove('print-gst-included', 'print-gst-not-included');
            
            // Add the appropriate class
            if (gstType === 'included') {
                document.body.classList.add('print-gst-included');
            } else {
                document.body.classList.add('print-gst-not-included');
            }
            
            // Print after modal animation completes
            setTimeout(() => {
                window.print();
                
                // Clean up classes after print dialog closes
                setTimeout(() => {
                    document.body.classList.remove('print-gst-included', 'print-gst-not-included');
                }, 500);
            }, 300);
        }
        
        printGstIncludedBtn.addEventListener('click', function() {
            // Close modal first
            printOptionsModal.hide();
            // Store GST preference
            window.invoiceGstType = 'included';
            // Print with GST Included
            printInvoice('included');
        });
        
        printGstNotIncludedBtn.addEventListener('click', function() {
            // Close modal first
            printOptionsModal.hide();
            // Store GST preference
            window.invoiceGstType = 'not_included';
            // Print with GST Not Included
            printInvoice('not_included');
        });
    }
});
</script>
@endpush

