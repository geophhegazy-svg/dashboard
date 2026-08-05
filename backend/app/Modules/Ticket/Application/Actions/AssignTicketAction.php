<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Models\User;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;

final readonly class AssignTicketAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function execute(
        Ticket $ticket,
        User $user,
    ): Ticket {

        $this->repository->assign(
            $ticket,
            $user,
        );

        return $this->repository->fresh(
            $ticket,
        );
    }
}
