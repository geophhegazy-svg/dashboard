<?php

declare(strict_types=1);

namespace App\Modules\Reports;

use App\Contracts\Repositories\ReportRepositoryInterface;
use App\Models\Report;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReportService
{
    public function __construct(
        private readonly ReportRepositoryInterface $reports,
    ) {}

    public function paginate(): LengthAwarePaginator
    {
        return $this->reports->paginate();
    }

    public function create(array $data): Report
    {
        return $this->reports->create($data);
    }

    public function update(
        Report $report,
        array $data
    ): Report {
        return $this->reports->update(
            $report,
            $data
        );
    }

    public function delete(
        Report $report
    ): bool {
        return $this->reports->delete($report);
    }

    public function find(
        int $id
    ): ?Report {
        return $this->reports->find($id);
    }
}
