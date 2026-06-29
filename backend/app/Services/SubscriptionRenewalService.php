<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\ActivityLogService;


class SubscriptionRenewalService
{
    public function renewPppoe(Subscription $sub, MikrotikService $mikrotik): bool
    {
        DB::transaction(function () use ($sub) {

            $sub->wallet_balance -= $sub->monthly_price;

            $sub->end_date = \Carbon\Carbon::parse($sub->end_date)
                ->addMonth();

            $sub->status = 'active';

            $sub->save();
            ActivityLogService::log(
                tenantId: $sub->tenant_id,
                userId: null,
                module: 'wallet',
                action: 'deduct',
                description: "Wallet deducted {$sub->monthly_price} EGP. Remaining balance: {$sub->wallet_balance} EGP."
            );

            $invoice = Invoice::create([
                'tenant_id'       => $sub->tenant_id,
                'customer_id'     => $sub->customer_id,
                'subscription_id' => $sub->id,
                'invoice_number'  => 'INV-' . now()->format('YmdHis') . '-' . $sub->id,
                'amount'          => $sub->monthly_price,
                'due_date'        => $sub->end_date,
                'status'          => 'paid',
                'paid_at'         => now(),
                'notes'           => 'Auto renewal from wallet',
            ]);

            Payment::create([
                'tenant_id'        => $sub->tenant_id,
                'invoice_id'       => $invoice->id,
                'amount'           => $sub->monthly_price,
                'payment_date'     => now(),
                'payment_method'   => 'wallet',
                'reference_number' => 'AUTO-WALLET',
                'notes'            => 'Automatic renewal from wallet',
            ]);

            \App\Models\Notification::create([
                'tenant_id'    => $sub->tenant_id,
                'customer_id'  => $sub->customer_id,
                'type'         => 'subscription_renewed',
                'title'        => 'تم تجديد الاشتراك',
                'message'      => 'تم تجديد اشتراكك تلقائياً من رصيد المحفظة بقيمة '
                    . $sub->monthly_price . ' جنيه.',
                'reminder_day' => null,
                'sent_at'      => now(),
            ]);
            // Activity Log
            ActivityLogService::log(
                tenantId: $sub->tenant_id,
                userId: null,
                module: 'subscription',
                action: 'renewed',
                description: "Subscription #{$sub->id} renewed automatically. Invoice #{$invoice->invoice_number}"
            );
        });

        // بعد نجاح الـ Transaction فقط
        if ($sub->pppoe_username) {
            $mikrotik->enablePppoe($sub->pppoe_username);
        }
        ActivityLogService::log(

            tenantId: $sub->tenant_id,

            userId: null,

            module: 'subscription',

            action: 'renewed',

            description: "Subscription #{$sub->id} renewed automatically from wallet."

        );

        return true;
    }
}
