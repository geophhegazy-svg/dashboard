<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

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
        'status', // active, disabled, expired
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

    /**
     * العلاقة مع العميل
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * العلاقة مع جهاز MikroTik
     */
    public function device()
    {
        return $this->belongsTo(NetworkDevice::class, 'mikrotik_device_id');
    }

    /**
     * التحقق مما إذا كان المستخدم نشطاً
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * التحقق مما إذا كان المستخدم متصلاً
     */
    public function isOnline(): bool
    {
        return $this->is_online ?? false;
    }

    /**
     * تحديث حالة الاتصال
     */
    public function updateOnlineStatus(bool $status): void
    {
        $this->update([
            'is_online' => $status,
            'last_login_at' => $status ? now() : $this->last_login_at,
        ]);
    }

    /**
     * نطاق البحث عن المستخدمين النشطين
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * نطاق البحث عن المستخدمين المتصلين
     */
    public function scopeOnline($query)
    {
        return $query->where('is_online', true);
    }

    /**
     * نطاق البحث عن المستخدمين المعطلين
     */
    public function scopeDisabled($query)
    {
        return $query->where('status', 'disabled');
    }
}
