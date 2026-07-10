<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\ReportExport;
use Illuminate\Database\Eloquent\Collection;

class ReportExportRepository
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
}
