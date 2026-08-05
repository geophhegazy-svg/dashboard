<?php

declare(strict_types=1);

namespace App\Modules\Reports\Infrastructure\Repositories;

use App\Modules\Reports\Infrastructure\Persistence\Models\Report;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Reports\Domain\Contracts\ReportRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ReportRepository implements ReportRepositoryInterface
{
    public function all(): Collection
    {
        return Report::query()
            ->latest()
            ->get();
    }

    public function find(
        int $id
    ): ?Report {

        return Report::query()->find($id);
    }

    public function create(
        array $data
    ): Report {

        return Report::query()->create($data);
    }

    public function update(
        Report $report,
        array $data
    ): Report {

        $report->update($data);

        return $report->refresh();
    }

    public function delete(
        Report $report
    ): bool {

        return (bool) $report->delete();
    }

    public function paginate(): LengthAwarePaginator
    {
        return Report::query()
            ->latest()
            ->paginate();
    }
}
