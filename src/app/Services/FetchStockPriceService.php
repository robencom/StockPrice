<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class FetchStockPriceService
{
    public function __construct(protected MockStockPriceService $mockStockPriceService)
    {
    }

    public function fetchStockData($stockSymbol)
    {
        $apiKey = config('alpha_vantage.api_key');
        $cacheKey = "stock_data_{$stockSymbol}";
        $useMock = config('app.use_mock_stock_service', false);

        return Cache::remember($cacheKey, 60, function () use ($useMock, $apiKey, $stockSymbol) {
            try {
                if ($useMock) {
                    $data = $this->mockStockPriceService->generateMockData($stockSymbol);
                } else {
                    $response = Http::get("https://www.alphavantage.co/query?function=GLOBAL_QUOTES&symbol={$stockSymbol}&apikey={$apiKey}");
                    $data = $response->json();

                    if ($response->successful()) {
                        // handle rate limit case
                        if (isset($data['Information']) && str_contains(strtolower($data['Information']), 'rate limit')) {
                            return [
                                'error' => 'Rate limit exceeded. Please try again later.',
                            ];
                        }
                    } else {
                        return $this->handleErrorResponse($response);
                    }
                }

                return [
                    'symbol' => $stockSymbol,
                    'price' => $data["Global Quote"]["05. price"] ?? 'N/A',
                    'previous_close' => $data["Global Quote"]["08. previous close"] ?? 'N/A',
                ];

            } catch (Exception) {
                return [
                    'error' => 'An error occurred while fetching stock data.'
                ];
            }
        });
    }

    protected function handleErrorResponse($response): array
    {
        return [
            'error' => 'API request failed.',
            'status' => $response->status()
        ];
    }
}
