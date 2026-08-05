<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Workflows;

use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Models\User;
use App\Modules\Ticket\Application\Actions\AssignTicketAction;

final readonly class AssignTicketWorkflow
{
    public function __construct(
        private AssignTicketAction $action,
    ) {}

    public function execute(
        Ticket $ticket,
        User $user,
    ): Ticket {

        return $this->action->execute(
            $ticket,
            $user,
        );
    }
}
