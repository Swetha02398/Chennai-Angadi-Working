<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRuleSlab extends Model
{
    protected $fillable = [
        'shipping_rule_id',
        'min_slab',
        'max_slab',
        'shipping_amount',
    ];

    public function rule()
    {
        return $this->belongsTo(ShippingRule::class);
    }
}