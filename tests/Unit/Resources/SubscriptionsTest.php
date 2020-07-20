<?php

namespace WirecardSubscription\Tests\Unit\Resources;

use WirecardSubscription\Requester;
use WirecardSubscription\Resources\Subscriptions;
use WirecardSubscription\Tests\Unit\ResourceTest;

class SubscriptionsTest extends ResourceTest
{
    protected function setUp(): void
    {
        $this->endpoint = 'subscriptions';
        $this->requester = $this->createMock(Requester::class);
        $this->resource = new Subscriptions($this->requester);
    }

    public function testEnableNewUserShouldSetQueryParam()
    {
        $this->requester
            ->expects($this->once())
            ->method('addQuerys')
            ->with(['new_customer' => 'true']);

        $this->resource->enableNewUser();
    }

    public function testDisableNewUserShouldSetQueryParam()
    {
        $this->requester
            ->expects($this->once())
            ->method('addQuerys')
            ->with(['new_customer' => 'false']);

        $this->resource->disableNewUser();
    }
}
