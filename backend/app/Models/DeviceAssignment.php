<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class DeviceAssignment extends Model
{
    use BelongsToTenant;

    protected $fillable = ['tenant_id', 'customer_id', 'device_id', 'assigned_at', 'returned_at', 'status', 'notes',];
    protected $casts = [
        'assigned_at' => 'datetime',
        'returned_at' => 'datetime',
    ];
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
