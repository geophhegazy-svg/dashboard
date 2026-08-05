<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Workflows;

use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Modules\Ticket\Application\Actions\ChangeTicketStatusAction;

final readonly class ChangeTicketStatusWorkflow
{
    public function __construct(
        private ChangeTicketStatusAction $action,
    ) {}

    public function execute(
        Ticket $ticket,
        string $status,
    ): Ticket {

        return $this->action->execute(
            $ticket,
            $status,
        );
    }
}
