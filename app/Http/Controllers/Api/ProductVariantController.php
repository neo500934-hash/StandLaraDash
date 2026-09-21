<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductVariantRequest;
use App\Http\Requests\UpdateProductVariantRequest;
use App\Http\Resources\ProductVariantResource;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProductVariantController extends Controller
{
    public function index(Product $product): AnonymousResourceCollection
    {
        return ProductVariantResource::collection($product->variants()->with('inventory')->get());
    }

    public function store(StoreProductVariantRequest $request, Product $product): ProductVariantResource
    {
        $variant = $product->variants()->create($request->validated());

        $variant->inventory()->create([
            'variant_id' => $variant->id,
        ]);

        return new ProductVariantResource($variant->load('inventory'));
    }

    public function show(Product $product, ProductVariant $variant): ProductVariantResource
    {
        return new ProductVariantResource($variant->load('inventory'));
    }

    public function update(UpdateProductVariantRequest $request, Product $product, ProductVariant $variant): ProductVariantResource
    {
        $variant->update($request->validated());

        return new ProductVariantResource($variant->load('inventory'));
    }

    public function destroy(Product $product, ProductVariant $variant): Response
    {
        $variant->delete();

        return response()->noContent();
    }
}
