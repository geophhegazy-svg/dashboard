<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Infrastructure\Persistence\Models;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    use BelongsToTenant;

    protected $table = 'wallets';

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
