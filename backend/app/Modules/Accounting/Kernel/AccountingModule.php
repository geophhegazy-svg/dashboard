<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Kernel;

use App\Core\Kernel\ModuleManifest;
use App\Core\Kernel\Modules\Module;
use App\Events\JournalEntryPosted;
use App\Modules\Accounting\Listeners\JournalEntryPostedListener;

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

            ->listeners([

                JournalEntryPosted::class => [

                    JournalEntryPostedListener::class,

                ],

            ]);
    }
}
