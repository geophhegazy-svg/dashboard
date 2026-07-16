<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Listeners;

use Illuminate\Support\Facades\Log;
use App\Core\EventBus\Contracts\EventContract;
use App\Core\EventBus\Contracts\EventListenerInterface;
use App\Modules\Accounting\Events\JournalEntryPosted;

final class JournalEntryPostedListener implements EventListenerInterface
{
    public function handle(
        EventContract $event
    ): void {

        if (! $event instanceof JournalEntryPosted) {
            return;
        }

        Log::info(
            'Accounting Module received JournalEntryPosted',
            [
                'journal_entry_id' => $event->journalEntry->id,
            ]
        );
    }
}
