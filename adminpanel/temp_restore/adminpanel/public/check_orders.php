<?php

// Bootstrap Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Order;

$orders = Order::all();
echo "Total orders: " . $orders->count() . "\n";

$issues = 0;
foreach ($orders as $order) {
    // Check if billing_address is a string
    if (is_string($order->billing_address)) {
        echo "Order ID {$order->id} ({$order->order_number}) billing_address is string: " . substr($order->billing_address, 0, 50) . "...\n";
        $issues++;
    }
    
    // Check if billing_address is null
    if ($order->billing_address === null) {
        echo "Order ID {$order->id} ({$order->order_number}) billing_address is null\n";
        $issues++;
    }

    // Check if guest_details is string or invalid
    if ($order->customer_type === 'guest' && is_string($order->guest_details)) {
        echo "Order ID {$order->id} ({$order->order_number}) guest_details is string: " . substr($order->guest_details, 0, 50) . "...\n";
        $issues++;
    }
}

if ($issues === 0) {
    echo "No issues found in orders data!\n";
} else {
    echo "Found {$issues} issues.\n";
}
