<?php

declare(strict_types=1);

namespace App\Data\Subscription;

final readonly class LinkPppoeData
{
    public function __construct(
        public string $username,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            username: $data['username'],
        );
    }
}
