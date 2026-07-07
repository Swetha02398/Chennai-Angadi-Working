<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{
    protected $table = 'notification_users';

    protected $fillable = [
        'notification_id',
        'users',   // JSON column
        'role',
        'status',
        'is_read',
        'read_at'
    ];
    protected $casts = [
        'users' => 'array', // automatically decode JSON
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}
