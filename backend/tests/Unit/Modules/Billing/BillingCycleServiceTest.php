<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Billing;

use App\Modules\Billing\Application\Services\BillingCycleService;
use Carbon\Carbon;
use Tests\TestCase;

class BillingCycleServiceTest extends TestCase
{
    private BillingCycleService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new BillingCycleService();
    }

    public function test_daily_cycle(): void
    {
        $date = Carbon::parse('2026-01-01');

        $this->assertEquals(
            '2026-01-11',
            $this->service
                ->calculateNextBillingDate($date, 'day', 10)
                ->toDateString()
        );
    }

    public function test_weekly_cycle(): void
    {
        $date = Carbon::parse('2026-01-01');

        $this->assertEquals(
            '2026-01-15',
            $this->service
                ->calculateNextBillingDate($date, 'week', 2)
                ->toDateString()
        );
    }

    public function test_monthly_cycle(): void
    {
        $date = Carbon::parse('2026-01-01');

        $this->assertEquals(
            '2026-02-01',
            $this->service
                ->calculateNextBillingDate($date, 'month', 1)
                ->toDateString()
        );
    }

    public function test_yearly_cycle(): void
    {
        $date = Carbon::parse('2026-01-01');

        $this->assertEquals(
            '2027-01-01',
            $this->service
                ->calculateNextBillingDate($date, 'year', 1)
                ->toDateString()
        );
    }

    public function test_grace_period(): void
    {
        $billing = Carbon::parse('2026-01-01');

        $this->assertEquals(
            '2026-01-06',
            $this->service
                ->calculateGraceDate($billing, 5)
                ->toDateString()
        );
    }

    public function test_is_due(): void
    {
        $this->assertTrue(
            $this->service->isDue(now()->subDay())
        );

        $this->assertFalse(
            $this->service->isDue(now()->addDay())
        );
    }

    public function test_is_expired(): void
    {
        $this->assertTrue(
            $this->service->isExpired(now()->subDay())
        );

        $this->assertFalse(
            $this->service->isExpired(now()->addDay())
        );
    }
}
