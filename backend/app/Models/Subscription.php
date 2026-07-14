<?php

declare(strict_types=1);

namespace App\Models;

use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use App\Modules\Subscription\Domain\Exceptions\InvalidStateTransitionException;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Subscription extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $table = 'subscriptions';

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

        'status' => SubscriptionStatus::class,

        'monthly_price' => 'decimal:2',
        'wallet_balance' => 'decimal:2',
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
        return $this->morphMany(
            ActivityLog::class,
            'subject'
        );
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
    | State Helpers
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->status === SubscriptionStatus::ACTIVE;
    }

    public function isSuspended(): bool
    {
        return $this->status === SubscriptionStatus::SUSPENDED;
    }

    public function isExpired(): bool
    {
        return $this->status === SubscriptionStatus::EXPIRED;
    }

    public function isGrace(): bool
    {
        return $this->status === SubscriptionStatus::GRACE;
    }

    public function isCancelled(): bool
    {
        return $this->status === SubscriptionStatus::CANCELLED;
    }

    public function isTerminated(): bool
    {
        return $this->status === SubscriptionStatus::TERMINATED;
    }

    public function isClosed(): bool
    {
        return in_array(
            $this->status,
            [
                SubscriptionStatus::CANCELLED,
                SubscriptionStatus::TERMINATED,
            ],
            true
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Transition Guards
    |--------------------------------------------------------------------------
    */

    public function canActivate(): bool
    {
        return $this->status->canActivate();
    }

    public function canSuspend(): bool
    {
        return $this->status->canSuspend();
    }

    public function canExpire(): bool
    {
        return $this->status->canExpire();
    }

    public function canRestore(): bool
    {
        return $this->status->canRestore();
    }

    public function canRenew(): bool
    {
        return $this->status->canRenew();
    }

    public function canCancel(): bool
    {
        return $this->status->canCancel();
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            SubscriptionStatus::ACTIVE
        );
    }

    public function scopeExpired(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            SubscriptionStatus::EXPIRED
        );
    }

    public function scopeSuspended(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            SubscriptionStatus::SUSPENDED
        );
    }

    public function scopeGrace(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            SubscriptionStatus::GRACE
        );
    }

    public function scopeCancelled(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            SubscriptionStatus::CANCELLED
        );
    }

    public function scopeTerminated(
        Builder $query
    ): Builder {
        return $query->where(
            'status',
            SubscriptionStatus::TERMINATED
        );
    }
}
