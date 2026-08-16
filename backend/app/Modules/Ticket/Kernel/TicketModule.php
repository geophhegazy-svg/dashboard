<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Repositories\TicketRepository;
use App\Modules\Ticket\Application\Actions\CreateTicketAction;
use App\Modules\Ticket\Application\Actions\UpdateTicketAction;
use App\Modules\Ticket\Application\Actions\DeleteTicketAction;
use App\Modules\Ticket\Application\Actions\CreateTicketReplyAction;
use App\Modules\Ticket\Application\Actions\ChangeTicketStatusAction;
use App\Modules\Ticket\Application\Actions\AssignTicketAction;
use App\Modules\Ticket\Application\Actions\GetAdminTicketStatisticsAction;
use App\Modules\Ticket\Application\Actions\GetCustomerTicketStatisticsAction;

final class TicketModule extends Module
{
    public function name(): string
    {
        return 'Ticket';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                TicketRepositoryInterface::class
                => TicketRepository::class,

                CreateTicketAction::class
                => CreateTicketAction::class,

                UpdateTicketAction::class
                => UpdateTicketAction::class,

                DeleteTicketAction::class
                => DeleteTicketAction::class,

                CreateTicketReplyAction::class
                => CreateTicketReplyAction::class,

                ChangeTicketStatusAction::class
                => ChangeTicketStatusAction::class,

                AssignTicketAction::class
                => AssignTicketAction::class,

                GetAdminTicketStatisticsAction::class
                => GetAdminTicketStatisticsAction::class,

                GetCustomerTicketStatisticsAction::class
                => GetCustomerTicketStatisticsAction::class,

            ]);
    }
}
