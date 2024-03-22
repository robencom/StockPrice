<?php

namespace App\Actions\Stocks;

use App\Models\Stock;

class GetStockBySymbolAction
{
    public function __invoke(string $symbol): Stock
    {
        return Stock::where('symbol', $symbol)->first();
    }
}
