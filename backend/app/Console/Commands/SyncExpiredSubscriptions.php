<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Contracts\MikrotikServiceInterface;
use App\Services\Subscription\SubscriptionRenewalService;

use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Models\HotspotSubscription;
use App\Models\Notification;

class SyncExpiredSubscriptions extends Command
{
    protected $signature = 'subscriptions:sync';

    protected $description = 'Disable expired subscriptions on MikroTik';

    public function handle(
        MikrotikServiceInterface $mikrotik,
        SubscriptionRenewalService $renewal
    ): int {
        Log::info('SYNC JOB RUNNING: ' . now());

        $today = now()->toDateString();

        $notificationService = app(
            \App\Services\NotificationService::class
        );

        /*
        |--------------------------------------------------------------------------
        | Send Expiration Reminders
        |--------------------------------------------------------------------------
        */

        $activeSubs = Subscription::where('status', 'active')->get();

        foreach ($activeSubs as $sub) {

            $daysLeft = Carbon::today()->diffInDays(
                Carbon::parse($sub->end_date),
                false
            );

            if ($daysLeft === 7) {
                $notificationService->createReminder($sub, 7);
            }

            if ($daysLeft === 3) {
                $notificationService->createReminder($sub, 3);
            }

            if ($daysLeft === 1) {
                $notificationService->createReminder($sub, 1);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PPPoE Subscriptions
        |--------------------------------------------------------------------------
        */

        $pppoeSubs = Subscription::whereDate(
            'end_date',
            '<',
            $today
        )->get();

        foreach ($pppoeSubs as $sub) {

            if ($sub->wallet_balance >= $sub->monthly_price) {

                $renewal->renewPppoe(
                    $sub,
                    $mikrotik
                );

                Log::info("AUTO RENEW PPPoE {$sub->id}");

                continue;
            }

            if ($sub->status !== 'expired') {

                if ($sub->pppoe_username) {
                    $mikrotik->disableUser(
                        $sub->pppoe_username
                    );
                }

                $sub->update([
                    'status' => 'expired',
                ]);

                Notification::create([
                    'tenant_id'    => $sub->tenant_id,
                    'customer_id'  => $sub->customer_id,
                    'type'         => 'subscription_expired',
                    'title'        => 'انتهاء الاشتراك',
                    'message'      => 'انتهى اشتراكك وتم إيقاف الخدمة لعدم وجود رصيد كافٍ بالمحفظة.',
                    'reminder_day' => null,
                    'sent_at'      => now(),
                ]);

                Log::info(
                    "EXPIRED PPPoE {$sub->id}"
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Hotspot Subscriptions
        |--------------------------------------------------------------------------
        */

        $hotspotSubs = HotspotSubscription::whereDate(
            'end_date',
            '<',
            $today
        )->get();

        foreach ($hotspotSubs as $sub) {

            if ($sub->wallet_balance >= $sub->monthly_price) {

                $renewal->renewHotspot(
                    $sub,
                    $mikrotik
                );

                Log::info("AUTO RENEW HOTSPOT {$sub->id}");

                continue;
            }

            if ($sub->status !== 'expired') {

                if ($sub->hotspot_username) {
                    $mikrotik->disableHotspotUser(
                        $sub->hotspot_username
                    );
                }

                $sub->update([
                    'status' => 'expired',
                ]);

                Notification::create([
                    'tenant_id'    => $sub->tenant_id,
                    'customer_id'  => $sub->customer_id,
                    'type'         => 'subscription_expired',
                    'title'        => 'انتهاء الاشتراك',
                    'message'      => 'انتهى اشتراكك وتم إيقاف الخدمة لعدم وجود رصيد كافٍ بالمحفظة.',
                    'reminder_day' => null,
                    'sent_at'      => now(),
                ]);

                Log::info(
                    "EXPIRED HOTSPOT {$sub->id}"
                );
            }
        }

        return self::SUCCESS;
    }
}
