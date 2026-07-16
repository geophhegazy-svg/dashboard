<?php

declare(strict_types=1);

namespace App\Core\Results\Concerns;

trait HasMetadata
{
    protected array $meta = [];

    public function meta(): array
    {
        return $this->meta;
    }

    public function withMeta(array $meta): static
    {
        $this->meta = array_merge($this->meta, $meta);

        return $this;
    }
}
