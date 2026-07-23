<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Queries\Handlers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Modules\Customer\Application\Queries\PaginateCustomersQuery;
use App\Modules\Customer\Domain\Contracts\CustomerRepositoryInterface;

final readonly class PaginateCustomersQueryHandler
{
    public function __construct(
        private CustomerRepositoryInterface $repository,
    ) {}

    public function handle(
        PaginateCustomersQuery $query,
    ): LengthAwarePaginator {

        return $this->repository->paginate(
            $query->perPage,
        );
    }
}
