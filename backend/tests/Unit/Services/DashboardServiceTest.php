<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Dashboard\DashboardService;
use App\Models\Customer;
use App\Models\Package;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use App\Models\Payment;
use App\Models\Invoice;


class DashboardServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_business_metrics_are_returned_correctly(): void
    {
        Customer::factory()->count(3)->create();

        Package::factory()->count(2)->create();

        $service = new DashboardService();

        $data = $service->getDashboardData();

        $this->assertEquals(3, $data['business']['total_customers']);

        $this->assertEquals(2, $data['business']['packages_count']);
    }

    public function test_customer_metrics_are_returned_correctly(): void
    {
        $active = Customer::factory()->create();
        $expired = Customer::factory()->create();
        $suspended = Customer::factory()->create();

        Subscription::factory()->active()->create([
            'customer_id' => $active->id,
            'tenant_id' => $active->tenant_id,
        ]);

        Subscription::factory()->expired()->create([
            'customer_id' => $expired->id,
            'tenant_id' => $expired->tenant_id,
        ]);

        Subscription::factory()->suspended()->create([
            'customer_id' => $suspended->id,
            'tenant_id' => $suspended->tenant_id,
        ]);

        $service = new DashboardService();

        $data = $service->getDashboardData();

        $this->assertEquals(1, $data['customers']['active']);
        $this->assertEquals(1, $data['customers']['expired']);
        $this->assertEquals(1, $data['customers']['suspended']);
    }

    public function test_subscription_metrics_are_returned_correctly(): void
    {
        Subscription::factory()->count(3)->active()->create();

        Subscription::factory()->count(2)->expired()->create();

        Subscription::factory()->count(1)->suspended()->create();

        $service = new DashboardService();

        $data = $service->getDashboardData();

        $this->assertEquals(
            3,
            $data['subscriptions']['pppoe']['active']
        );

        $this->assertEquals(
            2,
            $data['subscriptions']['pppoe']['expired']
        );

        $this->assertEquals(
            1,
            $data['subscriptions']['pppoe']['suspended']
        );
    }

    public function test_financial_metrics_are_returned_correctly(): void
    {
        $invoices = Invoice::factory()->count(5)->create();

        Payment::factory()->create([
            'invoice_id' => $invoices[0]->id,
            'tenant_id' => $invoices[0]->tenant_id,
            'amount' => 100,
            'payment_date' => now(),
        ]);

        Payment::factory()->create([
            'invoice_id' => $invoices[1]->id,
            'tenant_id' => $invoices[1]->tenant_id,
            'amount' => 200,
            'payment_date' => now(),
        ]);

        Payment::factory()->create([
            'invoice_id' => $invoices[2]->id,
            'tenant_id' => $invoices[2]->tenant_id,
            'amount' => 300,
            'payment_date' => now()->subMonth(),
        ]);

        $service = new DashboardService();

        $data = $service->getDashboardData();

        $this->assertEquals(
            5,
            $data['financial']['total_invoices']
        );

        $this->assertEquals(
            600,
            $data['financial']['total_revenue']
        );

        $this->assertEquals(
            300,
            $data['financial']['monthly_revenue']
        );
    }
}
