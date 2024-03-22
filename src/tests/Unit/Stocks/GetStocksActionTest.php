<?php

namespace Tests\Unit\Stocks;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Stock;
use App\Actions\Stocks\GetStocksAction;

class GetStocksActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_retrieves_all_stocks()
    {
        $stockA = Stock::create(['symbol' => 'AAPL', 'name' => 'Apple Inc.']);
        $stockB = Stock::create(['symbol' => 'MSFT', 'name' => 'Microsoft Corp.']);

        $getStocksAction = new GetStocksAction();
        $stocks = $getStocksAction();

        $this->assertCount(2, $stocks);
        $this->assertTrue($stocks->contains($stockA));
        $this->assertTrue($stocks->contains($stockB));
    }
}
