<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Subscription;

use App\Modules\Billing\Domain\Contracts\BillingCycleServiceInterface;
use App\Modules\Subscription\Application\Actions\EnterGraceSubscriptionAction;
use App\Modules\Subscription\Domain\Contracts\SubscriptionRepositoryInterface;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class EnterGraceSubscriptionActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_execute_enters_grace_and_calculates_grace_end_date(): void
    {
        Carbon::setTestNow(
            Carbon::parse('2026-08-24 10:00:00')
        );

        try {
            $subscription = Subscription::factory()->create([
                'status' => 'active',
                'end_date' => '2026-08-24',
                'grace_start_date' => null,
                'grace_end_date' => null,
            ]);

            $repository = Mockery::mock(
                SubscriptionRepositoryInterface::class
            );

            $repository
                ->shouldReceive('save')
                ->once()
                ->with($subscription)
                ->andReturnUsing(
                    static function (
                        Subscription $subscription
                    ): Subscription {
                        $subscription->save();

                        return $subscription;
                    }
                );

            $billingCycle = Mockery::mock(
                BillingCycleServiceInterface::class
            );

            $billingCycle
                ->shouldReceive('calculateGraceDate')
                ->once()
                ->with(
                    Mockery::on(
                        static fn ($date): bool =>
                            $date->toDateString() === '2026-08-24'
                    ),
                    $subscription->package->grace_days,
                )
                ->andReturn(
                    Carbon::parse('2026-08-29')
                );

            $action = new EnterGraceSubscriptionAction(
                $repository,
                $billingCycle,
            );

            $result = $action->execute($subscription);

            $this->assertSame(
                $subscription->id,
                $result->id
            );

            $this->assertTrue(
                $result->isGrace()
            );

            $this->assertSame(
                '2026-08-24',
                $result->grace_start_date->toDateString()
            );

            $this->assertSame(
                '2026-08-29',
                $result->grace_end_date->toDateString()
            );
        } finally {
            Carbon::setTestNow();
        }
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
