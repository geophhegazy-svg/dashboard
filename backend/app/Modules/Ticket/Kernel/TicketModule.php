<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Repositories\TicketRepository;
use App\Modules\Ticket\Application\Actions\CreateTicketAction;
use App\Modules\Ticket\Application\Workflows\CreateTicketWorkflow;
use App\Modules\Ticket\Application\Actions\UpdateTicketAction;
use App\Modules\Ticket\Application\Workflows\UpdateTicketWorkflow;
use App\Modules\Ticket\Application\Actions\DeleteTicketAction;
use App\Modules\Ticket\Application\Workflows\DeleteTicketWorkflow;
use App\Modules\Ticket\Application\Actions\CreateTicketReplyAction;
use App\Modules\Ticket\Application\Workflows\CreateTicketReplyWorkflow;
use App\Modules\Ticket\Application\Actions\ChangeTicketStatusAction;
use App\Modules\Ticket\Application\Workflows\ChangeTicketStatusWorkflow;
use App\Modules\Ticket\Application\Actions\AssignTicketAction;
use App\Modules\Ticket\Application\Workflows\AssignTicketWorkflow;
use App\Modules\Ticket\Application\Actions\GetAdminTicketStatisticsAction;
use App\Modules\Ticket\Application\Workflows\GetAdminTicketStatisticsWorkflow;
use App\Modules\Ticket\Application\Actions\GetCustomerTicketStatisticsAction;
use App\Modules\Ticket\Application\Workflows\GetCustomerTicketStatisticsWorkflow;


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

                CreateTicketWorkflow::class
                => CreateTicketWorkflow::class,

                UpdateTicketAction::class
                => UpdateTicketAction::class,

                UpdateTicketWorkflow::class
                => UpdateTicketWorkflow::class,

                DeleteTicketAction::class
                => DeleteTicketAction::class,

                DeleteTicketWorkflow::class
                => DeleteTicketWorkflow::class,

                CreateTicketReplyAction::class
                => CreateTicketReplyAction::class,

                CreateTicketReplyWorkflow::class
                => CreateTicketReplyWorkflow::class,

                ChangeTicketStatusAction::class
                => ChangeTicketStatusAction::class,

                ChangeTicketStatusWorkflow::class
                => ChangeTicketStatusWorkflow::class,

                AssignTicketAction::class
                => AssignTicketAction::class,

                AssignTicketWorkflow::class
                => AssignTicketWorkflow::class,

                GetAdminTicketStatisticsAction::class
                => GetAdminTicketStatisticsAction::class,

                GetAdminTicketStatisticsWorkflow::class
                => GetAdminTicketStatisticsWorkflow::class,

                GetCustomerTicketStatisticsAction::class
                => GetCustomerTicketStatisticsAction::class,

                GetCustomerTicketStatisticsWorkflow::class
                => GetCustomerTicketStatisticsWorkflow::class,

            ]);
    }
}
