<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'invoice_number' => $this->invoice_number,

            'customer' => $this->customer?->name,

            'amount' => $this->amount,

            'status' => $this->status,

            'paid_at' => $this->paid_at,

            'due_date' => $this->due_date,

        ];
    }
}
