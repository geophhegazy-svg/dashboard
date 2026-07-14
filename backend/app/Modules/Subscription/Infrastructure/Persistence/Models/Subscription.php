<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Infrastructure\Persistence\Models;

use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use App\Traits\BelongsToTenant;

use App\Models\Tenant;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\ActivityLog;

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

        'end_date' => 'datetime',


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
        return $this->belongsTo(
            Tenant::class
        );
    }



    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            Customer::class
        );
    }



    public function package(): BelongsTo
    {
        return $this->belongsTo(
            Package::class
        );
    }



    public function invoices(): HasMany
    {
        return $this->hasMany(
            Invoice::class
        );
    }



    public function payments(): HasMany
    {
        return $this->hasMany(
            Payment::class
        );
    }



    public function notifications(): HasMany
    {
        return $this->hasMany(
            Notification::class
        );
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
