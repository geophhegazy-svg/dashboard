<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Workflows;

use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Modules\Ticket\Application\Actions\CreateTicketAction;

final readonly class CreateTicketWorkflow
{
    public function __construct(
        private CreateTicketAction $action,
    ) {}

    public function execute(
        array $attributes,
    ): Ticket {

        return $this->action->execute(
            $attributes,
        );
    }
}
