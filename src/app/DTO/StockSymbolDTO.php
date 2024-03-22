<?php

namespace App\DTO;

class StockSymbolDTO
{
    protected string $symbol;

    public static function init(array $requestData): self
    {
        return (new self())
            ->setSymbol($requestData['symbol'] ?? null);
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }
}
