<?php

namespace App\Modules\Invoice\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Invoice extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'subscription_id',
        'hotspot_subscription_id',
        'invoice_number',
        'renewal_key',
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
        return $this->belongsTo(
            \App\Models\Tenant::class
        );
    }

    public function customer()
    {
        return $this->belongsTo(
            \App\Models\Customer::class
        );
    }

    public function subscription()
    {
        return $this->belongsTo(
            \App\Models\Subscription::class
        );
    }

    public function payments()
    {
        return $this->hasMany(
            \App\Modules\Payment\Infrastructure\Persistence\Models\Payment::class
        );
    }

    public function hotspotSubscription()
    {
        return $this->belongsTo(
            \App\Models\HotspotSubscription::class,
            'hotspot_subscription_id'
        );
    }
}
