<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['id' => $this->id, 'tenant_id' => $this->tenant_id, 'customer' => $this->customer?->name, 'device_type' => $this->device_type, 'brand' => $this->brand, 'model' => $this->model, 'serial_number' => $this->serial_number, 'mac_address' => $this->mac_address, 'ip_address' => $this->ip_address, 'status' => $this->status, 'notes' => $this->notes, 'created_at' => $this->created_at,];
    }
}
