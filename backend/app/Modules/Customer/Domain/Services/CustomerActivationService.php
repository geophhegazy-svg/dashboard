<?php

declare(strict_types=1);

namespace App\Modules\Customer\Domain\Services;

use App\Modules\Customer\Domain\Contracts\CustomerActivationServiceInterface;

final class CustomerActivationService implements CustomerActivationServiceInterface
{
    public function activate(int $customerId): void {}

    public function deactivate(int $customerId): void {}
}
