<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'type',
        'from_id',
        'from_role',
        'ref_id',
        'extra_data',
        'status',
    ];

    protected $casts = [
        'extra_data' => 'array',
         'status' => 'string',
    ];

    // One notification -> many NotificationUser rows
    public function recipients()
    {
        return $this->hasMany(NotificationUser::class, 'notification_id');
    }
}
