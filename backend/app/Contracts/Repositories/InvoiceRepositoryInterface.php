<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;

interface InvoiceRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Invoice;

    public function save(Invoice $invoice): bool;

    public function delete(Invoice $invoice): bool;
}
