<?php

declare(strict_types=1);

namespace App\Core\Kernel\Health\Checks;

use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use App\Core\Kernel\Health\Contracts\KernelHealthCheckInterface;
use App\Core\Kernel\Health\KernelHealthResult;

final readonly class ManifestAvailabilityCheck
implements KernelHealthCheckInterface
{
    public function __construct(
        private ModuleManifestCacheInterface $cache,
    ) {}


    public function name(): string
    {
        return 'Manifest';
    }


    public function check(): KernelHealthResult
    {
        $manifest = $this->cache->load();


        if ($manifest === null) {

            return new KernelHealthResult(
                $this->name(),
                false,
                'Compiled manifest is missing.',
            );
        }


        return new KernelHealthResult(
            $this->name(),
            true,
            sprintf(
                'Manifest loaded (%d modules).',
                $manifest->count(),
            ),
        );
    }
}
