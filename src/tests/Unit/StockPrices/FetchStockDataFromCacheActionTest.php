<?php

namespace Tests\Unit\StockPrices;

use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use App\Actions\StockPrices\FetchStockDataFromDatabaseAction;
use App\Actions\StockPrices\FetchStockDataFromCacheAction;

class FetchStockDataFromCacheActionTest extends TestCase
{
    /** @test */
    public function it_fetches_stock_data_from_cache()
    {
        $symbol = 'AAPL';
        $expectedData = ['price' => 150.00, 'previous_price' => 145.00];

        Cache::put("stock_data_{$symbol}", $expectedData, 60);

        $mockDatabaseAction = $this->createMock(FetchStockDataFromDatabaseAction::class);
        $mockDatabaseAction->expects($this->never())->method('__invoke');

        $action = new FetchStockDataFromCacheAction($mockDatabaseAction);
        $result = $action($symbol);

        $this->assertEquals($expectedData, $result);
    }

    /** @test */
    public function it_fetches_stock_data_from_database_and_caches_it_if_not_in_cache()
    {
        $symbol = 'AAPL';
        $expectedData = ['price' => 150.00, 'previous_price' => 145.00];

        $mockDatabaseAction = $this->createMock(FetchStockDataFromDatabaseAction::class);
        $mockDatabaseAction->method('__invoke')->willReturn($expectedData);

        Cache::shouldReceive('remember')
            ->once()
            ->with("stock_data_{$symbol}", 60, \Mockery::on(function ($closure) use ($expectedData) {
                return $closure() === $expectedData;
            }))
            ->andReturn($expectedData);

        $action = new FetchStockDataFromCacheAction($mockDatabaseAction);
        $result = $action($symbol);

        $this->assertEquals($expectedData, $result);
    }
}
