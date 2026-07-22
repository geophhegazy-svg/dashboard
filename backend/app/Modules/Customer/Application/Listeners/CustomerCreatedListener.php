<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Listeners;

use App\Modules\Customer\Domain\Events\CustomerCreated;

final readonly class CustomerCreatedListener
{
    public function handle(CustomerCreated $event): void
    {
        // سيتم إضافة المنطق لاحقًا
    }
}
