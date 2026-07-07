<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingRule extends Model
{
    protected $fillable = [
        'shipping_zone_id',
        'states',
        'condition_type',
        'is_active',
    ];

    protected $casts = [
        'states' => 'array',
    ];

    public function zone()
    {
        return $this->belongsTo(ShippingZone::class, 'shipping_zone_id');
    }

    public function slabs()
    {
        return $this->hasMany(ShippingRuleSlab::class);
    }
}