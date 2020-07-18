<?php

namespace WirecardSubscription\Tests\Unit;

use PHPUnit\Framework\TestCase;
use WirecardSubscription\Requester;
use WirecardSubscription\Resource;
use WirecardSubscription\Resources\Customers;
use WirecardSubscription\Resources\Plans;
use WirecardSubscription\Resources\Subscriptions;
use WirecardSubscription\Resources\Webhooks;
use WirecardSubscription\Response;
use WirecardSubscription\WirecardApi;

class WirecardApiTest extends TestCase
{
    protected $api;

    protected function setUp(): void
    {
        $this->api = new WirecardApi();
    }

    protected function tearDown():void
    {
        $this->api = null;
    }

    public function test_should_return_customers_resource()
    {
        $this->assertInstanceOf(Customers::class, $this->api->customers);
    }

    public function test_should_reuse_customers_object()
    {
        $this->assertSame($this->api->customers, $this->api->customers);
    }
    
    public function test_should_return_plans_resource()
    {
        $this->assertInstanceOf(Plans::class, $this->api->plans);
    }

    public function test_should_reuse_plans_object()
    {
        $this->assertSame($this->api->plans, $this->api->plans);
    }
    
    public function test_should_return_subscriptions_resource()
    {
        $this->assertInstanceOf(Subscriptions::class, $this->api->subscriptions);
    }

    public function test_should_reuse_subscriptions_object()
    {
        $this->assertSame($this->api->subscriptions, $this->api->subscriptions);
    }
    
    public function test_should_return_webhooks_resource()
    {
        $this->assertInstanceOf(Webhooks::class, $this->api->webhooks);
    }

    public function test_should_reuse_webhooks_object()
    {
        $this->assertSame($this->api->webhooks, $this->api->webhooks);
    }
}
