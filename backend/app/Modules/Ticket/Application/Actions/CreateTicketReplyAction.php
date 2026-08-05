<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Application\Actions;

use App\Modules\Ticket\Infrastructure\Persistence\Models\TicketReply;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;

final readonly class CreateTicketReplyAction
{
    public function __construct(
        private TicketRepositoryInterface $repository,
    ) {}

    public function execute(
        array $attributes,
    ): TicketReply {

        $reply = $this->repository->createReply(
            $attributes,
        );

        return $this->repository->freshReply(
            $reply,
        );
    }
}
