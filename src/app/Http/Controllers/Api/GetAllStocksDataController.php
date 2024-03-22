<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FetchAllStocksPriceService;
use Illuminate\Http\JsonResponse;

class GetAllStocksDataController extends Controller
{

    public function __construct(protected FetchAllStocksPriceService $fetchAllStocksPriceService)
    {
    }

    public function __invoke(): JsonResponse
    {
        $stockData = $this->fetchAllStocksPriceService->fetchAllStocksData();

        return response()->json([
            'data' => $stockData
        ]);
    }
}
