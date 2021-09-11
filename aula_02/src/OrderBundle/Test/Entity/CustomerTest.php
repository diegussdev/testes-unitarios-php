<?php

namespace OrderBundle\Entity\Test;

use OrderBundle\Entity\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTeste extends TestCase
{
    /**
     * @test
     * @dataProvider cutmerAllowedDataProvider
     */
    public function testIsAllowedToOrder($isActive, $isBlocked, $expectedAllowed)
    {
        $customer = new Customer(
            $isActive,
            $isBlocked,
            "Fulano da Silva",
            "+5511123456789"
        );

        $isAllowed = $customer->isAllowedToOrder();

        $this->assertEquals($expectedAllowed, $isAllowed);
    }

    public function cutmerAllowedDataProvider()
    {
        return [
            'shouldBeAllowedWhenIsActiveAndNotBlocked' => [
                'isActive' => true,
                'isBlocked' => false,
                'expectedAllowed' => true,
            ],
            'shouldNotBeAllowedWhenIsActiveButIsBlocked' => [
                'isActive' => true,
                'isBlocked' => true,
                'expectedAllowed' => false,
            ],
            'shouldNotBeAllowedWhenIsNotActive' => [
                'isActive' => false,
                'isBlocked' => true,
                'expectedAllowed' => false,
            ],
            'shouldNotBeAllowedWhenIsNotActiveAndIsBlocked' => [
                'isActive' => false,
                'isBlocked' => false,
                'expectedAllowed' => false,
            ],
        ];
    }
}
