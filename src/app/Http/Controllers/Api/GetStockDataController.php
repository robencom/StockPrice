<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FetchStockPriceService;
use Illuminate\Http\JsonResponse;

class GetStockDataController extends Controller
{

    public function __construct(protected FetchStockPriceService $fetchStockPriceService)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'symbol' => 'required|exists:stocks,name',
        ]);

        $stockSymbol = $validated['symbol'];

        $stockData = $this->fetchStockPriceService->fetchStockData($stockSymbol);

        return response()->json([
            'data' => $stockData
        ]);
    }
}
