<?php

namespace OrderBundle\Validators\Test;

use OrderBundle\Validators\CreditCardNumberValidator;
use PHPUnit\Framework\TestCase;

class CreditCardNumberValidatorTest extends TestCase
{
    /**
     * @dataProvider valueProvider
     */
    public function testIsValid($value, $expectedResult)
    {

        $creditCardNumberValidator = new CreditCardNumberValidator($value);

        $isValid = $creditCardNumberValidator->isValid();

        $this->assertEquals($expectedResult, $isValid);

    }

    public function valueProvider()
    {
        return [
            'shouldBeValidWhenValueIsACreditCard' => [
                'value' => 1234432112344321,
                'expectedResult' => true,
            ],
            'shouldBeValidWhenValueIsACreditCardAsString' => [
                'value' => '1234432112344321',
                'expectedResult' => true,
            ],
            'shouldNotBeValidWhenValueIsNotACreditCard' => [
                'value' => '1234',
                'expectedResult' => false,
            ],
            'shouldNotBeValidWhenValueIsEmpty' => [
                'value' => '',
                'expectedResult' => false,
            ],
        ];
    }
}
