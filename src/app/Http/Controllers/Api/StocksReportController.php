<?php

namespace App\Http\Controllers\Api;

use App\Actions\StockPrices\GenerateStockReportAction;;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Get(
 *     path="/api/stocks/report",
 *     tags={"Stocks"},
 *     summary="Get all stocks report",
 *     description="Returns a detailed report for all stocks including symbol, current price, previous price, and percentage change.",
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
 *                         example="AMZN"
 *                     ),
 *                     @OA\Property(
 *                         property="price",
 *                         type="string",
 *                         description="Current price of the stock",
 *                         example="157.9600"
 *                     ),
 *                     @OA\Property(
 *                         property="previous_price",
 *                         type="string",
 *                         description="Previous closing price of the stock",
 *                         example="133.0800"
 *                     ),
 *                     @OA\Property(
 *                         property="percentage_change",
 *                         type="float",
 *                         description="Percentage change in the stock price",
 *                         example=18.6955
 *                     )
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
class StocksReportController extends Controller
{
    public function __invoke(GenerateStockReportAction $generateStockReportAction): JsonResponse
    {
        return response()->json([
            'data' => $generateStockReportAction()
        ]);
    }
}
