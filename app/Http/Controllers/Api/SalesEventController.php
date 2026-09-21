<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSalesEventRequest;
use App\Http\Requests\UpdateSalesEventRequest;
use App\Http\Resources\SalesEventResource;
use App\Models\SalesEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class SalesEventController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return SalesEventResource::collection(SalesEvent::with('variants')->get());
    }

    public function store(StoreSalesEventRequest $request): SalesEventResource
    {
        $salesEvent = SalesEvent::create($request->validated());

        return new SalesEventResource($salesEvent);
    }

    public function show(SalesEvent $salesEvent): SalesEventResource
    {
        return new SalesEventResource($salesEvent->load('variants'));
    }

    public function update(UpdateSalesEventRequest $request, SalesEvent $salesEvent): SalesEventResource
    {
        $salesEvent->update($request->validated());

        return new SalesEventResource($salesEvent);
    }

    public function destroy(SalesEvent $salesEvent): Response
    {
        $salesEvent->delete();

        return response()->noContent();
    }

    public function attachVariants(Request $request, SalesEvent $salesEvent): SalesEventResource
    {
        $validated = $request->validate([
            'variants' => ['required', 'array'],
            'variants.*.id' => ['required', 'integer', 'exists:product_variants,id'],
            'variants.*.event_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $syncData = collect($validated['variants'])
            ->mapWithKeys(fn (array $variant) => [
                $variant['id'] => ['event_price' => $variant['event_price'] ?? null],
            ]);

        $salesEvent->variants()->syncWithoutDetaching($syncData);

        return new SalesEventResource($salesEvent->load('variants'));
    }

    public function detachVariants(Request $request, SalesEvent $salesEvent): SalesEventResource
    {
        $validated = $request->validate([
            'variant_ids' => ['required', 'array'],
            'variant_ids.*' => ['integer', 'exists:product_variants,id'],
        ]);

        $salesEvent->variants()->detach($validated['variant_ids']);

        return new SalesEventResource($salesEvent->load('variants'));
    }
}
