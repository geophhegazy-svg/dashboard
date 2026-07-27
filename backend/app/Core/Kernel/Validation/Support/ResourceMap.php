<?php

declare(strict_types=1);

namespace App\Core\Kernel\Validation\Support;

final class ResourceMap
{
    /**
     * @var array<string,list<string>>
     */
    private array $resources = [];

    public function add(
        string $key,
        string $owner,
    ): void {

        $this->resources[$key] ??= [];

        $this->resources[$key][] = $owner;
    }

    /**
     * @return array<string,list<string>>
     */
    public function all(): array
    {
        return $this->resources;
    }
}
