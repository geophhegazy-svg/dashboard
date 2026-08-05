<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Application\Services;

use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntry;
use App\Modules\Accounting\Application\Workflows\PostJournalEntryWorkflow;

final readonly class JournalPostingService
{
    public function __construct(
        private PostJournalEntryWorkflow $workflow,
    ) {}


    public function post(
        JournalEntry $entry
    ): JournalEntry {

        return $this->workflow->execute(
            $entry
        );
    }
}
