<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'module' => $this->module,

            'action' => $this->action,

            'description' => $this->description,

            'ip' => $this->ip_address,

            'created_at' => $this->created_at
                ->format('Y-m-d H:i'),

        ];
    }
}
