<?php

declare(strict_types=1);

namespace App\Modules\Activity\Application\Listeners;

use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Modules\Activity\Application\Actions\LogActivityAction;
use App\Modules\Subscription\Domain\Events\SubscriptionRenewed;

final readonly class SubscriptionRenewedActivityListener implements EventListenerInterface
{
    public function __construct(
        private LogActivityAction $logActivity,
    ) {}

    public function handle(EventContract $event): void
    {
        if (! $event instanceof SubscriptionRenewed) {
            return;
        }

        $subscription = $event->subscription;

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
