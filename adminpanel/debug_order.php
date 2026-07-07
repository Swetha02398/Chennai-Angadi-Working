<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Order;

$order = Order::find(150);
if ($order) {
    echo "Order ID: " . $order->id . "\n";
    echo "Payment Method: '" . $order->payment_method . "'\n";
    echo "COD Charge: " . $order->cod_charge . "\n";
    echo "Total Amount: " . $order->total_amount . "\n";
    echo "Final Amount: " . $order->final_amount . "\n";
} else {
    echo "Order not found\n";
}
