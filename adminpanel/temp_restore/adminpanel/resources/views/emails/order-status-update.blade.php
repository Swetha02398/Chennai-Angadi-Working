<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update - {{ $order->order_number }}</title>
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
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #000;
        }

        .intro-text {
            font-size: 14px;
            color: #555;
            margin-bottom: 30px;
        }

        /* Status Badge */
        .status-container {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }

        .status-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            border-radius: 25px;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #ffc107;
            color: #000;
        }

        .status-confirmed {
            background-color: #28a745;
        }

        .status-packed {
            background-color: #17a2b8;
        }

        .status-shipped {
            background-color: #007bff;
        }

        .status-delivered {
            background-color: #28a745;
        }

        .status-cancelled {
            background-color: #dc3545;
        }

        /* Order Info */
        .order-info {
            background-color: #fff8e1;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .order-info-row {
            display: table;
            width: 100%;
            margin-bottom: 8px;
        }

        .order-info-label {
            display: table-cell;
            width: 120px;
            font-weight: 600;
            color: #333;
        }

        .order-info-value {
            display: table-cell;
            color: #555;
        }

        /* Notes Section */
        .notes-section {
            background-color: #e3f2fd;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #2196f3;
            margin-bottom: 25px;
        }

        .notes-title {
            font-size: 14px;
            font-weight: 700;
            color: #1565c0;
            margin-bottom: 10px;
        }

        .notes-content {
            font-size: 14px;
            color: #333;
            line-height: 1.8;
        }

        /* Footer */
        .footer-questions {
            margin-top: 40px;
            font-size: 14px;
            color: #333;
        }

        .footer-questions a {
            color: #0066cc;
            text-decoration: none;
        }

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
            <img src="{{ asset('assets/imgs/theme/ChennaiAngadiLogo.png') }}"
                alt="ChennaiAngadi.com" class="logo">
        </div>

        <div class="content">
            <!-- Greeting -->
            <div class="greeting">
                @if($order->customer_type === 'registered' && $order->customer)
                    Hi! {{ $order->customer->username ?? $order->customer->name ?? 'Valued Customer' }},
                @else
                    Hi! {{ $order->billing_address['name'] ?? $order->guest_details['name'] ?? 'Valued Customer' }},
                @endif
            </div>

            <div class="intro-text">
                We have an update on your order. Please find the details below.
            </div>

            <!-- Order Info -->
            <div class="order-info">
                <div class="order-info-row">
                    <span class="order-info-label">Order ID</span>
                    <span class="order-info-value">: {{ $order->order_number }}</span>
                </div>
                <div class="order-info-row">
                    <span class="order-info-label">Order Date</span>
                    <span class="order-info-value">: {{ $order->created_at->format('d-M-Y') }}</span>
                </div>
                <div class="order-info-row">
                    <span class="order-info-label">Total Amount</span>
                    <span class="order-info-value">: Rs.
                        {{ number_format($order->final_amount ?? $order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="status-container">
                <div class="status-label">Your Order Status</div>
                @php
                    $statusClass = match (strtolower($status)) {
                        'pending' => 'status-pending',
                        'confirmed' => 'status-confirmed',
                        'packed' => 'status-packed',
                        'shipped' => 'status-shipped',
                        'delivered' => 'status-delivered',
                        'cancelled' => 'status-cancelled',
                        default => 'status-pending'
                    };
                @endphp
                <span class="status-badge {{ $statusClass }}">{{ ucfirst($status) }}</span>
            </div>

            <!-- Notes Section -->
            @if($notes)
                <div class="notes-section">
                    <div class="notes-title">📝 Message from Chennai Angadi:</div>
                    <div class="notes-content">{!! $notes !!}</div>
                </div>
            @endif

            <!-- Footer Quote -->
            <div class="footer-questions">
                <strong>Got Questions?</strong><br>
                Call Us: 09094676665<br>
                Email: <a href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a>
                <br><br>
                <strong>Thank You,</strong><br>
                <strong>Team Chennai Angadi</strong>
            </div>
        </div>

        <!-- Footer Bar -->
        <div class="footer-bar">
            Chennai Angadi,<br>
            New # 15, Old # 8, Muthu Street, Mylapore, Chennai - 600004
        </div>
    </div>
</body>

</html>