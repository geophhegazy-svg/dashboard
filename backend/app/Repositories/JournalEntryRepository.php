<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\JournalEntry;
use App\Repositories\Contracts\JournalEntryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class JournalEntryRepository implements JournalEntryRepositoryInterface
{
    public function create(array $data): JournalEntry
    {
        return JournalEntry::create($data);
    }

    public function update(JournalEntry $entry, array $data): JournalEntry
    {
        $entry->update($data);

        return $entry->refresh();
    }

    public function delete(JournalEntry $entry): bool
    {
        return (bool) $entry->delete();
    }

    public function find(int $id): ?JournalEntry
    {
        return JournalEntry::with('lines')->find($id);
    }

    public function all(): Collection
    {
        return JournalEntry::with('lines')
            ->latest()
            ->get();
    }
}
