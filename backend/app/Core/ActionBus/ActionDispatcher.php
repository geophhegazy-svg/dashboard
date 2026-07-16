<?php

declare(strict_types=1);

namespace App\Core\ActionBus;

use LogicException;
use App\Core\Contracts\ActionInterface;
use App\Core\ActionBus\Pipeline\ActionPipeline;

final readonly class ActionDispatcher
{
    public function __construct(
        private ActionRegistry $registry,
        private ActionPipeline $pipeline,
    ) {}

    /**
     * @param array<int,mixed> $arguments
     */
    public function dispatch(
        string $action,
        mixed ...$arguments,
    ): mixed {

        if (! $this->registry->has($action)) {
            throw new LogicException(
                sprintf(
                    'Action [%s] is not registered.',
                    $action,
                ),
            );
        }

        return $this->pipeline->process(
            $action,
            $arguments,
            [],
            function () use (
                $action,
                $arguments,
            ) {

                /** @var ActionInterface $instance */
                $instance = app($action);

                return $instance->execute(
                    ...$arguments,
                );
            },
        );
    }
}
