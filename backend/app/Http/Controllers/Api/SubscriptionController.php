<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Services\Subscription\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(
        private readonly SubscriptionService $subscriptionService
    ) {}

    /**
     * Activate subscription
     */
    public function activate(Subscription $subscription): JsonResponse
    {
        $this->subscriptionService->activate($subscription);

        return response()->json([
            'success' => true,
            'message' => 'Subscription activated successfully',
        ]);
    }

    /**
     * Suspend subscription
     */
    public function suspend(Subscription $subscription): JsonResponse
    {
        $this->subscriptionService->suspend($subscription);

        return response()->json([
            'success' => true,
            'message' => 'Subscription suspended successfully',
        ]);
    }

    /**
     * Renew subscription
     */
    public function renew(Request $request, Subscription $subscription): JsonResponse
    {
        $days = (int) $request->input('days', 30);

        $this->subscriptionService->renew($subscription, $days);

        return response()->json([
            'success' => true,
            'message' => 'Subscription renewed successfully',
        ]);
    }
}
