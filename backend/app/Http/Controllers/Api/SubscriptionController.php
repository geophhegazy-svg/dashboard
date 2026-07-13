<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;
use App\Services\Subscription\SubscriptionService;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(
        private readonly SubscriptionService $subscriptionService,
    ) {}

    /**
     * Activate subscription.
     */
    public function activate(
        Subscription $subscription
    ): JsonResponse {
        $this->authorize('activate', $subscription);

        $subscription = $this->subscriptionService->activate(
            $subscription
        );

        return ApiResponse::success(
            new SubscriptionResource($subscription),
            'Subscription activated successfully'
        );
    }

    /**
     * Suspend subscription.
     */
    public function suspend(
        Subscription $subscription
    ): JsonResponse {
        $this->authorize('suspend', $subscription);

        $subscription = $this->subscriptionService->suspend(
            $subscription
        );

        return ApiResponse::success(
            new SubscriptionResource($subscription),
            'Subscription suspended successfully'
        );
    }

    /**
     * Renew subscription.
     */
    public function renew(
        Request $request,
        Subscription $subscription
    ): JsonResponse {
        $this->authorize('renew', $subscription);

        $days = (int) $request->input(
            'days',
            30
        );

        $subscription = $this->subscriptionService->renew(
            $subscription,
            $days
        );

        return ApiResponse::success(
            new SubscriptionResource($subscription),
            'Subscription renewed successfully'
        );
    }

    /**
     * Restore subscription.
     */
    public function restore(
        Subscription $subscription
    ): JsonResponse {
        $this->authorize('restore', $subscription);

        $subscription = $this->subscriptionService->restore(
            $subscription
        );

        return ApiResponse::success(
            new SubscriptionResource($subscription),
            'Subscription restored successfully'
        );
    }

    /**
     * Expire subscription.
     */
    public function expire(
        Subscription $subscription
    ): JsonResponse {
        $this->authorize('expire', $subscription);

        $subscription = $this->subscriptionService->expire(
            $subscription
        );

        return ApiResponse::success(
            new SubscriptionResource($subscription),
            'Subscription expired successfully'
        );
    }
}
