<?php

declare(strict_types=1);

namespace App\Modules\Usage;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class UsageSnapshot extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'connection_type',
        'username',
        'bytes_download',
        'bytes_upload',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
