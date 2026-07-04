<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\InvoiceRepositoryInterface;
use App\Models\Invoice;
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

    public function save(Invoice $invoice): bool
    {
        return $invoice->save();
    }

    public function delete(Invoice $invoice): bool
    {
        return (bool) $invoice->delete();
    }
}
