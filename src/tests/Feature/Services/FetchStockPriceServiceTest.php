<?php

namespace Tests\Feature\Services;

use Tests\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Services\FetchStockPriceService;
use App\Services\MockStockPriceService;

class FetchStockPriceServiceTest extends TestCase
{
    /** @test */
    public function it_fetches_mock_data_successfully()
    {
        $service = new FetchStockPriceService(new MockStockPriceService());

        $expectedData = ['symbol' => 'AAPL', 'price' => '150', 'previous_close' => '145'];
        Cache::shouldReceive('remember')->once()->andReturn($expectedData);

        $data = $service->fetchStockData('AAPL');

        $this->assertEquals($expectedData, $data);
    }

    /** @test */
    public function it_handles_api_response_successfully()
    {
        Http::fake([
            'www.alphavantage.co/query*' => Http::response(['Global Quote' => ['05. price' => '150', '08. previous close' => '145']], 200)
        ]);

        config(['alpha_vantage.api_key' => 'dummykey', 'app.use_mock_stock_service' => false]);
        $service = new FetchStockPriceService(new MockStockPriceService());

        $data = $service->fetchStockData('AAPL');

        $this->assertEquals(['symbol' => 'AAPL', 'price' => '150', 'previous_close' => '145'], $data);
    }

    /** @test */
    public function it_handles_rate_limit_errors()
    {
        Http::fake([
            'www.alphavantage.co/query*' => Http::response(['Information' => 'Thank you for using Alpha Vantage! Our standard API rate limit is 5 requests per minute.'], 200)
        ]);

        config(['alpha_vantage.api_key' => 'dummykey', 'app.use_mock_stock_service' => false]);
        $service = new FetchStockPriceService(new MockStockPriceService());

        $data = $service->fetchStockData('AAPL');

        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('Rate limit exceeded. Please try again later.', $data['error']);
    }

    /** @test */
    public function it_handles_generic_api_failures()
    {
        Http::fake([
            'www.alphavantage.co/query*' => Http::response(['error' => 'API request failed.'], 500)
        ]);

        config(['alpha_vantage.api_key' => 'dummykey', 'app.use_mock_stock_service' => false]);
        $service = new FetchStockPriceService(new MockStockPriceService());

        $data = $service->fetchStockData('AAPL');

        $this->assertArrayHasKey('error', $data);
        $this->assertEquals('API request failed.', $data['error']);
    }
}
