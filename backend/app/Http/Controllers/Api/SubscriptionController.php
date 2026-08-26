<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Core\Workflow\WorkflowEngine;
use App\Modules\Subscription\Application\Workflows\ActivateWorkflow;
use App\Modules\Subscription\Application\Workflows\ExpireWorkflow;
use App\Modules\Subscription\Application\Workflows\RenewWorkflow;
use App\Modules\Subscription\Application\Workflows\RestoreWorkflow;
use App\Modules\Subscription\Application\Workflows\SuspendWorkflow;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(
        private readonly WorkflowEngine $engine,
        private readonly ActivateWorkflow $activateWorkflow,
        private readonly SuspendWorkflow $suspendWorkflow,
        private readonly ExpireWorkflow $expireWorkflow,
        private readonly RestoreWorkflow $restoreWorkflow,
        private readonly RenewWorkflow $renewWorkflow,
    ) {}

    /**
     * Activate subscription.
     */
    public function activate(
        Subscription $subscription
    ): JsonResponse {
        $this->authorize('activate', $subscription);

        $result = $this->engine->run(
            $this->activateWorkflow,
            $subscription,
        );

        /** @var Subscription $subscription */
        $subscription = $result->payload();

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

        $result = $this->engine->run(
            $this->suspendWorkflow,
            $subscription,
        );

        /** @var Subscription $subscription */
        $subscription = $result->payload();

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

        $result = $this->engine->run(
            $this->renewWorkflow,
            $subscription,
            $days,
        );

        /** @var Subscription $subscription */
        $subscription = $result->payload();

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

        $result = $this->engine->run(
            $this->restoreWorkflow,
            $subscription,
        );

        /** @var Subscription $subscription */
        $subscription = $result->payload();

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

        $result = $this->engine->run(
            $this->expireWorkflow,
            $subscription,
        );

        /** @var Subscription $subscription */
        $subscription = $result->payload();

        return ApiResponse::success(
            new SubscriptionResource($subscription),
            'Subscription expired successfully'
        );
    }
}
