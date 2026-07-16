<?php

declare(strict_types=1);

namespace App\Core\Actions;

use App\Core\Results\Result;

final readonly class ActionResult
{
    public function __construct(
        public Result $result,
    ) {}

    public static function from(
        Result $result,
    ): self {
        return new self($result);
    }

    public function result(): Result
    {
        return $this->result;
    }

    public function succeeded(): bool
    {
        return $this->result->successful();
    }

    public function failed(): bool
    {
        return ! $this->succeeded();
    }
}
