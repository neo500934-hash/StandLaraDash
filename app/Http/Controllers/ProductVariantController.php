<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\InventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductVariantController extends Controller
{
    public function __construct(private readonly InventoryService $inventoryService) {}

    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'sku' => ['required', 'string', 'max:255', Rule::unique('product_variants', 'sku')],
            'size' => ['nullable', 'string', 'max:255'],
            'variant_label' => ['nullable', 'string', 'max:255'],
            'regular_price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'quantity_on_hand' => ['required', 'integer', 'min:0'],
            'reorder_threshold' => ['required', 'integer', 'min:0'],
        ]);

        $variant = $product->variants()->create([
            'sku' => $validated['sku'],
            'size' => $validated['size'] ?? null,
            'variant_label' => $validated['variant_label'] ?? null,
            'regular_price' => $validated['regular_price'],
            'is_active' => $request->boolean('is_active'),
        ]);

        $variant->inventory()->create([
            'variant_id' => $variant->id,
            'reorder_threshold' => $validated['reorder_threshold'],
        ]);

        if ($validated['quantity_on_hand'] > 0) {
            $this->inventoryService->restock($variant->id, $validated['quantity_on_hand'], 'initial-stock');
        }

        return back()->with('status', __('Variant added.'));
    }

    public function update(Request $request, Product $product, ProductVariant $variant): RedirectResponse
    {
        abort_if($variant->product_id !== $product->id, 404);

        $validated = $request->validate([
            'sku' => ['required', 'string', 'max:255', Rule::unique('product_variants', 'sku')->ignore($variant)],
            'size' => ['nullable', 'string', 'max:255'],
            'variant_label' => ['nullable', 'string', 'max:255'],
            'regular_price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'quantity_on_hand' => ['required', 'integer', 'min:0'],
            'reorder_threshold' => ['required', 'integer', 'min:0'],
        ]);

        $variant->update([
            'sku' => $validated['sku'],
            'size' => $validated['size'] ?? null,
            'variant_label' => $validated['variant_label'] ?? null,
            'regular_price' => $validated['regular_price'],
            'is_active' => $request->boolean('is_active'),
        ]);

        $inventory = $variant->inventory;
        $delta = $validated['quantity_on_hand'] - $inventory->quantity_on_hand;

        if ($delta !== 0) {
            $this->inventoryService->adjust($variant->id, $delta, 'manual-edit');
        }

        $inventory->update(['reorder_threshold' => $validated['reorder_threshold']]);

        return back()->with('status', __('Variant updated.'));
    }

    public function destroy(Product $product, ProductVariant $variant): RedirectResponse
    {
        abort_if($variant->product_id !== $product->id, 404);

        $variant->delete();

        return back()->with('status', __('Variant deleted.'));
    }
}
