<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Listeners;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Modules\Invoice\Application\Contracts\InvoiceServiceInterface;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;

final readonly class SubscriptionRenewedListener implements EventListenerInterface
{
    public function __construct(
        private readonly InvoiceServiceInterface $invoiceService,
    ) {}

    public function handle(
        EventContract $event
    ): void {

        if (! $event instanceof SubscriptionRenewed) {
            return;
        }

        $subscription = $event->subscription;

        $this->invoiceService->createRenewal([
            'tenant_id'       => $subscription->tenant_id,
            'customer_id'     => $subscription->customer_id,
            'subscription_id' => $subscription->id,
            'renewal_key'     => $event->renewalKey,
            'amount'          => $subscription->monthly_price,
            'status'          => 'pending',
            'due_date'        => $subscription->end_date,
        ]);
    }
}
