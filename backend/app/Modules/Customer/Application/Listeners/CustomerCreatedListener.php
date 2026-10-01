<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Listeners;

use App\Modules\Customer\Domain\Events\CustomerCreated;
use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventListenerInterface;

final readonly class CustomerCreatedListener implements EventListenerInterface
{
    public function handle(EventContract $event): void
    {
        // سيتم إضافة المنطق لاحقًا
    }
}
