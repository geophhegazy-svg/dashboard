<?php

declare(strict_types=1);

namespace App\Repositories;

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

    public function deleteByJournalEntry(JournalEntry $entry): bool
    {
        return (bool) $entry->lines()->delete();
    }
}
