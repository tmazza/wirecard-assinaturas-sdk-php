<?php

namespace WirecardSubscription\Tests\Unit\Resources;

use WirecardSubscription\Requester;
use WirecardSubscription\Resources\Customers;
use WirecardSubscription\Resources\Plans;
use WirecardSubscription\Resources\Subscriptions;
use WirecardSubscription\Response;
use WirecardSubscription\Tests\Unit\ResourceTest;

class SubscriptionsTest extends ResourceTest
{
    protected function setUp(): void
    {
        $this->endpoint = 'subscriptions';
        $this->requester = $this->createMock(Requester::class);
        $this->resource = new Subscriptions($this->requester);
    }

    public function test_enableNewUser_should_set_query_param()
    {
        $this->requester
            ->expects($this->once())
            ->method('addQuerys')
            ->with(['new_customer' => 'true']);

        $this->resource->enableNewUser();
    }

    public function test_disableNewUser_should_set_query_param()
    {
        $this->requester
            ->expects($this->once())
            ->method('addQuerys')
            ->with(['new_customer' => 'false']);

        $this->resource->disableNewUser();
    }
}
