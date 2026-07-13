<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Contracts\MikrotikServiceInterface;
use App\Models\HotspotSubscription;
use App\Models\Invoice;
use App\Models\Subscription;
use App\Services\Activity\ActivityLogService;
use App\Services\Wallet\WalletService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Services\Payment\PaymentService;

class SubscriptionRenewalService
{
    public function __construct(
        private readonly MikrotikServiceInterface $mikrotik,
    ) {}

    public function renewPppoe(Subscription $sub): bool
    {
        $this->processRenewal($sub);

        if ($sub->pppoe_username) {
            $this->mikrotik->enableUser($sub->pppoe_username);
        }

        return true;
    }

    public function renewHotspot(HotspotSubscription $sub): bool
    {
        $this->processRenewal($sub);

        if ($sub->hotspot_username) {
            $this->mikrotik->enableHotspotUser($sub->hotspot_username);
        }

        return true;
    }

    private function processRenewal(
        Subscription|HotspotSubscription $sub
    ): void
    {
        $lock = Cache::lock($this->lockKey($sub), 30);

        if (! $lock->get()) {
            return;
        }

        try {

            DB::transaction(function () use ($sub) {

                $sub = $sub->newQuery()
                    ->lockForUpdate()
                    ->findOrFail($sub->id);

                $invoice = Invoice::firstOrCreate(
                    [
                        'renewal_key' => $this->renewalKey($sub),
                    ],
                    [
                        'tenant_id'       => $sub->tenant_id,
                        'customer_id'     => $sub->customer_id,
                        'subscription_id' => $sub->id,
                        'invoice_number'  => 'INV-' . now()->format('YmdHis') . '-' . $sub->id,
                        'amount'          => (float) $sub->monthly_price,
                        'due_date'        => now()->addMonth(),
                        'status'          => 'paid',
                        'paid_at'         => now(),
                        'notes'           => 'Auto renewal from wallet',
                    ]
                );

                if (! $invoice->wasRecentlyCreated) {
                    return;
                }

                $sub->update([
                    'end_date' => now()->addMonth(),
                    'status'   => 'active',
                ]);

                WalletService::deduct(
                    subscription: $sub,
                    amount: (float) $sub->monthly_price,
                    description: "Automatic subscription renewal. Invoice {$invoice->invoice_number}",
                    reference: $invoice->invoice_number
                );

                $this->createPayment($sub, $invoice);

                $this->createRenewalNotification($sub);

                $this->logRenewal($sub, $invoice);

            });

        } finally {
            $lock->release();
        }
    }

    /**
     * إنشاء مفتاح الـ Atomic Lock.
     */
    private function lockKey(
        Subscription|HotspotSubscription $sub
    ): string {
        return "subscription:renew:{$sub->id}";
    }

    /**
     * إنشاء مفتاح يمنع إنشاء أكثر من فاتورة
     * لنفس الاشتراك في نفس الشهر.
     */
    private function renewalKey(
        Subscription|HotspotSubscription $sub
    ): string {
        return "renewal-subscription-{$sub->id}-" . now()->format('Y-m');
    }

    /**
     * إنشاء عملية الدفع.
     */
    private function createPayment(
        Subscription|HotspotSubscription $sub,
        Invoice $invoice
    ): void {
        PaymentService::createFromInvoice(
            invoice: $invoice,
            amount: (float) $sub->monthly_price,
            method: 'wallet',
            reference: 'AUTO-WALLET',
            notes: 'Automatic renewal from wallet'
        );
    }

    /**
     * إنشاء إشعار التجديد.
     */
    private function createRenewalNotification(
        Subscription|HotspotSubscription $sub
    ): void {
        \App\Models\Notification::create([
            'tenant_id'   => $sub->tenant_id,
            'customer_id' => $sub->customer_id,
            'type'        => 'subscription_renewed',
            'title'       => 'تم تجديد الاشتراك',
            'message'     => 'تم تجديد اشتراكك تلقائياً من رصيد المحفظة بقيمة '
                . number_format((float) $sub->monthly_price, 2)
                . ' جنيه.',
            'sent_at'     => now(),
        ]);
    }

    /**
     * تسجيل Activity Log.
     */
    private function logRenewal(
        Subscription|HotspotSubscription $sub,
        Invoice $invoice
    ): void {
        ActivityLogService::log(
            tenantId: $sub->tenant_id,
            userId: null,
            module: 'subscription',
            action: 'renewed',
            description: "Subscription #{$sub->id} renewed automatically. Invoice {$invoice->invoice_number}"
        );
    }
}
