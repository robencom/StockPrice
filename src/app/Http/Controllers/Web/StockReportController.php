<?php

namespace App\Http\Controllers\Web;

use App\Actions\StockPrices\GenerateStockReportAction;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;

class StockReportController extends Controller
{
    public function __invoke(GenerateStockReportAction $generateStockReportAction)
    {
        $stocks = $generateStockReportAction();

        return View::make('stocks.report', [
            'stocks' => $stocks
        ]);
    }
}

