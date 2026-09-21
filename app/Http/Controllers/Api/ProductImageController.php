<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductImageResource;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function index(Product $product): AnonymousResourceCollection
    {
        return ProductImageResource::collection($product->images);
    }

    public function store(Request $request, Product $product): ProductImageResource
    {
        $validated = $request->validate([
            'image' => ['required', 'image', 'max:10240'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_primary' => ['nullable', 'boolean'],
        ]);

        $path = $request->file('image')->store("products/{$product->id}", 'public');

        if ($request->boolean('is_primary')) {
            $product->images()->update(['is_primary' => false]);
        }

        $image = $product->images()->create([
            'url' => Storage::disk('public')->url($path),
            'alt_text' => $validated['alt_text'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_primary' => $request->boolean('is_primary'),
        ]);

        return new ProductImageResource($image);
    }

    public function destroy(Product $product, ProductImage $image): Response
    {
        $image->delete();

        return response()->noContent();
    }

    public function reorder(Request $request, Product $product): AnonymousResourceCollection
    {
        $validated = $request->validate([
            'image_ids' => ['required', 'array'],
            'image_ids.*' => ['integer', 'exists:product_images,id'],
        ]);

        foreach ($validated['image_ids'] as $index => $imageId) {
            $product->images()->whereKey($imageId)->update(['sort_order' => $index]);
        }

        return ProductImageResource::collection($product->images()->orderBy('sort_order')->get());
    }

    public function setPrimary(Product $product, ProductImage $image): ProductImageResource
    {
        $product->images()->update(['is_primary' => false]);

        $image->update(['is_primary' => true]);

        return new ProductImageResource($image);
    }
}
