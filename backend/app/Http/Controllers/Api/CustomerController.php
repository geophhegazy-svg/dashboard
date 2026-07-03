<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\Customer\CustomerService;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerService $customerService
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Customer::class);

        return CustomerResource::collection(
            $this->customerService->paginate()
        );
    }

    public function store(StoreCustomerRequest $request): CustomerResource
    {
        $this->authorize('create', Customer::class);

        return new CustomerResource(
            $this->customerService->create(
                $request->validated()
            )
        );
    }

    public function show(Customer $customer): CustomerResource
    {
        $this->authorize('view', $customer);

        return new CustomerResource($customer);
    }

    public function update(
        StoreCustomerRequest $request,
        Customer $customer
    ): CustomerResource {
        $this->authorize('update', $customer);

        return new CustomerResource(
            $this->customerService->update(
                $customer,
                $request->validated()
            )
        );
    }

    public function destroy(Customer $customer): JsonResponse
    {
        $this->authorize('delete', $customer);

        $this->customerService->delete($customer);

        return response()->json([
            'message' => 'Customer deleted successfully',
        ]);
    }
}
