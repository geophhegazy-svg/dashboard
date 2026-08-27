<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Ticket;

use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Ticket\Application\Queries\FindTicketQuery;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class FindTicketQueryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_finds_a_ticket_through_the_query_bus(): void
    {
        $ticket = Ticket::factory()->create();

        $result = $this->app->make(QueryDispatcher::class)->dispatch(
            new FindTicketQuery($ticket->id),
        );

        $this->assertInstanceOf(Ticket::class, $result);
        $this->assertSame($ticket->id, $result->id);
    }

    public function test_it_loads_requested_relations_through_the_query_bus(): void
    {
        $ticket = Ticket::factory()->create();

        $result = $this->app->make(QueryDispatcher::class)->dispatch(
            new FindTicketQuery(
                ticketId: $ticket->id,
                relations: ['customer'],
            ),
        );

        $this->assertNotNull($result);
        $this->assertTrue($result->relationLoaded('customer'));
    }
}
