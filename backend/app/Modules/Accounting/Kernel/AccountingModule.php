<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Kernel;

use App\Core\Kernel\Modules\Module;
use App\Core\EventBus\EventRegistry;
use App\Events\JournalEntryPosted;
use App\Modules\Accounting\Listeners\JournalEntryPostedListener;

class AccountingModule extends Module
{
    public function name(): string
    {
        return 'Accounting';
    }


    public function register(): void {}


    public function boot(): void
    {
        app(EventRegistry::class)
            ->register(
                JournalEntryPosted::class,
                JournalEntryPostedListener::class
            );
    }
}
