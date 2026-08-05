<?php

declare(strict_types=1);

namespace App\Modules\Reports\Domain\Contracts;

use App\Modules\Reports\Infrastructure\Persistence\Models\ReportExport;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReportExportRepositoryInterface
{
    public function paginate(): LengthAwarePaginator;

    public function create(array $data): ReportExport;

    public function find(
        int $id
    ): ?ReportExport;
}
