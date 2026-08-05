<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Application\Actions;

use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntry;
use App\Exceptions\Accounting\JournalPostingException;
use App\Modules\Accounting\Application\Services\JournalValidationService;
use App\Modules\Activity\Application\Workflows\LogActivityWorkflow;
use App\Modules\Accounting\Domain\Events\JournalEntryPosted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Modules\Accounting\Domain\Contracts\JournalEntryRepositoryInterface;

final readonly class PostJournalEntryAction
{
    public function __construct(
        private JournalValidationService $validationService,
        private readonly JournalEntryRepositoryInterface $journalEntries,
        private readonly LogActivityWorkflow $logActivity,
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


                $this->journalEntries->update(

                    $entry,

                    [

                        'status'    => 'posted',

                        'posted_at' => now(),

                        'posted_by' => Auth::id(),

                    ]

                );


                $this->logActivity->execute(

                    [
                        'tenant_id' => (int) $entry->tenant_id,
                        'module'    => 'Accounting',
                        'action'    => 'Journal Posted',
                    ],

                    [
                        'user_id'     => Auth::id(),
                        'description' => "Journal Entry {$entry->entry_number} posted.",
                        'ip_address'  => request()->ip(),
                    ],

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
