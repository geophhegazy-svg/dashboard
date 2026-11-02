<?php

declare(strict_types=1);

namespace App\Modules\Network\Application\Workflows;

use App\Core\Workflow\AbstractWorkflow;
use App\Core\Workflow\Contracts\WorkflowContextInterface;
use App\Modules\Customer\Application\Actions\CreateCustomerAction;
use App\Modules\Network\Application\Actions\CreateNetworkServiceAction;
use App\Modules\Subscription\Application\Actions\CreateSubscriptionAction;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;

final class OnboardSubscriberWorkflow extends AbstractWorkflow
{
    public function __construct(
        private readonly CreateCustomerAction $createCustomerAction,
        private readonly CreateSubscriptionAction $createSubscriptionAction,
        private readonly CreateNetworkServiceAction $createNetworkServiceAction,
        private readonly SubscriptionRepositoryInterface $subscriptionRepository,
    ) {}

    protected function perform(
        WorkflowContextInterface $context,
    ): array {
        $arguments = $context->dto();

        /** @var array<string, mixed> $data */
        $data = $arguments[0] ?? [];

        $tenantId = (int) $data['tenant_id'];

        $customerData = $data['customer'];
        $customerData['tenant_id'] = $tenantId;

        $customer = $this->createCustomerAction->execute(
            $customerData
        );

        $subscriptionData = $data['subscription'];

        $subscriptionData['tenant_id'] = $tenantId;
        $subscriptionData['customer_id'] = $customer->id;

        $subscription = $this->createSubscriptionAction->execute(
            $subscriptionData
        );

        $networkServiceData = $data['network_service'];

        $networkServiceData['tenant_id'] = $tenantId;
        $networkServiceData['customer_id'] = $customer->id;
        $networkServiceData['package_id'] = $subscription->package_id;

        $networkService = $this->createNetworkServiceAction->execute(
            $networkServiceData
        );

        $subscription = $this->subscriptionRepository->update(
            $subscription,
            [
                'network_service_id' => $networkService->id,
            ]
        );

        return [
            'customer' => $customer,
            'subscription' => $subscription->fresh([
                'customer',
                'package',
                'networkService',
            ]),
            'network_service' => $networkService->fresh([
                'customer',
                'area',
                'package',
                'networkDevice',
            ]),
        ];
    }
}
