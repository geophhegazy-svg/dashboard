<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\JournalEntry;
use Illuminate\Database\Eloquent\Collection;

interface JournalEntryRepositoryInterface
{
    public function create(array $data): JournalEntry;

    public function update(JournalEntry $entry, array $data): JournalEntry;

    public function delete(JournalEntry $entry): bool;

    public function find(int $id): ?JournalEntry;

    public function all(): Collection;
}
