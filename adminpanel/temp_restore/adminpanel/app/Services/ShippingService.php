<?php

namespace App\Services;

use App\Models\ShippingZoneRegion;
use App\Models\ShippingRule;

class ShippingService
{
    public static function shippingCharge($state, $weight)
    {
        $region = ShippingZoneRegion::where('state', $state)
            ->where('is_active',1)
            ->first();

        if (!$region) {
            return 0; // or throw exception
        }

        $rule = ShippingRule::where('shipping_zone_id', $region->shipping_zone_id)
            ->where('is_active',1)
            ->first();

        if (!$rule) {
            return 0;
        }

        $slabs = ceil($weight / $rule->slab_value);

        return max($slabs, $rule->min_slab) * $rule->cost_per_slab;
    }
}
