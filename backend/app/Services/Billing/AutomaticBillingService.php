<?php

declare(strict_types=1);

namespace App\Services\Billing;

use App\Models\Subscription;
use App\Services\InvoiceService;
use App\Services\NotificationService;
use App\Services\Subscription\SubscriptionRenewalService;
use App\Services\WalletService;
use Illuminate\Database\Eloquent\Collection;

class AutomaticBillingService
{
    public function __construct(
        private readonly BillingEngine $billingEngine,
        private readonly SubscriptionRenewalService $renewalService,
        private readonly InvoiceService $invoiceService,
        private readonly NotificationService $notificationService,
    ) {}

    public function run(Collection $subscriptions): void
    {
        foreach ($subscriptions as $subscription) {
            $this->processSubscription($subscription);
        }
    }

    public function processSubscription(
        Subscription $subscription
    ): void {

        // سيتم تنفيذ المنطق هنا تدريجياً

    }
}
