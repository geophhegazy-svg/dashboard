<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Domain\Contracts;

use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntry;
use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntryLine;
use Illuminate\Database\Eloquent\Collection;

interface JournalEntryLineRepositoryInterface
{
    public function all(JournalEntry $entry): Collection;

    public function create(array $data): JournalEntryLine;

    public function createMany(JournalEntry $entry, array $lines): Collection;

    public function deleteByJournalEntry(JournalEntry $entry): bool;

    public function find(int $id): ?JournalEntryLine;

    public function delete(JournalEntryLine $line): bool;
}
