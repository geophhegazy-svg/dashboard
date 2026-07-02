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

            'customer_id' => $this->customer_id,

            'package_id' => $this->package_id,

            'customer' => $this->whenLoaded('customer'),

            'package' => $this->whenLoaded('package'),

            'start_date' => optional($this->start_date)
                ->format('Y-m-d'),

            'end_date' => optional($this->end_date)
                ->format('Y-m-d'),

            'monthly_price' => (float) $this->monthly_price,

            'wallet_balance' => (float) $this->wallet_balance,

            'status' => $this->status,

            'notes' => $this->notes,

            'pppoe_username' => $this->pppoe_username,

            'mikrotik_profile' => $this->mikrotik_profile,

            'created_at' => optional($this->created_at)
                ->toDateTimeString(),

            'updated_at' => optional($this->updated_at)
                ->toDateTimeString(),

        ];
    }
}
