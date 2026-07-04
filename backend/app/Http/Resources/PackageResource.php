<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'tenant_id'         => $this->tenant_id,

            'name'              => $this->name,
            'description'       => $this->description,

            'price'             => $this->price,
            'speed_download'    => $this->speed_download,
            'speed_upload'      => $this->speed_upload,

            'billing_cycle'     => $this->billing_cycle,
            'billing_interval'  => $this->billing_interval,
            'grace_days'        => $this->grace_days,
            'auto_suspend'      => $this->auto_suspend,
            'auto_expire'       => $this->auto_expire,

            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }
}
