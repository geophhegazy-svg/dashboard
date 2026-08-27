<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Queries;

use App\Core\QueryBus\Contracts\QueryInterface;

final readonly class FindCustomerTicketQuery implements QueryInterface
{
    public function __construct(
        public int $customerId,
        public int $ticketId,
        public array $relations = [],
    ) {}
}
