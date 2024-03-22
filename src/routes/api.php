<?php

use App\Http\Controllers\Api\StocksReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GetStockDataController;
use App\Http\Controllers\Api\GetAllStocksDataController;

//default user route
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//endpoint to fetch the latest stock price from the cache
Route::get('/stocks', GetStockDataController::class);

//endpoint to fetch all stock prices from the cache
Route::get('/stocks/all', GetAllStocksDataController::class);

//endpoint to return reports based on our data
Route::get('/stocks/report', StocksReportController::class);
