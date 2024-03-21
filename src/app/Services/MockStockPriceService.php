<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MockStockPriceService
{
    public function generateMockData($stockSymbol): array
    {
        $price = rand(10000, 20000) / 100;
        $previousPrice = rand(10000, 20000) / 100;
        $randomPrice = rand(10000, 20000) / 100;

        return [
            "Global Quote" => [
                "01. symbol" => $stockSymbol,
                "02. open" => number_format($randomPrice, 4),
                "03. high" => number_format($randomPrice, 4),
                "04. low" => number_format($randomPrice, 4),
                "05. price" => number_format($price, 4),
                "06. volume" => "3238643",
                "07. latest trading day" => date("Y-m-d"),
                "08. previous close" => number_format($previousPrice, 4),
                "09. change" => "0.6200",
                "10. change percent" => "0.3207%"
            ]
        ];
    }
}
