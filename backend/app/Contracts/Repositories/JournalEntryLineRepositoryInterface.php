<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
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
