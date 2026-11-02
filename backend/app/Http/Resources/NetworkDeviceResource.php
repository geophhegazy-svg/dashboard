<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Modules\Network\Infrastructure\Persistence\Models\NetworkDevice;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin NetworkDevice */
final class NetworkDeviceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'status' => $this->status,
            'is_online' => $this->is_online,
        ];
    }
}
