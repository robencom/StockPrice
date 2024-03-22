<?php

namespace App\Actions\Stocks;

use App\Models\Stock;
use Illuminate\Support\Collection;

class GetStocksAction
{
    public function __invoke(): Collection
    {
        return Stock::all();
    }
}
