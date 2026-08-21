<?php

declare(strict_types=1);

namespace App\Modules\Inventory\Infrastructure\Persistence\Models;

use App\Models\Tenant;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\Modules\Inventory\Infrastructure\Persistence\Models\InventoryFactory;

class Inventory extends Model
{
    use HasFactory;
    use BelongsToTenant;

    protected static function newFactory()
    {
        return InventoryFactory::new();
    }

    protected $fillable = [
        'tenant_id',
        'device_type',
        'brand',
        'model',
        'quantity',
        'minimum_quantity',
        'notes',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function isLowStock(): bool
    {
        return $this->quantity <= $this->minimum_quantity;
    }
}
