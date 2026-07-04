<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\Package;
use App\Services\Billing\BillingCycleService;
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
        $package = new Package([
            'billing_cycle' => 'day',
            'billing_interval' => 10,
        ]);

        $date = Carbon::parse('2026-01-01');

        $this->assertEquals(
            '2026-01-11',
            $this->service
                ->calculateNextBillingDate($date, $package)
                ->toDateString()
        );
    }

    public function test_weekly_cycle(): void
    {
        $package = new Package([
            'billing_cycle' => 'week',
            'billing_interval' => 2,
        ]);

        $date = Carbon::parse('2026-01-01');

        $this->assertEquals(
            '2026-01-15',
            $this->service
                ->calculateNextBillingDate($date, $package)
                ->toDateString()
        );
    }

    public function test_monthly_cycle(): void
    {
        $package = new Package([
            'billing_cycle' => 'month',
            'billing_interval' => 1,
        ]);

        $date = Carbon::parse('2026-01-01');

        $this->assertEquals(
            '2026-02-01',
            $this->service
                ->calculateNextBillingDate($date, $package)
                ->toDateString()
        );
    }

    public function test_yearly_cycle(): void
    {
        $package = new Package([
            'billing_cycle' => 'year',
            'billing_interval' => 1,
        ]);

        $date = Carbon::parse('2026-01-01');

        $this->assertEquals(
            '2027-01-01',
            $this->service
                ->calculateNextBillingDate($date, $package)
                ->toDateString()
        );
    }

    public function test_grace_period(): void
    {
        $package = new Package([
            'grace_days' => 5,
        ]);

        $billing = Carbon::parse('2026-01-01');

        $this->assertEquals(
            '2026-01-06',
            $this->service
                ->calculateGraceDate($billing, $package)
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
