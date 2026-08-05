<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Infrastructure\Repositories;

use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;
use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function all(): Collection
    {
        return Invoice::all();
    }

    public function find(int $id): ?Invoice
    {
        return Invoice::find($id);
    }

    public function create(
        array $attributes,
    ): Invoice {
        return Invoice::create(
            $attributes
        );
    }

    public function save(
        Invoice $invoice,
    ): bool {
        return $invoice->save();
    }

    public function update(
        Invoice $invoice,
        array $attributes,
    ): bool {
        return $invoice->update(
            $attributes
        );
    }

    public function fresh(
        Invoice $invoice,
        array $relations = [],
    ): Invoice {
        return $invoice->fresh(
            $relations
        );
    }

    public function delete(
        Invoice $invoice,
    ): bool {
        return (bool) $invoice->delete();
    }
}
