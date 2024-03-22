<?php

namespace Tests\Feature\Api;

use App\Services\FetchAllStocksPriceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\App;

class GetAllStocksDataControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_all_stocks_data_successfully()
    {
        $mockService = $this->createMock(FetchAllStocksPriceService::class);
        $mockService->method('fetchAllStocksData')->willReturn([
            ['symbol' => 'AAPL', 'price' => 150.00, 'previous_price' => 145.00],
            ['symbol' => 'TSLA', 'price' => 122.00, 'previous_price' => 155.00],
        ]);

        App::instance(FetchAllStocksPriceService::class, $mockService);

        $response = $this->getJson('/api/stocks/all');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    ['symbol' => 'AAPL', 'price' => 150.00, 'previous_price' => 145.00],
                    ['symbol' => 'TSLA', 'price' => 122.00, 'previous_price' => 155.00],
                ]
            ]);
    }
}
