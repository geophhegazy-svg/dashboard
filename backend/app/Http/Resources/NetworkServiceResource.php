<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NetworkServiceResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tenant_id' => $this->tenant_id,
            'customer_id' => $this->customer_id,
            'area_id' => $this->area_id,
            'package_id' => $this->package_id,
            'network_device_id' => $this->network_device_id,
            'connection_type' => $this->connection_type,
            'username' => $this->username,
            'mac_address' => $this->mac_address,
            'ip_address' => $this->ip_address,
            'ip_mode' => $this->ip_mode,
            'starts_at' => optional($this->starts_at)->toDateTimeString(),
            'ends_at' => optional($this->ends_at)->toDateTimeString(),
            'status' => $this->status,
            'provisioning_status' => $this->provisioning_status,
            'last_provisioned_at' => optional($this->last_provisioned_at)
                ->toDateTimeString(),
            'last_sync_at' => optional($this->last_sync_at)
                ->toDateTimeString(),
            'last_error' => $this->last_error,
            'customer' => $this->whenLoaded('customer'),
            'area' => $this->whenLoaded('area'),
            'package' => $this->whenLoaded('package'),
            'network_device' => $this->whenLoaded('networkDevice'),
            'created_at' => optional($this->created_at)->toDateTimeString(),
            'updated_at' => optional($this->updated_at)->toDateTimeString(),
        ];
    }
}
