<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Modules\Customer\Infrastructure\Persistence\Models\Customer;
use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Customer\Application\Queries\PaginateCustomersQuery;
use App\Core\CommandBus\CommandDispatcher;
use App\Modules\Customer\Application\Commands\CreateCustomerCommand;
use App\Modules\Customer\Application\Commands\UpdateCustomerCommand;
use App\Modules\Customer\Application\Commands\DeleteCustomerCommand;


class CustomerController extends Controller
{
    public function __construct(
        private readonly CommandDispatcher $commandDispatcher,
        private readonly QueryDispatcher $queryDispatcher,
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Customer::class);

        return CustomerResource::collection(
            $this->queryDispatcher->dispatch(
                new PaginateCustomersQuery()
            )
        );
    }

    public function store(StoreCustomerRequest $request)
    {
        $this->authorize('create', Customer::class);

        $customer = $this->commandDispatcher->dispatch(
            new CreateCustomerCommand(
                $request->validated()
            )
        );

        return new CustomerResource($customer);
    }

    public function show(Customer $customer): CustomerResource
    {
        $this->authorize('view', $customer);

        return new CustomerResource($customer);
    }

    public function update(
        StoreCustomerRequest $request,
        Customer $customer
    ) {
        $this->authorize('update', $customer);

        $customer = $this->commandDispatcher->dispatch(
            new UpdateCustomerCommand(
                $customer,
                $request->validated(),
            )
        );

        return new CustomerResource($customer);
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $this->commandDispatcher->dispatch(
            new DeleteCustomerCommand(
                $customer,
            )
        );

        return response()->json([
            'message' => 'Customer deleted successfully'
        ]);
    }
}
