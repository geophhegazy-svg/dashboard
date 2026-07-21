<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Subscription;

use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Subscription\Application\Queries\FindSubscriptionQuery;
use App\Modules\Subscription\Infrastructure\Persistence\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class FindSubscriptionQueryTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_finds_a_subscription_through_the_query_bus(): void
    {
        $subscription = Subscription::factory()->create();

        $result = $this->app->make(QueryDispatcher::class)->dispatch(
            new FindSubscriptionQuery($subscription->id),
        );

        $this->assertInstanceOf(Subscription::class, $result);
        $this->assertSame($subscription->id, $result->id);
    }
}
