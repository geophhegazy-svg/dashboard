<?php

declare(strict_types=1);

namespace Tests\Feature\Reports;

use App\Reports\Manager\ReportManager;
use App\Reports\Registry\ReportRegistry;
use App\Reports\Filters\ReportFilter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportsServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_registry_is_resolved_from_container(): void
    {
        $registry = app(ReportRegistry::class);

        $this->assertInstanceOf(
            ReportRegistry::class,
            $registry
        );
    }

    public function test_reports_are_registered_automatically(): void
    {
        $registry = app(ReportRegistry::class);

        $this->assertTrue(
            $registry->has('customers')
        );

        $this->assertTrue(
            $registry->has('subscriptions')
        );

        $this->assertTrue(
            $registry->has('invoices')
        );

        $this->assertTrue(
            $registry->has('payments')
        );

        $this->assertTrue(
            $registry->has('wallet')
        );

        $this->assertEquals(
            5,
            $registry->count()
        );
    }

    public function test_report_manager_works_without_manual_registration(): void
    {
        $registry = app(ReportRegistry::class);

        $manager = new ReportManager(
            $registry
        );

        $result = $manager->run(
            'customers',
            new ReportFilter()
        );

        $this->assertEquals(
            'customers',
            $result->name
        );

        $this->assertEquals(
            'Customers Report',
            $result->title
        );
    }

    public function test_available_reports_are_loaded_from_provider(): void
    {
        $registry = app(ReportRegistry::class);

        $manager = new ReportManager(
            $registry
        );

        $reports = $manager->availableReports();

        $this->assertCount(
            5,
            $reports
        );

        $names = array_column(
            $reports,
            'name'
        );

        $this->assertContains(
            'customers',
            $names
        );

        $this->assertContains(
            'subscriptions',
            $names
        );

        $this->assertContains(
            'invoices',
            $names
        );

        $this->assertContains(
            'payments',
            $names
        );

        $this->assertContains(
            'wallet',
            $names
        );
    }
}
