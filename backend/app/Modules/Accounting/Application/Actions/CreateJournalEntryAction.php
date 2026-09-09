<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Application\Actions;

use App\Modules\Accounting\Application\Services\JournalNumberService;
use App\Modules\Accounting\Domain\Contracts\JournalEntryRepositoryInterface;
use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntry;

final readonly class CreateJournalEntryAction
{
    public function __construct(
        private JournalEntryRepositoryInterface $repository,
        private JournalNumberService $numberService,
    ) {}

    public function execute(array $data): JournalEntry
    {
        $entryDate = $data['entry_date'] ?? now()->toDateString();

        $year = (int) date(
            'Y',
            strtotime((string) $entryDate),
        );

        $tenantId = (int) $data['tenant_id'];

        $data['entry_number'] =
            $this->numberService->generate(
                tenantId: $tenantId,
                year: $year,
            );

        $data['status'] = 'draft';

        $data['approved_by'] = null;
        $data['approved_at'] = null;
        $data['posted_at'] = null;
        $data['posted_by'] = null;

        return $this->repository->create($data);
    }
}
