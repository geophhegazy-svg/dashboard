<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Actions;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Customer\Domain\Contracts\CustomerRepositoryInterface;

final readonly class DeleteCustomerAction
{
    public function __construct(
        private CustomerRepositoryInterface $repository,
    ) {}

    public function execute(
        Customer $customer,
    ): bool {

        return $this->repository->delete(
            $customer,
        );
    }
}
