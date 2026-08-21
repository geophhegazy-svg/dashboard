<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Core\CommandBus\CommandDispatcher;
use App\Core\QueryBus\QueryDispatcher;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Resources\InventoryResource;
use App\Modules\Inventory\Application\Commands\CreateInventoryCommand;
use App\Modules\Inventory\Application\Commands\DeleteInventoryCommand;
use App\Modules\Inventory\Application\Commands\UpdateInventoryCommand;
use App\Modules\Inventory\Application\Queries\PaginateInventoriesQuery;
use App\Modules\Inventory\Infrastructure\Persistence\Models\Inventory;

final class InventoryController extends Controller
{
    public function __construct(
        private readonly CommandDispatcher $commandDispatcher,
        private readonly QueryDispatcher $queryDispatcher,
    ) {}

    public function index()
    {
        $this->authorize('viewAny', Inventory::class);

        return InventoryResource::collection(
            $this->queryDispatcher->dispatch(
                new PaginateInventoriesQuery()
            )
        );
    }

    public function store(StoreInventoryRequest $request)
    {
        $this->authorize('create', Inventory::class);

        $inventory = $this->commandDispatcher->dispatch(
            new CreateInventoryCommand(
                $request->validated()
            )
        );

        return new InventoryResource($inventory);
    }

    public function show(Inventory $inventory): InventoryResource
    {
        $this->authorize('view', $inventory);

        return new InventoryResource($inventory);
    }

    public function update(
        StoreInventoryRequest $request,
        Inventory $inventory
    ) {
        $this->authorize('update', $inventory);

        $inventory = $this->commandDispatcher->dispatch(
            new UpdateInventoryCommand(
                $inventory,
                $request->validated(),
            )
        );

        return new InventoryResource($inventory);
    }

    public function destroy(Inventory $inventory)
    {
        $this->authorize('delete', $inventory);

        $this->commandDispatcher->dispatch(
            new DeleteInventoryCommand(
                $inventory,
            )
        );

        return response()->json([
            'message' => 'Inventory item deleted successfully',
        ]);
    }
}
