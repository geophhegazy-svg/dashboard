<?php

namespace App\Http\Controllers\Api;

use App\Models\Inventory;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Resources\InventoryResource;

class InventoryController extends Controller
{
    public function index()
    {
        return InventoryResource::collection(Inventory::latest()->paginate());
    }
    public function store(StoreInventoryRequest $request)
    {
        $inventory = Inventory::create($request->validated());
        return response()->json(['data' => new InventoryResource($inventory)]);
    }
    public function show(Inventory $inventory)
    {
        return new InventoryResource($inventory);
    }
    public function update(StoreInventoryRequest $request, Inventory $inventory)
    {
        $inventory->update($request->validated());
        return new InventoryResource($inventory);
    }
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return response()->json(['message' => 'Inventory item deleted successfully']);
    }
}
