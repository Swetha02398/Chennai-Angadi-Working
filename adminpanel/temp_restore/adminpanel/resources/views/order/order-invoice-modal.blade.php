{{-- Unified Invoice content for Modal Popup --}}
<style>
    .invoice-print-content * { margin: 0; padding: 0; box-sizing: border-box; }
    .invoice-print-content { font-family: 'Arial', sans-serif; font-size: 11px; background: #fff; color: #000; padding: 8px; font-weight: normal; }
    
    /* Top Section */
    .invoice-print-content .top-section { display: flex; justify-content: space-between; margin-bottom: 8px; }
    .invoice-print-content .to-section { flex: 1; }
    .invoice-print-content .to-label { color: #dc3545; font-weight: bold; margin-bottom: 2px; font-size: 12px; }
    .invoice-print-content .customer-name { font-weight: normal; margin-bottom: 1px; font-size: 13px; color: #000; text-transform: capitalize; }
    .invoice-print-content .address-line { line-height: 1.3; font-size: 11px; color: #000; font-weight: normal; }
    
    /* Order Info Box */
    .invoice-print-content .order-info-box { 
        border-left: 1px dashed #999; 
        padding-left: 15px; 
        text-align: left;
        min-width: 120px;
    }
    .invoice-print-content .order-info-box .order-id-label { font-size: 11px; color: #dc3545; font-weight: bold; }
    .invoice-print-content .order-info-box .order-id { font-weight: bold; font-size: 12px; color: #dc3545; }
    .invoice-print-content .order-info-box .state { font-size: 11px; margin-top: 3px; font-weight: normal; color: #000; }
    
    /* From Section */
    .invoice-print-content .from-section { 
        margin-bottom: 8px; 
        font-size: 11px; 
        padding-bottom: 6px;
        border-bottom: 1px dashed #999;
        color: #000;
        font-weight: normal;
        line-height: 1.4;
    }
    .invoice-print-content .from-label { font-weight: bold; }
    .invoice-print-content .from-company { color: #000; font-weight: normal; }
    
    /* Header */
    .invoice-print-content .header-section { 
        display: flex; 
        justify-content: space-between; 
        align-items: flex-start; 
        margin-bottom: 12px; 
    }
    .invoice-print-content .logo-section { display: flex; flex-direction: row; align-items: center; gap: 5px; }
    .invoice-print-content .logo-section img { height: 48px; width: auto; }
    
    .invoice-print-content .title-section { text-align: center; flex: 1; }
    .invoice-print-content .title-section .title { font-size: 18px; font-weight: bold; color: #000; text-transform: uppercase; }
    
    .invoice-print-content .company-details { text-align: right; font-size: 11px; line-height: 1.4; font-weight: normal; }
    .invoice-print-content .company-details .name { font-weight: normal; color: #000; font-size: 12px; }
    .invoice-print-content .company-details .contact { color: #000; font-weight: normal; }
    
    /* Items Table */
    .invoice-print-content .items-table { width: 100%; border-collapse: collapse; margin-bottom: 0; border: 1px solid #999; }
    .invoice-print-content .items-table th { 
        background: #e8e8e8;
        border: 1px solid #999; 
        padding: 6px 10px; 
        text-align: center; 
        font-weight: bold; 
        font-size: 11px;
        color: #000;
    }
    .invoice-print-content .items-table th:nth-child(2) { text-align: left; }
    .invoice-print-content .items-table th.price-col, .invoice-print-content .items-table th.subtotal-col { text-align: center; }
    .invoice-print-content .items-table th.qty-col { text-align: center; }
    
    .invoice-print-content .items-table td { 
        padding: 6px 10px; 
        border: 1px solid #999; 
        font-size: 11px;
        vertical-align: middle;
        font-weight: normal;
        color: #000;
        text-align: center;
    }
    .invoice-print-content .items-table td.sno-col { text-align: center; width: 50px; }
    .invoice-print-content .items-table td:nth-child(2) { text-align: left; }
    .invoice-print-content .items-table td.price-col { text-align: center; width: 70px; }
    .invoice-print-content .items-table td.qty-col { text-align: center; width: 50px; }
    .invoice-print-content .items-table td.subtotal-col { text-align: center; width: 90px; color: #000; font-weight: bold; }
    .invoice-print-content .items-table .product-name { color: #000; text-align: left; font-weight: normal; }
    
    /* Summary Section */
    .invoice-print-content .summary-container {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        margin-top: 0;
        width: 100%;
    }
    .invoice-print-content .summary-row {
        display: flex;
        justify-content: space-between;
        width: 100%;
        font-size: 13px;
        border: 1px solid #999;
        border-top: none;
    }
    .invoice-print-content .summary-row .label { 
        text-align: left; 
        font-weight: bold; 
        color: #dc3545 !important; 
        padding: 6px 10px;
        flex: 1;
    }
    .invoice-print-content .summary-row .amount { 
        text-align: center; 
        font-weight: normal; 
        color: #dc3545 !important; 
        padding: 6px 10px;
        width: 90px;
        border-left: 1px solid #999;
    }
    
    .invoice-print-content .summary-row.total {
        border: 1px solid #999;
        border-top: none;
    }
    .invoice-print-content .summary-row.total .label { font-size: 14px; text-transform: uppercase; color: #dc3545 !important; }
    .invoice-print-content .summary-row.total .amount { font-size: 16px; color: #dc3545 !important; border-left: 1px solid #999; font-weight: bold; }
    
    /* Footer */
    .invoice-print-content .footer { 
        text-align: center; 
        margin-top: 15px; 
        font-size: 10px; 
        color: #000; 
        line-height: 1.4;
        font-weight: normal;
        border-top: 1px dashed #999;
        padding-top: 8px;
    }
    .invoice-print-content .footer a { color: #dc3545; text-decoration: none; font-weight: normal; }

    .hide-on-print { display: table-cell; }

    @media print {
        @page { size: A4 portrait; margin: 0; }
        .invoice-print-content { padding: 10mm !important; }
        .invoice-print-content .items-table th, .invoice-print-content .items-table td { padding: 6px 10px; font-size: 16px !important; }
        .hide-on-print { display: none !important; }
        .invoice-print-content .footer { margin-top: 20px; page-break-inside: avoid; }
        .invoice-print-content .summary-row { font-size: 18px; }
        .invoice-print-content .summary-row.total { font-size: 22px; }
    }
</style>

<div class="invoice-print-content" id="invoicePrintContent">
    <div class="top-section">
        <div class="to-section">
            <div class="to-label">To,</div>
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
                
                // Fallback to customer/guest details if shipping address fields are missing
                if (empty($customerName)) {
                    if ($order->customer_type === 'registered' && $order->customer) {
                        $customerName = $order->customer->username ?? $order->customer->name ?? 'N/A';
                    } else {
                        $customerName = $order->guest_details['first_name'] ?? $order->guest_details['name'] ?? 'Guest';
                    }
                }
                
                if (empty($mobile)) {
                    if ($order->customer_type === 'registered' && $order->customer) {
                        $mobile = $order->customer->mobilenumber ?? $order->customer->phone ?? 'N/A';
                    } else {
                        $mobile = $order->guest_details['phone'] ?? $order->guest_details['mobile'] ?? 'N/A';
                    }
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
            <div class="customer-name">{{ $customerName }}</div>
            <div class="address-line">
                {{ $addressLine ?: 'N/A' }}<br>
                Mobile: {{ $mobile }}
            </div>
        </div>
        <div class="order-info-box">
            <div class="order-id-label">Order ID</div>
            <div class="order-id">{{ $order->order_number }}</div>
            <div class="state">{{ $order->billing_address['state'] ?? $order->shipping_address['state'] ?? 'Tamil Nadu' }}</div>
        </div>
    </div>

    <div class="from-section">
        <span class="from-label">From,</span><br>
        <span class="from-company">Chennai Angadi, New #15/Old #8, Muthu Street, Mylapore, Chennai - 4, Mobile: +91 90946 76665</span>
    </div>

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

    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 40px;">S.NO.</th>
                <th>PRODUCTS</th>
                <th class="price-col" style="width: 80px;">PRICE</th>
                <th class="hide-on-print" style="width: 60px; text-align: center;">GST</th>
                <th class="hide-on-print" style="width: 60px; text-align: center;">SGST</th>
                <th class="hide-on-print" style="width: 60px; text-align: center;">IGST</th>
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
                <td class="product-name">{{ $item->product_productname ?? $item->product->productname ?? 'N/A' }} @if($item->variant_name) - {{ $item->variant_name }} @endif</td>
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

    <div class="summary-container">
        @if(($order->tax_amount ?? 0) > 0)
        <div class="summary-row">
            <span class="label" style="color: #dc3545 !important;">GST</span>
            <span class="amount" style="color: #dc3545 !important;">₹ {{ number_format($order->tax_amount, 2) }}</span>
        </div>
        @endif
        <div class="summary-row">
            <span class="label" style="color: #dc3545 !important;">Shipping Charges</span>
            <span class="amount" style="color: #dc3545 !important;">
                @if(($order->shipping_amount ?? 0) == 0)
                    Free
                @else
                    ₹ {{ number_format($order->shipping_amount, 0) }}
                @endif
            </span>
        </div>
        @if(in_array($order->payment_method, ['cash_on_delivery', 'cod']))
        <div class="summary-row">
            <span class="label" style="color: #dc3545 !important;">COD Charges</span>
            <span class="amount" style="color: #dc3545 !important;">
                @if(($order->cod_charge ?? 0) == 0)
                    Free
                @else
                    ₹ {{ number_format($order->cod_charge, 0) }}
                @endif
            </span>
        </div>
        @endif
        @if(($order->discount_amount ?? 0) > 0)
        <div class="summary-row">
            <span class="label" style="color: #28a745 !important;">Coupon @if($order->coupon_code)({{ $order->coupon_code }})@endif</span>
            <span class="amount" style="color: #28a745 !important;">- ₹ {{ number_format($order->discount_amount, 2) }}</span>
        </div>
        @endif
        <div class="summary-row total">
            <span class="label" style="color: #dc3545 !important;">TOTAL</span>
            <span class="amount" style="color: #dc3545 !important;">₹ {{ number_format($order->final_amount ?? $order->total_amount, 2) }}</span>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for shopping with us and we hope to serve you again in the future</p>
        <p>Please feel free to write to us at <a href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a> for any queries, suggestions, complaints or anything else.</p>
    </div>
</div>
