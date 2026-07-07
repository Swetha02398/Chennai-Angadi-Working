<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    // Mass assignable fields
     protected $table = 'customers';
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
        'fcm_token',
        'device_type',
    ];
    
}
