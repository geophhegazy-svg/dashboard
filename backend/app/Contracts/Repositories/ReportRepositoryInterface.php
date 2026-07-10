<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Report;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReportRepositoryInterface
{
    public function paginate(): LengthAwarePaginator;

    public function create(array $data): Report;

    public function update(
        Report $report,
        array $data
    ): Report;

    public function delete(
        Report $report
    ): bool;

    public function find(
        int $id
    ): ?Report;
}
