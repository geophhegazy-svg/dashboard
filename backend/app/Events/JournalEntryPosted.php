<?php

declare(strict_types=1);

namespace App\Events;

use App\Core\EventBus\Contracts\EventContract;
use App\Models\JournalEntry;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JournalEntryPosted implements EventContract
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public readonly JournalEntry $journalEntry,
    ) {}
}
