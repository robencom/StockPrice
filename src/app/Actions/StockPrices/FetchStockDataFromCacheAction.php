<?php

namespace App\Actions\StockPrices;

use Illuminate\Support\Facades\Cache;

class FetchStockDataFromCacheAction
{
    public function __construct(protected FetchStockDataFromDatabaseAction $fetchStockDataFromDatabaseAction)
    {
    }

    public function __invoke(string $symbol)
    {
        return Cache::remember("stock_data_{$symbol}", 60, function () use ($symbol) {
            return ($this->fetchStockDataFromDatabaseAction)($symbol);
        });
    }
}
