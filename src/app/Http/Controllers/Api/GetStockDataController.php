<?php

namespace App\Http\Controllers\Api;

use App\Actions\StockPrices\FetchStockDataFromCacheAction;
use App\DTO\StockSymbolDTO;
use App\Http\Controllers\Controller;
use App\Services\FetchStockPriceService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StockDataRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *    title="Documentation",
 *    version="1.0.0",
 * )
 * @OA\Get(
 *     path="/api/stocks/",
 *     tags={"Stocks"},
 *     summary="Get stock data",
 *     description="Returns stock data for the given symbol.",
 *     @OA\Parameter(
 *         name="symbol",
 *         in="query",
 *         required=true,
 *         description="Stock symbol to fetch data for",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="data",
 *                 type="object",
 *                 @OA\Property(
 *                     property="price",
 *                     type="string",
 *                     description="Current price of the stock",
 *                     example="102.5000"
 *                 ),
 *                 @OA\Property(
 *                     property="previous_price",
 *                     type="string",
 *                     description="Previous closing price of the stock",
 *                     example="112.5000"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *        response=422,
 *        description="Validation Error",
 *
 *        @OA\JsonContent(
 *
 *          @OA\Property(property="message", type="string", example="The selected symbol is invalid.")
 *        ),
 *     )
 * )
 */
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
