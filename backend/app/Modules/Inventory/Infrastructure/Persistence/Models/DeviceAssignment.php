<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Traits\BelongsToTenant;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\Modules\Inventory\Infrastructure\Persistence\Models\DeviceAssignmentFactory;

class DeviceAssignment extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected static function newFactory()
    {
        return DeviceAssignmentFactory::new();
    }

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'device_id',
        'assigned_at',
        'returned_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
