<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class HotspotSubscription extends Model
{
    use BelongsToTenant;

    protected $fillable = ['tenant_id', 'customer_id', 'package_id', 'hotspot_username', 'hotspot_password', 'mikrotik_profile', 'start_date', 'end_date', 'monthly_price', 'status', 'wallet_balance',];
    protected $casts = ['start_date' => 'date', 'end_date' => 'date',];
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
