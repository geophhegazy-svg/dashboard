<?php

declare(strict_types=1);

namespace App\Modules\Network\Infrastructure\Persistence\Models;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PPPoEUser extends Model
{
    use HasFactory, SoftDeletes;
    use BelongsToTenant;

    protected $table = 'pppoe_users';

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'username',
        'password',
        'mikrotik_device_id',
        'profile',
        'queue',
        'status',
        'is_online',
        'last_login_at',
        'last_sync_at',
        'notes',
    ];

    protected $casts = [
        'is_online' => 'boolean',
        'last_login_at' => 'datetime',
        'last_sync_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function device()
    {
        return $this->belongsTo(NetworkDevice::class, 'mikrotik_device_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isOnline(): bool
    {
        return $this->is_online ?? false;
    }

    public function updateOnlineStatus(bool $status): void
    {
        $this->update([
            'is_online' => $status,
            'last_login_at' => $status ? now() : $this->last_login_at,
        ]);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOnline($query)
    {
        return $query->where('is_online', true);
    }

    public function scopeDisabled($query)
    {
        return $query->where('status', 'disabled');
    }
}
