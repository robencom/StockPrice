<?php

namespace Tests\Feature\Api;

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
        $stock = Stock::create(['symbol' => 'AAPL', 'name' => 'Apple Inc.']);
        StockPrice::create([
            'stock_id' => $stock->id,
            'price' => 150.00,
            'previous_price' => 145.00
        ]);
    }

    /** @test */
    public function it_returns_a_successful_response()
    {
        $response = $this->getJson('/api/stocks/report');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['symbol', 'price', 'previous_price', 'percentage_change']
                ]
            ]);
    }

    /** @test */
    public function it_returns_correct_stock_data()
    {
        $response = $this->getJson('/api/stocks/report');

        $response->assertJson([
            'data' => [
                [
                    'symbol' => 'AAPL',
                    'price' => '150.00',
                    'previous_price' => '145.00',
                ]
            ]
        ]);
    }
}
