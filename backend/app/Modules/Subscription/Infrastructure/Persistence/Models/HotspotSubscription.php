<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Infrastructure\Persistence\Models;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Database\Factories\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscriptionFactory;

class HotspotSubscription extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected static function newFactory(): HotspotSubscriptionFactory
    {
        return HotspotSubscriptionFactory::new();
    }

    protected $table = 'hotspot_subscriptions';

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'package_id',
        'hotspot_username',
        'hotspot_password',
        'mikrotik_profile',
        'start_date',
        'end_date',
        'monthly_price',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'monthly_price' => 'decimal:2',
    ];

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
}
