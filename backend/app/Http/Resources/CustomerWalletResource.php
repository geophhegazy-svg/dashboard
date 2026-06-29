<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerWalletResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'balance' => $this->wallet_balance,

            'currency' => 'EGP',

            'status' => $this->status,

            'last_updated' => $this->updated_at,

        ];
    }
}
