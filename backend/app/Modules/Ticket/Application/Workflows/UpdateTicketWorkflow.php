<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Workflows;

use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Modules\Ticket\Application\Actions\UpdateTicketAction;

final readonly class UpdateTicketWorkflow
{
    public function __construct(
        private UpdateTicketAction $action,
    ) {}

    public function execute(
        Ticket $ticket,
        array $attributes,
    ): Ticket {

        return $this->action->execute(
            $ticket,
            $attributes,
        );
    }
}
