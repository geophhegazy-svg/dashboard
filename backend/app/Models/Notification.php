<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [

        'tenant_id',

        'customer_id',

        'subscription_id',

        'type',

        'reminder_day',

        'title',

        'message',

        'is_read',

        'sent_at',

    ];

    protected $casts = [

        'is_read' => 'boolean',

        'sent_at' => 'datetime',

    ];
}
