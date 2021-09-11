<?php

namespace PaymentBundle\Test\Service;

use MyFramework\HttpClientInterface;
use MyFramework\LoggerInterface;
use PaymentBundle\Service\Gateway;
use PHPUnit\Framework\TestCase;

class GatewayTest extends TestCase
{
    /**
     * @test
     */
    public function shouldNotPayWhenAuthenticationFail()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);

        $user = 'test';
        $password = 'invalid-password';
        $name = 'Fulano da Silva';
        $creditCard = '1111111111111111';
        $value = 100;
        $validity = new \DateTime('now');
        $responseToken = null;

        $logger = $this->createMock(LoggerInterface::class);
        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => $user,
                    'password' => $password,
                ],
                $responseToken,
            ],
        ];

        $httpClient
            ->expects($this->once())
            ->method('send')
            ->will($this->returnValueMap($map));

        $paid = $gateway->pay(
            $name,
            $creditCard,
            $validity,
            $value
        );

        $this->assertEquals(false, $paid);
    }

    /**
     * @test
     */
    public function shouldNotPayWhenFailOnGateway()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);

        $user = 'test';
        $password = 'valid-password';
        $name = 'Fulano da Silva';
        $creditCard = '1111111111111111';
        $value = 100;
        $validity = new \DateTime('now');
        $responseToken = 'token';

        $logger = $this->createMock(LoggerInterface::class);
        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => $user,
                    'password' => $password,
                ],
                $responseToken,
            ],
            [
                'POST',
                Gateway::BASE_URL . '/pay',
                [
                    'name' => $name,
                    'credit_card_number' => $creditCard,
                    'validity' => $validity,
                    'value' => $value,
                    'token' => $responseToken,
                ],
                ['paid' => false],
            ],
        ];

        $httpClient
            ->expects($this->atLeast(2))
            ->method('send')
            ->will($this->returnValueMap($map));

        $paid = $gateway->pay(
            $name,
            $creditCard,
            $validity,
            $value
        );

        $this->assertEquals(false, $paid);
    }

    /**
     * @test
     */
    public function shouldSuccesfullyPayWhenGatewayReturnOk()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);

        $user = 'test';
        $password = 'valid-password';
        $name = 'Fulano da Silva';
        $creditCard = '1234432112344321';
        $value = 100;
        $validity = new \DateTime('now');
        $responseToken = 'token';

        $logger = $this->createMock(LoggerInterface::class);
        $gateway = new Gateway($httpClient, $logger, $user, $password);

        $map = [
            [
                'POST',
                Gateway::BASE_URL . '/authenticate',
                [
                    'user' => $user,
                    'password' => $password,
                ],
                $responseToken,
            ],
            [
                'POST',
                Gateway::BASE_URL . '/pay',
                [
                    'name' => $name,
                    'credit_card_number' => $creditCard,
                    'validity' => $validity,
                    'value' => $value,
                    'token' => $responseToken,
                ],
                ['paid' => true],
            ],
        ];

        $httpClient
            ->expects($this->atLeast(2))
            ->method('send')
            ->will($this->returnValueMap($map));

        $paid = $gateway->pay(
            $name,
            $creditCard,
            $validity,
            $value
        );

        $this->assertEquals(true, $paid);
    }
}
