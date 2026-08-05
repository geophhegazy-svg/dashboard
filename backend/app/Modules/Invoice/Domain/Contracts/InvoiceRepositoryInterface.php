<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Domain\Contracts;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;

interface InvoiceRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Invoice;

    public function create(
        array $attributes,
    ): Invoice;

    public function save(Invoice $invoice): bool;

    public function update(
        Invoice $invoice,
        array $attributes,
    ): bool;

    public function fresh(
        Invoice $invoice,
        array $relations = [],
    ): Invoice;

    public function delete(Invoice $invoice): bool;
}
