<?php

namespace App\Console\Commands;

use App\Actions\StockPrices\StoreStockPriceAction;
use App\Services\FetchAllStocksPriceService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class FetchStockData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-stock-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches the latest stock price data for all predefined stocks';

    public function __construct(protected FetchAllStocksPriceService $fetchAllStocksPriceService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(StoreStockPriceAction $storeStockPricesAction)
    {
        $this->info('Fetching stock data...');
        $stockData = $this->fetchAllStocksPriceService->fetchAllStocksData();

        foreach ($stockData as $data) {
            $storeStockPricesAction($data['symbol'], $data['price'], $data['previous_price']);

            Cache::put("stock_data_{$data['symbol']}", ['price' => $data['price'], 'previous_price' => $data['previous_price']], 60);
        }
        $this->info('Stock data has been updated successfully.');
    }
}
