<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketReplyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'sender' => $this->is_staff ? 'staff' : 'customer',

            'sender_name' => $this->is_staff
                ? optional($this->user)->name
                : optional($this->customer)->name,

            'message' => $this->message,

            'created_at' => $this->created_at,

            'time' => optional($this->created_at)->format('Y-m-d H:i'),

        ];
    }
}
