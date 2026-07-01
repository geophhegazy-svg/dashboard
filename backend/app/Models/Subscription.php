<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'tenant_id',
        'customer_id',
        'package_id',
        'start_date',
        'end_date',
        'monthly_price',
        'status',
        'notes',
        'pppoe_username',
        'pppoe_password',
        'mikrotik_profile',
        'wallet_balance',
    ];

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
