<?php

declare(strict_types=1);

namespace App\Modules\Customer\Domain\Contracts;

interface CustomerActivationServiceInterface
{
    public function activate(int $customerId): void;

    public function deactivate(int $customerId): void;
}
