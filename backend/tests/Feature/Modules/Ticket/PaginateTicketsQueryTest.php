<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Ticket;

use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Ticket\Application\Queries\PaginateTicketsQuery;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PaginateTicketsQueryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_paginates_tickets_through_the_query_bus(): void
    {
        Ticket::factory()->count(3)->create();

        $result = $this->app->make(QueryDispatcher::class)->dispatch(
            new PaginateTicketsQuery(perPage: 2),
        );

        $this->assertSame(3, $result->total());
        $this->assertSame(2, $result->perPage());
        $this->assertCount(2, $result->items());
    }
}
