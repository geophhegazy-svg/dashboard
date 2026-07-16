<?php

declare(strict_types=1);

namespace App\Core\ActionBus\Pipeline;

use App\Core\ActionBus\Contracts\ActionMiddlewareInterface;

final class ActionPipeline
{
    /**
     * @param array<int,ActionMiddlewareInterface> $middlewares
     */
    public function process(
        string $action,
        array $arguments,
        array $middlewares,
        callable $destination,
    ): mixed {

        $pipeline = array_reduce(

            array_reverse($middlewares),

            function (
                callable $next,
                ActionMiddlewareInterface $middleware,
            ) use (
                $action,
                $arguments,
            ) {

                return fn() => $middleware->handle(
                    $action,
                    $arguments,
                    $next,
                );
            },

            $destination,
        );

        return $pipeline();
    }
}
