<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\JournalEntryRepositoryInterface;
use App\Models\JournalEntry;
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

    public function findByEntryNumber(string $entryNumber): ?JournalEntry
    {
        return JournalEntry::where('entry_number', $entryNumber)->first();
    }

    public function create(array $data): JournalEntry
    {
        return JournalEntry::create($data);
    }

    public function update(JournalEntry $entry, array $data): JournalEntry
    {
        $entry->update($data);

        return $entry->fresh();
    }

    public function delete(JournalEntry $entry): bool
    {
        return (bool) $entry->delete();
    }

    public function findWithLines(int $id): ?JournalEntry
    {
        return JournalEntry::with('lines.account')->find($id);
    }
}
