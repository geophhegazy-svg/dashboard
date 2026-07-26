<?php

declare(strict_types=1);

namespace App\Core\Kernel\Diagnostics;

use App\Core\Kernel\Contracts\ManifestFingerprintGeneratorInterface;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use App\Core\Kernel\Inspector\KernelInspector;
use App\Core\Kernel\Runtime\KernelRuntimeState;
use App\Core\Kernel\Lifecycle\KernelLifecycleManager;

final readonly class KernelDiagnostics
{
    public function __construct(
        private KernelInspector $inspector,
        private ModuleManifestCacheInterface $cache,
        private ManifestFingerprintGeneratorInterface $fingerprint,
        private KernelRuntimeState $runtime,
        private KernelLifecycleManager $lifecycle,
    ) {}


    public function generate(): KernelDiagnosticReport
    {
        $statistics = $this->inspector->statistics();

        $manifest = $this->cache->load();

        $context = $this->runtime->context();

        $lifecycle = $this->lifecycle
            ->state()
            ->value;

        return new KernelDiagnosticReport(
            modules: $statistics->modules(),
            resources: $statistics->resources(),
            dependencies: $statistics->dependencies(),
            cacheAvailable: $this->cache->has(),
            manifestAvailable: $manifest !== null,
            fingerprint: $manifest
                ? $this->fingerprint->generate($manifest)
                : null,
            booted: true,
            bootedAt: $context->bootedAt(),
            lifecycle: $lifecycle,
        );
    }
}
