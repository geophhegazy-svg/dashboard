<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'title' => $this->title,

            'message' => $this->message,

            'type' => $this->type,

            'reminder_day' => $this->reminder_day,

            'is_read' => (bool) $this->is_read,

            'sent_at' => optional($this->sent_at)
                ->format('Y-m-d H:i'),

            'created_at' => $this->created_at
                ->format('Y-m-d H:i'),

        ];
    }
}
