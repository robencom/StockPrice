<?php

namespace App\Services;

class PercentageChangeCalculationService
{
    /**
     * Calculate the percentage change between two prices.
     *
     * @param float $currentPrice The current price of the stock.
     * @param float $previousPrice The previous price of the stock.
     * @return float The percentage change.
     */
    public function calculatePercentageChange(float $currentPrice, float $previousPrice): float
    {
        if ($previousPrice == 0) {
            return 0;
        }

        return (($currentPrice - $previousPrice) / $previousPrice) * 100;
    }
}
