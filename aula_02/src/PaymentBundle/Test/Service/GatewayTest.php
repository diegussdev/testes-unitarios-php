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
        $httpClient->method('send')
            ->will($this->returnCallback(
                function ($method, $address, $body) {
                    return $this->fakeHttpClientSend($method, $address, $body);
                }
            ));

        $logger = $this->createMock(LoggerInterface::class);

        $user = 'test';
        $password = 'invalid-password';
        $gateway = new Gateway(
            $httpClient,
            $logger,
            $user,
            $password);

        $paid = $gateway->pay(
            'Fulano da Silva',
            '1111111111111111',
            new \DateTime('now'),
            100
        );

        $this->assertEquals(false, $paid);
    }

    /**
     * @test
     */
    public function shouldNotPayWhenFailOnGateway()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('send')
            ->will($this->returnCallback(
                function ($method, $address, $body) {
                    return $this->fakeHttpClientSend($method, $address, $body);
                }
            ));

        $logger = $this->createMock(LoggerInterface::class);

        $user = 'test';
        $password = 'valid-password';
        $gateway = new Gateway(
            $httpClient,
            $logger,
            $user,
            $password);

        $paid = $gateway->pay(
            'Fulano da Silva',
            '1111111111111111',
            new \DateTime('now'),
            100
        );

        $this->assertEquals(false, $paid);
    }

    /**
     * @test
     */
    public function shouldSuccesfullyPayWhenGatewayReturnOk()
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $httpClient->method('send')
            ->will($this->returnCallback(
                function ($method, $address, $body) {
                    return $this->fakeHttpClientSend($method, $address, $body);
                }
            ));

        $logger = $this->createMock(LoggerInterface::class);

        $user = 'test';
        $password = 'valid-password';
        $gateway = new Gateway(
            $httpClient,
            $logger,
            $user,
            $password);

        $paid = $gateway->pay(
            'Fulano da Silva',
            '1234432112344321',
            new \DateTime('now'),
            100
        );

        $this->assertEquals(true, $paid);
    }

    public function fakeHttpClientSend($method, $address, $body)
    {
        switch ($address) {
            case Gateway::BASE_URL . '/authenticate':

                if ($body['password'] != 'valid-password') {
                    return null;
                }

                return 'valid-token';
                break;
            case Gateway::BASE_URL . '/pay':

                if ($body['credit_card_number'] != '1234432112344321') {
                    return ['paid' => false];
                }

                return ['paid' => true];
                break;
        }
    }
}
