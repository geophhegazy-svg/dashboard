<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\JournalEntryLineRepositoryInterface;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use Illuminate\Database\Eloquent\Collection;

class JournalEntryLineRepository implements JournalEntryLineRepositoryInterface
{
    public function all(JournalEntry $entry): Collection
    {
        return $entry->lines()->with('account')->get();
    }

    public function find(int $id): ?JournalEntryLine
    {
        return JournalEntryLine::find($id);
    }

    public function create(array $data): JournalEntryLine
    {
        return JournalEntryLine::create($data);
    }

    public function createMany(JournalEntry $entry, array $lines): Collection
    {
        $created = collect();

        foreach ($lines as $line) {
            $created->push(
                $entry->lines()->create($line)
            );
        }

        return $created;
    }

    public function delete(JournalEntryLine $line): bool
    {
        return (bool) $line->delete();
    }

    public function deleteByJournalEntry(JournalEntry $entry): bool
    {
        return (bool) $entry->lines()->delete();
    }

}
