<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Console\Kernel;

use App\Core\Kernel\Contracts\ManifestFingerprintGeneratorInterface;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use Illuminate\Console\Command;

final class KernelCacheStatusCommand extends Command
{
    protected $signature = 'kernel:cache-status';

    protected $description =
    'Display compiled kernel manifest cache status.';


    public function __construct(
        private readonly ModuleManifestCacheInterface $cache,
        private readonly ManifestFingerprintGeneratorInterface $fingerprint,
    ) {
        parent::__construct();
    }


    public function handle(): int
    {
        if (! $this->cache->has()) {

            $this->table(
                [
                    'Metric',
                    'Value',
                ],
                [
                    [
                        'Cache',
                        'Missing',
                    ],
                ],
            );

            return self::SUCCESS;
        }


        $manifest = $this->cache->load();


        if ($manifest === null) {

            $this->error(
                'Cache exists but manifest could not be loaded.'
            );

            return self::FAILURE;
        }


        $this->table(
            [
                'Metric',
                'Value',
            ],
            [
                [
                    'Cache',
                    'Available',
                ],
                [
                    'Modules',
                    $manifest->count(),
                ],
                [
                    'Fingerprint',
                    $this->fingerprint->generate($manifest),
                ],
            ],
        );


        return self::SUCCESS;
    }
}
