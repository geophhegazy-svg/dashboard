<?php

declare(strict_types=1);

namespace App\Core\Kernel\Contracts;

use Closure;

interface ModuleRegistrarInterface
{
    public function bind(
        string $abstract,
        string $concrete,
    ): void;


    public function singleton(
        string $abstract,
        string $concrete,
    ): void;


    /**
     * @param class-string $action
     */
    public function registerAction(
        string $action,
    ): void;


    /**
     * @param class-string $query
     * @param class-string $handler
     */
    public function registerQuery(
        string $query,
        string $handler,
    ): void;


    /**
     * @param class-string $event
     * @param class-string $listener
     */
    public function registerListener(
        string $event,
        string $listener,
    ): void;


    /**
     * @param class-string $model
     * @param class-string $policy
     */
    public function registerPolicy(
        string $model,
        string $policy,
    ): void;


    /**
     * @param callable|string $routes
     * @param list<string> $middleware
     */

    public function registerRoute(
        Closure|string $routes,
        string $prefix,
        array $middleware
    ): void;

    /**
     * @param list<string> $paths
     */
    public function registerMigration(
        array $paths,
    ): void;


    /**
     * @param class-string $command
     */
    public function registerCommand(
        string $command,
    ): void;


    public function registerSchedule(
        callable $schedule,
    ): void;


    /**
     * @param array<string,mixed> $configuration
     */
    public function registerConfig(
        array $configuration,
    ): void;

    public function registerCommandHandler(
        string $command,
        string $handler,
    ): void;
}
