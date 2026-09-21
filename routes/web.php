<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\LocaleController;
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

    Route::resource('brands', BrandController::class);
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
