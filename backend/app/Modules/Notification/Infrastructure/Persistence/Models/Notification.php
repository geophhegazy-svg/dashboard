<?php

declare(strict_types=1);

namespace App\Modules\Notification\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use BelongsToTenant;

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

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
