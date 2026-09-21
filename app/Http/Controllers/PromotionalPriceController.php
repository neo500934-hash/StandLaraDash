<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\PromotionalPrice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PromotionalPriceController extends Controller
{
    public function store(Request $request, Product $product, ProductVariant $variant): RedirectResponse
    {
        abort_if($variant->product_id !== $product->id, 404);

        $validated = $request->validate([
            'promo_price' => ['required', 'numeric', 'min:0'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
        ]);

        $variant->promotionalPrices()->create($validated);

        return back()->with('status', __('Promotional price added.'));
    }

    public function destroy(Product $product, ProductVariant $variant, PromotionalPrice $promotionalPrice): RedirectResponse
    {
        abort_if($variant->product_id !== $product->id, 404);
        abort_if($promotionalPrice->variant_id !== $variant->id, 404);

        $promotionalPrice->delete();

        return back()->with('status', __('Promotional price removed.'));
    }
}
