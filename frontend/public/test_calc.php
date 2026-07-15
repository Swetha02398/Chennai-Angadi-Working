<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Illuminate\Http\Request::capture());

$req = new Illuminate\Http\Request();
$req->merge(['state' => 'Tamil Nadu', 'subtotal' => 290]);
$controller = app('App\Http\Controllers\Web\CheckoutController');
$res = $controller->calculateShipping($req);
echo $res->getContent();
?>
