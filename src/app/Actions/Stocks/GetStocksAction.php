<?php

namespace App\Actions\Stocks;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Collection;

class GetStocksAction
{
    public function __invoke(): Collection
    {
        return Stock::all();
    }
}
