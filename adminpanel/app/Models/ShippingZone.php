<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ShippingZone extends Model
{
    protected $fillable = ['name','priority','is_active'];

  public function regions()
{
    return $this->hasMany(ShippingZoneRegion::class, 'shipping_zone_id');
}

public function rules()
{
    return $this->hasMany(ShippingRule::class, 'shipping_zone_id');
}

}
