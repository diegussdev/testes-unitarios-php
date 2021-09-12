<?php

namespace FidelityProgramBundle\Test\Service;

use FidelityProgramBundle\Service\PointsCalculator;
use PHPUnit\Framework\TestCase;

class PointsCalculatorTest extends TestCase
{

    /**
     * @test
     * @dataProvider valueDataProvider
     */
    public function testPointsReceive($value, $expectedPoints)
    {
        $pointsCalculator = new PointsCalculator();
        $points = $pointsCalculator->calculatePointsToReceive($value);

        $this->assertEquals($expectedPoints, $points);
    }

    public function valueDataProvider()
    {
        return [
            [30, 0],
            [55, 1100],
            [75, 2250],
            [105, 5250],
        ];
    }
}
