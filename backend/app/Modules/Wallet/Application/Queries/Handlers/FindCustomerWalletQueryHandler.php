<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Application\Queries\Handlers;

use App\Core\QueryBus\Contracts\QueryHandlerInterface;
use App\Core\QueryBus\Contracts\QueryInterface;
use App\Modules\Wallet\Application\Queries\FindCustomerWalletQuery;
use App\Modules\Wallet\Domain\Contracts\WalletRepositoryInterface;
use App\Modules\Wallet\Infrastructure\Persistence\Models\Wallet;
use LogicException;

final readonly class FindCustomerWalletQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private WalletRepositoryInterface $repository,
    ) {}

    public function handle(
        QueryInterface $query,
    ): ?Wallet {
        if (! $query instanceof FindCustomerWalletQuery) {
            throw new LogicException(
                'FindCustomerWalletQueryHandler received an unsupported query.'
            );
        }

        return $this->repository->findByCustomerId(
            $query->tenantId,
            $query->customerId,
        );
    }
}
