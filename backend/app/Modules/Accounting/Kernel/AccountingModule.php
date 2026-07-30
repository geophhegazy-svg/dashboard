<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Modules\Accounting\Domain\Events\JournalEntryPosted;
use App\Modules\Accounting\Listeners\JournalEntryPostedListener;
use App\Modules\Accounting\Domain\Contracts\AccountRepositoryInterface;
use App\Modules\Accounting\Domain\Contracts\JournalEntryRepositoryInterface;
use App\Modules\Accounting\Domain\Contracts\JournalEntryLineRepositoryInterface;

use App\Modules\Accounting\Infrastructure\Repositories\AccountRepository;
use App\Modules\Accounting\Infrastructure\Repositories\JournalEntryRepository;
use App\Modules\Accounting\Infrastructure\Repositories\JournalEntryLineRepository;

final class AccountingModule extends Module
{
    public function name(): string
    {
        return 'Accounting';
    }

    public function dependencies(): array
    {
        return [
            \App\Modules\Billing\Kernel\BillingModule::class,
        ];
    }

    public function manifest(): ModuleManifest
    {
        return ModuleManifest::make()

            ->services([

                AccountRepositoryInterface::class
                => AccountRepository::class,

                JournalEntryRepositoryInterface::class
                => JournalEntryRepository::class,

                JournalEntryLineRepositoryInterface::class
                => JournalEntryLineRepository::class,

            ])

            ->listeners([

                JournalEntryPosted::class => [

                    JournalEntryPostedListener::class,

                ],

            ]);
    }
}
