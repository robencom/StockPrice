<?php

namespace App\Console\Commands;

use App\Services\FetchAllStocksPriceService;
use Illuminate\Console\Command;

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
    public function handle()
    {
        $this->info('Fetching stock data...');
        $stockData = $this->fetchAllStocksPriceService->fetchAllStocksData();

        // Example output to console, adjust according to your actual data structure
        foreach ($stockData as $data) {
            $this->info("{$data['symbol']}: {$data['price']}");
        }
    }
}
