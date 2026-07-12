<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\Shared\Exceptions\InvalidStateTransitionException;
use App\Enums\SubscriptionStatus;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Subscription extends Model
{
    use HasFactory;
    use BelongsToTenant;

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

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function activityLogs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    /*
    |--------------------------------------------------------------------------
    | State Machine
    |--------------------------------------------------------------------------
    */

    public function transitionTo(
        SubscriptionStatus $target
    ): self {

        if (! $this->status->canTransitionTo($target)) {
            throw InvalidStateTransitionException::fromStates(
                $this->status,
                $target
            );
        }

        $this->status = $target;

        return $this;
    }

    public function activate(): self
    {
        return $this->transitionTo(
            SubscriptionStatus::ACTIVE
        );
    }

    public function suspend(): self
    {
        return $this->transitionTo(
            SubscriptionStatus::SUSPENDED
        );
    }

    public function restore(): self
    {
        return $this->transitionTo(
            SubscriptionStatus::ACTIVE
        );
    }

    public function expire(): self
    {
        return $this->transitionTo(
            SubscriptionStatus::EXPIRED
        );
    }

    public function enterGrace(): self
    {
        return $this->transitionTo(
            SubscriptionStatus::GRACE
        );
    }

    public function cancel(): self
    {
        return $this->transitionTo(
            SubscriptionStatus::CANCELLED
        );
    }

    public function terminate(): self
    {
        return $this->transitionTo(
            SubscriptionStatus::TERMINATED
        );
    }

    public function renew(
        int $days = 30
    ): self {

        $this->transitionTo(
            SubscriptionStatus::ACTIVE
        );

        $this->end_date = $this->end_date
            ? $this->end_date->copy()->addDays($days)
            : now()->addDays($days);

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function isExpired(): bool
    {
        return $this->status->isExpired();
    }

    public function isSuspended(): bool
    {
        return $this->status->isSuspended();
    }

    public function isGrace(): bool
    {
        return $this->status->isGrace();
    }

    public function isCancelled(): bool
    {
        return $this->status->isCancelled();
    }

    public function isClosed(): bool
    {
        return $this->status->isClosed();
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

    public function canExpire(): bool
    {
        return $this->status->canExpire();
    }

    public function canRestore(): bool
    {
        return $this->status->canRestore();
    }

    public function canCancel(): bool
    {
        return $this->status->canCancel();
    }
}
