<?php

namespace WirecardSubscription\Tests\Unit\Resources;

use WirecardSubscription\Requester;
use WirecardSubscription\Resources\Customers;
use WirecardSubscription\Resources\Plans;
use WirecardSubscription\Resources\Subscriptions;
use WirecardSubscription\Resources\Webhooks;
use WirecardSubscription\Response;
use WirecardSubscription\Tests\Unit\ResourceTest;

class WebhooksTest extends ResourceTest
{
    protected function setUp(): void
    {
        $this->endpoint = 'users/preferences';
        $this->requester = $this->createMock(Requester::class);
        $this->resource = new Webhooks($this->requester);
    }

    private function templateCreate($url, $enableMerchant = false, $enableCustomer = false)
    {
        return [
            'json' => [
                'notification' => [
                    'webhook' => ['url' => $url],
                    'email' => [
                        'merchant' => ['enabled' => $enableMerchant],
                        'customer' => ['enabled' => $enableCustomer],
                    ],
                ],
            ]
        ];
    }

    public function test_connect_should_set_webhook()
    {
        $url = 'https://teste.com';
        $expectedBody = $this->templateCreate($url);

        $this->requester
             ->expects($this->once())
             ->method('send')
             ->with('POST', $this->endpoint, $expectedBody)
             ->willReturn($this->createMock(Response::class));

        $this->resource->connect($url);
    }

    public function test_connect_should_use_enableMerchant_param()
    {
        $url = 'https://teste.com';
        $enableMerchant = true;
        $enableCustomer = false;
        $expectedBody = $this->templateCreate($url, $enableMerchant, $enableCustomer);

        $this->requester
             ->expects($this->once())
             ->method('send')
             ->with('POST', $this->endpoint, $expectedBody)
             ->willReturn($this->createMock(Response::class));

        $this->resource->connect($url, $enableMerchant, $enableCustomer);
    }

    public function test_connect_should_use_enableCustomer_param()
    {
        $url = 'https://teste.com';
        $enableMerchant = false;
        $enableCustomer = true;
        $expectedBody = $this->templateCreate($url, $enableMerchant, $enableCustomer);

        $this->requester
             ->expects($this->once())
             ->method('send')
             ->with('POST', $this->endpoint, $expectedBody)
             ->willReturn($this->createMock(Response::class));

        $this->resource->connect($url, $enableMerchant, $enableCustomer);
    }

    public function test_connect_should_use_both_params()
    {
        $url = 'https://teste.com';
        $enableMerchant = true;
        $enableCustomer = true;
        $expectedBody = $this->templateCreate($url, $enableMerchant, $enableCustomer);

        $this->requester
             ->expects($this->once())
             ->method('send')
             ->with('POST', $this->endpoint, $expectedBody)
             ->willReturn($this->createMock(Response::class));

        $this->resource->connect($url, $enableMerchant, $enableCustomer);
    }
}
