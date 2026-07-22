<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin: New Order Placed!</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .header {
            background-color: #FFA500;
            /* Orange/Yellow */
            padding: 20px;
            text-align: center;
        }

        .logo {
            max-width: 200px;
            height: auto;
        }

        /* Body Content */
        .content {
            padding: 30px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #d9534f; /* Alert red */
        }

        .order-alert {
            font-size: 22px;
            font-weight: 800;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .intro-text {
            font-size: 14px;
            color: #555;
            margin-bottom: 30px;
        }

        /* Order Details Section */
        .order-info-grid {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }

        .order-info-left {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            font-size: 14px;
            line-height: 1.8;
        }

        .order-info-right {
            display: table-cell;
            width: 50%;
            text-align: right;
            vertical-align: top;
            font-size: 14px;
            line-height: 1.5;
        }

        .label {
            display: inline-block;
            width: 100px;
            color: #333;
        }

        /* Product Table */
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .product-table th {
            background-color: #e0e0e0;
            padding: 10px;
            text-align: left;
            font-weight: 700;
            border: 1px solid #ddd;
        }

        .product-table td {
            padding: 10px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        /* Totals */
        .totals-container {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-container td {
            padding: 8px 10px;
            font-size: 14px;
            font-weight: 700;
        }

        /* Action Button */
        .btn-container {
            text-align: center;
            margin: 40px 0;
        }

        .btn-action {
            background-color: #3BB77E;
            color: #ffffff !important;
            padding: 15px 35px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            display: inline-block;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        /* Footer */
        .footer-bar {
            background-color: #FFA500;
            color: #fff;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            margin-top: 30px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header with Logo -->
        <div class="header">
            <img src="{{ $message->embed(public_path('assets/imgs/images/ChennaiAngadiLogo.png')) }}"
                alt="ChennaiAngadi.com" class="logo">
        </div>

        <div class="content">
            <!-- Alert Header -->
            @if($order->order_type == 'billing')
                <div class="greeting">ADMIN NOTIFICATION (POS BILLING)</div>
                <div class="order-alert">NEW ORDER PLACED!</div>
                <div class="intro-text">
                    A new order has been created through the Admin Panel POS Billing system. Please review the details below.
                </div>
            @else
                <div class="greeting">ADMIN NOTIFICATION</div>
                <div class="order-alert">NEW ORDER PLACED!</div>
                <div class="intro-text">
                    A new customer order has been received on ChennaiAngadi.com. Please review the details below and prepare for fulfillment.
                </div>
            @endif

            <!-- Order Details -->
            <div class="order-info-grid">
                <div class="order-info-left">
                    <div><span class="label">Order ID</span> : {{ $order->order_number }}</div>
                    <div><span class="label">Order Date</span> : {{ $order->placed_at->format('d-M-Y') }}</div>
                    <div><span class="label">Order Time</span> : {{ $order->placed_at->format('H:i:s') }}</div>
                    <div><span class="label">Customer Name</span> : {{ $order->billing_address['name'] }}</div>
                    <div><span class="label">Customer Email</span> : {{ $order->billing_address['email'] }}</div>
                    <div><span class="label">Payment Method</span> :
                        {{ $order->payment_method == 'cash_on_delivery' ? 'Cash on Delivery' : 'Online Payment' }}
                    </div>
                </div>
                <div class="order-info-right">
                    <strong>Shipping Address:</strong><br>
                    {{ $order->shipping_address['name'] }},<br>
                    {{ $order->shipping_address['address'] }},<br>
                    {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} - {{ $order->shipping_address['pincode'] }}<br>
                    Ph: {{ $order->shipping_address['phone'] }}
                </div>
            </div>

            <!-- Product Table -->
            <table class="product-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">S.No</th>
                        <th>Product name</th>
                        <th class="text-right">Price</th>
                        <th class="text-right" style="width: 50px;">Qty</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                {{ $item->product_productname }}
                                @if($item->variant_name)
                                    <br><small style="color: #666;">({{ $item->variant_name }})</small>
                                @endif
                            </td>
                            <td class="text-right">Rs. {{ number_format($item->price, 2) }}</td>
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-right">Rs. {{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Totals Section -->
            <table class="totals-container">
                <tr>
                    <td class="text-right" style="border-top: 1px solid #ddd;">Total :</td>
                    <td class="text-right" style="width: 120px; border-top: 1px solid #ddd;">Rs.
                        {{ number_format($order->subtotal - $order->discount_amount, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="text-right">Shipping Charges :</td>
                    <td class="text-right">
                        @if($order->shipping_amount > 0)
                            Rs. {{ number_format($order->shipping_amount, 2) }}
                        @else
                            Free
                        @endif
                    </td>
                </tr>

                @if($order->cod_charge > 0)
                    <tr>
                        <td class="text-right">COD Charge :</td>
                        <td class="text-right">Rs. {{ number_format($order->cod_charge, 2) }}</td>
                    </tr>
                @endif

                <tr>
                    <td class="text-right" style="border-top: 1px solid #ddd; padding-top: 10px;">Net Payable Amount :
                    </td>
                    <td class="text-right" style="border-top: 1px solid #ddd; padding-top: 10px;">Rs.
                        {{ number_format($order->final_amount, 2) }}
                    </td>
                </tr>
            </table>

            <!-- Action Button -->
            <div class="btn-container">
                <a href="{{ rtrim(config('app.admin_url'), '/') }}/orders/view/{{ $order->id }}" class="btn-action">
                    View Order in Admin Panel
                </a>
            </div>

            <div class="intro-text" style="text-align: center; margin-top: 20px;">
                Note: Please log in to the admin panel to manage this order and update its status.
            </div>
        </div>

        <!-- Footer Bar -->
        <div class="footer-bar">
            Chennai Angadi Admin Notification System<br>
            Automated Message - Please do not reply to this email.
        </div>
    </div>
</body>

</html>
