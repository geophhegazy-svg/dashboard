<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Ticket;

use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Ticket\Application\Queries\GetTicketStatusMetricsQuery;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GetTicketStatusMetricsQueryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_ticket_status_metrics_through_the_query_bus(): void
    {
        Ticket::factory()->create([
            'status' => 'open',
        ]);

        Ticket::factory()->create([
            'status' => 'open',
        ]);

        Ticket::factory()->create([
            'status' => 'closed',
        ]);

        Ticket::factory()->create([
            'status' => 'in_progress',
        ]);

        $result = $this->app->make(QueryDispatcher::class)->dispatch(
            new GetTicketStatusMetricsQuery(),
        );

        $this->assertSame(2, $result['open']);
        $this->assertSame(1, $result['in_progress']);
        $this->assertSame(0, $result['resolved']);
        $this->assertSame(1, $result['closed']);
    }
}
