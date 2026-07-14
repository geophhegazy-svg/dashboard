<?php

declare(strict_types=1);

namespace App\Services\Subscription;

use App\Contracts\MikrotikServiceInterface;
use App\Modules\Subscription\Domain\Enums\SubscriptionStatus;
use App\Modules\Subscription\Domain\Events\SubscriptionEnteredGracePeriod;
use App\Models\HotspotSubscription;
use App\Models\Subscription;
use App\Services\Activity\ActivityLogService;
use Illuminate\Support\Facades\DB;

class SubscriptionGracePeriodService
{
    public function __construct(
        private readonly MikrotikServiceInterface $mikrotik,
    ) {}

    public function enterPppoeGrace(Subscription $subscription): bool
    {
        $this->processGrace($subscription);

        if ($subscription->pppoe_username) {
            $this->mikrotik->disableUser($subscription->pppoe_username);
        }

        return true;
    }

    public function enterHotspotGrace(HotspotSubscription $subscription): bool
    {
        $this->processGrace($subscription);

        if ($subscription->hotspot_username) {
            $this->mikrotik->disableHotspotUser($subscription->hotspot_username);
        }

        return true;
    }

    /**
     * @param Subscription|HotspotSubscription $subscription
     */
    private function processGrace($subscription): void
    {
        DB::transaction(function () use ($subscription) {

            $subscription->update([
                'status' => SubscriptionStatus::GRACE,
                'grace_end_date' => now()->addDays(
                    (int) config('subscriptions.grace_period_days')
                ),
            ]);

            \App\Models\Notification::create([
                'tenant_id'   => $subscription->tenant_id,
                'customer_id' => $subscription->customer_id,
                'type'        => 'subscription_grace',
                'title'       => 'تم الدخول لفترة السماح',
                'message'     => sprintf(
                    'انتهى الاشتراك وتم إدخاله فترة السماح حتى %s.',
                    $subscription->grace_end_date?->format('Y-m-d')
                ),
                'sent_at'     => now(),
            ]);

            ActivityLogService::log(
                tenantId: $subscription->tenant_id,
                userId: null,
                module: 'subscription',
                action: 'grace',
                description: "Subscription #{$subscription->id} entered grace period."
            );

            event(new SubscriptionEnteredGracePeriod(
                $subscription
            ));
        });
    }
}
