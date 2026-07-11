<?php

declare(strict_types=1);

namespace App\Services\Accounting;

use App\Events\JournalEntryPosted;
use App\Exceptions\Accounting\JournalPostingException;
use App\Models\JournalEntry;
use App\Services\Activity\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JournalPostingService
{
    public function __construct(
        private readonly JournalValidationService $validationService,
        private readonly ActivityLogService $activityLogService,
    ) {}

    public function post(JournalEntry $entry): JournalEntry
    {
        $entry->loadMissing('lines');

        if ($entry->status !== 'draft') {
            throw new JournalPostingException(
                'Only draft journal entries can be posted.'
            );
        }

        $this->validationService->validate($entry);

        return DB::transaction(function () use ($entry): JournalEntry {

            $entry->update([
                'status'    => 'posted',
                'posted_at' => now(),
                'posted_by' => Auth::id(),
            ]);

            $this->activityLogService->log(
                tenantId: (int) $entry->tenant_id,
                userId: Auth::id(),
                module: 'Accounting',
                action: 'Journal Posted',
                description: "Journal Entry {$entry->entry_number} posted."
            );

            JournalEntryPosted::dispatch($entry);

            return $entry->fresh([
                'lines',
                'creator',
                'approver',
                'postedBy',
            ]);
        });
    }
}
