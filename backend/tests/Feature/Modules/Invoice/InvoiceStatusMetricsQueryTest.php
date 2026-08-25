<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Invoice;

use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Invoice\Application\Queries\GetInvoiceStatusMetricsQuery;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class InvoiceStatusMetricsQueryTest extends TestCase
{
    use RefreshDatabase;

    public function test_invoice_status_metrics_are_owned_by_invoice_module(): void
    {
        Invoice::factory()->count(2)->create([
            'status' => 'paid',
        ]);

        Invoice::factory()->count(3)->create([
            'status' => 'pending',
        ]);

        Invoice::factory()->create([
            'status' => 'overdue',
        ]);

        Invoice::factory()->count(4)->create([
            'status' => 'cancelled',
        ]);

        $result = $this->app
            ->make(QueryDispatcher::class)
            ->dispatch(
                new GetInvoiceStatusMetricsQuery()
            );

        $this->assertSame(2, $result['paid']);
        $this->assertSame(3, $result['pending']);
        $this->assertSame(1, $result['overdue']);
        $this->assertSame(4, $result['cancelled']);
    }
}
