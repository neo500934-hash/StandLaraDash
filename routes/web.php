<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\WebsiteSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/language/{locale}', [LocaleController::class, 'switch'])->name('language.switch');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/blank', function () {
        return view('blank');
    })->name('blank');
    Route::get('/websettings', [WebsiteSettingController::class, 'edit'])->name('websettings');
    Route::put('/websettings', [WebsiteSettingController::class, 'update'])->name('websettings.update');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
