<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePromotionalPriceRequest;
use App\Http\Requests\UpdatePromotionalPriceRequest;
use App\Http\Resources\PromotionalPriceResource;
use App\Models\ProductVariant;
use App\Models\PromotionalPrice;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class PromotionalPriceController extends Controller
{
    public function index(ProductVariant $variant): AnonymousResourceCollection
    {
        return PromotionalPriceResource::collection($variant->promotionalPrices);
    }

    public function store(StorePromotionalPriceRequest $request, ProductVariant $variant): PromotionalPriceResource
    {
        $promotionalPrice = $variant->promotionalPrices()->create($request->validated());

        return new PromotionalPriceResource($promotionalPrice);
    }

    public function show(ProductVariant $variant, PromotionalPrice $promotionalPrice): PromotionalPriceResource
    {
        return new PromotionalPriceResource($promotionalPrice);
    }

    public function update(UpdatePromotionalPriceRequest $request, ProductVariant $variant, PromotionalPrice $promotionalPrice): PromotionalPriceResource
    {
        $promotionalPrice->update($request->validated());

        return new PromotionalPriceResource($promotionalPrice);
    }

    public function destroy(ProductVariant $variant, PromotionalPrice $promotionalPrice): Response
    {
        $promotionalPrice->delete();

        return response()->noContent();
    }
}
