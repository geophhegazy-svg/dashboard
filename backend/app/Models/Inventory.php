<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['tenant_id', 'device_type', 'brand', 'model', 'quantity', 'minimum_quantity', 'notes',];
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->minimum_quantity;
    }
}
