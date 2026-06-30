<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'ticket_number' => $this->ticket_number,

            'subject' => $this->subject,

            'description' => $this->description,

            'priority' => [

                'code' => $this->priority,

                'text' => match ($this->priority) {

                    'low'    => 'منخفضة',
                    'medium' => 'متوسطة',
                    'high'   => 'عالية',

                    default  => $this->priority,
                },

                'color' => match ($this->priority) {

                    'low'    => 'green',
                    'medium' => 'yellow',
                    'high'   => 'red',

                    default  => 'gray',
                }

            ],

            'status' => [

                'code' => $this->status,

                'text' => match ($this->status) {

                    'open'        => 'مفتوحة',

                    'in_progress' => 'قيد التنفيذ',

                    'resolved'    => 'تم الحل',

                    'closed'      => 'مغلقة',

                    default       => $this->status,
                },

                'color' => match ($this->status) {

                    'open'        => 'green',

                    'in_progress' => 'orange',

                    'resolved'    => 'blue',

                    'closed'      => 'gray',

                    default       => 'gray',
                }

            ],

            'opened_at' => $this->opened_at,

            'closed_at' => $this->closed_at,

            'notes' => $this->notes,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,

            'replies' => TicketReplyResource::collection(
                $this->whenLoaded('replies')
            ),

        ];
    }
}
