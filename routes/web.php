<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\PromotionalPriceController;
use App\Http\Controllers\WebsiteSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/language/{locale}', [LocaleController::class, 'switch'])->name('language.switch');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/blank', function () {
        return view('blank');
    })->name('blank');
    Route::get('/websettings', [WebsiteSettingController::class, 'edit'])->name('websettings');
    Route::put('/websettings', [WebsiteSettingController::class, 'update'])->name('websettings.update');

    Route::get('brands/data', [BrandController::class, 'data'])->name('brands.data');
    Route::resource('brands', BrandController::class);

    Route::get('categories/data', [CategoryController::class, 'data'])->name('categories.data');
    Route::delete('categories/bulk-destroy', [CategoryController::class, 'bulkDestroy'])->name('categories.bulk-destroy');
    Route::resource('categories', CategoryController::class);

    Route::get('products/data', [ProductController::class, 'data'])->name('products.data');
    Route::delete('products/bulk-destroy', [ProductController::class, 'bulkDestroy'])->name('products.bulk-destroy');
    Route::resource('products', ProductController::class);

    Route::prefix('products/{product}')->name('products.')->group(function () {
        Route::post('images', [ProductImageController::class, 'store'])->name('images.store');
        Route::post('images/{image}/primary', [ProductImageController::class, 'setPrimary'])->name('images.primary');
        Route::post('images/{image}/move', [ProductImageController::class, 'move'])->name('images.move');
        Route::delete('images/{image}', [ProductImageController::class, 'destroy'])->name('images.destroy');

        Route::post('variants', [ProductVariantController::class, 'store'])->name('variants.store');
        Route::put('variants/{variant}', [ProductVariantController::class, 'update'])->name('variants.update');
        Route::delete('variants/{variant}', [ProductVariantController::class, 'destroy'])->name('variants.destroy');

        Route::post('variants/{variant}/promotional-prices', [PromotionalPriceController::class, 'store'])->name('variants.promotional-prices.store');
        Route::delete('variants/{variant}/promotional-prices/{promotionalPrice}', [PromotionalPriceController::class, 'destroy'])->name('variants.promotional-prices.destroy');
    });
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
