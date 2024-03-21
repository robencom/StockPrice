<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;

class StocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = [
            'Apple' => 'AAPL',
            'Alphabet Class A' => 'GOOGL',
            'Microsoft' => 'MSFT',
            'Amazon' => 'AMZN',
            'Nvidia' => 'NVDA',
            'Tesla' => 'TSLA',
            'Meta' => 'META',
            'Alphabet Class C' => 'GOOG',
            'Berkshire Hathaway' => 'BRK.B',
            'UnitedHealth' => 'UNH',
        ];

        foreach ($stocks as $name => $symbol) {
            Stock::create([
                'name' => $name,
                'symbol' => $symbol
            ]);
        }
    }
}
