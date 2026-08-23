<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Infrastructure\Repositories;

use App\Modules\Accounting\Domain\Contracts\JournalEntryRepositoryInterface;
use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntry;
use Illuminate\Database\Eloquent\Collection;

class JournalEntryRepository implements JournalEntryRepositoryInterface
{
    public function all(): Collection
    {
        return JournalEntry::orderByDesc('entry_date')->get();
    }

    public function find(int $id): ?JournalEntry
    {
        return JournalEntry::find($id);
    }

    public function findLatestForYear(int $year): ?JournalEntry
    {
        return JournalEntry::query()
            ->whereYear('entry_date', $year)
            ->orderByDesc('id')
            ->first();
    }

    public function create(array $data): JournalEntry
    {
        return JournalEntry::create($data);
    }

    public function update(
        JournalEntry $entry,
        array $data,
    ): bool {

        return $entry->update(
            $data,
        );
    }

    public function delete(JournalEntry $entry): bool
    {
        return (bool) $entry->delete();
    }

}
