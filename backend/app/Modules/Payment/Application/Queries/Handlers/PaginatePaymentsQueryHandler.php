<?php

declare(strict_types=1);

namespace App\Modules\Payment\Application\Queries\Handlers;

use App\Modules\Payment\Application\Queries\PaginatePaymentsQuery;
use App\Modules\Payment\Domain\Contracts\PaymentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final readonly class PaginatePaymentsQueryHandler
{
    public function __construct(
        private PaymentRepositoryInterface $repository,
    ) {}

    public function handle(
        PaginatePaymentsQuery $query,
    ): LengthAwarePaginator {
        return $this->repository->paginate(
            $query->perPage,
        );
    }
}
