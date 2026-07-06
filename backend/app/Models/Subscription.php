<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SubscriptionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LogicException;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'package_id',
        'start_date',
        'end_date',
        'monthly_price',
        'status',
        'notes',
        'pppoe_username',
        'pppoe_password',
        'mikrotik_profile',
        'wallet_balance',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'status'     => SubscriptionStatus::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    /*
    |--------------------------------------------------------------------------
    | State Transitions
    |--------------------------------------------------------------------------
    */

    public function activate(): void
    {
        if (! $this->canActivate()) {
            throw new LogicException(
                "Subscription cannot be activated from [{$this->status->value}] state."
            );
        }

        $this->status = SubscriptionStatus::ACTIVE;
    }

    public function suspend(): void
    {
        if (! $this->canSuspend()) {
            throw new LogicException(
                "Subscription cannot be suspended from [{$this->status->value}] state."
            );
        }

        $this->status = SubscriptionStatus::SUSPENDED;
    }

    public function expire(): void
    {
        if (! $this->status->canExpire()) {
            throw new LogicException(
                "Subscription cannot expire from [{$this->status->value}] state."
            );
        }

        $this->status = SubscriptionStatus::EXPIRED;
    }

    public function restore(): void
    {
        if (! $this->status->canRestore()) {
            throw new LogicException(
                "Subscription cannot be restored from [{$this->status->value}] state."
            );
        }

        $this->status = SubscriptionStatus::ACTIVE;
    }

    /*
    |--------------------------------------------------------------------------
    | State Helpers
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function canActivate(): bool
    {
        return $this->status->canActivate();
    }

    public function canSuspend(): bool
    {
        return $this->status->canSuspend();
    }

    public function canRenew(): bool
    {
        return $this->status->canRenew();
    }
}
