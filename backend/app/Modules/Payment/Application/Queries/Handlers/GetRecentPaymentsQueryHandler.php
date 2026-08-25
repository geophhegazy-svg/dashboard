<?php

declare(strict_types=1);

namespace App\Modules\Payment\Application\Queries\Handlers;

use App\Modules\Payment\Application\Queries\GetRecentPaymentsQuery;
use App\Modules\Payment\Domain\Contracts\PaymentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

final readonly class GetRecentPaymentsQueryHandler
{
    public function __construct(
        private PaymentRepositoryInterface $repository,
    ) {}

    public function handle(
        GetRecentPaymentsQuery $query,
    ): Collection {
        return $this->repository->latest();
    }
}
