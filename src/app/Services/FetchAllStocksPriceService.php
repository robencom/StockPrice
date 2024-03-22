<?php

namespace App\Services;

use App\Actions\Stocks\GetStocksAction;


class FetchAllStocksPriceService
{
    public function __construct(
        protected FetchStockPriceService $fetchStockPriceService,
        protected GetStocksAction $getStocksAction,
    ) {
    }

    public function fetchAllStocksData(): array
    {
        $stocks = ($this->getStocksAction)();
        $stocksData = [];

        foreach ($stocks as $stock) {
            $data = $this->fetchStockPriceService->fetchStockData($stock->name);

            if (!empty($data)) {
                $stocksData[] = [
                    'symbol' => $stock->symbol,
                    'price' => $data["price"],
                    'previous_price' => $data["previous_close"],
                ];
            }
        }

        return $stocksData;
    }
}
