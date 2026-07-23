<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Modules\Customer\Application\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use App\Core\QueryBus\QueryDispatcher;
use App\Modules\Customer\Application\Queries\PaginateCustomersQuery;


class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerService $customerService,
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

        $customer = $this->customerService->create(
            $request->validated()
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

        $customer = $this->customerService->update(
            $customer,
            $request->validated()
        );

        return new CustomerResource($customer);
    }

    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $this->customerService->delete($customer);

        return response()->json([
            'message' => 'Customer deleted successfully'
        ]);
    }
}
