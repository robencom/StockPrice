<?php

namespace App\Http\Controllers\Api;

use App\Actions\StockPrices\GenerateStockReportAction;;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class StocksReportController extends Controller
{
    public function __invoke(GenerateStockReportAction $generateStockReportAction): JsonResponse
    {
        return response()->json([
            'data' => $generateStockReportAction()
        ]);
    }
}
