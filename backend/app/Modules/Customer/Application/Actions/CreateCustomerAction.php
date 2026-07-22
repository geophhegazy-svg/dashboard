<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Actions;

use App\Models\Customer;
use App\Modules\Customer\Domain\Contracts\CustomerRepositoryInterface;
use App\Modules\Customer\Domain\Events\CustomerCreated;
use App\Core\EventBus\EventDispatcher;

final readonly class CreateCustomerAction
{
    public function __construct(
        private CustomerRepositoryInterface $repository,
        private EventDispatcher $events,
    ) {}

    public function execute(Customer $customer): Customer
    {
        $this->repository->save($customer);

        $this->events->dispatch(
            new CustomerCreated(
                $customer->id,
            )
        );

        return $customer;
    }
}
