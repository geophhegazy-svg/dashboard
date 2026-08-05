<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;

final readonly class DeleteTicketAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function execute(
        Ticket $ticket,
    ): bool {

        return $this->repository->delete(
            $ticket,
        );
    }
}
