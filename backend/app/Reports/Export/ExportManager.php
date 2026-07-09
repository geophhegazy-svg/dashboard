<?php

declare(strict_types=1);

namespace App\Reports\Export;

use App\Reports\DTO\ExportResult;
use App\Reports\DTO\ReportResult;
use App\Reports\Export\Contracts\ExporterInterface;
use RuntimeException;

class ExportManager
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

        return $this->exporters[$format]
            ->export($report);
    }

    public function has(
        string $format
    ): bool {
        return isset(
            $this->exporters[$format]
        );
    }

    public function count(): int
    {
        return count(
            $this->exporters
        );
    }
}
