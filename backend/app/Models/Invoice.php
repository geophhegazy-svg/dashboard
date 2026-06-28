<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HotspotSubscription;

class Invoice extends Model
{
    protected $fillable = [
        'tenant_id',
        'customer_id',
        'subscription_id',
        'hotspot_subscription_id',
        'invoice_number',
        'amount',
        'due_date',
        'paid_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at'  => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    public function hotspotSubscription()
    {
        return $this->belongsTo(
            HotspotSubscription::class,
            'hotspot_subscription_id'
        );
    }
}
