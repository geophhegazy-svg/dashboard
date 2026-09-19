<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Core\Workflow\WorkflowEngine;
use App\Modules\Subscription\Application\Workflows\RenewWorkflow;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Http\Resources\CustomerSubscriptionResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerSubscriptionController extends Controller
{
    public function __construct(
        private readonly WorkflowEngine $engine,
        private readonly RenewWorkflow $renewWorkflow,
    ) {}

    public function current(Request $request): JsonResponse|CustomerSubscriptionResource
    {
        $customer = $request->user();

        $subscription = Subscription::with('package')
            ->where('customer_id', $customer->id)
            ->latest()
            ->first();

        if (!$subscription) {
            return response()->json([
                'message' => 'No subscription found.',
            ], 404);
        }

        return new CustomerSubscriptionResource($subscription);
    }

    public function renew(Request $request): JsonResponse|CustomerSubscriptionResource
    {
        $customer = $request->user();

        $subscription = Subscription::query()
            ->where('customer_id', $customer->id)
            ->latest()
            ->first();

        if (!$subscription) {
            return response()->json([
                'message' => 'No subscription found.',
            ], 404);
        }

        $days = (int) $request->input('days', 30);

        if ($days <= 0) {
            return response()->json([
                'message' => 'Days must be greater than zero.',
            ], 422);
        }

        $result = $this->engine->run(
            $this->renewWorkflow,
            $subscription,
            $days,
        );

        /** @var Subscription $subscription */
        $subscription = $result->payload();

        return new CustomerSubscriptionResource($subscription);
    }
}
