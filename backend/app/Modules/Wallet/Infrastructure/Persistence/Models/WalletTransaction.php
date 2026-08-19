<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Infrastructure\Persistence\Models;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
