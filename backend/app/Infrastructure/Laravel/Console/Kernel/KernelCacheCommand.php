<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Console\Kernel;

use App\Core\Kernel\Compiler\CompiledManifestProvider;
use App\Core\Kernel\ModuleRegistry;
use Illuminate\Console\Command;

final class KernelCacheCommand extends Command
{
    protected $signature = 'kernel:cache';

    protected $description =
    'Build and cache the compiled kernel manifest.';


    public function __construct(
        private readonly CompiledManifestProvider $provider,
        private readonly ModuleRegistry $registry,
    ) {
        parent::__construct();
    }


    public function handle(): int
    {
        $manifest = $this->provider->provide(
            $this->registry,
        );


        $this->info(
            'Kernel manifest cached successfully.',
        );


        $this->newLine();


        $this->table(
            [
                'Metric',
                'Value',
            ],
            [
                [
                    'Modules',
                    $manifest->count(),
                ],
                [
                    'Status',
                    'Cached',
                ],
            ],
        );


        return self::SUCCESS;
    }
}
