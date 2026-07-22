<?php

declare(strict_types=1);

namespace App\Modules\Customer\Domain\Events;

use App\Core\EventBus\Contracts\EventContract;

final readonly class CustomerUpdated implements EventContract
{
    public function __construct(
        public int $customerId,
    ) {}
}
