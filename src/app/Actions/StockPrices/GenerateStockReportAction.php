<?php

namespace App\Actions\StockPrices;

use \Illuminate\Support\Collection;
use App\Models\StockPrice;
use App\Services\PercentageChangeCalculationService;

class GenerateStockReportAction
{
    public function __construct(protected PercentageChangeCalculationService $calculationService)
    {
    }

    public function __invoke(): Collection
    {
        return StockPrice::with('stock')->get()->map(function ($stockPrice) {
            $percentageChange = $this->calculationService->calculatePercentageChange(
                $stockPrice->price,
                $stockPrice->previous_price
            );

            return [
                'symbol' => $stockPrice->stock->symbol,
                'price' => $stockPrice->price,
                'previous_price' => $stockPrice->previous_price,
                'percentage_change' => $percentageChange,
            ];
        });
    }
}
