<?php

namespace Tests\Feature\Web;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Stock;
use App\Models\StockPrice;

class StockReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $stock = Stock::create(['symbol' => 'AAPL', 'name' => 'Apple']);
        StockPrice::create([
            'stock_id' => $stock->id,
            'price' => 150.00,
            'previous_price' => 145.00
        ]);
    }

    /** @test */
    public function it_loads_the_stock_report_page_correctly()
    {
        $response = $this->get('/stocks/report');

        $response->assertStatus(200);
        $response->assertViewIs('stocks.report');
        $response->assertViewHas('stocks');
    }

    /** @test */
    public function stocks_report_page_shows_correct_data()
    {
        $response = $this->get('/stocks/report');

        $response->assertSee('AAPL');
        $response->assertSee(150.00);
        $response->assertSee(145.00);
    }
}

