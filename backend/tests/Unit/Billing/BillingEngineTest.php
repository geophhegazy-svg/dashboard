<?php

declare(strict_types=1);

namespace Tests\Unit\Billing;

use App\Services\Billing\BillingEngine;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use App\Enums\BillingStatus;

class BillingEngineTest extends TestCase
{
    public function test_monthly_due_date(): void
    {
        $engine = new BillingEngine();

        $next = $engine->nextDueDate(
            Carbon::parse('2026-01-01'),
            'monthly'
        );

        $this->assertEquals(
            '2026-02-01',
            $next->toDateString()
        );
    }

    public function test_yearly_due_date(): void
    {
        $engine = new BillingEngine();

        $next = $engine->nextDueDate(
            Carbon::parse('2026-01-01'),
            'yearly'
        );

        $this->assertEquals(
            '2027-01-01',
            $next->toDateString()
        );
    }

    public function test_weekly_due_date(): void
    {
        $engine = new BillingEngine();

        $next = $engine->nextDueDate(
            Carbon::parse('2026-01-01'),
            'weekly'
        );

        $this->assertEquals(
            '2026-01-08',
            $next->toDateString()
        );
    }

    public function test_daily_due_date(): void
    {
        $engine = new BillingEngine();

        $next = $engine->nextDueDate(
            Carbon::parse('2026-01-01'),
            'daily'
        );

        $this->assertEquals(
            '2026-01-02',
            $next->toDateString()
        );
    }

    public function test_status_is_active(): void
    {
        $engine = new BillingEngine();

        $status = $engine->status(
            Carbon::today()->addDays(10),
            3
        );

        $this->assertEquals(
            BillingStatus::ACTIVE,
            $status
        );
    }

    public function test_status_is_due(): void
    {
        $engine = new BillingEngine();

        $status = $engine->status(
            Carbon::today(),
            3
        );

        $this->assertEquals(
            BillingStatus::DUE,
            $status
        );
    }

    public function test_status_is_grace(): void
    {
        $engine = new BillingEngine();

        $status = $engine->status(
            Carbon::today()->subDays(2),
            5
        );

        $this->assertEquals(
            BillingStatus::GRACE,
            $status
        );
    }

    public function test_status_is_expired(): void
    {
        $engine = new BillingEngine();

        $status = $engine->status(
            Carbon::today()->subDays(10),
            3
        );

        $this->assertEquals(
            BillingStatus::EXPIRED,
            $status
        );
    }
}
