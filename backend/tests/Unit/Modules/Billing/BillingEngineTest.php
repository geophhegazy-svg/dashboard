<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Billing;

use Tests\TestCase;
use Carbon\Carbon;
use App\Enums\BillingStatus;
use App\Modules\Billing\Domain\Services\BillingEngine;

class BillingEngineTest extends TestCase
{
    private BillingEngine $engine;

    protected function setUp(): void
    {
        parent::setUp();

        $this->engine = new BillingEngine();
    }

    public function test_status_is_active(): void
    {
        $status = $this->engine->status(
            Carbon::now()->addDays(5)
        );

        $this->assertEquals(
            BillingStatus::ACTIVE,
            $status
        );
    }

    public function test_status_is_due(): void
    {
        $status = $this->engine->status(
            Carbon::today()
        );

        $this->assertEquals(
            BillingStatus::DUE,
            $status
        );
    }

    public function test_status_is_grace(): void
    {
        $status = $this->engine->status(
            Carbon::now()->subDays(2)
        );

        $this->assertEquals(
            BillingStatus::GRACE,
            $status
        );
    }

    public function test_status_is_expired(): void
    {
        $status = $this->engine->status(
            Carbon::now()->subDays(10)
        );

        $this->assertEquals(
            BillingStatus::EXPIRED,
            $status
        );
    }

    public function test_next_due_date_daily(): void
    {
        $date = Carbon::parse('2026-01-01');

        $next = $this->engine->nextDueDate(
            $date,
            'daily'
        );

        $this->assertEquals(
            '2026-01-02',
            $next->toDateString()
        );
    }

    public function test_next_due_date_weekly(): void
    {
        $date = Carbon::parse('2026-01-01');

        $next = $this->engine->nextDueDate(
            $date,
            'weekly'
        );

        $this->assertEquals(
            '2026-01-08',
            $next->toDateString()
        );
    }

    public function test_next_due_date_monthly(): void
    {
        $date = Carbon::parse('2026-01-01');

        $next = $this->engine->nextDueDate(
            $date,
            'monthly'
        );

        $this->assertEquals(
            '2026-02-01',
            $next->toDateString()
        );
    }

    public function test_next_due_date_yearly(): void
    {
        $date = Carbon::parse('2026-01-01');

        $next = $this->engine->nextDueDate(
            $date,
            'yearly'
        );

        $this->assertEquals(
            '2027-01-01',
            $next->toDateString()
        );
    }

    public function test_invalid_cycle_throws_exception(): void
    {
        $this->expectException(
            \InvalidArgumentException::class
        );

        $this->engine->nextDueDate(
            Carbon::now(),
            'invalid'
        );
    }
}
