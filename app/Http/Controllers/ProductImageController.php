<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductImageController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'max:10240'],
        ]);

        $nextSortOrder = (int) $product->images()->max('sort_order') + 1;
        $hasPrimary = $product->images()->where('is_primary', true)->exists();

        foreach ($validated['images'] as $index => $file) {
            $path = $file->store("products/{$product->id}", 'public');

            $product->images()->create([
                'url' => Storage::disk('public')->url($path),
                'sort_order' => $nextSortOrder + $index,
                'is_primary' => ! $hasPrimary && $index === 0,
            ]);
        }

        return back()->with('status', __('Images uploaded.'));
    }

    public function setPrimary(Product $product, ProductImage $image): RedirectResponse
    {
        abort_if($image->product_id !== $product->id, 404);

        $product->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return back()->with('status', __('Primary image updated.'));
    }

    public function move(Request $request, Product $product, ProductImage $image): RedirectResponse
    {
        abort_if($image->product_id !== $product->id, 404);

        $validated = $request->validate([
            'direction' => ['required', 'in:up,down'],
        ]);

        $neighbor = $product->images()
            ->where('sort_order', $validated['direction'] === 'up' ? '<' : '>', $image->sort_order)
            ->orderBy('sort_order', $validated['direction'] === 'up' ? 'desc' : 'asc')
            ->first();

        if ($neighbor) {
            [$imageOrder, $neighborOrder] = [$image->sort_order, $neighbor->sort_order];
            $image->update(['sort_order' => $neighborOrder]);
            $neighbor->update(['sort_order' => $imageOrder]);
        }

        return back()->with('status', __('Image order updated.'));
    }

    public function destroy(Product $product, ProductImage $image): RedirectResponse
    {
        abort_if($image->product_id !== $product->id, 404);

        $path = Str::after($image->url, '/storage/');
        Storage::disk('public')->delete($path);

        $wasPrimary = $image->is_primary;
        $image->delete();

        if ($wasPrimary) {
            $product->images()->orderBy('sort_order')->first()?->update(['is_primary' => true]);
        }

        return back()->with('status', __('Image deleted.'));
    }
}
