<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Listeners;

use App\Core\EventBus\Contracts\ListenerContract;
use App\Core\EventBus\Contracts\EventContract;
use App\Events\JournalEntryPosted;
use Illuminate\Support\Facades\Log;

class JournalEntryPostedListener implements ListenerContract
{
    public function handle(EventContract $event): void
    {
        if (!$event instanceof JournalEntryPosted) {
            return;
        }


        Log::info(
            'Accounting Module received JournalEntryPosted',
            [
                'journal_entry_id' =>
                $event->journalEntry->id,
            ]
        );
    }
}
