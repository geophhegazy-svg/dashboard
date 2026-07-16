<?php

declare(strict_types=1);

namespace App\Core\Actions;

use App\Core\Results\Result;

abstract class Action
{
    final public function run(
        mixed ...$arguments,
    ): Result {
        return $this->execute(...$arguments);
    }

    abstract protected function execute(
        mixed ...$arguments,
    ): Result;
}
