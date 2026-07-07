<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Package extends Model
{
    use HasFactory;
    use BelongsToTenant;
    protected $fillable = [
        'tenant_id',
        'name',
        'download_speed',
        'upload_speed',
        'price',
        'quota_gb',
        'status',
        'description',
        'mikrotik_profile',
        'billing_cycle',
        'billing_interval',
        'grace_days',
        'auto_suspend',
        'auto_expire',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
