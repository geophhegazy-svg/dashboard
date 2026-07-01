<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\SubscriptionActivated;
use App\Services\Activity\SubscriptionActivityService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSubscriptionActivityListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(
        private readonly SubscriptionActivityService $activityService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(SubscriptionActivated $event): void
    {
        $this->activityService->log(
            subscription: $event->subscription,
            action: 'activated'
        );
    }
}
