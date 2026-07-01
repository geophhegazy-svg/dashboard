<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
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
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
