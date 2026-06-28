<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['id' => $this->id, 'tenant_id' => $this->tenant_id, 'invoice_id' => $this->invoice_id, 'amount' => $this->amount, 'payment_date' => $this->payment_date, 'payment_method' => $this->payment_method, 'reference_number' => $this->reference_number, 'notes' => $this->notes, 'created_at' => $this->created_at,];
    }
}
