<?php

namespace WirecardSubscription\Tests\Unit\Resources;

use WirecardSubscription\Requester;
use WirecardSubscription\Resources\Customers;
use WirecardSubscription\Resources\Plans;
use WirecardSubscription\Response;
use WirecardSubscription\Tests\Unit\ResourceTest;

class CustomersTest extends ResourceTest
{
    protected function setUp(): void
    {
        $this->endpoint = 'customers';
        $this->requester = $this->createMock(Requester::class);
        $this->resource = new Customers($this->requester);
    }

    public function testEnableNewVaultShouldSetQueryParam()
    {
        $this->requester
            ->expects($this->once())
            ->method('addQuerys')
            ->with(['new_vault' => 'true']);

        $this->resource->enableNewVault();
    }

    public function testSetCardShouldSetStatusActivate()
    {
        $code = 'code';
        $card = '1234567890123456';

        $this->requester
            ->method('send')
            ->willReturn($this->createMock(Response::class));

        $expectedBody = ['json' => ['credit_card' => $card]];

        $this->requester
            ->expects($this->exactly(3))
            ->method('send')
            ->withConsecutive(
                ['GET', $this->endpoint . '/' . $code],
                ['PUT', $this->endpoint . '/' . $code . '/billing_infos', $expectedBody],
                ['GET', $this->endpoint . '/' . $code]
            );
        
        $this->resource->setCard($code, $card);
    }
}
