<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Application\Actions;

use App\Models\JournalEntry;
use App\Exceptions\Accounting\JournalPostingException;
use App\Modules\Accounting\Application\Services\JournalValidationService;
use App\Modules\Activity\Application\Services\ActivityLogService;
use App\Modules\Accounting\Domain\Events\JournalEntryPosted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final readonly class PostJournalEntryAction
{
    public function __construct(
        private JournalValidationService $validationService,
    ) {}

    public function execute(
        JournalEntry $entry
    ): JournalEntry {

        $entry->loadMissing('lines');


        if ($entry->status !== 'draft') {

            throw new JournalPostingException(
                'Only draft journal entries can be posted.'
            );
        }


        $this->validationService->validate(
            $entry
        );


        return DB::transaction(
            function () use ($entry): JournalEntry {


                $entry->update([

                    'status'    => 'posted',
                    'posted_at' => now(),
                    'posted_by' => Auth::id(),

                ]);


                ActivityLogService::log(

                    tenantId: (int) $entry->tenant_id,

                    userId: Auth::id(),

                    module: 'Accounting',

                    action: 'Journal Posted',

                    description: "Journal Entry {$entry->entry_number} posted."

                );

                JournalEntryPosted::dispatch(
                    $entry
                );


                return $entry->fresh([
                    'lines',
                    'creator',
                    'approver',
                    'postedBy',
                ]);
            }
        );
    }
}
