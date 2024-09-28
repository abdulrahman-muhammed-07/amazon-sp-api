<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CodeMiddleware;
use App\Http\Middleware\SessionTokenMiddleware;
use App\Http\Controllers\Api\Auth\CodeController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Settings\SettingsController;


Route::group(['prefix' => 'auth'], function () {
    Route::post('code', [CodeController::class, 'action'])->middleware(CodeMiddleware::class);
    Route::post('login', [LoginController::class, 'action'])->middleware(SessionTokenMiddleware::class);
});

Route::middleware(['store.id'])->group(function () {
    Route::group(['prefix' => 'settings'], function () {
        Route::get('show', [SettingsController::class, 'show']);
        Route::get('update', [SettingsController::class, 'update']);
        Route::post('store', [SettingsController::class, 'store']);
    });
});
