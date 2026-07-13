<?php

declare(strict_types=1);

namespace App\Application\Payment\Results;

final readonly class WorkflowResult
{
    public function __construct(
        public bool $success,
        public mixed $payload = null,
        public ?string $message = null,
        public array $errors = [],
    ) {}
}
