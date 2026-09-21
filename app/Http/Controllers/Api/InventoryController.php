<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InsufficientStockException;
use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryResource;
use App\Models\Inventory;
use App\Models\ProductVariant;
use App\Services\InventoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class InventoryController extends Controller
{
    public function __construct(private readonly InventoryService $inventoryService) {}

    public function show(ProductVariant $variant): InventoryResource
    {
        return new InventoryResource($variant->inventory);
    }

    public function adjust(Request $request, ProductVariant $variant): InventoryResource|JsonResponse
    {
        $validated = $request->validate([
            'delta' => ['required', 'integer'],
            'reference_id' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $this->inventoryService->adjust($variant->id, $validated['delta'], $validated['reference_id'] ?? null);
        } catch (InsufficientStockException $exception) {
            return response()->json(['message' => $exception->getMessage()], 409);
        }

        return new InventoryResource($variant->inventory()->first());
    }

    public function restock(Request $request, ProductVariant $variant): InventoryResource
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'reference_id' => ['nullable', 'string', 'max:255'],
        ]);

        $this->inventoryService->restock($variant->id, $validated['quantity'], $validated['reference_id'] ?? null);

        return new InventoryResource($variant->inventory()->first());
    }

    public function lowStock(): AnonymousResourceCollection
    {
        $lowStock = Inventory::with('variant')
            ->whereColumn('quantity_on_hand', '<=', 'reorder_threshold')
            ->get();

        return InventoryResource::collection($lowStock);
    }
}
