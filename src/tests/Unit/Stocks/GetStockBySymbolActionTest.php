<?php

namespace Tests\Unit\Stocks;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Stock;
use App\Actions\Stocks\GetStockBySymbolAction;

class GetStockBySymbolActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_retrieves_a_stock_by_symbol()
    {
        Stock::create(['symbol' => 'AAPL', 'name' => 'Apple Inc.']);

        $getStockBySymbolAction = new GetStockBySymbolAction();
        $retrievedStock = $getStockBySymbolAction('AAPL');

        $this->assertNotNull($retrievedStock);
        $this->assertEquals('AAPL', $retrievedStock->symbol);
        $this->assertEquals('Apple Inc.', $retrievedStock->name);
    }
}
