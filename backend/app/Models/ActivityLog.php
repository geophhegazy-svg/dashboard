<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class ActivityLog extends Model
{
    use BelongsToTenant;

    protected $fillable = [

        'tenant_id',

        'user_id',

        'module',

        'action',

        'description',

        'ip_address'

    ];
    protected $appends = [
        'icon',
        'color',
        'title'
    ];
    public function getIconAttribute()
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

    public function getColorAttribute()
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

    public function getTitleAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->action));
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
