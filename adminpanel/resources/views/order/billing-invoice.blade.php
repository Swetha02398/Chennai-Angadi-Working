<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; font-size: 11px; background: #fff; color: #000; font-weight: normal; }
        
        .invoice-container {
            max-width: 800px;
            margin: 10px auto;
            padding: 15px 20px;
            background: #fff;
            border: 1px solid #999;
        }

        /* Top Section */
        .top-section { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .to-section { flex: 1; }
        .to-label { color: #dc3545; font-weight: bold; margin-bottom: 2px; font-size: 12px; }
        .customer-name { font-weight: normal; margin-bottom: 1px; font-size: 13px; color: #000; text-transform: capitalize; }
        .address-line { line-height: 1.3; font-size: 11px; color: #000; font-weight: normal; }
        
        /* Order Info Box */
        .order-info-box { 
            border-left: 1px dashed #999; 
            padding-left: 15px; 
            text-align: left;
            min-width: 120px;
        }
        .order-info-box .order-id-label { font-size: 11px; color: #dc3545; font-weight: bold; }
        .order-info-box .order-id { font-weight: bold; font-size: 12px; color: #dc3545; }
        .order-info-box .state { font-size: 11px; margin-top: 3px; font-weight: normal; color: #000; }
        .order-info-box .order-date { font-size: 10px; color: #666; margin-top: 2px; }
        
        /* From Section */
        .from-section { 
            margin-bottom: 8px; 
            font-size: 11px; 
            padding-bottom: 6px;
            border-bottom: 1px dashed #999;
            color: #000;
            font-weight: normal;
            line-height: 1.4;
        }
        .from-label { font-weight: bold; }
        .from-company { color: #000; font-weight: normal; }
        
        /* Header */
        .header-section { 
            display: flex; 
            justify-content: space-between; 
            align-items: flex-start; 
            margin-bottom: 12px; 
        }
        .logo-section { display: flex; flex-direction: row; align-items: center; gap: 5px; }
        .logo-section img { height: 48px; width: auto; }
        
        .title-section { text-align: center; flex: 1; }
        .title-section .title { font-size: 18px; font-weight: bold; color: #000; text-transform: uppercase; }
        
        .company-details { text-align: right; font-size: 11px; line-height: 1.4; font-weight: normal; }
        .company-details .name { font-weight: normal; color: #000; font-size: 12px; }
        .company-details .contact { color: #000; font-weight: normal; }
        
        /* Items Table */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 0; border: 1px solid #999; }
        .items-table th { 
            background: #d4edda;
            border: 1px solid #999; 
            padding: 6px 5px; 
            text-align: center; 
            font-weight: bold; 
            font-size: 11px;
            color: #000;
        }
        .items-table th:nth-child(2) { text-align: left; }
        
        .items-table td { 
            padding: 5px; 
            border: 1px solid #999; 
            font-size: 10px;
            vertical-align: middle;
            font-weight: normal;
            color: #000;
            text-align: center;
            white-space: nowrap;
        }
        .items-table td:nth-child(2) { text-align: left; white-space: normal; }
        .items-table td.subtotal-col { font-weight: bold; }
        .items-table .product-name { color: #000; text-align: left; font-weight: normal; white-space: normal; }
        
        /* Footer */
        .footer { 
            text-align: center; 
            margin-top: 15px; 
            font-size: 10px; 
            color: #000; 
            line-height: 1.4;
            font-weight: normal;
            border-top: 1px dashed #999;
            padding-top: 8px;
        }
        .footer a { color: #dc3545; text-decoration: none; font-weight: normal; }

        /* =========================================
           GST INCLUDED SPECIFIC STYLES
           ========================================= */
        #billingGstIncludedInvoice { display: none; }
        #billingGstIncludedInvoice .gi-top-section { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 11px; }
        #billingGstIncludedInvoice .gi-to-section { flex: 1; }
        #billingGstIncludedInvoice .gi-to-label { color: #dc3545; font-weight: bold; margin-bottom: 2px; }
        #billingGstIncludedInvoice .gi-customer-name { font-weight: 600; font-size: 12px; text-transform: capitalize; }
        #billingGstIncludedInvoice .gi-address-line { color: #333; line-height: 1.4; font-size: 11px; }
        #billingGstIncludedInvoice .gi-order-box { border-left: 1px dashed #999; padding-left: 12px; text-align: left; }
        #billingGstIncludedInvoice .gi-order-id-label { font-size: 10px; color: #dc3545; font-weight: bold; }
        #billingGstIncludedInvoice .gi-order-id { font-weight: bold; font-size: 12px; color: #dc3545; }
        #billingGstIncludedInvoice .gi-state { font-size: 10px; color: #333; margin-top: 2px; }
        #billingGstIncludedInvoice .gi-from-section { font-size: 11px; padding: 8px 0; border-bottom: 1px dashed #999; margin-bottom: 12px; }
        #billingGstIncludedInvoice .gi-from-label { font-weight: bold; }
        #billingGstIncludedInvoice .gi-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
        #billingGstIncludedInvoice .gi-logo img { height: 40px; width: auto; }
        #billingGstIncludedInvoice .gi-title { text-align: center; flex: 1; }
        #billingGstIncludedInvoice .gi-title h3 { font-size: 16px; font-weight: bold; margin: 0; text-transform: uppercase; }
        #billingGstIncludedInvoice .gi-company { text-align: right; font-size: 10px; line-height: 1.3; }
        #billingGstIncludedInvoice .gi-company-name { font-weight: 600; font-size: 11px; }
        #billingGstIncludedInvoice .gi-table { width: 100%; border-collapse: collapse; margin-bottom: 0; font-size: 10px; table-layout: fixed; }
        #billingGstIncludedInvoice .gi-table th { background: #d4edda; border: 1px solid #999; padding: 5px 4px; font-size: 9px; font-weight: bold; text-align: center; white-space: nowrap; }
        #billingGstIncludedInvoice .gi-table td { border: 1px solid #999; padding: 5px 4px; font-size: 10px; text-align: center; white-space: nowrap; }
        #billingGstIncludedInvoice .gi-table td.product-name { text-align: left; white-space: normal; }
        #billingGstIncludedInvoice .gi-summary-row { display: flex; justify-content: space-between; border: 1px solid #999; border-top: none; font-size: 11px; }
        #billingGstIncludedInvoice .gi-summary-row .label { padding: 6px 8px; flex: 1; font-weight: 600; color: #dc3545; }
        #billingGstIncludedInvoice .gi-summary-row .amount { padding: 6px 8px; width: 80px; text-align: right; border-left: 1px solid #999; color: #dc3545; }
        #billingGstIncludedInvoice .gi-total-row { font-size: 12px; font-weight: bold; }
        #billingGstIncludedInvoice .gi-footer { margin-top: 15px; text-align: center; font-size: 10px; color: #333; line-height: 1.5; border-top: 1px dashed #999; padding-top: 10px; }
        #billingGstIncludedInvoice .gi-footer a { color: #dc3545; text-decoration: none; }
        #billingGstIncludedInvoice .gst-highlight { color: #0066cc; font-weight: 600; }

        /* Print Controls Styles */
        .no-print {
            margin-bottom: 15px;
            text-align: right;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .print-btn-green {
            padding: 10px 15px;
            background: #22c55e;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
        }

        .print-btn-yellow {
            padding: 10px 15px;
            background: #eab308;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-weight: bold;
            font-size: 14px;
        }

        @media print {
            @page { size: A4 portrait; margin: 0; }
            body { background: #fff; margin: 0 !important; padding: 0 !important; width: 100%; height: auto !important; overflow: visible !important; }
            .no-print { display: none !important; }
            .invoice-container { margin: 0 !important; padding: 10mm !important; width: 100% !important; max-width: none !important; border: none !important; box-shadow: none !important; }
            .footer { margin-top: 20px; page-break-inside: avoid; }
            
            body.print-gst-included #billingGstNotIncludedInvoice {
                display: none !important;
            }
            body.print-gst-included #billingGstIncludedInvoice {
                display: block !important;
            }

            body.print-gst-not-included #billingGstIncludedInvoice {
                display: none !important;
            }
            body.print-gst-not-included #billingGstNotIncludedInvoice {
                display: block !important;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Print Buttons -->
        <div class="no-print">
            <button class="print-btn-green" onclick="printInvoice('included')">🖨️ Print (GST Included)</button>
            <button class="print-btn-yellow" onclick="printInvoice('not_included')">🖨️ Print (GST Not Included)</button>
        </div>

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
        @endphp

        <!-- =========================================
             1. GST NOT INCLUDED INVOICE (ESTIMATE)
             ========================================= -->
        <div id="billingGstNotIncludedInvoice">
            <div class="top-section">
                <div class="to-section">
                    <div class="to-label">To,</div>
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
                    <div class="order-date">Order Date: {{ $order->created_at->format('d-m-Y') }}</div>
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
                        <th style="width: 80px;">PRICE</th>
                        <th style="width: 50px;">QTY</th>
                        <th style="width: 100px;">SUB TOTAL</th>
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
                            <td style="white-space: nowrap;">₹{{ number_format($item->price, 0) }}</td>
                            <td>{{ $item->quantity ?? $item->qty ?? 1 }}</td>
                            <td class="subtotal-col" style="white-space: nowrap;">₹{{ number_format($lineTotal, 0) }}</td>
                        </tr>
                    @endforeach
                    {{-- Summary rows --}}
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold; color: #dc3545; border: 1px solid #999;">Shipping Charges</td>
                        <td style="text-align: right; font-weight: bold; color: #dc3545; border: 1px solid #999; white-space: nowrap;">
                            @if(($order->shipping_amount ?? 0) == 0)
                                Free
                            @else
                                ₹{{ number_format($order->shipping_amount, 0) }}
                            @endif
                        </td>
                    </tr>
                    @if(($order->discount_amount ?? 0) > 0)
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold; color: #28a745; border: 1px solid #999;">Coupon Discount @if($order->coupon_code)({{ $order->coupon_code }})@endif</td>
                        <td style="text-align: right; font-weight: bold; color: #28a745; border: 1px solid #999; white-space: nowrap;">- ₹{{ number_format($order->discount_amount, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="4" style="text-align: right; font-weight: bold; color: #dc3545; font-size: 12px; border: 1px solid #999;">TOTAL</td>
                        <td style="text-align: right; font-weight: bold; color: #dc3545; font-size: 14px; border: 1px solid #999; white-space: nowrap;">₹{{ number_format($order->final_amount ?? $order->total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="footer">
                <p>Thank you for shopping with us and we hope to serve you again in the future. Please feel free to write to us at <a href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a> for any queries, suggestions, complaints or anything else.</p>
            </div>
        </div>

        <!-- =========================================
             2. GST INCLUDED INVOICE (TAX INVOICE)
             ========================================= -->
        <div id="billingGstIncludedInvoice">
            <!-- Top Section -->
            <div class="gi-top-section">
                <div class="gi-to-section">
                    <div class="gi-to-label">To,</div>
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
                    <h3>Estimate Invoice</h3>
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
                                    $displayVariant = $item->variant->quantity->name ?? $item->variant->quantity->label ?? $item->variant_name;
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
                <p>Thank you for shopping with us and we hope to serve you again in the future. Please feel free to write to us at <a href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a> for any queries, suggestions, complaints or anything else.</p>
            </div>
        </div>
    </div>

    <!-- Print Helper Script -->
    <script>
        function printInvoice(type) {
            document.body.classList.remove('print-gst-included', 'print-gst-not-included');
            if (type === 'included') {
                document.body.classList.add('print-gst-included');
            } else {
                document.body.classList.add('print-gst-not-included');
            }
            setTimeout(() => {
                window.print();
                setTimeout(() => {
                    document.body.classList.remove('print-gst-included', 'print-gst-not-included');
                }, 500);
            }, 200);
        }
    </script>
</body>

</html>