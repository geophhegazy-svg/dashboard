<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Application\Services;

use App\Modules\Accounting\Application\Actions\PostJournalEntryAction;
use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntry;

final readonly class JournalPostingService
{
    public function __construct(
        private PostJournalEntryAction $action,
    ) {}

    public function post(
        JournalEntry $entry
    ): JournalEntry {
        return $this->action->execute($entry);
    }
}
