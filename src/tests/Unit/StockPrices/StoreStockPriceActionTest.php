<?php

namespace Tests\Unit\StockPrices;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Stock;
use App\Models\StockPrice;
use App\Actions\StockPrices\StoreStockPriceAction;
use App\Actions\Stocks\GetStockBySymbolAction;

class StoreStockPriceActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_or_updates_stock_price_for_an_existing_stock()
    {
        $stock = Stock::create(['symbol' => 'AAPL', 'name' => 'Apple Inc.']);

        $action = new StoreStockPriceAction(new GetStockBySymbolAction());
        $action('AAPL', 150.00, 145.00);

        $stockPrice = StockPrice::first();

        $this->assertNotNull($stockPrice);
        $this->assertEquals($stock->id, $stockPrice->stock_id);
        $this->assertEquals(150.00, $stockPrice->price);
        $this->assertEquals(145.00, $stockPrice->previous_price);
    }

    /** @test */
    public function it_does_not_create_stock_price_if_stock_does_not_exist()
    {
        $action = new StoreStockPriceAction(new GetStockBySymbolAction());
        $action('NONEXISTENT', 150.00, 145.00);

        $this->assertEquals(0, StockPrice::count());
    }
}
