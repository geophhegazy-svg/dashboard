<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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

            'tenant_id' => $this->tenant_id,

            'customer' => [
                'id' => $this->customer?->id,
                'name' => $this->customer?->name,
            ],

            'package' => [
                'id' => $this->package?->id,
                'name' => $this->package?->name,
            ],

            'monthly_price' => $this->monthly_price,

            'start_date' => $this->start_date,

            'end_date' => $this->end_date,

            'status' => $this->status,

            'notes' => $this->notes,
        ];
    }
}
