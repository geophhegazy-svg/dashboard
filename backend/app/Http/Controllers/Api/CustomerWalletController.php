<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerWalletResource;
use Illuminate\Http\Request;

class CustomerWalletController extends Controller
{
    public function show(Request $request)
    {
        $customer = $request->user();

        $subscription = $customer->subscriptions()
            ->latest()
            ->first();

        if (!$subscription) {
            return response()->json([
                'message' => 'No active subscription found.'
            ], 404);
        }

        return new CustomerWalletResource($subscription);
    }
}
