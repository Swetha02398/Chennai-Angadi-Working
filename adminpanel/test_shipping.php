<?php
$req = new \Illuminate\Http\Request();
$req->replace([
    'state'=>'Andhra Pradesh',
    'order_total'=>249,
    'total_weight'=>0,
    'items' => [
        [
            'qty' => 1,
            'variant_name' => '1300'
        ]
    ]
]);
$controller = app()->make(\App\Http\Controllers\Web\Order\BillingController::class);
echo $controller->calculateShipping($req)->getContent();
