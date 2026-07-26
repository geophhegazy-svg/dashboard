<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Console\Kernel;


use App\Core\Kernel\Diagnostics\KernelDiagnostics;
use Illuminate\Console\Command;

final class KernelDiagnosticsCommand extends Command
{
    protected $signature = 'kernel:diagnostics';

    protected $description =
    'Display kernel diagnostic information.';


    public function __construct(
        private readonly KernelDiagnostics $diagnostics,
    ) {
        parent::__construct();
    }


    public function handle(): int
    {
        $report = $this->diagnostics->generate();


        $this->table(
            [
                'Metric',
                'Value',
            ],
            [
                [
                    'Modules',
                    $report->modules(),
                ],
                [
                    'Resources',
                    $report->resources(),
                ],
                [
                    'Dependencies',
                    $report->dependencies(),
                ],
                [
                    'Boot Status',
                    $report->booted()
                        ? 'Booted'
                        : 'Not Booted',
                ],
                [
                    'Booted At',
                    $report->bootedAt()
                        ? $report->bootedAt()
                        ->format('Y-m-d H:i:s')
                        : 'N/A',
                ],
                [
                    'Cache',
                    $report->cacheAvailable()
                        ? 'Available'
                        : 'Missing',
                ],
                [
                    'Manifest',
                    $report->manifestAvailable()
                        ? 'Available'
                        : 'Missing',
                ],
                [
                    'Lifecycle',
                    $report->lifecycle(),
                ],
                [
                    'Fingerprint',
                    $report->fingerprint()
                        ?? 'N/A',
                ],
            ],
        );


        return self::SUCCESS;
    }
}
