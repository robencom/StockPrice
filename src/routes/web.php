<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\StockReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/stocks/report', StockReportController::class);
