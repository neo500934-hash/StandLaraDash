<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\ProductVariantController;
use App\Http\Controllers\Api\PromotionalPriceController;
use App\Http\Controllers\Api\SalesEventController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('v1')->name('api.')->group(function () {
    Route::apiResource('categories', CategoryController::class);

    Route::apiResource('products', ProductController::class);

    Route::prefix('products/{product}')->group(function () {
        Route::apiResource('images', ProductImageController::class)->only(['index', 'store', 'destroy']);
        Route::patch('images/reorder', [ProductImageController::class, 'reorder'])->name('products.images.reorder');
        Route::patch('images/{image}/set-primary', [ProductImageController::class, 'setPrimary'])->name('products.images.set-primary');

        Route::apiResource('variants', ProductVariantController::class);
    });

    Route::prefix('variants/{variant}')->group(function () {
        Route::apiResource('promotional-prices', PromotionalPriceController::class)
            ->parameters(['promotional-prices' => 'promotionalPrice']);

        Route::get('inventory', [InventoryController::class, 'show'])->name('variants.inventory.show');
        Route::post('inventory/adjust', [InventoryController::class, 'adjust'])->name('variants.inventory.adjust');
        Route::post('inventory/restock', [InventoryController::class, 'restock'])->name('variants.inventory.restock');
    });

    Route::get('inventory/low-stock', [InventoryController::class, 'lowStock'])->name('inventory.low-stock');

    Route::apiResource('sales-events', SalesEventController::class)
        ->parameters(['sales-events' => 'salesEvent']);
    Route::post('sales-events/{salesEvent}/attach-variants', [SalesEventController::class, 'attachVariants'])->name('sales-events.attach-variants');
    Route::post('sales-events/{salesEvent}/detach-variants', [SalesEventController::class, 'detachVariants'])->name('sales-events.detach-variants');
});
