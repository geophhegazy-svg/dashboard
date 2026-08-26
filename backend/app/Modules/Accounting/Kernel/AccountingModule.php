<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Accounting\Domain\Events\JournalEntryPosted;
use App\Modules\Accounting\Listeners\JournalEntryPostedListener;
use App\Modules\Accounting\Domain\Contracts\JournalEntryRepositoryInterface;
use App\Modules\Accounting\Application\Services\JournalEntryNumberService;
use App\Modules\Accounting\Application\Services\JournalValidationService;

use App\Modules\Accounting\Infrastructure\Repositories\JournalEntryRepository;

final class AccountingModule extends Module
{
    public function name(): string
    {
        return 'Accounting';
    }

    public function dependencies(): array
    {
        return [
            \App\Modules\Activity\Kernel\ActivityModule::class,
        ];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                JournalEntryRepositoryInterface::class
                => JournalEntryRepository::class,

                JournalEntryNumberService::class
                => JournalEntryNumberService::class,

                JournalValidationService::class
                => JournalValidationService::class,

            ])

            ->listeners([

                JournalEntryPosted::class => [

                    JournalEntryPostedListener::class,

                ],

            ]);
    }
}
