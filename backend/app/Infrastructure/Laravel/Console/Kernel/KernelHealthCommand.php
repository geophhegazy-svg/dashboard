<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Console\Kernel;

use App\Core\Kernel\Health\KernelHealthService;
use Illuminate\Console\Command;

final class KernelHealthCommand extends Command
{
    protected $signature = 'kernel:health';

    protected $description =
    'Display kernel health status.';


    public function __construct(
        private readonly KernelHealthService $health,
    ) {
        parent::__construct();
    }


    public function handle(): int
    {
        $report = $this->health->check();


        $this->info(
            'Kernel Health',
        );


        $this->newLine();


        $this->line(
            'STATUS: ' . $report->status(),
        );


        $this->newLine();


        foreach ($report->results() as $result) {

            $symbol = $result->passed()
                ? '✓'
                : '✗';


            $this->line(
                sprintf(
                    '%s %s',
                    $symbol,
                    $result->name(),
                ),
            );


            $this->line(
                '  ' . $result->message(),
            );
        }


        return $report->healthy()
            ? self::SUCCESS
            : self::FAILURE;
    }
}
