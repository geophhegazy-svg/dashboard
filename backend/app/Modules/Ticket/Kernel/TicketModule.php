<?php

declare(strict_types=1);

namespace App\Modules\Ticket\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Ticket\Domain\Contracts\TicketRepositoryInterface;
use App\Modules\Ticket\Infrastructure\Repositories\TicketRepository;
use App\Modules\Ticket\Application\Actions\DeleteTicketAction;
use App\Modules\Ticket\Application\Actions\ChangeTicketStatusAction;
use App\Modules\Ticket\Application\Actions\AssignTicketAction;
use App\Modules\Ticket\Application\Actions\CreateAdminTicketAction;
use App\Modules\Ticket\Application\Actions\CreateCustomerTicketAction;
use App\Modules\Ticket\Application\Actions\UpdateTicketFromAdminAction;
use App\Modules\Ticket\Application\Actions\ReplyAsStaffAction;
use App\Modules\Ticket\Application\Actions\ReplyAsCustomerAction;
use App\Modules\Ticket\Application\Actions\CloseTicketByCustomerAction;
use App\Modules\Ticket\Application\Queries\PaginateCustomerTicketsQuery;
use App\Modules\Ticket\Application\Queries\PaginateTicketsQuery;
use App\Modules\Ticket\Application\Queries\FindTicketQuery;
use App\Modules\Ticket\Application\Queries\GetTicketStatusMetricsQuery;
use App\Modules\Ticket\Application\Queries\FindCustomerTicketQuery;
use App\Modules\Ticket\Application\Queries\GetTicketRepliesQuery;
use App\Modules\Ticket\Application\Queries\GetAdminTicketStatisticsQuery;
use App\Modules\Ticket\Application\Queries\GetCustomerTicketStatisticsQuery;
use App\Modules\Ticket\Application\Queries\Handlers\PaginateCustomerTicketsQueryHandler;
use App\Modules\Ticket\Application\Queries\Handlers\PaginateTicketsQueryHandler;
use App\Modules\Ticket\Application\Queries\Handlers\FindTicketQueryHandler;
use App\Modules\Ticket\Application\Queries\Handlers\GetTicketStatusMetricsQueryHandler;
use App\Modules\Ticket\Application\Queries\Handlers\FindCustomerTicketQueryHandler;
use App\Modules\Ticket\Application\Queries\Handlers\GetTicketRepliesQueryHandler;
use App\Modules\Ticket\Application\Queries\Handlers\GetAdminTicketStatisticsQueryHandler;
use App\Modules\Ticket\Application\Queries\Handlers\GetCustomerTicketStatisticsQueryHandler;
use App\Modules\Ticket\Infrastructure\Persistence\Models\Ticket;
use App\Modules\Ticket\Policies\TicketPolicy;

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

                CreateAdminTicketAction::class
                => CreateAdminTicketAction::class,

                CreateCustomerTicketAction::class
                => CreateCustomerTicketAction::class,

                UpdateTicketFromAdminAction::class
                => UpdateTicketFromAdminAction::class,

                DeleteTicketAction::class
                => DeleteTicketAction::class,

                ReplyAsStaffAction::class
                => ReplyAsStaffAction::class,

                ReplyAsCustomerAction::class
                => ReplyAsCustomerAction::class,

                ChangeTicketStatusAction::class
                => ChangeTicketStatusAction::class,

                CloseTicketByCustomerAction::class
                => CloseTicketByCustomerAction::class,

                AssignTicketAction::class
                => AssignTicketAction::class,

            ])

            ->queries([

                PaginateCustomerTicketsQuery::class
                => PaginateCustomerTicketsQueryHandler::class,

                PaginateTicketsQuery::class
                => PaginateTicketsQueryHandler::class,

                FindTicketQuery::class
                => FindTicketQueryHandler::class,

                FindCustomerTicketQuery::class
                => FindCustomerTicketQueryHandler::class,

                GetTicketRepliesQuery::class
                => GetTicketRepliesQueryHandler::class,

                GetTicketStatusMetricsQuery::class
                => GetTicketStatusMetricsQueryHandler::class,

                GetAdminTicketStatisticsQuery::class
                => GetAdminTicketStatisticsQueryHandler::class,

                GetCustomerTicketStatisticsQuery::class
                => GetCustomerTicketStatisticsQueryHandler::class,

            ])

            ->policies([

                Ticket::class => TicketPolicy::class,

            ]);
    }
}
