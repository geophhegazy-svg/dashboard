<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return ['id' => $this->id, 'tenant_id' => $this->tenant_id, 'customer' => $this->customer?->name, 'assigned_to' => $this->user?->name, 'ticket_number' => $this->ticket_number, 'subject' => $this->subject, 'description' => $this->description, 'priority' => $this->priority, 'status' => $this->status, 'opened_at' => $this->opened_at, 'closed_at' => $this->closed_at, 'notes' => $this->notes, 'created_at' => $this->created_at,];
    }
}
