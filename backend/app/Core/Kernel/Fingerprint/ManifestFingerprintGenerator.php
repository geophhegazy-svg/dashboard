<?php

declare(strict_types=1);

namespace App\Core\Kernel\Fingerprint;

use App\Core\Kernel\Compiler\CompiledModuleManifest;
use App\Core\Kernel\Contracts\ManifestFingerprintGeneratorInterface;
use JsonException;

final class ManifestFingerprintGenerator
implements ManifestFingerprintGeneratorInterface
{
    /**
     * @throws JsonException
     */
    public function generate(
        CompiledModuleManifest $manifest,
    ): string {

        $payload = $manifest->toPayload();

        unset($payload['fingerprint']);

        return hash(
            'sha256',
            json_encode(
                $payload,
                JSON_THROW_ON_ERROR,
            ),
        );
    }
}
