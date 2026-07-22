<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
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
        .totals-row td {
            font-weight: 700;
            border: none;
            padding: 5px 10px;
        }

        .totals-container {
            width: 100%;
            border-collapse: collapse;
        }

        .totals-container td {
            padding: 8px 10px;
            font-size: 14px;
            font-weight: 700;
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
            <img src="<?php echo e($message->embed(public_path('assets/imgs/images/ChennaiAngadiLogo.png'))); ?>"
                alt="ChennaiAngadi.com" class="logo">
        </div>

        <div class="content">
            <!-- Greeting -->
            <div class="greeting">
                Hi! <?php echo e($order->billing_address['name']); ?>,
            </div>

            <div class="intro-text">
                Thank you for shopping with ChennaiAngadi.com!<br>
                This email contains important information about your order. Please save it for future reference.
            </div>

            <!-- Order Details -->
            <div class="order-info-grid">
                <div class="order-info-left">
                    <div><span class="label">Order ID</span> : <?php echo e($order->order_number); ?></div>
                    <div><span class="label">Order Date</span> : <?php echo e($order->placed_at->format('d-M-Y')); ?></div>
                    <div><span class="label">Order Time</span> : <?php echo e($order->placed_at->format('H:i:s')); ?></div>
                    <div><span class="label">Payment Method</span> :
                        <?php echo e($order->payment_method == 'cash_on_delivery' ? 'Cash on Delivery' : 'Online Payment'); ?>

                    </div>
                </div>
                <div class="order-info-right">
                    <strong><?php echo e($order->shipping_address['name']); ?></strong>,<br>
                    <?php echo e($order->shipping_address['address']); ?>,<br>
                    <?php echo e($order->shipping_address['city']); ?>,<br>
                    Ph: <?php echo e($order->shipping_address['phone']); ?>

                </div>
            </div>

            <!-- Product Table -->
            <table class="product-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">S#</th>
                        <th>Product name</th>
                        <th class="text-right">Price</th>
                        <th class="text-right" style="width: 50px;">Qty</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e($index + 1); ?></td>
                            <td>
                                <?php echo e($item->product_productname); ?>

                                <?php if($item->variant_name): ?>
                                    <br><small style="color: #666;">(<?php echo e($item->variant_name); ?>)</small>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">Rs. <?php echo e(number_format($item->price, 2)); ?></td>
                            <td class="text-center"><?php echo e($item->qty); ?></td>
                            <td class="text-right">Rs. <?php echo e(number_format($item->total, 2)); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>

            <!-- Totals Section -->
            <table class="totals-container">
                <tr>
                    <td class="text-right" style="border-top: 1px solid #ddd;">Total :</td>
                    <td class="text-right" style="width: 120px; border-top: 1px solid #ddd;">Rs.
                        <?php echo e(number_format($order->subtotal - $order->discount_amount, 2)); ?>

                    </td>
                </tr>
                <tr>
                    <td class="text-right">Shipping Charges :</td>
                    <td class="text-right">
                        <?php if($order->shipping_amount > 0): ?>
                            Rs. <?php echo e(number_format($order->shipping_amount, 2)); ?>

                        <?php else: ?>
                            Free
                        <?php endif; ?>
                    </td>
                </tr>

                <?php if(in_array($order->payment_method, ['cash_on_delivery', 'cod'])): ?>
                <?php if($order->cod_charge > 0): ?>
                    <tr>
                        <td class="text-right">COD Charge :</td>
                        <td class="text-right">Rs. <?php echo e(number_format($order->cod_charge, 2)); ?></td>
                    </tr>
                <?php endif; ?>
                <?php endif; ?>

                <tr>
                    <td class="text-right" style="border-top: 1px solid #ddd; padding-top: 10px;">Net Payable Amount :
                    </td>
                    <td class="text-right" style="border-top: 1px solid #ddd; padding-top: 10px;">Rs.
                        <?php echo e(number_format($order->final_amount, 2)); ?>

                    </td>
                </tr>
            </table>

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

</html><?php /**PATH C:\xampp\htdocs\chennais\frontend\resources\views/emails/order-placed.blade.php ENDPATH**/ ?>