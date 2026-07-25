<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Kernel;

use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\Contracts\ModuleManifestCacheInterface;
use Illuminate\Filesystem\Filesystem;

final readonly class FileModuleManifestCache
implements ModuleManifestCacheInterface
{
    private const CACHE_FILE = 'cache/kernel-manifest.json';

    public function __construct(
        private Filesystem $filesystem,
    ) {}

    public function has(): bool
    {
        return $this->filesystem->exists(
            base_path(self::CACHE_FILE),
        );
    }

    public function load(): ?CompiledModuleManifest
    {
        if (! $this->has()) {
            return null;
        }

        $payload = json_decode(
            $this->filesystem->get(
                base_path(self::CACHE_FILE),
            ),
            true,
            flags: JSON_THROW_ON_ERROR,
        );

        return CompiledModuleManifest::fromPayload(
            $payload,
        );
    }

    public function save(
        CompiledModuleManifest $manifest,
    ): void {

        $this->filesystem->ensureDirectoryExists(
            dirname(
                base_path(self::CACHE_FILE),
            ),
        );

        $this->filesystem->put(
            base_path(self::CACHE_FILE),
            json_encode(
                $manifest->toPayload(),
                JSON_PRETTY_PRINT
                    | JSON_UNESCAPED_SLASHES
                    | JSON_THROW_ON_ERROR,
            ),
        );
    }

    public function clear(): void
    {
        $this->filesystem->delete(
            base_path(self::CACHE_FILE),
        );
    }
}
