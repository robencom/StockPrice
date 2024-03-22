<?php

namespace Tests\Feature\Api;

use App\Models\Stock;
use App\Models\StockPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetStockDataControllerTest extends TestCase
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
    public function it_returns_a_successful_response_with_valid_symbol()
    {
        $response = $this->getJson('/api/stocks/?symbol=AAPL');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'price' => 150.00,
                    'previous_price' => 145.00
                ]
            ]);
    }

    /** @test */
    public function it_returns_an_error_for_invalid_symbol()
    {
        $response = $this->getJson('/api/stocks/?symbol=INVALID');

        $response->assertStatus(422);
    }
}
