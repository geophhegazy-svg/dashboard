<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = ['tenant_id', 'customer_id', 'device_type', 'brand', 'model', 'serial_number', 'mac_address', 'ip_address', 'status', 'notes',];
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
