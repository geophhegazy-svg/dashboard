<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Application\Services;

use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntry;
use App\Core\Workflow\WorkflowEngine;
use App\Modules\Accounting\Application\Workflows\PostJournalEntryWorkflow;

final readonly class JournalPostingService
{
    public function __construct(
        private WorkflowEngine $engine,
        private PostJournalEntryWorkflow $workflow,
    ) {}


    public function post(
        JournalEntry $entry
    ): JournalEntry {

        $result = $this->engine->run(
            $this->workflow,
            $entry,
        );

        /** @var JournalEntry $posted */
        $posted = $result->payload();

        return $posted;
    }
}
