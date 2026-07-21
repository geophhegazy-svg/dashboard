<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Billing;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Enums\BillingStatus;
use App\Modules\Billing\AutomaticBillingService;
use App\Modules\Billing\Domain\Services\BillingEngine;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRenewalServiceInterface;
use App\Services\Notification\NotificationService;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;

class AutomaticBillingServiceTest extends TestCase
{
    use RefreshDatabase;

    private function expiredSubscription(): Subscription
    {
        return Subscription::factory()->create([
            'status'   => 'expired',
            'end_date' => now()->subDays(10),
        ]);
    }

    private function activeSubscription(): Subscription
    {
        return Subscription::factory()->create([
            'end_date' => now()->addDays(10),
        ]);
    }

    public function test_active_subscription_is_ignored(): void
    {
        $subscription = $this->activeSubscription();

        $billing = $this->createMock(
            BillingEngine::class
        );

        $billing
            ->expects($this->once())
            ->method('status')
            ->willReturn(BillingStatus::ACTIVE);

        $renewal = $this->createMock(
            SubscriptionRenewalServiceInterface::class
        );

        $renewal
            ->expects($this->never())
            ->method('renewPppoe');

        $notification = $this->createMock(
            NotificationService::class
        );

        $service = new AutomaticBillingService(
            $billing,
            $renewal,
            $notification
        );

        $service->processSubscription(
            $subscription
        );

    }

    public function test_expired_subscription_is_renewed(): void
    {
        $subscription = $this->expiredSubscription();

        $billing = $this->createMock(
            BillingEngine::class
        );

        $billing
            ->expects($this->once())
            ->method('status')
            ->willReturn(BillingStatus::EXPIRED);

        $renewal = $this->createMock(
            SubscriptionRenewalServiceInterface::class
        );

        $renewal
            ->expects($this->once())
            ->method('renewPppoe')
            ->with($subscription);

        $notification = $this->createMock(
            NotificationService::class
        );

        $service = new AutomaticBillingService(
            $billing,
            $renewal,
            $notification
        );

        $service->processSubscription(
            $subscription
        );
    }

    public function test_failed_renewal_sends_notification(): void
    {
        $subscription = $this->expiredSubscription();

        $billing = $this->createMock(
            BillingEngine::class
        );

        $billing
            ->method('status')
            ->willReturn(BillingStatus::EXPIRED);

        $renewal = $this->createMock(
            SubscriptionRenewalServiceInterface::class
        );

        $renewal
            ->method('renewPppoe')
            ->willThrowException(
                new \RuntimeException('Failure')
            );

        $notification = $this->createMock(
            NotificationService::class
        );

        $notification
            ->expects($this->once())
            ->method('billingFailed')
            ->with($subscription);

        $service = new AutomaticBillingService(
            $billing,
            $renewal,
            $notification
        );

        $this->expectException(
            \RuntimeException::class
        );

        $service->processSubscription(
            $subscription
        );
    }

    public function test_run_processes_collection(): void
    {
        /** @var Collection<int, Subscription> $subscriptions */
        $subscriptions = new Collection([
            $this->expiredSubscription(),
            $this->expiredSubscription(),
            $this->expiredSubscription(),
        ]);

        $billing = $this->createMock(
            BillingEngine::class
        );

        $billing
            ->method('status')
            ->willReturn(BillingStatus::EXPIRED);

        $renewal = $this->createMock(
            SubscriptionRenewalServiceInterface::class
        );

        $renewal
            ->expects($this->exactly(3))
            ->method('renewPppoe');

        $notification = $this->createMock(
            NotificationService::class
        );

        $service = new AutomaticBillingService(
            $billing,
            $renewal,
            $notification
        );

        $service->run(
            $subscriptions
        );

    }
}
