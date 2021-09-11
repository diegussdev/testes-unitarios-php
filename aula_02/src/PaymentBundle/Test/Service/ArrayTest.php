<?php

namespace PaymentBundle\Test\Service;

use PHPUnit\Framework\TestCase;

class ArrayTest extends TestCase
{
    private $array;

    public static function setUpBeforeClass()
    {

    }

    public static function tearDownAfterClass()
    {

    }

    /**
     * @test
     */
    public function shouldBeFilled()
    {
        $this->array = ['hello' => 'word'];

        $this->assertNotEmpty($this->array);
    }

    /**
     * @test
     */
    public function shouldBeEmpty()
    {
        $this->assertEmpty($this->array);
    }

}
