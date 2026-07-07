<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;
    // Mass assignable fields
    protected $fillable = [
        'username',
        'email',
        'password',
        'mobilenumber',
        'address',
        'pin',
        'gender',
        'dob',
        'profile_image',
        'city',
        'state',
        'country',
        'agree',
        'status',
    ];

    public function wishlist()
    {
        return $this->hasMany(\App\Models\Wishlist::class, 'customer_id');
    }

    public function addresses()
    {
        return $this->hasMany(\App\Models\AddressBook::class, 'customer_id');
    }

}
