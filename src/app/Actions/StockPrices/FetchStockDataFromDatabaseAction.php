<?php

namespace App\Actions\StockPrices;

use App\Models\StockPrice;

class FetchStockDataFromDatabaseAction
{
    public function __invoke(string $symbol)
    {
        $stockPrice = StockPrice::whereHas('stock', function ($query) use ($symbol) {
            $query->where('symbol', $symbol);
        })->first(['price', 'previous_price']);

        return $stockPrice ? $stockPrice->toArray() : null;
    }
}
