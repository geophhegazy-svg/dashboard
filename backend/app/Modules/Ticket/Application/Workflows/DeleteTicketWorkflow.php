<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Workflows;

use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Modules\Ticket\Application\Actions\DeleteTicketAction;

final readonly class DeleteTicketWorkflow
{
    public function __construct(
        private DeleteTicketAction $action,
    ) {}

    public function execute(
        Ticket $ticket,
    ): bool {

        return $this->action->execute(
            $ticket,
        );
    }
}
