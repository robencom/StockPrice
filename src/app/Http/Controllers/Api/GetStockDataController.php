<?php

namespace App\Http\Controllers\Api;

use App\Actions\StockPrices\FetchStockDataFromCacheAction;
use App\DTO\StockSymbolDTO;
use App\Http\Controllers\Controller;
use App\Services\FetchStockPriceService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StockDataRequest;

class GetStockDataController extends Controller
{

    public function __construct(protected FetchStockPriceService $fetchStockPriceService)
    {
    }

    public function __invoke(
        StockDataRequest $stockDataRequest,
        FetchStockDataFromCacheAction $fetchStockDataFromCacheAction
    ): JsonResponse {
        $stockSymbolDto = StockSymbolDTO::init($stockDataRequest->validated());

        $stockData = $fetchStockDataFromCacheAction($stockSymbolDto->getSymbol());

        return response()->json([
            'data' => $stockData
        ]);
    }
}
