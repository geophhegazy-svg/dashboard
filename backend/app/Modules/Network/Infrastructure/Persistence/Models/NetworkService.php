<?php

declare(strict_types=1);

namespace App\Modules\Network\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Modules\Customer\Infrastructure\Persistence\Models\Area;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Package\Infrastructure\Persistence\Models\Package;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Subscription\Infrastructure\Persistence\Models\HotspotSubscription;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NetworkService extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'area_id',
        'package_id',
        'network_device_id',
        'connection_type',
        'username',
        'password',
        'mac_address',
        'ip_address',
        'ip_mode',
        'starts_at',
        'ends_at',
        'status',
        'provisioning_status',
        'last_provisioned_at',
        'last_sync_at',
        'last_error',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'last_provisioned_at' => 'datetime',
        'last_sync_at' => 'datetime',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function hotspotSubscriptions(): HasMany
    {
        return $this->hasMany(HotspotSubscription::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function networkDevice(): BelongsTo
    {
        return $this->belongsTo(NetworkDevice::class);
    }
}
