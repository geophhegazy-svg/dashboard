<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tenant;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\ActivityLog;

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

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
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

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }
}
