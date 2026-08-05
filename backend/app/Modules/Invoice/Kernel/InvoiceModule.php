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

use App\Modules\Invoice\Application\Workflows\CreateInvoiceWorkflow;
use App\Modules\Invoice\Application\Workflows\UpdateInvoiceWorkflow;
use App\Modules\Invoice\Application\Workflows\DeleteInvoiceWorkflow;
use App\Modules\Invoice\Application\Services\InvoiceService;

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

                CreateInvoiceWorkflow::class
                => CreateInvoiceWorkflow::class,

                UpdateInvoiceWorkflow::class
                => UpdateInvoiceWorkflow::class,

                DeleteInvoiceWorkflow::class
                => DeleteInvoiceWorkflow::class,

                InvoiceService::class
                => InvoiceService::class,

            ]);
    }
}
