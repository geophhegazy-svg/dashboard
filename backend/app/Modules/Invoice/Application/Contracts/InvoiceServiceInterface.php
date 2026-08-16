<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Contracts;

use App\Modules\Invoice\Infrastructure\Persistence\Models\Invoice;

interface InvoiceServiceInterface
{
    public function create(
        array $data,
    ): Invoice;

    public function update(
        Invoice $invoice,
        array $data,
    ): Invoice;

    public function delete(
        Invoice $invoice,
    ): bool;
}
