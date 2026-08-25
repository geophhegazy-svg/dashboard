<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;
use App\Modules\Invoice\Infrastructure\Repositories\InvoiceRepository;

use App\Modules\Invoice\Application\Actions\CreateInvoiceAction;
use App\Modules\Invoice\Application\Actions\UpdateInvoiceAction;
use App\Modules\Invoice\Application\Actions\DeleteInvoiceAction;
use App\Modules\Invoice\Application\Actions\SettleInvoiceAction;

use App\Modules\Invoice\Application\Services\InvoiceService;

use App\Modules\Invoice\Application\Queries\PaginateInvoicesQuery;
use App\Modules\Invoice\Application\Queries\GetCustomerInvoiceSummaryQuery;
use App\Modules\Invoice\Application\Queries\PaginateCustomerInvoicesQuery;
use App\Modules\Invoice\Application\Queries\FindCustomerInvoiceQuery;
use App\Modules\Invoice\Application\Queries\Handlers\PaginateCustomerInvoicesQueryHandler;
use App\Modules\Invoice\Application\Queries\Handlers\FindCustomerInvoiceQueryHandler;
use App\Modules\Invoice\Application\Queries\GetInvoiceDashboardMetricsQuery;
use App\Modules\Invoice\Application\Queries\GetInvoiceStatusMetricsQuery;
use App\Modules\Invoice\Application\Queries\BuildInvoiceReportQuery;

use App\Modules\Invoice\Application\Queries\Handlers\PaginateInvoicesQueryHandler;
use App\Modules\Invoice\Application\Queries\Handlers\GetCustomerInvoiceSummaryQueryHandler;
use App\Modules\Invoice\Application\Queries\Handlers\GetInvoiceDashboardMetricsQueryHandler;
use App\Modules\Invoice\Application\Queries\Handlers\GetInvoiceStatusMetricsQueryHandler;
use App\Modules\Invoice\Application\Queries\Handlers\BuildInvoiceReportQueryHandler;

use App\Modules\Invoice\Application\Commands\CreateInvoiceCommand;
use App\Modules\Invoice\Application\Commands\UpdateInvoiceCommand;
use App\Modules\Invoice\Application\Commands\DeleteInvoiceCommand;

use App\Modules\Invoice\Application\Commands\Handlers\CreateInvoiceCommandHandler;
use App\Modules\Invoice\Application\Commands\Handlers\UpdateInvoiceCommandHandler;
use App\Modules\Invoice\Application\Commands\Handlers\DeleteInvoiceCommandHandler;
use App\Modules\Invoice\Application\Contracts\InvoiceServiceInterface;

final class InvoiceModule extends Module
{
    public function name(): string
    {
        return 'Invoice';
    }

    public function dependencies(): array
    {
        return [];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                InvoiceRepositoryInterface::class
                => InvoiceRepository::class,

                CreateInvoiceAction::class
                => CreateInvoiceAction::class,

                UpdateInvoiceAction::class
                => UpdateInvoiceAction::class,

                DeleteInvoiceAction::class
                => DeleteInvoiceAction::class,

                SettleInvoiceAction::class
                => SettleInvoiceAction::class,

                InvoiceServiceInterface::class
                => InvoiceService::class,

            ])

            ->queries([

                PaginateInvoicesQuery::class
                => PaginateInvoicesQueryHandler::class,

                GetCustomerInvoiceSummaryQuery::class
                => GetCustomerInvoiceSummaryQueryHandler::class,

                PaginateCustomerInvoicesQuery::class
                => PaginateCustomerInvoicesQueryHandler::class,

                FindCustomerInvoiceQuery::class
                => FindCustomerInvoiceQueryHandler::class,

                GetInvoiceDashboardMetricsQuery::class
                => GetInvoiceDashboardMetricsQueryHandler::class,

                GetInvoiceStatusMetricsQuery::class
                => GetInvoiceStatusMetricsQueryHandler::class,

                BuildInvoiceReportQuery::class
                => BuildInvoiceReportQueryHandler::class,

            ])

            ->commandHandlers([

                CreateInvoiceCommand::class
                => CreateInvoiceCommandHandler::class,

                UpdateInvoiceCommand::class
                => UpdateInvoiceCommandHandler::class,

                DeleteInvoiceCommand::class
                => DeleteInvoiceCommandHandler::class,

            ]);
    }
}
