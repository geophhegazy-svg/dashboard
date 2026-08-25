<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Queries\Handlers;

use App\Modules\Invoice\Application\Queries\BuildInvoiceReportQuery;
use App\Modules\Invoice\Domain\Contracts\InvoiceRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

final readonly class BuildInvoiceReportQueryHandler
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
    ) {}

    public function handle(
        BuildInvoiceReportQuery $query,
    ): Builder {
        return $this->repository->queryForReport();
    }
}
