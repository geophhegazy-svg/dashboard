<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Http\Resources\CustomerSubscriptionResource;

class CustomerSubscriptionController extends Controller
{
    public function current(Request $request)
    {
        $customer = $request->user();

        $subscription = Subscription::with('package')
            ->where('customer_id', $customer->id)
            ->latest()
            ->first();

        if (!$subscription) {
            return response()->json([
                'message' => 'No subscription found.'
            ], 404);
        }

        return new CustomerSubscriptionResource($subscription);
    }
}
