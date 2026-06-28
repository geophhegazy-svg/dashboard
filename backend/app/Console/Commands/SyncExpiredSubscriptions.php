<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Subscription;
use App\Models\HotspotSubscription;
use App\Services\MikrotikService;
use App\Models\Invoice;
use App\Models\Payment;

class SyncExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:sync';
    protected $description = 'Disable expired subscriptions on MikroTik';
    public function handle(MikrotikService $mikrotik)
    {
        Log::info('SYNC JOB RUNNING: ' . now());

        $today = now()->toDateString();

        /*
|--------------------------------------------------
| PPPoE Subscriptions
|--------------------------------------------------
*/
        $pppoeSubs = Subscription::whereDate('end_date', '<', $today)
            ->get();

        foreach ($pppoeSubs as $sub) {

            // تجديد تلقائي من المحفظة
            if ($sub->wallet_balance >= $sub->monthly_price) {

                $sub->wallet_balance -= $sub->monthly_price;

                $sub->end_date = \Carbon\Carbon::parse(
                    $sub->end_date
                )->addMonth();

                $sub->status = 'active';

                $sub->save();

                if ($sub->pppoe_username) {
                    $mikrotik->enablePppoe(
                        $sub->pppoe_username
                    );
                }
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
                    'reference_number' => null,
                    'notes'            => 'Automatic payment from wallet',
                ]);

                Log::info(
                    "AUTO RENEW PPPoE {$sub->id}"
                );

                continue;
            }

            // لا يوجد رصيد كاف
            if ($sub->status !== 'expired') {

                if ($sub->pppoe_username) {
                    $mikrotik->disablePppoe(
                        $sub->pppoe_username
                    );
                }

                $sub->update([
                    'status' => 'expired'
                ]);

                Log::info(
                    "EXPIRED PPPoE {$sub->id}"
                );
            }
        }

        /*
|--------------------------------------------------
| Hotspot Subscriptions
|--------------------------------------------------
*/
        $hotspotSubs = HotspotSubscription::whereDate(
            'end_date',
            '<',
            $today
        )->get();

        foreach ($hotspotSubs as $sub) {

            if ($sub->wallet_balance >= $sub->monthly_price) {

                $sub->wallet_balance -= $sub->monthly_price;

                $sub->end_date = \Carbon\Carbon::parse(
                    $sub->end_date
                )->addMonth();

                $sub->status = 'active';

                $sub->save();

                $mikrotik->enableHotspot(
                    $sub->hotspot_username
                );
                $invoice = Invoice::create([
                    'tenant_id'               => $sub->tenant_id,
                    'customer_id'             => $sub->customer_id,
                    'hotspot_subscription_id' => $sub->id,
                    'invoice_number'          => 'INV-' . now()->format('YmdHis') . '-H' . $sub->id,
                    'amount'                  => $sub->monthly_price,
                    'due_date'                => $sub->end_date,
                    'status'                  => 'paid',
                    'paid_at'                 => now(),
                    'notes'                   => 'Auto renewal from wallet',
                ]);

                Payment::create([
                    'tenant_id'        => $sub->tenant_id,
                    'invoice_id'       => $invoice->id,
                    'amount'           => $sub->monthly_price,
                    'payment_date'     => now(),
                    'payment_method'   => 'wallet',
                    'reference_number' => null,
                    'notes'            => 'Automatic payment from wallet',
                ]);

                Log::info(
                    "AUTO RENEW HOTSPOT {$sub->id}"
                );

                continue;
            }

            if ($sub->status !== 'expired') {

                $mikrotik->disableHotspot(
                    $sub->hotspot_username
                );

                $sub->update([
                    'status' => 'expired'
                ]);

                Log::info(
                    "EXPIRED HOTSPOT {$sub->id}"
                );
            }
        }

        return self::SUCCESS;
    }
}
