<?php

declare(strict_types=1);

namespace App\Modules\Reports\Application\Manager;

use App\Modules\Reports\Application\Contracts\ExporterInterface;
use App\Modules\Reports\Application\DTO\ExportResult;
use App\Modules\Reports\Application\DTO\ReportResult;
use RuntimeException;

final class ExportManager
{
    /**
     * @var array<string, ExporterInterface>
     */
    private array $exporters = [];

    public function register(
        ExporterInterface $exporter
    ): void {
        $this->exporters[$exporter->name()] = $exporter;
    }

    public function export(
        ReportResult $report,
        string $format
    ): ExportResult {
        if (! isset($this->exporters[$format])) {
            throw new RuntimeException(
                "Exporter [{$format}] is not registered."
            );
        }

        return $this->exporters[$format]->export($report);
    }

    public function has(
        string $format
    ): bool {
        return isset($this->exporters[$format]);
    }

    public function count(): int
    {
        return count($this->exporters);
    }
}
