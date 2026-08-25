<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Invoice;

use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Invoice\Application\Queries\GetInvoiceDashboardMetricsQuery;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class InvoiceDashboardMetricsQueryTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_dashboard_metrics_are_owned_by_invoice_module(): void
    {
        Invoice::factory()->create([
            'status' => 'pending',
            'amount' => 100,
        ]);

        Invoice::factory()->create([
            'status' => 'paid',
            'amount' => 200,
            'paid_at' => now(),
        ]);

        Invoice::factory()->create([
            'status' => 'paid',
            'amount' => 300,
            'paid_at' => now(),
        ]);

        Invoice::factory()->create([
            'status' => 'paid',
            'amount' => 500,
            'paid_at' => now()->subMonth(),
        ]);

        $result = $this->app
            ->make(QueryDispatcher::class)
            ->dispatch(
                new GetInvoiceDashboardMetricsQuery()
            );

        $this->assertSame(4, $result['total_invoices']);
        $this->assertSame(1, $result['pending_invoices']);
        $this->assertSame(3, $result['paid_invoices']);
        $this->assertSame(500.0, $result['monthly_revenue']);
    }
}
