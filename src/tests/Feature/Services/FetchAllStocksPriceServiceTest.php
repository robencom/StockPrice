<?php

namespace Tests\Feature\Services;

use Tests\TestCase;
use App\Models\Stock;
use App\Services\FetchAllStocksPriceService;
use App\Services\FetchStockPriceService;
use App\Actions\Stocks\GetStocksAction;
use Illuminate\Support\Facades\App;

class FetchAllStocksPriceServiceTest extends TestCase
{
    /** @test */
    public function it_fetches_all_stocks_data_successfully()
    {
        $stocks = collect([
            new Stock(['symbol' => 'AAPL', 'name' => 'Apple']),
            new Stock(['symbol' => 'MSFT', 'name' => 'Microsoft']),
        ]);

        $getStocksActionMock = $this->createMock(GetStocksAction::class);
        $getStocksActionMock->method('__invoke')->willReturn($stocks);
        App::instance(GetStocksAction::class, $getStocksActionMock);

        $fetchStockPriceServiceMock = $this->createMock(FetchStockPriceService::class);
        $fetchStockPriceServiceMock->method('fetchStockData')
            ->willReturnMap([
                ['Apple', ['price' => 150, 'previous_close' => 145]],
                ['Microsoft', ['price' => 200, 'previous_close' => 195]],
            ]);
        App::instance(FetchStockPriceService::class, $fetchStockPriceServiceMock);

        $service = new FetchAllStocksPriceService($fetchStockPriceServiceMock, $getStocksActionMock);

        $result = $service->fetchAllStocksData();

        $this->assertCount(2, $result);
        $this->assertEquals([
            ['symbol' => 'AAPL', 'price' => 150, 'previous_price' => 145],
            ['symbol' => 'MSFT', 'price' => 200, 'previous_price' => 195],
        ], $result);
    }
}


