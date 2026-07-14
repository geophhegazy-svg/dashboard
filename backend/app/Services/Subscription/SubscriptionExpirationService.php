<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Contracts\MikrotikServiceInterface;
use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use App\Modules\Subscription\Domain\Events\SubscriptionExpired;
use App\Models\HotspotSubscription;
use App\Models\Subscription;
use App\Services\Activity\ActivityLogService;
use Illuminate\Support\Facades\DB;

class SubscriptionExpirationService
{
    public function __construct(
        private readonly MikrotikServiceInterface $mikrotik,
    ) {}

    public function expirePppoe(
        Subscription $subscription
    ): bool {

        $this->processExpiration($subscription);

        if ($subscription->pppoe_username) {
            $this->mikrotik->disableUser(
                $subscription->pppoe_username
            );
        }

        return true;
    }

    public function expireHotspot(
        HotspotSubscription $subscription
    ): bool {

        $this->processExpiration($subscription);

        if ($subscription->hotspot_username) {
            $this->mikrotik->disableHotspotUser(
                $subscription->hotspot_username
            );
        }

        return true;
    }

    /**
     * @param Subscription|HotspotSubscription $subscription
     */
    private function processExpiration(
        Subscription|HotspotSubscription $subscription
    ): void {

        DB::transaction(function () use ($subscription) {

            $subscription->update([
                'status' => SubscriptionStatus::EXPIRED,
                'grace_end_date' => null,
            ]);

            \App\Models\Notification::create([
                'tenant_id'   => $subscription->tenant_id,
                'customer_id' => $subscription->customer_id,
                'type'        => 'subscription_expired',
                'title'       => 'انتهى الاشتراك',
                'message'     => 'انتهت فترة السماح وتم إيقاف الاشتراك.',
                'sent_at'     => now(),
            ]);

            ActivityLogService::log(
                tenantId: $subscription->tenant_id,
                userId: null,
                module: 'subscription',
                action: 'expired',
                description: "Subscription #{$subscription->id} expired."
            );

            event(
                new SubscriptionExpired(
                    $subscription
                )
            );
        });
    }
}
