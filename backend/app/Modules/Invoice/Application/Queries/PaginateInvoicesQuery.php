<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Queries;

use App\Core\QueryBus\Contracts\QueryInterface;

final readonly class PaginateInvoicesQuery implements QueryInterface
{
    public function __construct(
        public int $perPage = 15,
    ) {}
}
