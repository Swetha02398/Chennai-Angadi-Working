<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HsnCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'description',
        'gst_rate',
        'cgst_rate',
        'sgst_rate',
        'igst_rate',
        'effective_from',
        'effective_to',
        'status',
        'category',
        'last_updated_by',
    ];

    protected $casts = [
        'gst_rate' => 'decimal:2',
        'cgst_rate' => 'decimal:2',
        'sgst_rate' => 'decimal:2',
        'igst_rate' => 'decimal:2',
        'status' => 'boolean',
        'effective_from' => 'date',
        'effective_to' => 'date',
    ];
}
