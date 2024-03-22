<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\PercentageChangeCalculationService;

class PercentageChangeCalculationServiceTest extends TestCase
{
    protected PercentageChangeCalculationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PercentageChangeCalculationService();
    }

    /** @test */
    public function it_calculates_percentage_increase_correctly()
    {
        $percentageChange = $this->service->calculatePercentageChange(110, 100);
        $this->assertEquals('10.0000', $percentageChange);
    }

    /** @test */
    public function it_calculates_percentage_decrease_correctly()
    {
        $percentageChange = $this->service->calculatePercentageChange(90, 100);
        $this->assertEquals('-10.0000', $percentageChange);
    }

    /** @test */
    public function it_returns_zero_when_previous_price_is_zero()
    {
        $percentageChange = $this->service->calculatePercentageChange(100, 0);
        $this->assertEquals('0', $percentageChange);
    }

    /** @test */
    public function it_formats_percentage_change_to_four_decimal_places()
    {
        $percentageChange = $this->service->calculatePercentageChange(100.1234, 100);
        $this->assertEquals('0.1234', $percentageChange);
    }
}
