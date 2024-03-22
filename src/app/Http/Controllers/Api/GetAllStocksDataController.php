<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FetchAllStocksPriceService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     path="/api/stocks/all",
 *     tags={"Stocks"},
 *     summary="Get all stocks data",
 *     description="Returns data for all stocks.",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(
 *                         property="symbol",
 *                         type="string",
 *                         description="Stock symbol",
 *                         example="TSLA"
 *                     ),
 *                     @OA\Property(
 *                         property="price",
 *                         type="string",
 *                         description="Current price of the stock",
 *                         example="122.2145"
 *                     ),
 *                     @OA\Property(
 *                         property="previous_price",
 *                         type="string",
 *                         description="Previous closing price of the stock",
 *                         example="133.2000"
 *                     ),
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error"
 *     )
 * )
 */
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
