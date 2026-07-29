<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Workflows\Contracts;

use App\Modules\Subscription\Application\Results\RenewalResult;

interface RenewalWorkflowInterface
{
    public function run(
        int $days = 30,
    ): RenewalResult;
}
