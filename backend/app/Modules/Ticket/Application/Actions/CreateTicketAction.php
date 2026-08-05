<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;

final readonly class CreateTicketAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function execute(
        array $attributes,
    ): Ticket {

        return $this->repository->create(
            $attributes,
        );
    }
}
