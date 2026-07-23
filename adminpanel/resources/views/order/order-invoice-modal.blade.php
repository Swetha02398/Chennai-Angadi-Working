<div class="invoice-print-content" id="invoicePrintContent">
<style>
    .invoice-print-content { font-family: 'Arial', sans-serif; background: #fff; color: #000; padding: 15px; }
    .invoice-print-content * { margin: 0; padding: 0; box-sizing: border-box; }
    @media print {
        @page { margin: 5mm; }
        html, body { background: #fff; margin: 0 !important; padding: 0 !important; width: 100%; height: auto !important; }
        .invoice-print-content { padding: 0 !important; margin: 0 !important; width: 100% !important; max-width: none !important; border: none !important; }
    }
    .gi-top-section { display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 13px; }
    .gi-to-section { flex: 1; }
    .gi-to-label { color: #333; font-weight: bold; margin-bottom: 4px; font-size: 14px; }
    .gi-customer-name { font-weight: 600; font-size: 15px; margin-bottom: 2px; }
    .gi-address-line { color: #333; line-height: 1.5; font-size: 13px; }
    .gi-order-box { border-left: 1px dashed #999; padding-left: 15px; text-align: left; }
    .gi-order-id-label { font-size: 12px; color: #666; margin-bottom: 2px; }
    .gi-order-id { font-weight: bold; font-size: 16px; color: #000; margin-bottom: 4px; }
    .gi-state { font-size: 12px; color: #333; margin-top: 4px; }
    .gi-from-section { font-size: 13px; padding-bottom: 8px; border-bottom: 1px dashed #999; margin-bottom: 15px; line-height: 1.5; }
    .gi-from-label { font-weight: bold; font-size: 14px; }
    .gi-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .gi-logo img { height: 50px; width: auto; }
    .gi-title { text-align: center; flex: 1; }
    .gi-title h3 { font-size: 20px; font-weight: bold; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
    .gi-company { text-align: right; font-size: 12px; line-height: 1.4; }
    .gi-company-name { font-weight: bold; font-size: 14px; }
    .gi-table { width: 100%; border-collapse: collapse; margin-bottom: 0; font-size: 12px; table-layout: fixed; }
    .gi-table th { background: #f0f0f0; border: 1px solid #999; padding: 8px 6px; font-size: 11px; font-weight: bold; text-align: center; text-transform: uppercase; }
    .gi-table td { border: 1px solid #999; padding: 8px 6px; font-size: 12px; text-align: center; }
    .gi-table td.product-name { text-align: left; white-space: normal; line-height: 1.4; }
    .gi-summary-row { display: flex; justify-content: space-between; border: 1px solid #999; border-top: none; font-size: 13px; }
    .gi-summary-row .label { padding: 10px; flex: 1; font-weight: 600; color: #dc3545; text-align: right; }
    .gi-summary-row .amount { padding: 10px; width: 120px; text-align: right; border-left: 1px solid #999; color: #dc3545; font-weight: 600; }
    .gi-total-row .label { font-size: 15px; font-weight: bold; }
    .gi-total-row .amount { font-size: 16px; font-weight: bold; }
    .gi-footer { margin-top: 20px; text-align: center; font-size: 12px; color: #333; line-height: 1.6; border-top: 1px dashed #999; padding-top: 15px; }
    .gi-footer a { color: #dc3545; text-decoration: none; font-weight: bold; }
    .gst-highlight { color: #0066cc; font-weight: bold; }
</style>

<!-- Top Section -->
<div class="gi-top-section">
    <div class="gi-to-section">
        <div class="gi-to-label">To,</div>
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
                <td class="text-end" style="text-align: right; white-space: nowrap;">&#8377;{{ number_format($item->price, 2) }}</td>
                <td class="gst-highlight text-end" style="text-align: right;">{{ $productGst }}% (&#8377;{{ number_format($gstAmount, 2) }})</td>
                <td class="gst-highlight text-end" style="text-align: right;">{{ $productSgst }}% (&#8377;{{ number_format($sgstAmount, 2) }})</td>
                <td class="gst-highlight text-end" style="text-align: right;">{{ $productIgst }}% (&#8377;{{ number_format($igstAmount, 2) }})</td>
                <td>{{ $qty }}</td>
                <td class="text-end" style="text-align: right; white-space: nowrap;">&#8377; {{ number_format($lineTotal, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
    <!-- Summary rows inside table for alignment -->
    <tfoot>
        @if((float)$totalGst > 0)
        <tr>
            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">GST</td>
            <td style="text-align: right; color: #dc3545; border: 1px solid #999;">&#8377; {{ number_format($totalGst, 2) }}</td>
        </tr>
        @endif
        @if((float)$totalSgst > 0)
        <tr>
            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">SGST</td>
            <td style="text-align: right; color: #dc3545; border: 1px solid #999;">&#8377; {{ number_format($totalSgst, 2) }}</td>
        </tr>
        @endif
        @if((float)$totalIgst > 0)
        <tr>
            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">IGST</td>
            <td style="text-align: right; color: #dc3545; border: 1px solid #999;">&#8377; {{ number_format($totalIgst, 2) }}</td>
        </tr>
        @endif
        @if((float)($order->discount_amount ?? 0) > 0)
        <tr>
            <td colspan="8" style="text-align: right; font-weight: 600; color: #28a745; border: 1px solid #999;">Coupon Applied @if($order->coupon_code)({{ $order->coupon_code }})@endif</td>
            <td style="text-align: right; color: #28a745; border: 1px solid #999;">- &#8377; {{ number_format($order->discount_amount, 2) }}</td>
        </tr>
        @endif
        @if((float)($order->shipping_amount ?? 0) > 0)
        <tr>
            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">Shipping Charges</td>
            <td style="text-align: right; color: #dc3545; border: 1px solid #999;">&#8377; {{ number_format($order->shipping_amount, 2) }}</td>
        </tr>
        @endif
        @if(in_array($order->payment_method, ['cash_on_delivery', 'cod']))
        @if((float)($order->cod_charge ?? 0) > 0)
        <tr>
            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">COD Charges</td>
            <td style="text-align: right; color: #dc3545; border: 1px solid #999;">&#8377; {{ number_format($order->cod_charge, 2) }}</td>
        </tr>
        @endif
        @endif
        @php $totalTax = $totalGst + $totalSgst + $totalIgst; @endphp
        <tr>
            <td colspan="8" style="text-align: right; font-weight: bold; font-size: 14px; color: #dc3545; border: 1px solid #999; background: #fff8f8;">TOTAL (Incl. GST)</td>
            <td style="text-align: right; font-weight: bold; font-size: 14px; color: #dc3545; border: 1px solid #999; background: #fff8f8;">&#8377; {{ number_format($order->final_amount ?? $order->total_amount, 2) }}</td>
        </tr>
    </tfoot>
</table>

<!-- Footer -->
<div class="gi-footer">
    <p>Thank you for shopping with us and we hope to serve you again in the future. Please feel free to write to us at <a href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a> for any queries, suggestions, complaints or anything else.</p>
</div>
</div>
