<?php

declare(strict_types=1);

namespace App\Modules\Subscription\Application\Orchestrators;

interface AutoGraceSubscriptionsOrchestratorInterface
{
    public function execute(): int;
}
