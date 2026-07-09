<?php

declare(strict_types=1);

namespace App\Reports\Export;

use RuntimeException;
use App\Reports\DTO\ReportResult;
use App\Reports\Export\Contracts\Exporter;

class ExportManager
{
    /**
     * @var array<string, Exporter>
     */
    private array $exporters = [];

    public function register(
        Exporter $exporter
    ): void {

        $this->exporters[$exporter->extension()] = $exporter;
    }

    public function export(
        ReportResult $report,
        string $format
    ): string {

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
