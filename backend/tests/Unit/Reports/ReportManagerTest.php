<?php

declare(strict_types=1);

namespace Tests\Unit\Reports;

use App\Reports\Filters\ReportFilter;
use App\Reports\Manager\ReportManager;
use App\Reports\Registry\ReportRegistry;
use App\Reports\Reports\CustomerReport;
use App\Reports\Reports\SubscriptionReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Reports\Reports\InvoiceReport;
use App\Reports\Reports\PaymentReport;
use App\Reports\Reports\WalletReport;


class ReportManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_report_is_registered(): void
    {
        $registry = new ReportRegistry();

        $registry->register(
            new CustomerReport()
        );

        $this->assertTrue(
            $registry->has('customers')
        );

        $this->assertEquals(
            1,
            $registry->count()
        );


    }

    public function test_report_manager_can_run_customer_report(): void
    {
        $registry = new ReportRegistry();

        $registry->register(
            new CustomerReport()
        );

        $manager = new ReportManager($registry);

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

        $this->assertIsArray(
            $result->headers
        );

        $this->assertIsArray(
            $result->rows
        );

        $this->assertIsArray(
            $result->summary
        );

        $this->assertIsArray(
            $result->meta
        );
    }

    public function test_available_reports_returns_registered_reports(): void
    {
        $registry = new ReportRegistry();

        $registry->register(
            new CustomerReport()
        );

        $registry->register(
            new SubscriptionReport()
        );

        $registry->register(
            new InvoiceReport()
        );

        $registry->register(
            new PaymentReport()
        );

        $registry->register(
            new WalletReport()
        );

        $manager = new ReportManager($registry);

        $reports = $manager->availableReports();

        /*
        |--------------------------------------------------------------------------
        | لا نعتمد على عدد التقارير أو ترتيبها
        |--------------------------------------------------------------------------
        */

        $this->assertGreaterThanOrEqual(
            2,
            count($reports)
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

        $this->assertContains('invoices', $names);

        $this->assertContains(
            'payments',
            $names
        );

        $this->assertContains(
            'wallet',
            $names
        );
    }

    public function test_report_manager_can_run_subscription_report(): void
    {
        $registry = new ReportRegistry();

        $registry->register(
            new SubscriptionReport()
        );

        $manager = new ReportManager($registry);

        $result = $manager->run(
            'subscriptions',
            new ReportFilter()
        );

        $this->assertEquals(
            'subscriptions',
            $result->name
        );

        $this->assertEquals(
            'Subscriptions Report',
            $result->title
        );

        $this->assertIsArray(
            $result->headers
        );

        $this->assertIsArray(
            $result->rows
        );

        $this->assertIsArray(
            $result->summary
        );

        $this->assertArrayHasKey(
            'total_subscriptions',
            $result->summary
        );
    }

    public function test_report_manager_can_run_invoice_report(): void
    {
        $registry = new ReportRegistry();

        $registry->register(
            new InvoiceReport()
        );

        $manager = new ReportManager($registry);

        $result = $manager->run(
            'invoices',
            new ReportFilter()
        );

        $this->assertEquals(
            'invoices',
            $result->name
        );

        $this->assertEquals(
            'Invoices Report',
            $result->title
        );

        $this->assertIsArray(
            $result->rows
        );

        $this->assertArrayHasKey(
            'total_invoices',
            $result->summary
        );
    }

    public function test_report_manager_can_run_payment_report(): void
    {
        $registry = new ReportRegistry();

        $registry->register(
            new PaymentReport()
        );

        $manager = new ReportManager($registry);

        $result = $manager->run(
            'payments',
            new ReportFilter()
        );

        $this->assertEquals(
            'payments',
            $result->name
        );

        $this->assertEquals(
            'Payments Report',
            $result->title
        );

        $this->assertIsArray(
            $result->rows
        );

        $this->assertArrayHasKey(
            'total_payments',
            $result->summary
        );
    }

    public function test_report_manager_can_run_wallet_report(): void
    {
        $registry = new ReportRegistry();

        $registry->register(
            new WalletReport()
        );

        $manager = new ReportManager($registry);

        $result = $manager->run(
            'wallet',
            new ReportFilter()
        );

        $this->assertEquals(
            'wallet',
            $result->name
        );

        $this->assertEquals(
            'Wallet Report',
            $result->title
        );

        $this->assertIsArray(
            $result->rows
        );

        $this->assertArrayHasKey(
            'total_transactions',
            $result->summary
        );
    }
}
