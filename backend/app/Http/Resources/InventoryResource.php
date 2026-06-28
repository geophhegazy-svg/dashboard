<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'tenant_id'        => $this->tenant_id,
            'device_type'      => $this->device_type,
            'brand'            => $this->brand,
            'model'            => $this->model,
            'quantity'         => $this->quantity,
            'minimum_quantity' => $this->minimum_quantity,
            'low_stock'        => $this->quantity <= $this->minimum_quantity,
            'notes'            => $this->notes,
            'created_at'       => $this->created_at,
        ];
    }
}
