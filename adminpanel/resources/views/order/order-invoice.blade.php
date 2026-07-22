<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        * {
            margin: 8mm;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 18px;
            background: #fff;
            color: #000;
            font-weight: normal;
        }

        .invoice-container {
            max-width: 800px;
            margin: 10px auto;
            padding: 15px 20px;
            background: #fff;
            border: 1px solid #999;
        }

        /* Top Section */
        .top-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .to-section {
            flex: 1;
        }

        .to-label {
            color: #dc3545;
            font-weight: bold;
            margin-bottom: 4px;
            font-size: 20px;
        }

        .customer-name {
            font-weight: normal;
            margin-bottom: 4px;
            color: #000;
            font-size: 20px;
            text-transform: capitalize;
        }

        .address-line {
            line-height: 1.4;
            font-size: 18px;
            color: #000;
            font-weight: normal;
        }

        /* Order Info Box */
        .order-info-box {
            border-left: 1px dashed #999;
            padding-left: 20px;
            text-align: left;
            min-width: 150px;
        }

        .order-info-box .order-id-label {
            font-size: 16px;
            color: #dc3545;
            font-weight: bold;
        }

        .order-info-box .order-id {
            font-weight: bold;
            font-size: 18px;
            color: #dc3545;
            margin-bottom: 4px;
        }

        .order-info-box .state {
            font-size: 16px;
            margin-top: 4px;
            font-weight: normal;
            color: #000;
        }

        /* From Section */
        .from-section {
            margin-bottom: 18px;
            font-size: 18px;
            padding-bottom: 12px;
            border-bottom: 1px dashed #999;
            line-height: 1.5;
            color: #000;
            font-weight: normal;
        }

        .from-label {
            font-weight: bold;
        }

        .from-company {
            color: #000;
            font-weight: normal;
        }

        /* Header */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 18px;
        }

        .logo-section img {
            height: 55px;
            width: auto;
        }

        .title-section {
            text-align: center;
            flex: 1;
        }

        .title-section .title {
            font-size: 28px;
            font-weight: bold;
            color: #000;
            text-transform: uppercase;
        }

        .company-details {
            text-align: right;
            font-size: 16px;
            line-height: 1.4;
            color: #000;
            font-weight: normal;
        }

        .company-details .name {
            font-weight: normal;
            color: #000;
            font-size: 18px;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            border: 1px solid #999;
        }

        .items-table th {
            background: #e8e8e8;
            border: 1px solid #999;
            padding: 8px 10px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            color: #000;
        }

        .items-table th:nth-child(2) {
            text-align: left;
        }

        .items-table th.price-col,
        .items-table th.subtotal-col {
            text-align: center;
        }

        .items-table th.qty-col {
            text-align: center;
        }

        .items-table td {
            padding: 8px 10px;
            border: 1px solid #999;
            font-size: 16px;
            vertical-align: middle;
            font-weight: normal;
            color: #000;
            text-align: center;
        }

        .items-table td.sno-col {
            width: 45px;
            text-align: center;
        }

        .items-table td:nth-child(2) {
            text-align: left;
        }

        .items-table td.price-col {
            text-align: center;
            width: 85px;
        }

        .items-table td.qty-col {
            text-align: center;
            width: 60px;
        }

        .items-table td.subtotal-col {
            text-align: center;
            width: 100px;
            color: #000;
            font-weight: bold;
        }

        .items-table .product-name {
            color: #000;
            text-align: left;
        }

        /* Summary Section */
        .summary-section {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-top: 10px;
            page-break-inside: avoid;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            width: 50%;
            min-width: 300px;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .summary-row .label {
            text-align: left;
            font-weight: bold;
            color: #dc3545;
            font-size: 20px;
        }

        .summary-row .amount {
            text-align: center;
            font-weight: normal;
            color: #dc3545;
            font-size: 20px;
        }

        .summary-row.total {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #999;
        }

        .summary-row.total .label {
            font-size: 22px;
            text-transform: uppercase;
            color: #dc3545;
        }

        .summary-row.total .amount {
            font-size: 26px;
            color: #dc3545;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 25px;
            font-size: 16px;
            color: #000;
            line-height: 1.5;
            border-top: 1px dashed #999;
            padding-top: 12px;
            font-weight: normal;
        }

        .footer a {
            color: #dc3545;
            text-decoration: none;
            font-weight: normal;
        }

        /* Print Styles */
        .no-print {
            margin-bottom: 15px;
            text-align: right;
        }

        .print-btn {
            padding: 10px 20px;
            background: #000;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 8mm;
            }

            html,
            body {
                background: #fff;
                margin: 0 !important;
                padding: 0 !important;
                width: 100%;
                height: auto !important;
                overflow: visible !important;
            }

            .no-print {
                display: none !important;
            }

            .invoice-container {
                margin: 0 !important;
                padding: 0mm 10mm 10mm 10mm !important;
                width: 100% !important;
                max-width: none !important;
                border: none !important;
                box-shadow: none !important;
            }

            .items-table th,
            .items-table td {
                font-size: 18px;
                padding: 8px;
                border: 2px solid #000;
            }

            .hide-on-print {
                display: none !important;
            }

            .summary-row {
                font-size: 20px;
                margin-bottom: 8px;
            }

            .summary-row.total {
                font-size: 24px;
                border-top: 4px solid #000;
            }

            .footer {
                margin-top: 20px;
                padding-top: 10px;
                page-break-inside: avoid;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Print Button -->
        <div class="no-print">
            <button class="print-btn" onclick="window.print()">🖨️ Print Invoice</button>
        </div>

        <!-- Top Section -->
        <div class="top-section">
            <div class="to-section">
                <div class="to-label">To,</div>
                @if($order->customer_type === 'registered' && $order->customer)
                    <div class="customer-name">{{ $order->customer->username }}</div>
                    <div class="address-line">
                        {{ $order->billing_address['address'] ?? $order->customer->address ?? 'N/A' }}<br>
                        @if(isset($order->billing_address['city'])){{ $order->billing_address['city'] }}, @endif
                        {{ $order->billing_address['state'] ?? 'Tamil Nadu' }} -
                        {{ $order->billing_address['pincode'] ?? '' }}<br>
                        Mobile: {{ $order->customer->mobilenumber ?? 'N/A' }}
                    </div>
                @else
                    <div class="customer-name">
                        {{ $order->guest_details['first_name'] ?? $order->guest_details['name'] ?? 'Guest' }}</div>
                    <div class="address-line">
                        {{ $order->billing_address['address'] ?? $order->guest_details['address'] ?? 'N/A' }}<br>
                        @if(isset($order->billing_address['city'])){{ $order->billing_address['city'] }}, @endif
                        {{ $order->billing_address['state'] ?? 'Tamil Nadu' }} -
                        {{ $order->billing_address['pincode'] ?? $order->guest_details['pincode'] ?? '' }}<br>
                        Mobile: {{ $order->guest_details['phone'] ?? 'N/A' }}
                    </div>
                @endif
            </div>
            <div class="order-info-box">
                <div class="order-id-label">Order ID</div>
                <div class="order-id">{{ $order->order_number }}</div>
                <div class="state">
                    {{ $order->billing_address['state'] ?? $order->shipping_address['state'] ?? 'Tamil Nadu' }}</div>
            </div>
        </div>

        <!-- From Section -->
        <div class="from-section">
            <span class="from-label">From,</span><br>
            <span class="from-company">Chennai Angadi, New #15/Old #8, Muthu Street, Mylapore, Chennai - 4, Mobile: +91
                90946 76665</span>
        </div>

        <!-- Header -->
        <div class="header-section">
            <div class="logo-section">
                <img src="{{ asset('assets/imgs/theme/ChennaiAngadiLogo.png') }}" alt="Chennai Angadi">
            </div>
            <div class="title-section">
                <span class="title">Estimate Invoice</span>
            </div>
            <div class="company-details">
                <div class="name">Chennai Angadi</div>
                <div class="contact">15/8, Muthu St, Mylapore, Chennai 4</div>
                <div class="contact">Mobile: +91 90946 76665 | Email: care@chennaiangadi.com</div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 40px;">S.NO.</th>
                    <th>PRODUCTS</th>
                    <th class="price-col" style="width: 80px;">PRICE</th>
                    <th class="hide-on-print tax-col" style="width: 60px;">GST</th>
                    <th class="hide-on-print tax-col" style="width: 60px;">SGST</th>
                    <th class="hide-on-print tax-col" style="width: 60px;">IGST</th>
                    <th class="qty-col" style="width: 50px;">QTY</th>
                    <th class="subtotal-col" style="width: 100px;">SUB TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @php $itemSubtotal = 0; @endphp
                @foreach($order->items as $index => $item)
                    @php 
                        $lineTotal = $item->price * ($item->quantity ?? $item->qty ?? 1);
                        $itemSubtotal += $lineTotal;
                        
                        // Get tax values from product table using product_id
                        $product = $item->product;
                        $productGst = $product->gst ?? 0;
                        $productSgst = $product->sgst ?? 0;
                        $productIgst = $product->igst ?? 0;
                    @endphp
                    <tr>
                        <td class="sno-col">{{ $index + 1 }}</td>
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
                        <td class="price-col">₹ {{ number_format($item->price, 0) }}</td>
                        <td class="hide-on-print" style="text-align: center;">{{ $productGst }}%</td>
                        <td class="hide-on-print" style="text-align: center;">{{ $productSgst }}%</td>
                        <td class="hide-on-print" style="text-align: center;">{{ $productIgst }}%</td>
                        <td class="qty-col">{{ $item->quantity ?? $item->qty ?? 1 }}</td>
                        <td class="subtotal-col">₹ {{ number_format($lineTotal, 0) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Section -->
        <div class="summary-section">
            @if((float)($order->tax_amount ?? 0) > 0)
            <div class="summary-row">
                <span class="label">GST</span>
                <span class="amount">₹ {{ number_format($order->tax_amount, 2) }}</span>
            </div>
            @endif

            @if((float)($order->discount_amount ?? 0) > 0)
            <div class="summary-row">
                <span class="label" style="color: #28a745 !important;">Coupon Applied @if($order->coupon_code)({{ $order->coupon_code }})@endif</span>
                <span class="amount" style="color: #28a745 !important;">- ₹ {{ number_format($order->discount_amount, 2) }}</span>
            </div>
            @endif

            @if((float)($order->shipping_amount ?? 0) > 0)
            <div class="summary-row">
                <span class="label">Shipping Charges</span>
                <span class="amount">₹ {{ number_format($order->shipping_amount, 0) }}</span>
            </div>
            @endif

            @if(in_array($order->payment_method, ['cash_on_delivery', 'cod']))
            @if((float)($order->cod_charge ?? 0) > 0)
            <div class="summary-row">
                <span class="label">COD Charges</span>
                <span class="amount">₹ {{ number_format($order->cod_charge, 0) }}</span>
            </div>
            @endif
            @endif

            <div class="summary-row total">
                <span class="label">Total (Incl. GST)</span>
                <span class="amount">₹ {{ number_format($order->final_amount ?? $order->total_amount, 2) }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for shopping with us and we hope to serve you again in the future. Please feel free to write to us at <a href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a> for any queries, suggestions, complaints or anything else.</p>
        </div>
    </div>
</body>
</html>
