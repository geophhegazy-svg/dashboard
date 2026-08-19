<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Core\QueryBus\QueryDispatcher;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerWalletResource;
use App\Http\Resources\WalletTransactionResource;
use App\Modules\Wallet\Application\Queries\FindCustomerWalletQuery;
use App\Modules\Wallet\Application\Queries\PaginateWalletTransactionsQuery;
use Illuminate\Http\Request;

final class CustomerWalletController extends Controller
{
    public function __construct(
        private readonly QueryDispatcher $queryDispatcher,
    ) {}

    public function show(Request $request)
    {
        $customer = $request->user();

        $wallet = $this->queryDispatcher->dispatch(
            new FindCustomerWalletQuery(
                tenantId: (int) $customer->tenant_id,
                customerId: (int) $customer->id,
            )
        );

        if ($wallet === null) {
            return response()->json([
                'message' => 'Wallet not found.',
            ], 404);
        }

        return new CustomerWalletResource($wallet);
    }

    public function transactions(Request $request)
    {
        $customer = $request->user();

        $transactions = $this->queryDispatcher->dispatch(
            new PaginateWalletTransactionsQuery(
                tenantId: (int) $customer->tenant_id,
                customerId: (int) $customer->id,
                perPage: (int) $request->integer('per_page', 15),
            )
        );

        return WalletTransactionResource::collection($transactions);
    }
}
