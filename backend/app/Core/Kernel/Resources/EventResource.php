<?php

declare(strict_types=1);

namespace App\Core\Kernel\Resources;

final readonly class EventResource
{
    /**
     * @param array<class-string> $events
     */
    public function __construct(
        public array $events,
    ) {}
}
