<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'email_type',
        'recipient_email',
        'recipient_name',
        'subject',
        'order_number',
        'status',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Get email type label
    public function getEmailTypeLabelAttribute()
    {
        return match ($this->email_type) {
            'order_confirmation' => 'Order Confirmation',
            'status_update' => 'Status Update',
            'billing_invoice' => 'Billing Invoice',
            default => ucfirst(str_replace('_', ' ', $this->email_type))
        };
    }

    // Get status badge class
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'sent' => 'bg-success',
            'failed' => 'bg-danger',
            default => 'bg-secondary'
        };
    }
}
