<?php

declare(strict_types=1);

namespace App\Modules\Activity\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Models\User;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'module',
        'action',
        'description',
        'ip_address',
    ];

    protected $appends = [
        'icon',
        'color',
        'title',
    ];

    public function getIconAttribute(): string
    {
        return match ($this->module) {
            'wallet' => 'wallet',
            'subscription' => 'wifi',
            'invoice' => 'receipt',
            'payment' => 'payments',
            'mikrotik' => 'router',
            'notification' => 'notifications',
            default => 'history',
        };
    }

    public function getColorAttribute(): string
    {
        return match ($this->module) {
            'wallet' => 'warning',
            'subscription' => 'primary',
            'invoice' => 'success',
            'payment' => 'info',
            'mikrotik' => 'secondary',
            'notification' => 'danger',
            default => 'dark',
        };
    }

    public function getTitleAttribute(): string
    {
        return ucwords(
            str_replace('_', ' ', $this->action)
        );
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
