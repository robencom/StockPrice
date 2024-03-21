<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GetStockDataController;
use App\Http\Controllers\Api\GetAllStocksDataController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/stocks', GetStockDataController::class);

Route::get('/stocks/all', GetAllStocksDataController::class);

// Reporting route here
