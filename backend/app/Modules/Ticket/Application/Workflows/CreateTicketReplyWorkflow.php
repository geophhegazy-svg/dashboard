<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Workflows;

use App\Modules\Ticket\Infrastructure\Persistence\Models\TicketReply;
use App\Modules\Ticket\Application\Actions\CreateTicketReplyAction;

final readonly class CreateTicketReplyWorkflow
{
    public function __construct(
        private CreateTicketReplyAction $action,
    ) {}

    public function execute(
        array $attributes,
    ): TicketReply {

        return $this->action->execute(
            $attributes,
        );
    }
}
