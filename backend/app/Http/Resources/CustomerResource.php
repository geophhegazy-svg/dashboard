<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'tenant_id'   => $this->tenant_id,
            'name'        => $this->name,
            'phone'       => $this->phone,
            'email'       => $this->email,
            'address'     => $this->address,
            'national_id' => $this->national_id,
            'status'      => $this->status,
            'notes'       => $this->notes,
            'created_at'  => $this->created_at,
        ];
    }
}
