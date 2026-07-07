<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    // ✅ Add this line here
    protected $table = 'coupons';

    protected $fillable = [
        'code',
        'description',
        'type',
        'value',
        'min_amount',
        'max_discount',
        'usage_limit',
        'used_count',
        'per_user_limit',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'status',
        'created_by'
    ];

    protected $casts = [
        'status' => 'boolean',
        'value' => 'decimal:2',
        'min_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
