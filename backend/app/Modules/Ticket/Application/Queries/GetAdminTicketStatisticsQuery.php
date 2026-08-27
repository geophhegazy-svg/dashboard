<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Queries;

use App\Core\QueryBus\Contracts\QueryInterface;

final readonly class GetAdminTicketStatisticsQuery implements QueryInterface
{
    public function __construct() {}
}
