<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;
use App\Modules\Invoice\Infrastructure\Repositories\InvoiceRepository;

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

            ]);
    }
}
