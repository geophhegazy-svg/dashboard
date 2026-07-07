<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class WalletTransaction extends Model
{
    use BelongsToTenant;

    protected $fillable = [

        'tenant_id',
        'customer_id',

        'amount',

        'balance_before',
        'balance_after',

        'type',

        'reference',

        'description',

    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
