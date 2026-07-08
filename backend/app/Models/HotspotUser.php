<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;

class HotspotUser extends Model
{
    use HasFactory, SoftDeletes;
    use BelongsToTenant;

    protected $table = 'hotspot_users';

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'username',
        'password',
        'mikrotik_device_id',
        'profile',           // باقة Hotspot
        'status',            // active, disabled, expired
        'is_online',
        'uptime',
        'bytes_in',
        'bytes_out',
        'last_login_at',
        'expiry_date',
        'last_sync_at',
        'notes',
    ];

    protected $casts = [
        'is_online' => 'boolean',
        'uptime' => 'integer',
        'bytes_in' => 'integer',
        'bytes_out' => 'integer',
        'last_login_at' => 'datetime',
        'expiry_date' => 'datetime',
        'last_sync_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
    ];

    // العلاقات
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function device()
    {
        return $this->belongsTo(NetworkDevice::class, 'mikrotik_device_id');
    }

    // النطاقات (Scopes)
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOnline($query)
    {
        return $query->where('is_online', true);
    }

    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<', now());
    }

    // الدوال المساعدة
    public function isActive(): bool
    {
        return $this->status === 'active' && ($this->expiry_date === null || $this->expiry_date->isFuture());
    }

    public function isOnline(): bool
    {
        return $this->is_online ?? false;
    }

    public function getUptimeFormatted(): string
    {
        $seconds = $this->uptime ?? 0;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $secs);
    }

    public function getTrafficFormatted(): string
    {
        $bytes = $this->bytes_in + $this->bytes_out;
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 2) . ' KB';
        if ($bytes < 1073741824) return round($bytes / 1048576, 2) . ' MB';
        return round($bytes / 1073741824, 2) . ' GB';
    }
}
