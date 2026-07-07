<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'customer_type',
        'title',
        'name',
        'phone',
        'email',
        'address',
        'landmark',
        'city',
        'state',
        'pincode',
        'country',
        'latitude',
        'longitude',
        'is_default',
        'status',
    ];

    /**
     * Relation: An address belongs to one customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
