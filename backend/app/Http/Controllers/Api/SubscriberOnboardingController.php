<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Core\Workflow\WorkflowEngine;
use App\Http\Controllers\Controller;
use App\Http\Requests\OnboardSubscriberRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\NetworkServiceResource;
use App\Http\Resources\SubscriptionResource;
use App\Modules\Network\Application\Workflows\OnboardSubscriberWorkflow;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Modules\Network\Infrastructure\Persistence\Models\NetworkService;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use Illuminate\Http\JsonResponse;

final class SubscriberOnboardingController extends Controller
{
    public function __construct(
        private readonly WorkflowEngine $engine,
        private readonly OnboardSubscriberWorkflow $workflow,
    ) {}

    public function store(
        OnboardSubscriberRequest $request,
    ): JsonResponse {
        $this->authorize('create', Customer::class);
        $this->authorize('create', Subscription::class);
        $this->authorize('network_services.create');

        $result = $this->engine->run(
            $this->workflow,
            $request->validated(),
        );

        /** @var array{
         *     customer: Customer,
         *     subscription: Subscription,
         *     network_service: NetworkService
         * } $data
         */
        $data = $result->payload();

        return response()->json([
            'message' => 'Subscriber onboarded successfully.',
            'data' => [
                'customer' => new CustomerResource(
                    $data['customer']
                ),
                'subscription' => new SubscriptionResource(
                    $data['subscription']
                ),
                'network_service' => new NetworkServiceResource(
                    $data['network_service']
                ),
            ],
        ], 201);
    }
}
