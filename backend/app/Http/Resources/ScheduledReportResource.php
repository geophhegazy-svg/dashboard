<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduledReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->name,

            'report_name' => $this->report_name,

            'frequency' => $this->frequency,

            'format' => $this->format,

            'filters' => $this->filters,

            'email' => $this->email,

            'is_active' => $this->is_active,

            'last_run_at' => $this->last_run_at,

            'next_run_at' => $this->next_run_at,

            'created_by' => $this->created_by,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
