<?php

declare(strict_types=1);

namespace App\Core\QueryBus;

use LogicException;
use App\Core\Contracts\ContainerInterface;
use App\Core\QueryBus\Contracts\QueryInterface;

final readonly class QueryDispatcher
{
    public function __construct(
        private QueryRegistry $registry,
        private ContainerInterface $container,
    ) {}

    public function dispatch(
        QueryInterface $query,
    ): mixed {

        $descriptor = $this->registry->get(
            $query::class,
        );

        if ($descriptor === null) {
            throw new LogicException(
                sprintf(
                    'Query [%s] is not registered.',
                    $query::class,
                ),
            );
        }

        $handler = $this->container->make(
            $descriptor->handler,
        );

        return $handler->handle(
            $query,
        );
    }
}
