<?php

namespace Tests\Unit\StockPrices;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Stock;
use App\Models\StockPrice;
use App\Actions\StockPrices\FetchStockDataFromDatabaseAction;

class FetchStockDataFromDatabaseActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_fetches_stock_data_from_database()
    {
        $stock = Stock::create(['symbol' => 'AAPL', 'name' => 'Apple Inc.']);
        StockPrice::create([
            'stock_id' => $stock->id,
            'price' => 150.00,
            'previous_price' => 145.00,
        ]);

        $action = new FetchStockDataFromDatabaseAction();
        $result = $action('AAPL');

        $this->assertEquals(['price' => 150.00, 'previous_price' => 145.00], $result);
    }

    /** @test */
    public function it_returns_null_if_stock_does_not_exist()
    {
        $action = new FetchStockDataFromDatabaseAction();
        $result = $action('NONEXISTENT');

        $this->assertNull($result);
    }
}
