<?php

namespace App\Actions\StockPrices;

use App\Actions\Stocks\GetStockBySymbolAction;
use App\Models\StockPrice;

class StoreStockPriceAction
{
    public function __construct(protected GetStockBySymbolAction $getStockBySymbolAction)
    {
    }

    public function __invoke(string $symbol, float $price, float $previousClose): void
    {
        $stock = ($this->getStockBySymbolAction)($symbol);

        if ($stock) {
            StockPrice::updateOrCreate(
                ['stock_id' => $stock->id],
                [
                    'price' => $price,
                    'previous_price' => $previousClose
                ]
            );
        }
    }
}
