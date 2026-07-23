<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            background: #f5f5f5;
            color: #000;
            margin: 0;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 15px 20px;
            background: #fff;
            border: 1px solid #999;
        }

        /* Top Section */
        .top-section {
            width: 100%;
            margin-bottom: 8px;
            border-collapse: collapse;
        }
        .top-section td {
            vertical-align: top;
        }
        .to-section {
            width: 70%;
        }
        .order-info-box {
            width: 30%;
            border-left: 1px dashed #999;
            padding-left: 15px;
        }
        .to-label { color: #dc3545; font-weight: bold; margin-bottom: 2px; font-size: 12px; }
        .customer-name { font-weight: normal; margin-bottom: 1px; font-size: 13px; color: #000; text-transform: capitalize; }
        .address-line { line-height: 1.4; font-size: 11px; color: #000; font-weight: normal; }

        .order-id-label { font-size: 11px; color: #dc3545; font-weight: bold; }
        .order-id { font-weight: bold; font-size: 12px; color: #dc3545; }
        .state { font-size: 11px; margin-top: 3px; font-weight: normal; color: #000; }
        .order-date { font-size: 10px; color: #666; margin-top: 2px; }

        /* From Section */
        .from-section {
            margin-bottom: 8px;
            font-size: 11px;
            padding-bottom: 6px;
            border-bottom: 1px dashed #999;
            color: #000;
            line-height: 1.4;
        }
        .from-label { font-weight: bold; }

        /* Header Layout using Table */
        .header-section {
            width: 100%;
            margin-bottom: 12px;
            border-collapse: collapse;
        }
        .header-section td {
            vertical-align: top;
        }
        .logo-section { width: 33%; }
        .logo-section img { height: 48px; width: auto; }
        .title-section { width: 33%; text-align: center; }
        .title-section .title { font-size: 18px; font-weight: bold; color: #000; text-transform: uppercase; }
        .company-details { width: 34%; text-align: right; font-size: 11px; line-height: 1.4; }
        .company-details .name { font-weight: normal; color: #000; font-size: 12px; }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            border: 1px solid #999;
            font-size: 10px;
        }
        .items-table th {
            background: #d4edda;
            border: 1px solid #999;
            padding: 6px 5px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            color: #000;
        }
        .items-table td {
            padding: 5px;
            border: 1px solid #999;
            font-size: 10px;
            text-align: center;
            vertical-align: middle;
            color: #000;
        }
        .items-table .product-name {
            text-align: left;
        }
        .items-table tfoot td {
            font-size: 11px;
        }
        .gst-highlight {
            color: #0066cc;
            font-weight: 600;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
            color: #000;
            line-height: 1.5;
            border-top: 1px dashed #999;
            padding-top: 10px;
        }
        .footer a { color: #dc3545; text-decoration: none; }
    </style>
</head>
<body>
    @php
        // Prepare customer data
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

        // Calculate GST vs NON GST Total
        $totalGst = 0;
        $totalSgst = 0;
        $totalIgst = 0;
        $hasGst = false;

        foreach($order->items as $item) {
            $product = $item->product;
            if ($product) {
                if (($product->gst ?? 0) > 0 || ($product->sgst ?? 0) > 0 || ($product->igst ?? 0) > 0) {
                    $hasGst = true;
                }
            }
        }
        
        // Use exact tax_amount from order if available, else derive it. Actually `billing-invoice` always uses $hasGst logic based on order->tax_amount but wait, email needs exact conditions. If order->tax_amount > 0, it means we have GST.
        $hasGst = ($order->tax_amount ?? 0) > 0 || $hasGst;
    @endphp

    <div class="invoice-container">
        <!-- Top Section via Table for Email support -->
        <table class="top-section">
            <tr>
                <td class="to-section">
                    <div class="to-label">To,</div>
                    <div class="customer-name">{{ $customerName }}</div>
                    <div class="address-line">
                        {{ $addressLine ?: 'N/A' }}<br>
                        Mobile: {{ $mobile }}
                    </div>
                </td>
                <td class="order-info-box">
                    <div class="order-id-label">Order ID</div>
                    <div class="order-id">{{ $order->order_number }}</div>
                    <div class="state">{{ $order->billing_address['state'] ?? $order->shipping_address['state'] ?? 'Tamil Nadu' }}</div>
                    <div class="order-date">Order Date: {{ $order->created_at->format('d-m-Y h:i A') }}</div>
                </td>
            </tr>
        </table>

        <!-- From Section -->
        <div class="from-section">
            <span class="from-label">From,</span><br>
            Chennai Angadi, New #15/Old #8, Muthu Street, Mylapore, Chennai - 4, Mobile: +91 90946 76665
        </div>

        <!-- Header Section via Table -->
        <table class="header-section">
            <tr>
                <td class="logo-section">
                    <img src="{{ asset('assets/imgs/theme/ChennaiAngadiLogo.png') }}" alt="Chennai Angadi" />
                </td>
                <td class="title-section">
                    <div class="title">Estimate Invoice</div>
                </td>
                <td class="company-details">
                    <div class="name">Chennai Angadi</div>
                    <div>15/8, Muthu St, Mylapore, Chennai 4</div>
                    <div>Mobile: +91 90946 76665 | Email: care@chennaiangadi.com</div>
                </td>
            </tr>
        </table>

        @if($hasGst)
            <!--=========================================
                 GST INCLUDED INVOICE (TAX INVOICE)
                 =========================================-->
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 6%;">S.NO.</th>
                        <th style="width: 22%; text-align: left;">PRODUCTS</th>
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
                    @php 
                        $giSubtotal = 0; 
                    @endphp
                    @foreach($order->items as $index => $item)
                        @php 
                            $qty = $item->quantity ?? $item->qty ?? 1;
                            $lineTotal = $item->price * $qty;
                            $giSubtotal += $lineTotal;
                            
                            $product = $item->product;
                            $productHsn = $product->hsn ?? 'N/A';
                            $productGst = $product->gst ?? 0;
                            $productSgst = $product->sgst ?? 0;
                            $productIgst = $product->igst ?? 0;
                            
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
                                    $displayVariant = $item->variant->quantity->name ?? $item->variant->quantity->label ?? $item->variant_name;
                                @endphp
                                @if($displayVariant) - {{ $displayVariant }} @endif
                            </td>
                            <td>{{ $productHsn }}</td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td class="gst-highlight">{{ $productGst }}% (₹{{ number_format($gstAmount, 2) }})</td>
                            <td class="gst-highlight">{{ $productSgst }}% (₹{{ number_format($sgstAmount, 2) }})</td>
                            <td class="gst-highlight">{{ $productIgst }}% (₹{{ number_format($igstAmount, 2) }})</td>
                            <td>{{ $qty }}</td>
                            <td style="text-align: center;">₹ {{ number_format($lineTotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @if((float)$totalGst > 0)
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545;">GST</td>
                        <td style="text-align: center; color: #dc3545;">₹ {{ number_format($totalGst, 2) }}</td>
                    </tr>
                    @endif
                    @if((float)$totalSgst > 0)
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545;">SGST</td>
                        <td style="text-align: center; color: #dc3545;">₹ {{ number_format($totalSgst, 2) }}</td>
                    </tr>
                    @endif
                    @if((float)$totalIgst > 0)
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545;">IGST</td>
                        <td style="text-align: center; color: #dc3545;">₹ {{ number_format($totalIgst, 2) }}</td>
                    </tr>
                    @endif
                    @if((float)($order->discount_amount ?? 0) > 0)
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: 600; color: #28a745;">Coupon Applied @if($order->coupon_code)({{ $order->coupon_code }})@endif</td>
                        <td style="text-align: center; color: #28a745;">- ₹ {{ number_format($order->discount_amount, 2) }}</td>
                    </tr>
                    @endif
                    @if((float)($order->shipping_amount ?? 0) > 0)
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545;">Shipping Charges</td>
                        <td style="text-align: center; color: #dc3545;">₹ {{ number_format($order->shipping_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="8" style="text-align: right; font-weight: bold; font-size: 12px; color: #dc3545;">TOTAL (Incl. GST)</td>
                        <td style="text-align: center; font-weight: bold; font-size: 12px; color: #dc3545;">₹ {{ number_format($order->final_amount ?? $order->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        @else
            <!--=========================================
                 GST NOT INCLUDED INVOICE (ESTIMATE)
                 =========================================-->
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 8%;">S.NO.</th>
                        <th style="width: 52%; text-align: left;">PRODUCTS</th>
                        <th style="width: 15%;">PRICE</th>
                        <th style="width: 10%;">QTY</th>
                        <th style="width: 15%;">SUB TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $index => $item)
                        @php 
                            $lineTotal = $item->price * ($item->quantity ?? $item->qty ?? 1);
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="product-name">
                                {{ $item->product_productname ?? $item->product->productname ?? 'N/A' }}
                                @php
                                    $displayVariant = $item->variant->quantity->name ?? $item->variant->quantity->label ?? $item->variant_name;
                                @endphp
                                @if($displayVariant) - {{ $displayVariant }}@endif
                            </td>
                            <td>₹{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity ?? $item->qty ?? 1 }}</td>
                            <td style="text-align: center;">₹{{ number_format($lineTotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @if((float)($order->discount_amount ?? 0) > 0)
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold; color: #28a745;">Coupon Applied @if($order->coupon_code)({{ $order->coupon_code }})@endif</td>
                        <td style="text-align: center; font-weight: bold; color: #28a745;">- ₹{{ number_format($order->discount_amount, 2) }}</td>
                    </tr>
                    @endif
                    @if((float)($order->shipping_amount ?? 0) > 0)
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold; color: #dc3545;">Shipping Charges</td>
                        <td style="text-align: center; font-weight: bold; color: #dc3545;">₹{{ number_format($order->shipping_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold; color: #dc3545; font-size: 12px;">TOTAL</td>
                        <td style="text-align: center; font-weight: bold; color: #dc3545; font-size: 14px;">₹{{ number_format(($order->final_amount ?? $order->total_amount) - ($order->tax_amount ?? 0), 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        @endif

        <div class="footer">
            <p>Thank you for shopping with us and we hope to serve you again in the future. Please feel free to write to us at <a href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a> for any queries, suggestions, complaints or anything else.</p>
        </div>
    </div>
</body>
</html>
