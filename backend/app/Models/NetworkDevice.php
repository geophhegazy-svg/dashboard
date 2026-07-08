<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class NetworkDevice extends Model
{
    use HasFactory, SoftDeletes;
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'ip_address',
        'username',
        'password',
        'type', // mikrotik, cisco, ubiquiti, etc.
        'port',
        'status', // active, inactive
        'is_online',
        'last_ping_at',
        'last_sync_at',
        'last_error',
        'notes',
    ];

    protected $casts = [
        'is_online' => 'boolean',
        'last_ping_at' => 'datetime',
        'last_sync_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * العلاقة مع مستخدمي PPPoE
     */
    public function pppoeUsers()
    {
        return $this->hasMany(PPPoEUser::class, 'mikrotik_device_id');
    }

    /**
     * التحقق مما إذا كان الجهاز متصلاً
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
            'last_ping_at' => now(),
            'status' => $status ? 'active' : 'inactive',
        ]);
    }

    /**
     * نطاق البحث عن الأجهزة النشطة
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * نطاق البحث عن الأجهزة المتصلة
     */
    public function scopeOnline($query)
    {
        return $query->where('is_online', true);
    }

    /**
     * نطاق البحث عن أجهزة MikroTik
     */
    public function scopeMikrotik($query)
    {
        return $query->where('type', 'mikrotik');
    }
}
