<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\HotspotSubscription;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Subscription;
use App\Contracts\MikrotikServiceInterface;

class SubscriptionRenewalService
{
    public function renewPppoe(
        Subscription $sub,
        MikrotikServiceInterface $mikrotik
    ): bool {

        $this->processRenewal($sub);

        /*
        |--------------------------------------------------------------------------
        | تفعيل المستخدم فى MikroTik (PPPoE) بعد نجاح العملية
        |--------------------------------------------------------------------------
        */

        if ($sub->pppoe_username) {
            $mikrotik->enablePppoe($sub->pppoe_username);
        }

        return true;
    }

    public function renewHotspot(
        HotspotSubscription $sub,
        MikrotikServiceInterface $mikrotik
    ): bool {

        $this->processRenewal($sub);

        /*
        |--------------------------------------------------------------------------
        | تفعيل المستخدم فى MikroTik (Hotspot) بعد نجاح العملية
        |--------------------------------------------------------------------------
        */

        if ($sub->hotspot_username) {
            $mikrotik->enableHotspot($sub->hotspot_username);
        }

        return true;
    }

    /**
     * منطق الفوترة المشترك بين تجديد PPPoE وتجديد Hotspot:
     * إنشاء فاتورة + خصم من المحفظة + تسجيل عملية دفع + إشعار + Activity Log.
     *
     * @param Subscription|HotspotSubscription $sub
     */
    private function processRenewal($sub): void
    {
        DB::transaction(function () use ($sub) {

            /*
            |--------------------------------------------------------------------------
            | 1- إنشاء الفاتورة
            |--------------------------------------------------------------------------
            */

            $invoice = Invoice::create([

                'tenant_id'       => $sub->tenant_id,

                'customer_id'     => $sub->customer_id,

                'subscription_id' => $sub->id,

                'invoice_number'  => 'INV-' . now()->format('YmdHis') . '-' . $sub->id,

                'amount'          => $sub->monthly_price,

                'due_date'        => now()->addMonth(),

                'status'          => 'paid',

                'paid_at'         => now(),

                'notes'           => 'Auto renewal from wallet',

            ]);

            /*
            |--------------------------------------------------------------------------
            | 2- خصم المحفظة
            |--------------------------------------------------------------------------
            */

            WalletService::deduct(
                subscription: $sub,
                amount: $sub->monthly_price,
                description: "Automatic subscription renewal. Invoice {$invoice->invoice_number}",
                reference: $invoice->invoice_number
            );

            /*
            |--------------------------------------------------------------------------
            | 3- إنشاء عملية الدفع
            |--------------------------------------------------------------------------
            */

            Payment::create([

                'tenant_id'        => $sub->tenant_id,

                'invoice_id'       => $invoice->id,

                'amount'           => $sub->monthly_price,

                'payment_date'     => now(),

                'payment_method'   => 'wallet',

                'reference_number' => 'AUTO-WALLET',

                'notes'            => 'Automatic renewal from wallet',

            ]);

            /*
            |--------------------------------------------------------------------------
            | 4- إنشاء إشعار للعميل
            |--------------------------------------------------------------------------
            */

            \App\Models\Notification::create([

                'tenant_id'    => $sub->tenant_id,

                'customer_id'  => $sub->customer_id,

                'type'         => 'subscription_renewed',

                'title'        => 'تم تجديد الاشتراك',

                'message'      => 'تم تجديد اشتراكك تلقائياً من رصيد المحفظة بقيمة '
                    . $sub->monthly_price . ' جنيه.',

                'sent_at'      => now(),

            ]);

            /*
            |--------------------------------------------------------------------------
            | 5- Activity Log للاشتراك
            |--------------------------------------------------------------------------
            */

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
