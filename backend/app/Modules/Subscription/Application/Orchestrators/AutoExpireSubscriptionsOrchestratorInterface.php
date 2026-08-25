<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Orchestrators;

interface AutoExpireSubscriptionsOrchestratorInterface
{
    public function execute(): int;
}
