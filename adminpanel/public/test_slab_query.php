<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(Illuminate\Http\Request::capture());

$calculationAmount = 290;
$ruleId = 6;
$slab = App\Models\ShippingRuleSlab::where('shipping_rule_id', $ruleId)
            ->where('min_slab', '<=', $calculationAmount)
            ->where(function ($query) use ($calculationAmount) {
                $query->where('max_slab', '>=', $calculationAmount)
                    ->orWhereNull('max_slab');
            })
            ->first();
print_r($slab ? $slab->toArray() : 'NO MATCH');
?>
