<?php

namespace FidelityProgramBundle\Service;

use FidelityProgramBundle\Entity\Points;
use FidelityProgramBundle\Repository\PointsRepositoryInterface;
use OrderBundle\Entity\Customer;

class FidelityProgramService
{
    private $pointsRepository;
    private $pointsCalculator;

    public function __construct(
        PointsRepositoryInterface $pointsRepository,
        PointsCalculator $pointsCalculator
    ) {
        $this->pointsRepository = $pointsRepository;
        $this->pointsCalculator = $pointsCalculator;
    }

    public function addPoints(Customer $customer, $value)
    {
        $pointsToAdd = $this->pointsCalculator->calculatePointsToReceive($value);

        if ($pointsToAdd > 0) {
            $points = new Points($customer, $pointsToAdd);
            $this->pointsRepository->save($points);
        }
    }
}
