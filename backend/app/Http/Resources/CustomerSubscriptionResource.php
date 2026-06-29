<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CustomerSubscriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $daysRemaining = Carbon::today()->diffInDays(
            Carbon::parse($this->end_date),
            false
        );

        return [

            'id' => $this->id,

            'status' => $this->status,

            'package' => [
                'name' => $this->package->name,
                'download_speed' => $this->package->download_speed,
                'upload_speed' => $this->package->upload_speed,
                'quota_gb' => $this->package->quota_gb,
            ],

            'wallet_balance' => $this->wallet_balance,

            'start_date' => $this->start_date,

            'end_date' => $this->end_date,

            'days_remaining' => $daysRemaining,

            'pppoe' => [
                'username' => $this->pppoe_username,
                'profile' => $this->mikrotik_profile,
            ],

        ];
    }
}
