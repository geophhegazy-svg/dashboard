<?php

declare(strict_types=1);

namespace App\Modules\Reports\Infrastructure\Repositories;

use App\Models\ReportExport;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Reports\Domain\Contracts\ReportExportRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
final class ReportExportRepository implements ReportExportRepositoryInterface
{
    public function all(): Collection
    {
        return ReportExport::query()
            ->latest()
            ->get();
    }

    public function find(
        int $id
    ): ?ReportExport {

        return ReportExport::query()->find($id);
    }

    public function create(
        array $data
    ): ReportExport {

        return ReportExport::query()->create($data);
    }

    public function update(
        ReportExport $export,
        array $data
    ): ReportExport {

        $export->update($data);

        return $export->refresh();
    }

    public function delete(
        ReportExport $export
    ): bool {

        return (bool) $export->delete();
    }

    public function paginate(): LengthAwarePaginator
    {
        return ReportExport::query()
            ->latest()
            ->paginate();
    }
}
