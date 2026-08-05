<?php

declare(strict_types=1);

namespace App\Modules\Customer\Application\Actions;

use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Modules\Customer\Domain\Contracts\CustomerRepositoryInterface;
use App\Modules\Customer\Domain\Events\CustomerCreated;
use App\Core\EventBus\Contracts\EventDispatcherInterface;

final readonly class CreateCustomerAction
{
    public function __construct(
        private CustomerRepositoryInterface $repository,
        private EventDispatcherInterface $events,
    ) {}

    public function execute(
        array $data,
    ): Customer
    {
        $customer = $this->repository->create(
            $data,
        );
        
        $this->repository->save($customer);

        $this->events->dispatch(
            new CustomerCreated(
                $customer->id,
            )
        );

        return $customer;
    }
}
