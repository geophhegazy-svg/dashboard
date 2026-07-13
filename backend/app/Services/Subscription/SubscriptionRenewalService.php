<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Contracts\MikrotikServiceInterface;
use App\Models\HotspotSubscription;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use App\Services\Activity\ActivityLogService;
use App\Services\Wallet\WalletService;

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

    /**
     * @param Subscription|HotspotSubscription $sub
     */
    private function processRenewal($sub): void
    {
        DB::transaction(function () use ($sub) {

            $invoice = Invoice::create([
                'tenant_id'       => $sub->tenant_id,
                'customer_id'     => $sub->customer_id,
                'subscription_id' => $sub->id,
                'invoice_number'  => 'INV-' . now()->format('YmdHis') . '-' . $sub->id,
                'amount'          => (float) $sub->monthly_price,
                'due_date'        => now()->addMonth(),
                'status'          => 'paid',
                'paid_at'         => now(),
                'notes'           => 'Auto renewal from wallet',
            ]);

            /*
            |--------------------------------------------------------------------------
            | 1.5- تمديد تاريخ انتهاء الاشتراك (مهم جدًا: من غيرها هيتجدد تاني بكرة!)
            |--------------------------------------------------------------------------
            */

            $sub->update([
                'end_date' => now()->addMonth(),
                'status'   => 'active',
            ]);

            /*
            |--------------------------------------------------------------------------
            | 2- خصم المحفظة
            |--------------------------------------------------------------------------
            */

            WalletService::deduct(
                subscription: $sub,
                amount: (float) $sub->monthly_price,
                description: "Automatic subscription renewal. Invoice {$invoice->invoice_number}",
                reference: $invoice->invoice_number
            );

            Payment::create([
                'tenant_id'        => $sub->tenant_id,
                'invoice_id'       => $invoice->id,
                'amount'           => (float) $sub->monthly_price,
                'payment_date'     => now(),
                'payment_method'   => 'wallet',
                'reference_number' => 'AUTO-WALLET',
                'notes'            => 'Automatic renewal from wallet',
            ]);

            \App\Models\Notification::create([
                'tenant_id'   => $sub->tenant_id,
                'customer_id' => $sub->customer_id,
                'type'        => 'subscription_renewed',
                'title'       => 'تم تجديد الاشتراك',
                'message' => sprintf(
                    'تم تجديد اشتراكك تلقائياً من رصيد المحفظة بقيمة %s جنيه.',
                    number_format((float) $sub->monthly_price, 2, '.', '')),
                'sent_at'     => now(),
            ]);

            ActivityLogService::log(
                tenantId: $sub->tenant_id,
                userId: null,
                module: 'subscription',
                action: 'renewed',
                description: "Subscription #{$sub->id} renewed automatically. Invoice {$invoice->invoice_number}"
            );
        });
    }
}
