<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'tenant_id'        => $this->tenant_id,
            'customer'         => $this->customer?->name,
            'subscription_id'  => $this->subscription_id,
            'invoice_number'   => $this->invoice_number,
            'amount'           => $this->amount,
            'due_date'         => $this->due_date,
            'paid_at'          => $this->paid_at,
            'status'           => $this->status,
            'notes'            => $this->notes,
            'created_at'       => $this->created_at,
        ];
    }
}
