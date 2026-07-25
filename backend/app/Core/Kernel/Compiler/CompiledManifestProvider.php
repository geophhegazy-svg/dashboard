<?php

declare(strict_types=1);

namespace App\Core\Kernel\Compiler;

use App\Core\Kernel\Contracts\ManifestFingerprintGeneratorInterface;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use App\Core\Kernel\ModuleRegistry;

final readonly class CompiledManifestProvider
{
    public function __construct(
        private ModuleManifestCompiler $compiler,
        private ModuleManifestCacheInterface $cache,
        private ManifestFingerprintGeneratorInterface $fingerprint,
    ) {}

    public function provide(
        ModuleRegistry $registry,
    ): CompiledModuleManifest {

        $compiled = $this->compile(
            $registry,
        );

        $fingerprint = $this->fingerprint->generate(
            $compiled,
        );

        if ($this->cache->has()) {

            $cached = $this->cache->load();

            if (
                $cached !== null
                && $this->fingerprint->generate($cached) === $fingerprint
            ) {
                return $cached;
            }
        }

        $this->cache->save(
            $compiled,
        );

        return $compiled;
    }

    private function compile(
        ModuleRegistry $registry,
    ): CompiledModuleManifest {

        return $this->compiler->compile(
            $registry->all(),
        );
    }
}
