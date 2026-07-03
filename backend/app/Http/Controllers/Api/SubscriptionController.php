<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Services\Subscription\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\SubscriptionResource;
use App\Support\ApiResponse;

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
        $this->authorize('activate', $subscription);
        $this->subscriptionService->activate($subscription);

        $subscription->refresh();

        return ApiResponse::success(
            new SubscriptionResource($subscription),
            'Subscription activated successfully'
        );
    }

    /**
     * Suspend subscription
     */
    public function suspend(Subscription $subscription): JsonResponse
    {
        $this->authorize('suspend', $subscription);
        $this->subscriptionService->suspend($subscription);

        $subscription->refresh();

        return ApiResponse::success(
            new SubscriptionResource($subscription),
            'Subscription suspended successfully'
        );
    }

    /**
     * Renew subscription
     */
    public function renew(
        Request $request,
        Subscription $subscription
    ): JsonResponse {
        $this->authorize('renew', $subscription);

        $days = (int) $request->input('days', 30);

        $this->subscriptionService->renew(
            $subscription,
            $days
        );

        $subscription->refresh();

        return ApiResponse::success(
            new SubscriptionResource($subscription),
            'Subscription renewed successfully'
        );
    }

    public function restore(
        Subscription $subscription
    ): JsonResponse {
        $this->authorize('restore', $subscription);
        

        $this->subscriptionService->restore($subscription);

        $subscription->refresh();

        return ApiResponse::success(
            new SubscriptionResource($subscription),
            'Subscription restored successfully'
        );
    }

    public function expire(
        Subscription $subscription
    ): JsonResponse {
        $this->authorize('expire', $subscription);

        $this->subscriptionService->expire($subscription);

        $subscription->refresh();

        return ApiResponse::success(
            new SubscriptionResource($subscription),
            'Subscription expired successfully'
        );
    }
}
