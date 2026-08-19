<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Application\Queries;

use App\Core\QueryBus\Contracts\QueryInterface;

final readonly class FindCustomerWalletQuery implements QueryInterface
{
    public function __construct(
        public int $tenantId,
        public int $customerId,
    ) {}
}
