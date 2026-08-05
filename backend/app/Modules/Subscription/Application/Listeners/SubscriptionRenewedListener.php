<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Listeners;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use App\Modules\Invoice\Application\Services\InvoiceService;
use App\Modules\Payment\Application\Services\PaymentService;
use App\Modules\Notification\Application\Services\NotificationService;
use App\Modules\Activity\Application\Workflows\LogActivityWorkflow;
use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;

final readonly class SubscriptionRenewedListener implements EventListenerInterface
{
    public function __construct(
        private InvoiceService $invoiceService,
        private PaymentService $paymentService,
        private NotificationService $notificationService,
        private LogActivityWorkflow $logActivity,
    ) {}

    public function handle(
        EventContract $event
    ): void {

        if (! $event instanceof SubscriptionRenewed) {
            return;
        }

        $subscription = $event->subscription;

        /*
        |--------------------------------------------------------------------------
        | Idempotency
        |--------------------------------------------------------------------------
        */

        $invoice = Invoice::where(
            'subscription_id',
            $subscription->id
        )->first();

        if (! $invoice) {

            $invoice = $this->invoiceService->create([
                'tenant_id'       => $subscription->tenant_id,
                'customer_id'     => $subscription->customer_id,
                'subscription_id' => $subscription->id,
                'amount'          => $subscription->monthly_price,
                'status'          => 'pending',
                'issued_at'       => now(),
                'due_date'        => $subscription->end_date,
            ]);
        }

        if (! $invoice->payments()->exists()) {

            $this->paymentService->createFromInvoice(
                $invoice,
                (float) $subscription->monthly_price,
                'wallet',
                'AUTO-WALLET',
            );
        }

        $this->notificationService
            ->subscriptionRenewed($subscription);

        $this->logActivity->execute(

            [
                'tenant_id' => $subscription->tenant_id,
                'module'    => 'subscription',
                'action'    => 'renewed',
            ],

            [
                'user_id'     => null,
                'description' => 'Subscription renewed automatically.',
                'ip_address'  => request()->ip(),
            ],

        );
    }
}
