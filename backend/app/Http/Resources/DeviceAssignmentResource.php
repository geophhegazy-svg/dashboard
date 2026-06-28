<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceAssignmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['id' => $this->id, 'tenant_id' => $this->tenant_id, 'customer' => $this->customer?->name, 'device' => ['id' => $this->device?->id, 'type' => $this->device?->device_type, 'brand' => $this->device?->brand, 'model' => $this->device?->model, 'serial_number' => $this->device?->serial_number,], 'assigned_at' => $this->assigned_at, 'returned_at' => $this->returned_at, 'status' => $this->status, 'notes' => $this->notes,];
    }
}
