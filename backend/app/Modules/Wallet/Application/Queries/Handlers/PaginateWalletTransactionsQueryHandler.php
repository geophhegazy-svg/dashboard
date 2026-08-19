<?php

declare(strict_types=1);

namespace App\Modules\Wallet\Application\Queries\Handlers;

use App\Core\QueryBus\Contracts\QueryHandlerInterface;
use App\Core\QueryBus\Contracts\QueryInterface;
use App\Modules\Wallet\Application\Queries\PaginateWalletTransactionsQuery;
use App\Modules\Wallet\Domain\Contracts\WalletRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LogicException;

final readonly class PaginateWalletTransactionsQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private WalletRepositoryInterface $repository,
    ) {}

    public function handle(
        QueryInterface $query,
    ): LengthAwarePaginator {
        if (! $query instanceof PaginateWalletTransactionsQuery) {
            throw new LogicException(
                'PaginateWalletTransactionsQueryHandler received an unsupported query.'
            );
        }

        return $this->repository->paginateTransactions(
            $query->tenantId,
            $query->customerId,
            $query->perPage,
        );
    }
}
