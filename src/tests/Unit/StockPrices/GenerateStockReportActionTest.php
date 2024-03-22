<?php

namespace Tests\Unit\StockPrices;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Stock;
use App\Models\StockPrice;
use App\Actions\StockPrices\GenerateStockReportAction;
use App\Services\PercentageChangeCalculationService;
use Illuminate\Support\Collection;

class GenerateStockReportActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_generates_stock_report_with_percentage_changes()
    {
        $stock = Stock::create(['symbol' => 'AAPL', 'name' => 'Apple Inc.']);
        StockPrice::create([
            'stock_id' => $stock->id,
            'price' => 150.00,
            'previous_price' => 145.00,
        ]);

        $mockService = $this->createMock(PercentageChangeCalculationService::class);
        $mockService->method('calculatePercentageChange')->willReturn(3.45);

        $action = new GenerateStockReportAction($mockService);

        $report = $action();

        $this->assertInstanceOf(Collection::class, $report);
        $this->assertCount(1, $report);
        $this->assertEquals([
            'symbol' => 'AAPL',
            'price' => 150.00,
            'previous_price' => 145.00,
            'percentage_change' => 3.45,
        ], $report->first());
    }
}
