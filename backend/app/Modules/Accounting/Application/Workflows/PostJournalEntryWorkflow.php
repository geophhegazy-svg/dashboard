<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Application\Workflows;

use App\Models\JournalEntry;
use App\Core\Workflow\AbstractWorkflow;
use App\Modules\Accounting\Application\Actions\PostJournalEntryAction;

final class PostJournalEntryWorkflow extends AbstractWorkflow
{
    public function __construct(
        private readonly PostJournalEntryAction $action,
    ) {}

    protected function perform(
        mixed ...$arguments
    ): JournalEntry {

        /** @var JournalEntry $entry */
        $entry = $arguments[0];

        return $this->action->execute(
            $entry
        );
    }
}
