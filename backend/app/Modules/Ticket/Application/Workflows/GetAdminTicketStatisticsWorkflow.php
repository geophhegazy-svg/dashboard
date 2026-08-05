<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Workflows;

use App\Modules\Ticket\Application\Actions\GetAdminTicketStatisticsAction;

final readonly class GetAdminTicketStatisticsWorkflow
{
    public function __construct(
        private GetAdminTicketStatisticsAction $action,
    ) {}

    public function execute(): array
    {
        return $this->action->execute();
    }
}
