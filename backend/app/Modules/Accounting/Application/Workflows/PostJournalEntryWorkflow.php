<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Application\Workflows;

use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntry;
use App\Core\Workflow\AbstractWorkflow;
use App\Core\Workflow\Contracts\WorkflowContextInterface;
use App\Modules\Accounting\Application\Actions\PostJournalEntryAction;

final class PostJournalEntryWorkflow extends AbstractWorkflow
{
    public function __construct(
        private readonly PostJournalEntryAction $action,
    ) {}

    protected function perform(
        WorkflowContextInterface $context,
    ): JournalEntry {

        /** @var JournalEntry $entry */
        $entry = $context->dto()[0] ?? null;

        return $this->action->execute(
            $entry
        );
    }
}
