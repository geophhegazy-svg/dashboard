<?php

declare(strict_types=1);

namespace App\Modules\Accounting\Domain\Contracts;

use App\Modules\Accounting\Infrastructure\Persistence\Models\JournalEntry;
use Illuminate\Database\Eloquent\Collection;

interface JournalEntryRepositoryInterface
{
    public function create(array $data): JournalEntry;

    public function update(
        JournalEntry $entry,
        array $data,
    ): bool;

    public function delete(JournalEntry $entry): bool;

    public function find(int $id): ?JournalEntry;

    public function all(): Collection;
}
