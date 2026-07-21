<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows\Contracts;

use App\Core\DTO\RenewalResult;

interface RenewalWorkflowInterface
{
    public function run(
        int $days = 30,
    ): RenewalResult;
}
