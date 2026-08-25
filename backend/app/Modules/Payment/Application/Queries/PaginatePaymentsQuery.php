<?php

declare(strict_types=1);

namespace App\Modules\Payment\Application\Queries;

use App\Core\QueryBus\Contracts\QueryInterface;

final readonly class PaginatePaymentsQuery implements QueryInterface
{
    public function __construct(
        public int $perPage = 15,
    ) {}
}
