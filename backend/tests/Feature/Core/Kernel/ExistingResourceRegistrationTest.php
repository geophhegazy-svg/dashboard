<?php

declare(strict_types=1);

namespace Tests\Feature\Core\Kernel;

use App\Core\ActionBus\ActionRegistry;
use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\EventRegistry;
use App\Core\Kernel\Resources\ActionResource;
use App\Core\Kernel\Resources\ListenerResource;
use App\Core\Kernel\Resources\QueryResource;
use App\Core\QueryBus\QueryRegistry;
use Tests\TestCase;

final class ExistingResourceRegistrationTest extends TestCase
{
    public function test_action_resource_registers_module_actions(): void
    {
        (new ActionResource([
            ExistingResourceRegistrationAction::class,
        ]))->register();

        $this->assertTrue(
            $this->app->make(ActionRegistry::class)
                ->has(ExistingResourceRegistrationAction::class),
        );
    }

    public function test_listener_resource_registers_module_listeners(): void
    {
        (new ListenerResource([
            ExistingResourceRegistrationEvent::class => [
                ExistingResourceRegistrationListener::class,
            ],
        ]))->register();

        $this->assertSame(
            [ExistingResourceRegistrationListener::class],
            $this->app->make(EventRegistry::class)
                ->listenersFor(new ExistingResourceRegistrationEvent()),
        );
    }

    public function test_query_resource_registers_module_query_handlers(): void
    {
        (new QueryResource([
            ExistingResourceRegistrationQuery::class => ExistingResourceRegistrationHandler::class,
        ]))->register();

        $this->assertSame(
            ExistingResourceRegistrationHandler::class,
            $this->app->make(QueryRegistry::class)
                ->get(ExistingResourceRegistrationQuery::class)?->handler,
        );
    }
}

final class ExistingResourceRegistrationAction
{
}

final class ExistingResourceRegistrationEvent implements EventContract
{
}

final class ExistingResourceRegistrationListener
{
}

final class ExistingResourceRegistrationQuery
{
}

final class ExistingResourceRegistrationHandler
{
}
