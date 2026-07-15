<?php

declare(strict_types=1);

namespace App\Core\EventBus\Contracts;

interface ListenerContract
{
    public function handle(EventContract $event): void;
}
