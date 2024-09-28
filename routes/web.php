<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnInstallController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/uninstall', [UnInstallController::class, 'uninstall']);
