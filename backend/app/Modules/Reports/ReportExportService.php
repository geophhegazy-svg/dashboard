<?php

declare(strict_types=1);

namespace App\Modules\Reports;

use App\Contracts\Repositories\ReportExportRepositoryInterface;
use App\Models\ReportExport;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReportExportService
{
    public function __construct(
        private readonly ReportExportRepositoryInterface $exports,
    ) {}

    public function paginate(): LengthAwarePaginator
    {
        return $this->exports->paginate();
    }

    public function create(array $data): ReportExport
    {
        return $this->exports->create($data);
    }

    public function find(
        int $id
    ): ?ReportExport {
        return $this->exports->find($id);
    }
}
