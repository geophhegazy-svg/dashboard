<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Traits\BelongsToTenant;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\Modules\Inventory\Infrastructure\Persistence\Models\DeviceFactory;

class Device extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected static function newFactory()
    {
        return DeviceFactory::new();
    }

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'device_type',
        'brand',
        'model',
        'serial_number',
        'mac_address',
        'ip_address',
        'status',
        'notes',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
