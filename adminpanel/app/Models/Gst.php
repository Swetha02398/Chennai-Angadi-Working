<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gst extends Model
{
    use HasFactory;

     protected $fillable = [
        'default_tax_rate',
        'enable_auto_gst',
        'gst_rules',
        'rounding_method',
        'last_updated_by',
        'notes',
    ];

    protected $casts = [
        'enable_auto_gst' => 'boolean',
        'default_tax_rate' => 'decimal:2',
        'gst_rules' => 'array',
    ];
}
