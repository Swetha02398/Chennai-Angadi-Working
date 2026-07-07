<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quantity extends Model
{
    use HasFactory;

    protected $table = 'quantities';

    protected $fillable = [
        'name',
        'label',
        'status',
    ];

    /**
     * Get all product variants using this quantity
     */
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'quantity_id');
    }
}
